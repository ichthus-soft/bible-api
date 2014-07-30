<?php
namespace Bible_api;

if(!file_exists(__DIR__.'/vendor/autoload.php')) {
  die('Inainte de a folosi acest api, trebuie sa instalezi dependentele folosind "composer install"');
}
require_once __DIR__.'/vendor/autoload.php';
if(!file_exists(__DIR__.'/config.php')) {
  die('Inainte de a folosi acest api, copiaza fisierul config.php.dist in config.php si schimba setarile de conexiune la baza de date!');
}
require_once __DIR__.'/config.php';

use BibleRef\Reference;
use BibleRef\Utils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Rah\Danpu\Dump;
use Rah\Danpu\Import;

$app = new \Silex\Application();

$app->register(new \Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
            'driver'    => 'pdo_mysql',
            'host'      => Config::DB_HOST,
            'dbname'    => Config::DB_NAME,
            'user'      => Config::DB_USER,
            'password'  => Config::DB_PASSWORD,
            'charset'   => 'utf8',
        )
));

$sql = "SHOW TABLES LIKE 'bibslia'";
var_dump(count($app['db']->fetchAll($sql)));
if(count($app['db']->fetchAll($sql)) === 0 AND !isset($_GET['import'])) {
  // echo __DIR__;
  die('Baza de date nu a fost importata! Daca vrei sa import automat baza de date, <a href="/bigdump.php">click aici</a>!');
}

$app->get('/', function() use ($app) {
    $post = $app['db']->fetchAll($sql);
    var_dump($post);
return 'hello!';
});

$app->get('/v2/{query}.cauta', function($query) use($app) {
  $return = [];
  $return['rezultate'] = 0;
  $return['versete'] = [];
  $query = str_replace('+',' ',$query);
  // $return['text'] = '';
  $_verset = $app['db']->fetchAll("SELECT * FROM biblia WHERE `text` LIKE ?",
              ["%".$query."%"]);
  if($_verset)
    {
      foreach($_verset as $_verset) {
        $a = [];
        $return['rezultate']++;
        $a['testament'] = $_verset['testament'];
        $a['carte'] = $_verset['carte'];
        $a['capitol'] = $_verset['capitol'];
        $a['verset'] = $_verset['verset'];
        $a['text'] = $_verset['text'];
        array_push($return['versete'], $a);
        // $return['text'] .= $_verset['text'].' ';
      }
    }
    return $app->json($return, 201);
});

$app->get('/v2/{query}.js', function($query) use($app) {
  $query = str_replace('.js','',$query);

  $return = v2_query($query, $app);
  $string = '';
  foreach($return['versete'] as $ret) {
    $text = $ret['text'];
    $string .= "document.writeln(\"<p>$text</p>\");";
  }
  $pasaj = $return["pasaj"];
  $string .= "document.writeln(\"<span class='referinta'>$pasaj</p>\");";
  $response = new Response();
  // $response->setCharset('UTF-8');
  $response->headers->set('Content-Type', 'text/javascript');
  $response->setContent($string);
  $response->setStatusCode(Response::HTTP_OK);
  $request = Request::createFromGlobals();
  $response->prepare($request);
  $response->send();
  return '';
});

$app->get('/v2/{query}', function($query) use($app) {
  $query = str_replace('.js','',$query);
  $return = v2_query($query, $app);
  return $app->json($return, 201);
});


$app->get('/v1/{query}', function($query) use($app) {
  $query = str_replace('+',' ',$query);
  $arr = (new Reference($query, false))->getArray();
  $verses = [];
  $q = "SELECT * FROM biblia WHERE ";
  // var_dump(count($arr));
  if(is_array($arr)) {
    $cnt = 0;
      if(!isset($arr['name'])):
    foreach($arr as $book) {
      $cnt++;
      $add = '';
      $extra = '';
      if($cnt != 2)
        $extra .= ') ';
      if($cnt > 1)
        $add .=" {$extra}OR ";
      $q .= "{$add}(carte = '{$app->escape($book['name'])}' AND";
        if(is_array($book['chapter'])) {
          $_c = 0;
          $q .= ' (';
          foreach($book['chapter'] as $capitol => $versete) {
            $_c++;
            $add = '';
            if($_c > 1)
              $add .= ' OR ';
            $versete = implode(',',$versete);
            $q .= "{$add}(capitol = {$app->escape($capitol)} AND verset IN({$app->escape($versete)}))";
            // $q .= ')';
          }
          $q .= ')';
        } else {
          $q .= " (capitol = '{$app->escape($book['chapter'])}'";
          $verses = implode(',',$book['verses']);
          $q .=" AND verset IN({$app->escape($verses)}";
          $q .= ')';
        }
      $q .= ')';
      }
      else:
        if(!is_array($arr['chapter'])):
        $versete = implode(',',$arr['verses']);
        $q .= "(carte = '{$app->escape($arr['name'])}' AND capitol='{$app->escape($arr['chapter'])}' AND verset IN($versete)";
        else:
          $q .= "(carte = '{$app->escape($arr['name'])}'";
          $cnt = 0;
          foreach($arr['chapter'] as $capitol => $versete){
            $cnt++;
            if($cnt == 1) $adresare = "AND("; else $adresare = 'OR';
            $versete = implode(',',$versete);
            $q .= " $adresare (capitol = '{$capitol}' AND verset IN({$versete}))";
          }
          $q .= ')';
        endif;
      endif;
      $q .= ')';
    }
  // var_dump($arr);
  $post = $app['db']->fetchAll($q);
  // var_dump($post);
  $resp = [];
  $resp['totalVersete'] = count($post);
  $resp['versete'] = [];
  $resp['text'] = "";
  foreach($post as $verset) {
    $a = [];
    $a['testament'] = $verset['testament'];
    $a['carte'] = $verset['carte'];
    $a['capitol'] = $verset['capitol'];
    $a['verset'] = $verset['verset'];
    $a['text'] = $verset['text'];
    array_push($resp['versete'], $a);
    $resp['text'] .= $verset['text'];
  }
  // header('Content-Type: application/json');
  return $app->json($resp, 201);
});

$app->run();


function v2_query($query, &$app) {
  $test = new Reference($query);
  $test = $test->v2();
  $return['pasaj'] = $test['passage'];
  $return['versete'] = [];
  $return['text'] = '';
  foreach($test['books'] as $nume => $versete) {
    foreach($versete['verses'] as $capitol => $verset) {
      foreach($verset as $v) {
          $_verset = $app['db']->fetchAssoc("SELECT * FROM biblia WHERE carte = ? AND capitol = ? AND verset = ?",
    [$nume, $capitol, $v]);
        if($_verset)
        {
          $a['testament'] = $_verset['testament'];
          $a['carte'] = $_verset['carte'];
          $a['capitol'] = $_verset['capitol'];
          $a['verset'] = $_verset['verset'];
          $a['text'] = $_verset['text'];
          array_push($return['versete'], $a);
          $return['text'] .= $_verset['text'].' ';
        }
      }
    }
  }
  return $return;
}

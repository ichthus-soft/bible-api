<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Bible Api - Biblia Cornilescu in format JSON Web Service</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <!--link rel="stylesheet/less" href="views/less/bootstrap.less" type="text/css" /-->
  <!--link rel="stylesheet/less" href="views/less/responsive.less" type="text/css" /-->
  <!--script src="views/js/less-1.3.3.min.js"></script-->
  <!--append ‘#!watch’ to the browser URL, then refresh the page. -->
  
  <link href="views/css/bootstrap.min.css" rel="stylesheet">
  <link href="views/css/style.css" rel="stylesheet">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="views/js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="views/img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="views/img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="views/img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="views/img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="views/img/favicon.png">
  
  <script type="text/javascript" src="views/js/jquery.min.js"></script>
  <script type="text/javascript" src="views/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="views/js/scripts.js"></script>
</head>

<body>
<div class="container">
  <div class="row clearfix">
    <div class="col-md-12 column">
      <div class="jumbotron">
        <h1>
          Biblia - Api JSON
        </h1>
        <p>
          In Iulie 2014 am inceput sa fac un mic script de PHP cu care sa pot extrage anumite versete din Biblie din baza de date si sa le returnez in format JSON ca sa le pot folosi in mai multe proiecte.
        </p>
        <p>
          A trecut mult timp si pana acum sistemul nu pare sa aiba erori. Scriptul este complet <b>open source</b>, poti modifica pana si aceasta pagina. Proiectul este public pe Github - <a href="https://github.com/ichthus-soft/bible-api" target="_blank">aici</a>.
        </p>
        <p>Mai multe informatii despre cum se foloseste acest api, cum il poti instala la tine pe server, ce combinatii de <b>query</b> se pot introduce si asa mai departe gasesti tot pe Github.</p>
        <p><a href="http://biblia.filipac.net/v2/Ioan+3:16" target="_blank">Exemplu Ioan 3:16</a><br>
            <a href="http://biblia.filipac.net/v2/Ioan+3:1-16">Exemplu Ioan 3:1-16</a><br>
            <a href="http://biblia.filipac.net/v2/Ioan+3:1,3,7,9,16&4:1">Exemplu Ioan 3:1,3,7,9,16 & 4:1</a>
        </p>
      </div>
    </div>
  </div>
  <div class="row clearfix">
    <div class="col-md-4 column">
      <h2>
        Pe scurt despre folosinta
      </h2>
      
      <p>
        Url-ul la care se pot obtine versetele este <b>http://biblia.filipac.net/v2/</b><br>
        <b>De exemplu</b> - Pentru versetul <i>Ioan 3:16</i> - <b>http://biblia.filipac.net/v2/Ioan+3:16</b>
      </p>
    </div>
    <div class="col-md-5 column">
      <h2>
        Download pentru serverul propriu
      </h2>
      <p>
        Asa cum am spus si mai sus, scriptul este complet open source si il puteti instala la dvs. pe server in caz ca nu vreti sa folositi serverul meu.
      </p>
      <p>
        <center>
          <a class="btn btn-success btn-lg" href="https://github.com/ichthus-soft/bible-api/archive/master.zip">Download</a>
        </center>
      </p>
    </div>
    <div class="col-md-3 column">
      <h2>
        Heading
      </h2>
      <p>
        Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
      </p>
      <p>
        <a class="btn" href="#">View details »</a>
      </p>
    </div>
  </div>
</div>
</body>
</html>

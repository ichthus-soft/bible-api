Bible Api
---------------------------
![ichthus-soft/bible-api](https://raw.githubusercontent.com/ichthus-soft/bible-api/master/bibleapi.jpg)
Acesta este un api **open source** care returneaza un sir de versete in format JSON pentru a fi putea utilizate in orice limbaj de programare. Spre exemplu, un plugin de Wordpress a fost creeat care te ajuta sa inserezi in pagina textul din Biblie doar cu un shortcode:
```php
[Biblia pasaj="Geneza 1:1-10"]
```
In curand voi face public si acest plugin de Wordpress, mai trebuie sa stea putin in faza de testare.

Cum se face query-ul
---------------
Bible Api foloseste pachetul **ichthus-soft/bible_ref** pentru a intelege query-ul pe care doresti sa il returnezi.  Astfel ai urmatoarele optiuni:

**Nota autor:** De-a lungul exemplelor vei vedea ca poti in loc de spatiu sa pui **+**. Astfel url-ul va arata mult mai frumos decat cu spatiu. Este strict o alegere de gust, API-ul intelege si un query cu spatiu si un query cu **+**

```markdown
# Un singur verset
Ioan 3:16 sau Ioan+3:16
# Un pasaj de versete
Ioan 3:1-16 sau Ioan+3:1-16
# Mai multe capitole
Ioan 3:1&4:1-10
# Poti cere mai multe carti
Ioan 3:16;Filipeni 1:12
# Poti combina toate acestea
Ioan 3:16&1:1;Apocalipsa 1:1-10,15;Geneza 1:1-20&2:1
```
Deci, ca sa generalizez:

 - Formatul este **numele-cartii capitol:verset[-sfarsit]**
 - Ca sa adaugi un nou capitol, adauga **&** la query - *2:1&3:5*
 - Ca sa adaugi o noua carte, adauga **;** la query - *Geneza 1:1;Faptele Apostolilor 1:9*

Ce returneaza API-ul?
--
Daca esti familiar cu JSON, poti vedea un exemplu de raspuns mai jos.
Api-ul returneaza:

 - **pasaj** - Pasajul de unde sunt afisate versetele
 - **versete** - un array de versete care are campurile urmatoare disponibile: **testament** - 1 este VT, 2 NT, **carte** - numele cartii, **capitol** - capitolul de unde este versetul, **verset** numarul versetului, **text** - textul adica versetul in sine.
 - **text** - toate versetele concatenate, rezulta un singur bloc de text
 - **nl** - versetele cu cate un ```<br>``` intre ele
 - **nlvn** - versetele cu un ```<br>``` intre ele si cu numarul versetului la inceput de rand

In textul versetelor, cuvintele rostite de Domnul Isus sunt intr-un span cu clasa **.Isus**. Astfel poti din css-ul tau sa colorezi aceste cuvinte sau sa le dai un stil special fata de restul textului.

**Versetul zilei**
Tot in acest api poti accesa **versetul zilei** cu ajutorul api-ului de la **Resursecrestine.ro**. Tot ce trebuie sa faci este sa vizitezi **biblia.filipac.net/v2/versetulZilei** si vei primi raspuns in acelasi stil standardizat pe care il gasesti la sfarsitul acestei documentatii.

Cum pot ajuta acest proiect?
---
Poti ajuta in multe moduri, amintesc doar unele din ele:

 - Testeaza acest produs si vezi daca poti gasi un bug, raporteaza-l aici pe Github sau incearca sa il rezolvi tu (Fa-ti un fork la acest proiect, rezolva, da commit si  apoi merge request)
 - Spune la prieteni despre proiectul acesta.
 - Foloseste api-ul la tine pe site (exemplu **bisericasega.ro** foloseste in mod frecvent acest api)
 - Vino cu noi idei de inbunatatire - mereu se pot adauga chestii noi sau se pot inbunatati cele existente.
 - **Scrie o documentatie mai elaborata!** Eu (Filip) nu prea am rabdare sa scriu documentatii.  Poti sa o faci chiar tu.
 - Instaleaza API-ul la tine pe site.

Acestea sunt doar cateva care imi vin acum in minte.

Cum instalez la mine pe site acest api?
--
Nu trebuie neaparat sa instalezi acest API, poti folosi cu incredere serverul meu. Totusi daca tu crezi ca mi-ai incetini cumva serverul cu mii de accesari pe minut, poti sa il instalezi pe serverul tau. Tot ce ai nevoie este un **Apache**, **PHP 5.5**, **Composer** si **Mysql**. Pasii sunt mai jos:

**Metoda 1:**
 - Cloneaza acest proiect de Github: ```git clone https://github.com/ichthus-soft/bible-api```
 - Instaleaza proiectul folosind Composer - ```composer install```

**Metoda 2:**
- Instaleaza proiectul folosit composer: ```composer require ichtus-soft/bible-api```.

**Configurare:**
 - Copiaza ```config.php.dist``` intr-un fisier numit ```config.php``` si schimba datele de access la baza de date.
 - Acceseaza URL-ul public al serverului si urmeaza pasii de pe ecran pentru a insera tabelele in Mysql, necesare pentru a functiona.
 - Gata! Ai instalat API-ul local. Acum in loc de ```biblia.filipac.net``` poti folosi url-ul tau propriu.

**Exemplu query si raspuns**
--
*http://biblia.filipac.net/v2/Ioan+3:16&1:1*
```json
{
pasaj: "Ioan 3:16,1:1",
versete: [
{
testament: "2",
carte: "Ioan",
capitol: "3",
verset: "16",
text: "<span class='Isus'>Fiindcă atât de mult a iubit Dumnezeu lumea, că a dat pe singurul Lui Fiu, pentru ca oricine crede în El să nu piară, ci să aibă viaţa veşnică.</span>"
},
{
testament: "2",
carte: "Ioan",
capitol: "1",
verset: "1",
text: "La început era Cuvântul, şi Cuvântul era cu Dumnezeu, şi Cuvântul era Dumnezeu."
}
],
text: "<span class='Isus'>Fiindcă atât de mult a iubit Dumnezeu lumea, că a dat pe singurul Lui Fiu, pentru ca oricine crede în El să nu piară, ci să aibă viaţa veşnică.</span> La început era Cuvântul, şi Cuvântul era cu Dumnezeu, şi Cuvântul era Dumnezeu. ",
nl: "<span class='Isus'>Fiindcă atât de mult a iubit Dumnezeu lumea, că a dat pe singurul Lui Fiu, pentru ca oricine crede în El să nu piară, ci să aibă viaţa veşnică.</span><br>La început era Cuvântul, şi Cuvântul era cu Dumnezeu, şi Cuvântul era Dumnezeu.<br>",
nlvn: "<span style="font-size: 10px;">16</span> <span class='Isus'>Fiindcă atât de mult a iubit Dumnezeu lumea, că a dat pe singurul Lui Fiu, pentru ca oricine crede în El să nu piară, ci să aibă viaţa veşnică.</span><br><span style="font-size: 10px;">1</span> La început era Cuvântul, şi Cuvântul era cu Dumnezeu, şi Cuvântul era Dumnezeu.<br>"
}
```

Site-uri care folosesc acest api si de care stim
--

 - [www.bisericasega.ro](http://www.bisericasega.ro)

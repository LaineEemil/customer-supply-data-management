<?php
require 'yhteys.php';

    echo "<link rel=stylesheet type=text/css href=styles.css>";

    if (!empty($_GET["tyokohde"])) {

        $kysely = $yhteys->prepare('SELECT * FROM tyokohde WHERE kohdetunnus = ?');
        $tulos = $kysely->execute(array($_GET["tyokohde"]));
        $rivi = $kysely->fetch();
    
        echo "<h1> Luo tuntityö lasku kohteelle: " . $rivi["osoite"] . " </h1>";

        echo "<form action=tuntityolasku_luo_final.php?tyokohde=$_GET[tyokohde] method=post>";
        echo "<fieldset>";
        echo "<legend>Anna päivämäärä, johon mennessä tehdyt työt ja käytetyt tarvikkeet lisätään laskulle</legend>";
        echo "<label for=paivamaara> Päivämäärä: </label> <br>";
        echo "<input type=date name=paivamaara value=". '"'. date("Y-m-d") . '"' . " />  <br> <br>" ;
        echo "</fieldset><fieldset>";
        echo "<legend>Anna laskulle eräpäivä</legend>";
        echo "<label for=erapaiva> Eräpäivä: </label> <br>";
        echo "<input type=date name=erapaiva />  <br> <br>" ;
        echo "<input type=submit id=nappi value=Seuraava>". "</fieldset>" . "</form action>"."<br>";
    }

    echo "<footer>";
    echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
    echo "</footer>";

?>
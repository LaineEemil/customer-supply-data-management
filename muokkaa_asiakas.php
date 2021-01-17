<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<header>
    <meta http-equiv="Content-type" value="text/html; charset=UTF-8" />
</header>

<body>
<?php
require 'yhteys.php';
    $kysely = $yhteys->prepare('SELECT * FROM asiakas');
    $tulos = $kysely->execute();
    $rivi = $kysely->fetch();

    echo "<link rel=stylesheet type=text/css href=styles.css>";
    header("Content-Type: text/html; charset=UTF-8");
    echo "<meta http-equiv=Content-Type content=text/html; charset=UTF-8>";
    echo "<h1> Muokkaa asiakkaan tietoja tai poista asiakas tietokannasta</h1>";
        if (!empty($rivi)) {
            while($rivi) {
                echo "<ul style=list-style-type:disc;>";
                echo "<li>";
                echo "<form action=muokkaa_asiakas_edit.php?asiakas=$rivi[atunnus] method=post>". "Nimi: " . str_replace("”","ö",str_replace("„","ä", $rivi["nimi"]))  . " - Osoite: " . 
                str_replace("”","ö",str_replace("„","ä", $rivi["osoite"])) . " Puhnro: " . $rivi["puhnro"]. " Sposti: " . $rivi["sposti"]. " <input type=submit id=nappi value=" . '"' ."Muokkaa tietoja".'"'.">";
                echo " <button type=button id=poistonappi" . " onclick=".'"'."window.location= 'poista_asiakas.php?atunnus=$rivi[atunnus]'".'"'." >Poista</button> ". "</form action>"."<br>"; 
                echo "</li>";
                echo "</ul>";
                $rivi = $kysely->fetch();
            }
        } else {
            echo "<ul style=list-style-type:disc;>";
            echo "<li>";
            echo "<p>Yhtäkään asiakasta ei ole vielä lisätty!</p>";
            echo "</li>";
            echo "</ul>";
        }

        echo "<footer>";
        echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
        echo "</footer>";

?>
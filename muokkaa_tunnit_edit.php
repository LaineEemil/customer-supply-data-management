<?php
require 'yhteys.php';

    $kysely = $yhteys->prepare('SELECT * FROM ktarvikkeet WHERE kohdetunnus = ?');
    $tulos = $kysely->execute(array($_GET["tyokohde"]));
    $rivi = $kysely->fetch();

    echo "<link rel=stylesheet type=text/css href=styles.css>";

    echo "<h1> Poista tai muokkaa käytettyjä tarvikkeita </h1>";

    if (!empty($rivi)) {
        
        while($rivi) {

            echo "<ul style=list-style-type:disc;>";
            echo "<li>";
            echo "<form action=muokkaa_tarvikkeet_edit_select.php?tyokohde=$rivi[ktarviketunnus] method=post>". "tarvikkeen nimi: " . $rivi["nimi"]. " | Kohteen osoite: " . 
                $rivi["maara"]. " | Kohteen kuvaus: " . $rivi["paivamaara"]. " | <input type=submit id=nappi value=Valitse>"."</form action>"."<br>";
            echo "</li>";
            echo "</ul>";
            $rivi = $kysely->fetch();
        }
    } else {
        echo "<ul style=list-style-type:disc;>";
        echo "<li>";
        echo "<p>Yhtäkään työkohdetta ei ole vielä lisätty!</p>";
        echo "</li>";
        echo "</ul>";
    }

    echo "<footer>";
    echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
    echo "</footer>";

?>
<?php
require 'yhteys.php';
    $kysely = $yhteys->prepare('SELECT * FROM asiakas');
    $tulos = $kysely->execute();
    $rivi = $kysely->fetch();

    echo "<link rel=stylesheet type=text/css href=styles.css>";

    echo "<h1> Valitse asiakas </h1>";
        if (!empty($rivi)) {
            while($rivi) {
                echo "<ul style=list-style-type:disc;>";
                echo "<li>";
                echo "<form action=hinta_arvio_kohde.php?asiakas=$rivi[atunnus] method=post>". "Nimi: " . str_replace("”","ö",str_replace("„","ä", $rivi["nimi"])) . " - Osoite: " . 
                str_replace("”","ö",str_replace("„","ä", $rivi["osoite"])) . " Puhnro: " . $rivi["puhnro"]. " Sposti: " . $rivi["sposti"]. " <input type=submit id=nappi value=Valitse>"."</form action>"."<br>";
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
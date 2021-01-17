<?php
require 'yhteys.php';

    $kysely = $yhteys->prepare('SELECT * FROM tyokohde WHERE atunnus = ?');
    $tulos = $kysely->execute(array($_GET["asiakas"]));
    $rivi = $kysely->fetch();

    echo "<link rel=stylesheet type=text/css href=styles.css>";

    echo "<h1> Valitse kohde, jolle tehdään hinta-arvio </h1>";
    if (!empty($rivi)) {
        while($rivi) {

            // Haetaan kohteesta löytyvän atunnuksen avulla asiakkaan tiedot.
            $kysely_a = $yhteys->prepare('SELECT nimi FROM asiakas WHERE atunnus = ?');
            $tulos_a = $kysely_a->execute(array($_GET["asiakas"]));
            $rivi_a = $kysely_a->fetch();

            echo "<ul style=list-style-type:disc;>";
            echo "<li>";
            echo "<form action=hinta_arvio_data.php?asiakas=$_GET[asiakas]&tyokohde=$rivi[kohdetunnus] method=post>". " Kohteen osoite: " . 
            str_replace("”","ö",str_replace("„","ä", $rivi["osoite"])) . " | Kohteen kuvaus: " . str_replace("”","ö",str_replace("„","ä", $rivi["kuvaus"])). " | <input type=submit id=nappi value=Valitse>"."</form action>"."<br>";
            echo "</li>";
            echo "</ul>";
            $rivi = $kysely->fetch();
        }
    } else {
        echo "<ul style=list-style-type:disc;>";
        echo "<li>";
        echo "<p>Yhtäkään työkohdetta ei ole vielä lisätty tälle asiakaalle!</p>";
        echo "</li>";
        echo "</ul>";
    }

    echo "<footer>";
    echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
    echo "</footer>";

?>
<?php
require 'yhteys.php';

    $kysely = $yhteys->prepare('SELECT * FROM ktarvikkeet WHERE ktarviketunnus = ?');
    $tulos = $kysely->execute(array($_GET["ktunnus"]));
    $rivi = $kysely->fetch();

    $kysely_k = $yhteys->prepare('SELECT * FROM tyokohde WHERE kohdetunnus = ?');
    $tulos_k = $kysely_k->execute(array($_GET["tyokohde"]));
    $rivi_k = $kysely_k->fetch();

    echo "<link rel=stylesheet type=text/css href=styles.css>";

    echo "<h1> Muokkaa kohteessa: " . str_replace("”","ö",str_replace("„","ä", $rivi_k["osoite"])) . "<br> Päivämäärällä: " . $rivi["paivamaara"] . "<br> Käytettyä tarviketta</h1>";

    if (!empty($rivi)) {
        
        while($rivi) {

            echo "<ul>" . "<li>";
            echo "<form action=muokkaa_tarvikkeet_edit_select_query.php?ktunnus=$rivi[ktarviketunnus] method=post>". "Tarvikkeen nimi: " . str_replace("”","ö",str_replace("„","ä", $rivi["nimi"]));
            echo "</li>" . "<li>";
            echo " Määrä: " . "<input type=number name=maara value=" . '"' . $rivi["maara"] . '"' . ">";
            echo " <br> <br> <input type=submit id=nappi value=Muokkaa määrää>"."</form action>";
            echo "</li>" . "</ul>";
            $rivi = $kysely->fetch();
        }
    } else {
        echo "<ul style=list-style-type:disc;>";
        echo "<li>";
        echo "<p>Yhtäkään käytettyä tarviketta ei ole vielä lisätty!</p>";
        echo "</li>";
        echo "</ul>";
    }

    echo "<footer>";
    echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
    echo "</footer>";

?>
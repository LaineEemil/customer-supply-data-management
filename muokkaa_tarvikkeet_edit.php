<?php
require 'yhteys.php';

    $kysely = $yhteys->prepare('SELECT * FROM ktarvikkeet WHERE kohdetunnus = ?');
    $tulos = $kysely->execute(array($_GET["tyokohde"]));
    $rivi = $kysely->fetch();

    echo "<link rel=stylesheet type=text/css href=./styles.css>";

    echo "<h1> Poista tai muokkaa käytettyjä tarvikkeita </h1>";

    if (!empty($rivi)) {
        
        while($rivi) {

            echo "<ul>";
            echo "<li>";
            echo "<form action=muokkaa_tarvikkeet_edit_select.php?ktunnus=$rivi[ktarviketunnus]&tyokohde=$_GET[tyokohde] method=post>". "Tarvikkeen nimi: " . $rivi["nimi"]. " | Määrä: " . 
                $rivi["maara"]. " | Päivämäärä: " . $rivi["paivamaara"]. " | <input type=submit id=nappi value=".'"'."Muokkaa tietoja".'"'."> </input>".
                " <button type=button id=poistonappi" . " onclick=".'"'."window.location= 'poista_tarvikkeet_edit_select.php?ktunnus=$rivi[ktarviketunnus]'".'"'." >Poista</button> ". "</form action>"."<br>"; 
            echo "</li>";
            echo "</ul>";
            $rivi = $kysely->fetch();
        }

    } else {
        echo "<ul>";
        echo "<li>";
        echo "<p>Yhtäkään käytettyä tarviketta ei ole vielä lisätty!</p>";
        echo "</li>";
        echo "</ul>";
    }

    echo "<footer>";
    echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
    echo "</footer>";
?>
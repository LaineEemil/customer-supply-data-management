<?php
require 'yhteys.php';

    echo "<link rel=stylesheet type=text/css href=styles.css>";

    $kysely = $yhteys->prepare('SELECT * FROM tyokohde');
    $tulos = $kysely->execute();
    $rivi = $kysely->fetch();

    echo "<link rel=stylesheet type=text/css href=styles.css>";

    echo "<h1> Valitse työkohde laskua varten </h1>";


    if (!empty($rivi)) {

        // Lisätään lippu, jos työkohteita ei löydy työkohteita, joilla ei ole laskua.
        $löytyi = false;

        while($rivi) {

            // Haetaan laskuista kohdetunnusken avulla onko lasku kohteelle luotu jo.
            $kysely_l = $yhteys->prepare('SELECT * FROM lasku WHERE kohdetunnus = ?');
            $tulos_l = $kysely_l->execute(array($rivi["kohdetunnus"]));
            $rivi_l = $kysely_l->fetch();

            // Haetaan kohteesta löytyvän atunnuksen avulla asiakkaan tiedot.
            $kysely_a = $yhteys->prepare('SELECT nimi FROM asiakas WHERE atunnus = ?');
            $tulos_a = $kysely_a->execute(array($rivi["atunnus"]));
            $rivi_a = $kysely_a->fetch();

            if (!empty($rivi_l["laskutunnus"])) {
                $rivi = $kysely->fetch();
            } else {
                $löytyi = true;
                echo "<ul style=list-style-type:disc;>";
                echo "<li>";
                echo "<form action=tuntityolasku_ale_luo.php?tyokohde=$rivi[kohdetunnus] method=post>". "Asiakkaan nimi: " . str_replace("”","ö",str_replace("„","ä", $rivi_a["nimi"])). " | Kohteen osoite: " . 
                str_replace("„","ä", $rivi["osoite"]) . " | Kohteen kuvaus: " . str_replace("”","ö",str_replace("„","ä", $rivi["kuvaus"])) . " | <input type=submit id=nappi value=".'"'."Luo tuntityölasku".'"'.">"."</form action>"."<br>";
                echo "</li>";
                echo "</ul>";
                $rivi = $kysely->fetch();
            }
        }

    } else {
        echo "<ul style=list-style-type:disc;>";
        echo "<li>";
        echo "<p>Yhtäkään työkohdetta ei ole vielä lisätty!</p>";
        echo "</li>";
        echo "</ul>";
    }

    if ($löytyi == false) {
        echo "<ul style=list-style-type:disc;>";
        echo "<li>";
        echo "<p>Kaikilla työkohteilla on jo tuntityölaskut lisättynä!</p>";
        echo "</li>";
        echo "</ul>";
    }

    echo "<footer>";
    echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
    echo "</footer>";

?>
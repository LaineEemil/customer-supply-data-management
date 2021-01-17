<?php
require 'yhteys.php';

    $kysely = $yhteys->prepare('SELECT * FROM tarvikkeet');
    $tulos = $kysely->execute();
    $rivi = $kysely->fetch();

    echo "<link rel=stylesheet type=text/css href=styles.css>";
    
    if (!empty($rivi)) {

        while($rivi) {

            $ttunnus = $rivi["tarviketunnus"];
            $maara = $_POST[$ttunnus . "maara"];
            $nimi = str_replace("”","ä",str_replace("„","ä",$rivi["nimi"]));

            if (!empty($maara) && intval($maara) > 0 && !empty($_POST[$ttunnus]) && intval($maara) <= $rivi["varastotilanne"]) {

                $id = uniqid('kaytetty');
                $kysely_1 = $yhteys->prepare('INSERT INTO ktarvikkeet (ktarviketunnus,kohdetunnus,tarviketunnus,nimi,maara,paivamaara) VALUES (?,?,?,?,?,?)');
                $onnistuiko_1 = $kysely_1->execute(array($id, $_POST["kohdetunnus"], $_POST[$ttunnus], $nimi, $maara, $_POST["paivamaara"]));
                $kysely_2 = $yhteys->prepare('UPDATE tarvikkeet SET varastotilanne = ? WHERE tarviketunnus = ?');
                $onnistuiko_2 = $kysely_2->execute(array($maara, $ttunnus));

            } else if ($maara == 0) {

            } else {
                echo "<p id=epaonnistui > Tuotetta: ". $nimi . " ei ole tarpeeksi varastossa!</p>";
            }
        
            $rivi = $kysely->fetch();

        }

    } else {
        echo "<ul style=list-style-type:disc;>";
        echo "<li>";
        echo "<p>Yhtäkään tarviketta ei ole vielä lisätty!</p>";
        echo "</li>";
        echo "</ul>";
    }

    echo "<p id=onnistui> Käytetyt tarvikkeet on päivitetty onnistuneesti </p> <br>";

    echo "<footer>";
    echo "<h3><a href=valitsetuotteet.php?tyokohde=" . $_POST["kohdetunnus"] . ">Lisää käytettyjä tuotteita samalle asiakkaalle</a></h3>";
    echo "<h3><a href=tyokohteet_tarvikkeet.php?>Lisää käytettyjä tuotteita toiselle asiakkaalle</a></h3>";
    echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
    echo "</footer>";

?>
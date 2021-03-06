<?php
require 'yhteys.php';

    echo "<link rel=stylesheet type=text/css href=styles.css>";

    if (!empty($_GET['ktunnus'])) {

        $kysely_t = $yhteys->prepare('SELECT * FROM ktarvikkeet WHERE ktarviketunnus = ?');
        $tulos_t = $kysely_t->execute(array($_GET["ktunnus"]));
        $rivi_t = $kysely_t->fetch();

        $kysely = $yhteys->prepare('SELECT * FROM tarvikkeet WHERE tarviketunnus = ?');
        $tulos = $kysely->execute(array($rivi_t["tarviketunnus"]));
        $rivi = $kysely->fetch();

        $vanha_maara = $rivi_t["maara"];
        $vanha_varasto = $rivi["varastotilanne"];
        $varastotilanne = $rivi["varastotilanne"] + $rivi_t["maara"];

        try{ 
            $kysely1 = $yhteys->prepare('DELETE FROM ktarvikkeet WHERE ktarviketunnus = ?');
            $onnistuiko1 = $kysely1->execute(array($_GET['ktunnus']));
            $kysely2 = $yhteys->prepare('UPDATE tarvikkeet SET varastotilanne = ? WHERE tarviketunnus = ?');
            $onnistuiko2 = $kysely2->execute(array($varastotilanne, $rivi_t['tarviketunnus']));
            if ($onnistuiko1 && $onnistuiko2) { 
                echo "<p id=onnistui> Poisto onnistui </p>" . $rivi_t["nimi"] . "<br> Päivämäärältä " . $rivi_t["paivamaara"] . " ----> poistettu ";
                echo "<p id=onnistui> Varastotilanteen muokkaus onnistui </p>" . $rivi_t["nimi"] . " varastotilanne " . $vanha_varasto . " ---> " . $varastotilanne;
            }

        } catch (PDOException $e) {
            echo " <p id=epaonnistui> Poisto epäonnistui </p> ";
        }
    } else {
        echo "<p id=epaonnistui> Poisto epäonnistui </p>";
    }

    echo "<footer>";
    echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
    echo "</footer>";

?>
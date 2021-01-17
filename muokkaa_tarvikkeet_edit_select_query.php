<?php
require 'yhteys.php';

    echo "<link rel=stylesheet type=text/css href=styles.css>";

    if (!empty($_GET['ktunnus']) && !empty($_POST['maara'])) {
        
        $kysely_t = $yhteys->prepare('SELECT * FROM ktarvikkeet WHERE ktarviketunnus = ?');
        $tulos_t = $kysely_t->execute(array($_GET["ktunnus"]));
        $rivi_t = $kysely_t->fetch();

        $kysely = $yhteys->prepare('SELECT * FROM tarvikkeet WHERE tarviketunnus = ?');
        $tulos = $kysely->execute(array($rivi_t["tarviketunnus"]));
        $rivi = $kysely->fetch();

        $vanha_maara = $rivi_t["maara"];
        $vanha_varasto = $rivi["varastotilanne"];
        $varastotilanne = $rivi["varastotilanne"] + ($rivi_t["maara"] - $_POST["maara"]);

        if (intval($rivi_t["maara"]) <= $rivi["varastotilanne"])
        try{
            $kysely1 = $yhteys->prepare('UPDATE ktarvikkeet SET maara = ? WHERE ktarviketunnus = ?');
            $onnistuiko1 = $kysely1->execute(array($_POST["maara"], $_GET['ktunnus']));
            $kysely2 = $yhteys->prepare('UPDATE tarvikkeet SET varastotilanne = ? WHERE tarviketunnus = ?');
            $onnistuiko2 = $kysely2->execute(array($varastotilanne, $rivi_t['tarviketunnus']));
            if ($onnistuiko1 && $onnistuiko2) {
                echo "<p id=onnistui> Käytettyjen muokkaus onnistui </p>" . $rivi_t["nimi"] . " määrä " . $vanha_maara . " ---> " . $_POST["maara"];
                echo "<p id=onnistui> Varastotilanteen muokkaus onnistui </p>" . $rivi_t["nimi"] . " varastotilanne " . $vanha_varasto . " ---> " . $varastotilanne;

            }
        } catch (PDOException $e) {
            echo "<p id=epaonnistui> Muokkaus epäonnistui </p>";
        }
    } else {
        echo "<p id=epaonnistui> Muokkaus epäonnistui </p>";
    }

    echo "<footer>";
    echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
    echo "</footer>";

?>
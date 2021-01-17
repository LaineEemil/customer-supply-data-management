<?php
require 'yhteys.php';

    echo "<link rel=stylesheet type=text/css href=styles.css>";

    $kysely = $yhteys->prepare('SELECT * FROM tyokohde WHERE atunnus = ?');
    $tulos = $kysely->execute(array($_GET["atunnus"]));
    $rivi = $kysely->fetch();

    $kysely_a = $yhteys->prepare('SELECT * FROM asiakas WHERE atunnus = ?');
    $tulos_a = $kysely_a->execute(array($_GET["atunnus"]));
    $rivi_a = $kysely_a->fetch();

    if (!empty($_GET['atunnus']) && empty($rivi['osoite'])) {

        try{ 

            $kysely = $yhteys->prepare('DELETE FROM asiakas WHERE atunnus = ?');
            $onnistuiko = $kysely->execute(array($_GET['atunnus']));
            
            if ($onnistuiko) { 
                echo "<p id=onnistui> Poisto onnistui </p>" . str_replace("”","ö",str_replace("„","ä", $rivi_a["nimi"])) . " ----> poistettu ";
            }

        } catch (PDOException $e) {
            echo " <p id=epaonnistui> Poisto epäonnistui! </p> ";
        }
    } else {
        echo "<p id=epaonnistui> Poista kaikki asiakkaan työkohteet ennen asiakkaan poistoa!</p>";
    }

    echo "<footer>";
    echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
    echo "</footer>";

?>
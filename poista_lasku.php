<?php
require 'yhteys.php';

    echo "<link rel=stylesheet type=text/css href=styles.css>";

    if (!empty($_GET['laskutunnus'])) {

        try{ 

            $kysely = $yhteys->prepare('DELETE FROM lasku WHERE laskutunnus = ?');
            $onnistuiko = $kysely->execute(array($_GET['laskutunnus']));
            
            if ($onnistuiko) { 
                echo "<p id=onnistui> Laskun poisto onnistui </p>";
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
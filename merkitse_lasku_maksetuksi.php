<?php
require 'yhteys.php';

header("Content-Type: text/html; charset=UTF-8");
echo "<link rel=stylesheet type=text/css href=styles.css>";

if (!empty($_GET['laskutunnus'])) {
    $kysely = $yhteys->prepare('SELECT * FROM lasku WHERE laskutunnus = ?');
    $tulos = $kysely ->execute(array($_GET["laskutunnus"]));
    $rivi = $kysely ->fetch();

    if ($rivi["maksettu"]) {

        $kysely = $yhteys->prepare('UPDATE lasku SET maksettu = ? WHERE laskutunnus = ?');
        $onnistuiko = $kysely->execute(array('f',$_GET["laskutunnus"]));
        if ($onnistuiko) {
            header("Location: laskut.php");
            die();
        }

    } else {
        $kysely = $yhteys->prepare('UPDATE lasku SET maksettu = ? WHERE laskutunnus = ?');
        $onnistuiko = $kysely->execute(array('t',$_GET["laskutunnus"]));
        if ($onnistuiko) {
            header("Location: laskut.php");
            die();
        }
    }
    
} else {
    header("Location: laskut.php");
    die();
}
?>
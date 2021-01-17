<?php
require 'yhteys.php';

echo "<link rel=stylesheet type=text/css href=styles.css>";

if (!empty($_POST['osoite']) && !empty($_POST['atunnus'])) {

    try{
        $id = uniqid('kohde');
        $kysely = $yhteys->prepare('INSERT INTO tyokohde (kohdetunnus,atunnus,kuvaus,osoite,postiosoite,suunnittelualennus,tyoalennus,aputyoalennus) VALUES (?,?,?,?,?,?,?,?)');
        $onnistuiko = $kysely->execute(array($id, $_POST["atunnus"], $_POST["kuvaus"], $_POST["osoite"], $_POST["postiosoite"],$_POST["suunnittelualennus"],$_POST["tyoalennus"],$_POST["aputyoalennus"]));
        if ($onnistuiko) {
            echo "<p id=onnistui>Työkohteen lisäys onnistui!</p>";
            echo "<footer>";
            echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
            echo "</footer>";
        }
    } catch (PDOException $e) {
        echo "<p id=epaonnistui>Työkohteen lisäys epäonnistui!</p>";
        echo "<footer>";
        echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
        echo "</footer>";
    }
} else {
    echo "<p id=epaonnistui>Työkohteen lisäys epäonnistui!</p>";
    echo "<footer>";
    echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
    echo "</footer>";
}
?>
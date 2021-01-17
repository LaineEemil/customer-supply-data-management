<?php
require 'yhteys.php';

echo "<link rel=stylesheet type=text/css href=styles.css>";

if (!empty($_POST['nimi']) && !empty($_POST['yksikko']) && !empty($_POST['varastotilanne']) 
    && !empty($_POST['ostohinta']) && !empty($_POST['myyntihinta'])&& !empty($_POST['alv'])) {

    try{
        $id = uniqid('tarvike');
        $kysely = $yhteys->prepare('INSERT INTO tarvikkeet (tarviketunnus,tuotetunnus,nimi,kuvaus,yksikko,varastotilanne,ostohinta,myyntihinta,alv) VALUES (?,?,?,?,?,?,?,?,?)');
        $onnistuiko = $kysely->execute(array($id,$_POST["tuotetunnus"],$_POST["nimi"],$_POST["kuvaus"], $_POST["yksikko"],
            $_POST["varastotilanne"], $_POST["ostohinta"], $_POST["myyntihinta"],$_POST["alv"]));

            if ($onnistuiko) {
                echo "<p id=onnistui>Tarvikkeen lisäys onnistui!</p>";
                echo "<footer>";
                echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
                echo "</footer>";
            }
        } catch (PDOException $e) {
            echo "<p id=epaonnistui>Tarvikkeen lisäys epäonnistui!</p>";
            echo "<footer>";
            echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
            echo "</footer>";
        }
    } else {
        echo "<p id=epaonnistui>Tarvikkeen lisäys epäonnistui!</p>";
        echo "<footer>";
        echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
        echo "</footer>";
    }
?>
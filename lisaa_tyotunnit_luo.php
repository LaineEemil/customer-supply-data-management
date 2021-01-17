<?php
require 'yhteys.php';

echo "<link rel=stylesheet type=text/css href=styles.css>";

if (!empty($_POST['paivamaara']) && !empty($_POST['kohdetunnus']) && !empty($_POST['tyonmaara']) && !empty($_POST['tyotapa'])) {
    try{
        $id = uniqid('tunti');
        $kysely = $yhteys->prepare('INSERT INTO tyotunnit (tuntitunnus,kohdetunnus,paivamaara,tyonmaara,tyotapa) VALUES (?,?,?,?,?)');
        $onnistuiko = $kysely->execute(array($id,$_POST["kohdetunnus"], $_POST["paivamaara"], $_POST["tyonmaara"],$_POST["tyotapa"]));
        if ($onnistuiko) {
            echo "<p id=onnistui>Työtuntien lisäys onnistui!</p>";
            echo "<footer>";
            echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
            echo "</footer>";
        }
    } catch (PDOException $e) {
        echo "<p id=epaonnistui>Työtuntien lisäys epäonnistui!</p>";
        echo "<footer>";
        echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
        echo "</footer>";
    }
} else {
    echo "<p id=epaonnistui>Työtuntien lisäys epäonnistui!</p>";
    echo "<footer>";
    echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
    echo "</footer>";
}
?>
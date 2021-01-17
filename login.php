<?php
require 'yhteys.php';

echo "<link rel=stylesheet type=text/css href=styles.css>";

if (!empty($_POST['sposti']) && !empty($_POST['salasana'])) {
    try{
        $kysely = $yhteys->prepare('SELECT sposti, salasana FROM login WHERE sposti = ? AND salasana = ?');
        $tulos = $kysely->execute(array($_POST["sposti"],$_POST["salasana"]));
        $yhteys = "SELECT sposti, salasana FROM login WHERE sposti = $_POST['sposti'] AND salasana = $_POST['salasana']";
        $tulos = 
        echo $_POST["sposti"];
        echo "<br>";
        echo $_POST["salasana"];
        $rivi = $kysely->fetch();
        if ($tulos) {
            while($rivi) {
                echo "<ul style=list-style-type:disc;>";
                echo "<li>";
                echo "Sähköposti: " . $rivi[0] . " | Salasana: " . $rivi[1] . "<br>";
                echo "</li>";
                echo "</ul>";
                $rivi = $kysely->fetch();
            }
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
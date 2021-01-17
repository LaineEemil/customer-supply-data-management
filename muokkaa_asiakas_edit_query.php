<?php
require 'yhteys.php';

header("Content-Type: text/html; charset=UTF-8");
echo "<link rel=stylesheet type=text/css href=styles.css>";

if (!empty($_POST['atunnus'])&&!empty($_POST['nimi']) && !empty($_POST['osoite'])&& !empty($_POST['puhnro']) && strpos($_POST["sposti"],"ä")===false && strpos($_POST["sposti"],"ö")===false) {

    try{
        $kysely = $yhteys->prepare('UPDATE asiakas SET nimi=?,osoite=?,postiosoite=?,puhnro=?,sposti=? WHERE atunnus = ?');
        $onnistuiko = $kysely->execute(array(str_replace("”","ö",str_replace("„","ä", $_POST["nimi"]))
            ,str_replace("”","ö",str_replace("„","ä", $_POST["osoite"])), $_POST["postiosoite"],$_POST["puhnro"],$_POST["sposti"],$_POST["atunnus"]));
        if ($onnistuiko) {
            echo "<p id=onnistui>Tietojen muokkaus onnistui!</p>";
        }
    } catch (PDOException $e) {
        echo "<p id=epaonnistui>Tietojen muokkaus epäonnistui!</p>";
    }
} else {
    echo "<p id=epaonnistui> Tietojen muokkaus epäonnistui!</p>";
}

echo "<footer>";
echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
echo "</footer>";
?>
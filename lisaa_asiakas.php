<?php
require 'yhteys.php';

header("Content-Type: text/html; charset=UTF-8");
echo "<link rel=stylesheet type=text/css href=styles.css>";

if (!empty($_POST['nimi']) && !empty($_POST['osoite'])&& !empty($_POST['puhnro']) && strpos($_POST["sposti"],"ä")===false && strpos($_POST["sposti"],"ö")===false) {

    try{
        $id = uniqid('asiakas');
        $kysely = $yhteys->prepare('INSERT INTO asiakas (atunnus,nimi,osoite,postiosoite,puhnro,sposti) VALUES (?,?,?,?,?,?)');
        $onnistuiko = $kysely->execute(array($id,$_POST["nimi"], $_POST["osoite"], $_POST["postiosoite"],$_POST["puhnro"],$_POST["sposti"]));
        if ($onnistuiko) {
            header("Location: lisays_onnistui.html");
            die();
        }
    } catch (PDOException $e) {
        header("Location: lisays_virhe.html");
        die();
    }
} else {
    header("Location: lisays_virhe.html");
    die();
}
?>
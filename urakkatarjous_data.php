<?php
require 'yhteys.php';

echo "<link rel=stylesheet type=text/css href=styles.css>";

$kysely = $yhteys->prepare('SELECT * FROM tyokohde WHERE kohdetunnus = ?');
$tulos = $kysely->execute(array($_GET["tyokohde"]));
$rivi = $kysely->fetch();


echo "<title> Muodosta urakkatarjous kohteelle </title>";
echo "</head>";
echo "<body>";
echo "<form action=urakkatarjous_yhteenveto.php method=POST>";
echo "<fieldset>";

echo "<input type=hidden name=atunnus value=".'"'.$_GET["asiakas"].'"'."/>";
echo "<input type=hidden name=kohdetunnus  value=".'"'.$_GET["tyokohde"].'"'."/>";

echo "<legend>Lisää urakkatarjoukseen työtunteja</legend>";
echo "<label for=asennustyo>Asennustyö: </label> <br>";
echo "<input type=number name=tyo step=. value=".'"'."0".'"'."/> Tuntia <br>";
echo "<label for=tyoalennus>Alennus: </label> <br>";
echo "<input type=number name=tyoalennus step=. value=". '"' . $rivi["tyoalennus"] . '"' . "/> % <br> <br>";

echo "<label for=suunnittelutyo>Suunnittelutyö: </label> <br>";
echo "<input type=number name=suunnittelu step=. value=".'"'."0".'"'."/> Tuntia <br>";
echo "<label for=suunnittelualennus>Alennus: </label> <br>";
echo "<input type=number name=suunnittelualennus step=. value=". '"' . $rivi["suunnittelualennus"] . '"' . "/> % <br> <br>";

echo "<label for=aputyo>Aputyö : </label> <br>";
echo "<input type=number name=aputyo step=. value=".'"'."0".'"'."/> Tuntia <br>";
echo "<label for=aputyoalennus>Alennus: </label> <br>";
echo "<input type=number name=aputyoalennus step=. value=". '"' . $rivi["aputyoalennus"] . '"' . "/> % <br> <br>";
echo "</fieldset>";

$kysely = $yhteys->prepare('SELECT * FROM tarvikkeet');
$tulos = $kysely->execute();
$rivi = $kysely->fetch();

    if (!empty($_GET["tyokohde"])) {
        $ktunnus = $_GET["tyokohde"];
    }

    if (!empty($rivi)) {

        echo "<fieldset>";
        echo "<legend>Lisää työtarvikkeita urakkatarjoukseen</legend>";

        while ($rivi) {
            echo "<input type=checkbox name=" . '"' . $rivi["tarviketunnus"] . '"' . "value=" . $rivi["tarviketunnus"] . ">";
            echo " | <label for=" . $rivi["nimi"] . ">" . str_replace("”","ö",str_replace("„","ä", $rivi["nimi"])) . "</label>";
            echo " <input type=number step=. name=" . '"' . $rivi["tarviketunnus"] . "maara" . '"' . " value=".'"'."0".'"'."> " . $rivi["yksikko"];
            echo " | <label for=". '"' . $rivi["tarviketunnus"] . "alennus" . '"' . ">" . "Alennus: " . "</label>";
            echo "<input type=number name=". '"' . $rivi["tarviketunnus"] . "alennus" . '"' . " step=. value=". '"' . "0" . '"' . "/> % <br> <br>";
            $rivi = $kysely->fetch();
        }
        echo "</fieldset> <br>";
        echo "<input type=submit id=nappi value=".'"'."Avaa urakkalasku".'"'.">";
        echo "</form>";

    } else {
        echo "<ul style=list-style-type:disc;>";
        echo "<li>";
        echo "<p>Yhtäkään työtarviketta ei ole vielä lisätty!</p>";
        echo "</li>";
        echo "</ul>";
    }

    echo "<footer>";
    echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
    echo "</footer>";

?>

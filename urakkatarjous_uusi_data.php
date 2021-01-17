<?php
require 'yhteys.php';

echo "<link rel=stylesheet type=text/css href=styles.css>";

echo "<title> Muodosta urakkatarjous kohteelle </title>";
echo "</head>";
echo "<body>";
echo "<form action=urakkatarjous_yhteenveto.php method=POST>";

echo "<fieldset>";
echo "<legend>Lisää urakalle asiakkaan- ja kohteentiedot</legend>";
echo "<label for=nimi>Asiakkaan kokonimi: </label> <br>";
echo "<input type=text name=nimi/> <br> <br>";
echo "<label for=aosoite>Asiakkaan osoite: </label> <br>";
echo "<input type=text name=aosoite/> <br> <br>";
echo "<label for=pnumero>Postinumero : </label> <br>";
echo "<input type=number name=pnumero step=. value=0/> <br> <br>";
echo "<label for=kaupunki>Kaupunki : </label> <br>";
echo "<input type=text name=kaupunki/> <br> <br>";
echo "</fieldset>";

echo "<fieldset>";
echo "<legend>Lisää urakalle asiakkaan- ja kohteentiedot</legend>";
echo "<label for=nimi>Asiakkaan kokonimi: </label> <br>";
echo "<input type=text name=nimi/> <br> <br>";
echo "<label for=aosoite>Asiakkaan osoite: </label> <br>";
echo "<input type=text name=aosoite/> <br> <br>";
echo "<label for=pnumero>Postinumero : </label> <br>";
echo "<input type=number name=pnumero step=. value=0/> <br> <br>";
echo "<label for=kaupunki>Kaupunki : </label> <br>";
echo "<input type=text name=kaupunki/> <br> <br>";
echo "</fieldset>";

echo "<input type=checkbox name=tallennetaan value=true";
echo "<label for=tasiakas> Tallennetaanko asiakkaan- ja kohteentiedot tietokantaan? </label>";

echo "<fieldset>";
echo "<legend>Lisää hinta-arvioon työtunteja</legend>";
echo "<label for=asennustyo>Asennustyö: </label> <br>";
echo "<input type=number name=asennustyo step=. value=0/> Tuntia <br> <br>";
echo "<label for=suunnittelutyo>Suunnittelutyö: </label> <br>";
echo "<input type=number name=suunnittelutyo step=. value=0/> Tuntia <br> <br>";
echo "<label for=aputyo>Aputyö : </label> <br>";
echo "<input type=number name=aputyo step=. value=0/> Tuntia <br> <br>";
echo "</fieldset>";

$kysely = $yhteys->prepare('SELECT * FROM tarvikkeet');
$tulos = $kysely->execute();
$rivi = $kysely->fetch();

    if (!empty($_GET["tyokohde"])) {
        $ktunnus = $_GET["tyokohde"];
    }

    if (!empty($rivi)) {

        echo "<fieldset>";
        echo "<legend>Lisää työtarvikkeita hinta-arvioon</legend>";

        while ($rivi) {
            echo "<input type=checkbox name=" . '"' . $rivi["tarviketunnus"] . '"' . "value=" . $rivi["tarviketunnus"] . ">";
            echo " <label for=" . $rivi["nimi"] . ">" . $rivi["nimi"] . "</label>";
            echo " <input type=number step=. name=" . '"' . $rivi["tarviketunnus"] . "maara" . '"' . " > " . $rivi["yksikko"] . "<br> <br>";
            $rivi = $kysely->fetch();
        }
        echo "</fieldset> <br>";
        echo "<input type=submit id=nappi value=Submit>";
        echo "</form>";

    } else {
        echo "<ul style=list-style-type:disc;>";
        echo "<li>";
        echo "<p>Yhtäkään asiakasta ei ole vielä lisätty!</p>";
        echo "</li>";
        echo "</ul>";
    }

    echo "<footer>";
    echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
    echo "</footer>";

?>

<?php
require 'yhteys.php';

echo "<link rel=stylesheet type=text/css href=styles.css>";

echo "<title> Muodosta tuntityölasku kohteelle </title>";
echo "</head>";
echo "<body>";
echo "<form action=tuntityolasku_ale_luo_yhteenveto.php?tyokohde=" . $_GET["tyokohde"] . " method=POST>";

if (!empty($_GET["tyokohde"])) {
    $ktunnus = $_GET["tyokohde"];
}

echo "<fieldset>";
echo "<legend>Anna päivämäärä, johon mennessä tehdyt työt ja käytetyt tarvikkeet lisätään laskulle</legend>";
echo "<label for=paivamaara> Päivämäärä: </label> <br>";
echo "<input type=date name=paivamaara value=". '"'. date("Y-m-d") . '"' . " />  <br> <br>" ;
echo "</fieldset><fieldset>";
echo "<legend>Anna laskulle eräpäivä</legend>";
echo "<label for=erapaiva> Eräpäivä: </label> <br>";
echo "<input type=date name=erapaiva />  <br> <br>" ;
echo "</fieldset> <br>";


$kysely = $yhteys->prepare('SELECT * FROM ktarvikkeet WHERE kohdetunnus = ?');
$tulos = $kysely->execute(array($ktunnus));
$rivi = $kysely->fetch();

    if (!empty($_GET["tyokohde"])) {
        $ktunnus = $_GET["tyokohde"];
    }

    if (!empty($rivi)) {
        $loydetyt = array();

        echo "<fieldset>";
        echo "<legend>Lisää työtarvikkeille alennuksia</legend>";

        while ($rivi) {
            if (!in_array($rivi["tarviketunnus"],$loydetyt)) {
                echo "<label for=" . $rivi["nimi"] . ">" . str_replace("”","ö",str_replace("„","ä", $rivi["nimi"])) . "</label>";
                echo " | <label for=". '"' . $rivi["tarviketunnus"] . "alennus" . '"' . ">" . "Alennus: " . "</label>";
                echo "<input type=number name=". '"' . $rivi["tarviketunnus"] . "alennus" . '"' . " step=. value=". '"' . "0" . '"' . "/> % <br> <br>";
                array_push($loydetyt,$rivi["tarviketunnus"]);
            }
            $rivi = $kysely->fetch();
        }
        echo "</fieldset> <br>";

    } else {
        echo "<ul style=list-style-type:disc;>";
        echo "<li>";
        echo "<p>Yhtäkään käytettyä työtarviketta ei ole vielä kohteelle!</p>";
        echo "</li>";
        echo "</ul>";
    }

    echo "<input type=submit id=nappi value=".'"'."Tulosta tuntityölasku".'"'.">";
    echo "</form>";

    echo "<footer>";
    echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
    echo "</footer>";

?>

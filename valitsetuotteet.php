<?php
require 'yhteys.php';

    $kysely = $yhteys->prepare('SELECT * FROM tarvikkeet');
    $tulos = $kysely->execute();
    $rivi = $kysely->fetch();

    echo "<link rel=stylesheet type=text/css href=styles.css>";
    
    if (!empty($_GET["tyokohde"])) {
        $ktunnus = $_GET["tyokohde"];
    }

    echo "<h1> Valitse kohteessa käytetyt tarvikkeet </h1>";
        if (!empty($rivi)) {
            echo "<form action=valitsetuotteet_kaytetyt.php method=POST>";

            echo "<label for=paivamaara>Päivämäärä: </label> <br>";
            echo "<input type=date id=paivamaara name=paivamaara value="."'".date("Y-m-d")."'"."> </input>  <br> <br>";

            while($rivi) {
                echo "<input type=checkbox name=".'"'.$rivi["tarviketunnus"].'"' . "value=".$rivi["tarviketunnus"] . ">";
                echo " <label for=". $rivi["nimi"] . ">". str_replace("”","ä",str_replace("„","ä",$rivi["nimi"])) . "</label> <br>";
                echo " <input type=number step=. name=".'"'.$rivi["tarviketunnus"]."maara".'"'. " value=".'"'."0".'"'."> ". $rivi["yksikko"] . " <br> <br>";
                $rivi = $kysely->fetch();
            }
            echo "<input type=hidden name=kohdetunnus value=". $ktunnus . ">";
            echo "<input type=submit id=nappi value=".'"'."Lisää kohteessa käytetyt tarvikkeet".'"'.">";
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
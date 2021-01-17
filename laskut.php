<?php
require 'yhteys.php';

    $kysely_1 = $yhteys->prepare('SELECT * FROM lasku WHERE erapaiva < ? AND maksettu = ?');
    $tulos_1 = $kysely_1 ->execute(array(date("d-m-Y"),'f'));
    $rivi_1 = $kysely_1 ->fetch();

    echo "<link rel=stylesheet type=text/css href=styles.css>";

    echo "<h1> Eräpäivään: " . date("d/m/Y") . " mennessä maksamattomat laskut</h1>";

    if (!empty($rivi_1)) {

        while($rivi_1) {

            // Haetaan kohteen tiedot kohdetunnuksen avulla.
            $kysely_k = $yhteys->prepare('SELECT * FROM tyokohde WHERE kohdetunnus = ?');
            $tulos_k = $kysely_k->execute(array($rivi_1["kohdetunnus"]));
            $rivi_k = $kysely_k->fetch();

            // Haetaan asiakkaan tiedot atunnuksen avulla.
            $kysely_a = $yhteys->prepare('SELECT * FROM asiakas WHERE atunnus = ?');
            $tulos_a = $kysely_a->execute(array($rivi_k["atunnus"]));
            $rivi_a = $kysely_a->fetch();
            if (!empty($rivi_1["edellisenlaskuntunnus"])) {    

                echo "<ul style=list-style-type:disc;>";
                echo "<li>";
                echo "<form action=tuntityolasku_yhteenveto.php?tyokohde=$rivi_1[kohdetunnus] method=post>";
                echo "<input type=hidden name=paivamaara value=" . '"' . $rivi_1["paivamaara"] . '"' . ">";
                echo "<input type=hidden name=erapaiva value=" . '"' . $rivi_1 ["erapaiva"] . '"' . ">";
                echo "Asiakkaan nimi: " . str_replace("”","ö",str_replace("„","ä",$rivi_a["nimi"])) . " | Kohteen osoite: " ;
                echo str_replace("”","ö",str_replace("„","ä",$rivi_k["osoite"])) . " | Kohteen kuvaus: " . str_replace("”","ö",str_replace("„","ä",$rivi_k["kuvaus"]));
                echo " | <input type=submit id=keltanappi value=" . '"'. "Tulosta muistutuslasku". '"' . ">";
                echo " | <button type=button id=keltavihreanappi" . " onclick=".'"'."window.location= 'merkitse_lasku_lahetetyksi.php?laskutunnus=$rivi_1[laskutunnus]'".'"'." > " . "Merkitse muistutuslasku lähetetyksi" . "</button>";
                echo " | <button type=button id=nappi" . " onclick=".'"'."window.location= 'merkitse_lasku_maksetuksi.php?laskutunnus=$rivi_1[laskutunnus]'".'"'." >" . "Merkitse maksetuksi" . "</button>";
                echo "</form action>";
                echo "</li>";
                echo "</ul>";
            } else {
                echo "<ul style=list-style-type:disc;>";
                echo "<li>";
                echo "<form action=tuntityolasku_yhteenveto.php?tyokohde=$rivi_1[kohdetunnus] method=post>";
                echo "<input type=hidden name=paivamaara value=" . '"' . $rivi_1["paivamaara"] . '"' . ">";
                echo "<input type=hidden name=erapaiva value=" . '"' . $rivi_1 ["erapaiva"] . '"' . ">";
                echo "Asiakkaan nimi: " . str_replace("”","ö",str_replace("„","ä",$rivi_a["nimi"])) . " | Kohteen osoite: " ;
                echo str_replace("”","ö",str_replace("„","ä",$rivi_k["osoite"])) . " | Kohteen kuvaus: " . str_replace("”","ö",str_replace("„","ä",$rivi_k["kuvaus"]));
                echo " | <input type=submit id=keltanappi value=" . '"'. "Tulosta muistutuslasku". '"' . ">";
                echo " | <button type=button id=keltavihreanappi" . " onclick=".'"'."window.location= 'merkitse_lasku_lahetetyksi.php?laskutunnus=$rivi_1[laskutunnus]'".'"'." > " . "Merkitse muistutuslasku lähetetyksi" . "</button>";
                echo " | <button type=button id=nappi" . " onclick=".'"'."window.location= 'merkitse_lasku_maksetuksi.php?laskutunnus=$rivi_1[laskutunnus]'".'"'." >" . "Merkitse maksetuksi" . "</button>";
                echo "</form action>";
                echo "</li>";
                echo "</ul>";
            }
            
            $rivi_1 = $kysely_1->fetch();
        }
    } else {
        echo "<ul style=list-style-type:disc;>";
        echo "<li>";
        echo "<p>Yhtäkään yli maksuajan olevaa laskua ei löytynyt!</p>";
        echo "</li>";
        echo "</ul>";
    }

    $kysely_2 = $yhteys->prepare('SELECT * FROM lasku WHERE erapaiva >= ? AND maksettu = ?');
    $tulos_2 = $kysely_2->execute(array(date("d-m-Y"),'f'));
    $rivi_2 = $kysely_2->fetch();

    echo "<link rel=stylesheet type=text/css href=styles.css>";

    echo "<h1> Maksamattomat laskut </h1>";

    if (!empty($rivi_2)) {

        while($rivi_2) {

            // Haetaan kohteen tiedot kohdetunnuksen avulla.
            $kysely_k = $yhteys->prepare('SELECT * FROM tyokohde WHERE kohdetunnus = ?');
            $tulos_k = $kysely_k->execute(array($rivi_2["kohdetunnus"]));
            $rivi_k = $kysely_k->fetch();

            // Haetaan asiakkaan tiedot atunnuksen avulla.
            $kysely_a = $yhteys->prepare('SELECT * FROM asiakas WHERE atunnus = ?');
            $tulos_a = $kysely_a->execute(array($rivi_k["atunnus"]));
            $rivi_a = $kysely_a->fetch();
            
            if (!empty($rivi_2["lahetettypaivamaara"])) {
                echo "<ul style=list-style-type:disc;>";
                echo "<li>";
                echo "<form action=tuntityolasku_yhteenveto.php?tyokohde=$rivi_2[kohdetunnus] method=post>";
                echo "<input type=hidden name=paivamaara value=" . '"' . $rivi_2["paivamaara"] . '"' . ">";
                echo "<input type=hidden name=erapaiva value=" . '"' . $rivi_2["erapaiva"] . '"' . ">";
                echo "Lähetetty : " . $rivi_2["lahetettypaivamaara"];
                echo " | Asiakkaan nimi: " . str_replace("”","ö",str_replace("„","ä",$rivi_a["nimi"])) . " | Kohteen osoite: " ;
                echo str_replace("”","ö",str_replace("„","ä",$rivi_k["osoite"])) . " | Kohteen kuvaus: " . str_replace("”","ö",str_replace("„","ä",$rivi_k["kuvaus"]));
                echo " | <input type=submit id=keltanappi value=" . '"'. "Tulosta lasku". '"' . ">";
                echo " | <button type=button id=keltavihreanappi" . " onclick=".'"'."window.location= 'merkitse_lasku_maksetuksi.php?laskutunnus=$rivi_2[laskutunnus]'".'"'." >" . "Merkitse maksetuksi" . "</button>";
                echo "</form action>";
                echo "</li>";
                echo "</ul>";
            } else {

                echo "<ul style=list-style-type:disc;>";
                echo "<li>";
                echo "<form action=tuntityolasku_yhteenveto.php?tyokohde=$rivi_2[kohdetunnus] method=post>";
                echo "<input type=hidden name=paivamaara value=" . '"' . $rivi_2["paivamaara"] . '"' . ">";
                echo "<input type=hidden name=erapaiva value=" . '"' . $rivi_2["erapaiva"] . '"' . ">";
                echo "Asiakkaan nimi: " . str_replace("”","ö",str_replace("„","ä",$rivi_a["nimi"])) . " | Kohteen osoite: " ;
                echo str_replace("”","ö",str_replace("„","ä",$rivi_k["osoite"])) . " | Kohteen kuvaus: " . str_replace("”","ö",str_replace("„","ä",$rivi_k["kuvaus"]));
                echo " | <input type=submit id=keltanappi value=" . '"'. "Tulosta lasku". '"' . ">";
                echo " | <button type=button id=keltavihreanappi" . " onclick=".'"'."window.location= 'merkitse_lasku_lahetetyksi.php?laskutunnus=$rivi_2[laskutunnus]'".'"'." > " . "Merkitse lähetetyksi" . "</button>";
                echo " | <button type=button id=nappi" . " onclick=".'"'."window.location= 'merkitse_lasku_maksetuksi.php?laskutunnus=$rivi_2[laskutunnus]'".'"'." > " . "Merkitse maksetuksi" . "</button>";
                echo "</form action>";
                echo "</li>";
                echo "</ul>";
            }
            $rivi_2 = $kysely_2->fetch();
        }
    } else {
        echo "<ul style=list-style-type:disc;>";
        echo "<li>";
        echo "<p>Yhtäkään maksamatonta laskua ei löydy!</p>";
        echo "</li>";
        echo "</ul>";
    }

    $kysely_3 = $yhteys->prepare('SELECT * FROM lasku WHERE maksettu = ?');
    $tulos_3 = $kysely_3 ->execute(array('t'));
    $rivi_3 = $kysely_3 ->fetch();

    echo "<link rel=stylesheet type=text/css href=styles.css>";

    echo "<h1> Maksetut laskut </h1>";

    if (!empty($rivi_3)) {

        while($rivi_3) {

            // Haetaan kohteen tiedot kohdetunnuksen avulla.
            $kysely_k = $yhteys->prepare('SELECT * FROM tyokohde WHERE kohdetunnus = ?');
            $tulos_k = $kysely_k->execute(array($rivi_3["kohdetunnus"]));
            $rivi_k = $kysely_k->fetch();

            // Haetaan asiakkaan tiedot atunnuksen avulla.
            $kysely_a = $yhteys->prepare('SELECT * FROM asiakas WHERE atunnus = ?');
            $tulos_a = $kysely_a->execute(array($rivi_k["atunnus"]));
            $rivi_a = $kysely_a->fetch();            

            echo "<ul style=list-style-type:disc;>";
            echo "<li>";
            echo "<form action=tuntityolasku_yhteenveto.php?tyokohde=$rivi_3[kohdetunnus] method=post>";
            echo "<input type=hidden name=paivamaara value=" . '"' . $rivi_3["paivamaara"] . '"' . ">";
            echo "<input type=hidden name=erapaiva value=" . '"' . $rivi_3["erapaiva"] . '"' . ">";
            echo "Asiakkaan nimi: " . str_replace("”","ö",str_replace("„","ä",$rivi_a["nimi"])) . " | Kohteen osoite: " ;
            echo str_replace("”","ö",str_replace("„","ä",$rivi_k["osoite"])) . " | Kohteen kuvaus: " . str_replace("”","ö",str_replace("„","ä",$rivi_k["kuvaus"]));
            echo " | <input type=submit id=keltanappi value=".'"'."Tulosta lasku".'"'.">";
            echo " | <button type=button id=poistonappi" . " onclick=".'"'."window.location= 'merkitse_lasku_maksetuksi.php?laskutunnus=$rivi_3[laskutunnus]'".'"'." >Merkitse-ei-maksetuksi</button>";
            echo " | <button type=button id=poistonappi" . " onclick=".'"'."window.location= 'poista_lasku.php?laskutunnus=$rivi_3[laskutunnus]'".'"'." >Poista</button>";
            echo "</form action>";
            echo "</li>";
            echo "</ul>";
            $rivi_3 = $kysely_3->fetch();
        }
    } else {
        echo "<ul style=list-style-type:disc;>";
        echo "<li>";
        echo "<p>Yhtäkään maksettua laskua ei löytynyt!</p>";
        echo "</li>";
        echo "</ul>";
    }

    echo "<footer>";
    echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
    echo "</footer>";

?>
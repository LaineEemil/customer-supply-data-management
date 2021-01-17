<?php
require 'yhteys.php';

// Haetaan kohteen tiedot
$kysely = $yhteys->prepare('SELECT * FROM tyokohde WHERE kohdetunnus = ?');
$tulos = $kysely->execute(array($_GET["tyokohde"]));
$rivi_kohde = $kysely->fetch();

// Haetaan asiakkaan tiedot
$kysely = $yhteys->prepare('SELECT * FROM asiakas WHERE atunnus = ?');
$tulos = $kysely->execute(array($rivi_kohde["atunnus"]));
$rivi_asiakas = $kysely->fetch();

// Haetaan tehtyjen tuntien tiedot
$kysely_tunnit = $yhteys->prepare('SELECT * FROM tyotunnit WHERE kohdetunnus = ? AND paivamaara <= ? ORDER BY paivamaara ASC');
$tulos_tunnit = $kysely_tunnit->execute(array($_GET["tyokohde"],$_POST["paivamaara"]));
$rivi_tunnit = $kysely_tunnit->fetch();

// Haetaan käytettyjen tarvikkeiden tiedot
$kysely_käytetyt = $yhteys->prepare('SELECT * FROM ktarvikkeet WHERE kohdetunnus = ? AND paivamaara <= ? ORDER BY paivamaara ASC');
$tulos_käytetyt = $kysely_käytetyt->execute(array($_GET["tyokohde"],$_POST["paivamaara"]));
$rivi_käytetyt = $kysely_käytetyt->fetch();

// Haetaan tarvikkeiden tiedot
$kysely_tarvikkeet = $yhteys->prepare('SELECT * FROM tarvikkeet');
$tulos_tarvikkeet = $kysely_tarvikkeet->execute();
$rivi_tarvikkeet = $kysely_tarvikkeet->fetch();

//Laskemiseen tarvittavat attribuutit
$tarvikkeet = 0.00;
$työhinta = 0.00;
$alennusmaara = 0.00;
$edellinen_pvm = date("1972-1-1");


echo "<h1> Lasku kohteelle: " . str_replace("”","ö",str_replace("„","ä", $rivi_kohde["osoite"])) . "</h1> <br>";

echo "<h3> Asiakkaan tiedot: </h3>";
echo "<p> Nimi: " . str_replace("”","ö",str_replace("„","ä", $rivi_asiakas["nimi"])) . " </p>";
echo "<p> Laskutusosoite: " . str_replace("”","ö",str_replace("„","ä", $rivi_asiakas["osoite"])) . " </p>";
echo "<p> Postiosoite: " . $rivi_kohde["postiosoite"] . " </p>";
echo "<p> Puhelinnumero: " . $rivi_asiakas["puhnro"] . " </p>";
echo "<p> Sähköposti: " . $rivi_asiakas["sposti"] . " </p>";

echo "<h3> Kohteen tiedot: </h3>";
echo "<p> Kohteen osoite: " . str_replace("”","ö",str_replace("„","ä", $rivi_kohde["osoite"])) . " </p>";
echo "<p> Postiosoite: " . $rivi_kohde["postiosoite"] . " </p>";
echo "<p> Kuvaus: " . str_replace("”","ö",str_replace("„","ä", $rivi_kohde["kuvaus"])) . " </p>";

echo "<h3> Käytetyt tarvikkeet: </h3>";

if (!empty($rivi_käytetyt) && !empty($rivi_tarvikkeet)) {

        while($rivi_käytetyt) {

            while($rivi_tarvikkeet) {
                if ($rivi_tarvikkeet["tarviketunnus"] == $rivi_käytetyt["tarviketunnus"]) {
                    $alennus =  $rivi_käytetyt["tarviketunnus"]."alennus";
                    if ($edellinen_pvm == $rivi_käytetyt["paivamaara"]) {
                        echo "<br>";
                    } else {
                        echo "<br>";
                        echo "Päivämäärä : " . $rivi_käytetyt["paivamaara"] . " <br>";
                    }

                    if ($_POST[$alennus] > 0) {
                        echo "Tarvike : " . str_replace("”","ö",str_replace("„","ä", $rivi_tarvikkeet["nimi"]));
                        echo " | Määrä: " . $rivi_käytetyt["maara"] . " " . $rivi_tarvikkeet["yksikko"];
                        echo " | Alennus kohteelle: " . str_replace("”","ö",str_replace("„","ä", $rivi_tarvikkeet["nimi"])) . " -" . $_POST[$alennus] . "%";
                        echo "<br>";
                        echo "Hinta sis. alv = " . $rivi_tarvikkeet["myyntihinta"] . "e";
                        $alv = number_format(($rivi_tarvikkeet["myyntihinta"]) * (1 - (intval($rivi_tarvikkeet["alv"])/100)),2);
                        echo " | Hinta ilman alv = " . $alv;
                        $ale = number_format(($alv - ($alv * (intval($_POST[$alennus])/100))),2);
                        echo "e - " . ($alv - $ale) . "e";
                        echo " | Alv = " . number_format(($rivi_tarvikkeet["myyntihinta"]) * (intval($rivi_tarvikkeet["alv"])/100),2) . "e ";
                        echo " | Alv = ". $rivi_tarvikkeet["alv"] . "%";
                        echo " | Yht. " . ($rivi_tarvikkeet["myyntihinta"] - ($alv - $ale)) . "e x " . $rivi_käytetyt["maara"] . " " . $rivi_tarvikkeet["yksikko"];
                        $yht = number_format(($rivi_tarvikkeet["myyntihinta"] - ($alv - $ale)) * $rivi_käytetyt["maara"],2);
                        echo " = " . $yht . "e";
                        echo "<br>";
                        $tarvikkeet = $tarvikkeet + $yht;
                    } else {
                        echo "Tarvike : " . str_replace("”","ö",str_replace("„","ä", $rivi_tarvikkeet["nimi"]));
                        echo " | Määrä: " . $rivi_käytetyt["maara"] . " " . $rivi_tarvikkeet["yksikko"];
                        echo "<br>";
                        echo "Hinta sis. alv = " . $rivi_tarvikkeet["myyntihinta"] . "e ";
                        echo " | Hinta ilman alv = " . number_format(($rivi_tarvikkeet["myyntihinta"]) * (1 - (intval($rivi_tarvikkeet["alv"])/100)),2) . "e ";
                        echo " | Alv = " . number_format(($rivi_tarvikkeet["myyntihinta"]) * (intval($rivi_tarvikkeet["alv"])/100),2) . "e ";
                        echo " | Alv = ". $rivi_tarvikkeet["alv"] . "%";
                        echo " | Yht. " . $rivi_tarvikkeet["myyntihinta"] . "e x " . $rivi_käytetyt["maara"] . " " . $rivi_tarvikkeet["yksikko"];
                        $yht = number_format($rivi_tarvikkeet["myyntihinta"] * $rivi_käytetyt["maara"],2);
                        echo " = " . $yht . "e";
                        echo "<br>";
                        $tarvikkeet = $tarvikkeet + $yht;
                    }
                    
                    $kysely_tarvikkeet = $yhteys->prepare('SELECT * FROM tarvikkeet');
                    $tulos_tarvikkeet = $kysely_tarvikkeet->execute();
                    $rivi_tarvikkeet = $kysely_tarvikkeet->fetch();
                    break;
                }
                $rivi_tarvikkeet = $kysely_tarvikkeet->fetch();
            }

            $rivi_käytetyt = $kysely_käytetyt->fetch();

        }

    } else {
        echo "<p> Projektissa ei käytetty tarvikkeita </p>";
        echo "<p> Hinta 0.00 euroa </p>";
        $tarvikkeet = $tarvikkeet + 0;
    }

    echo "<p> Tarvikkeiden hinta yht." . $tarvikkeet . " euroa</p>";

    echo "<h3> Tehdyt työtunnit: </h3>";

    // Jos jokin alennuksista on asetettu päälle tulostetaan alennukset ja käytetään niitä.
    if ($rivi_kohde["suunnittelualennus"] >= 1 || $rivi_kohde["tyoalennus"] >= 1 || $rivi_kohde["aputyoalennus"] >= 1) {
        echo "<p> Suunnittelu alennus " . $rivi_kohde["suunnittelualennus"] . " % </p>";
        echo "<p> Työalennus alennus " . $rivi_kohde["tyoalennus"] . "% </p>";
        echo "<p> Aputyöalennus alennus " . $rivi_kohde["aputyoalennus"] . "% </p>";

        if (!empty($rivi_tunnit)) {

            $edellinen_pvm = date("1972-1-1");

            while($rivi_tunnit) {

                if ($edellinen_pvm == $rivi_tunnit["paivamaara"]) {
                    echo "<br>";
                } else {
                    echo "<br>";
                    echo "Päivämäärä : " . $rivi_tunnit["paivamaara"] . " <br>";
                    $edellinen_pvm = $rivi_tunnit["paivamaara"];
                }

                if ($rivi_tunnit["tyotapa"] == "tyo") {
                    $alv = number_format(45 * 0.76,2);
                    $ale = number_format(($alv  * (intval($rivi_kohde["tyoalennus"])/100)),2);
                    $yht = number_format(45 * $rivi_tunnit["tyonmaara"],2);
                    echo "Työtapa : Asennustyö | Alennus: " . $rivi_kohde["tyoalennus"] . "% | Norm. hinta: 45e/tunti | Alennettu hinta:". (45 - $ale) . "e/tunti";
                    echo " | Työtunnit: " . $rivi_tunnit["tyonmaara"] . "h";
                    echo " | Hinta sis. ALV: 45e x " . $rivi_tunnit["tyonmaara"] . "h = " . $yht . "e";
                    echo " | ALV = 24%";
                    echo " | Hinta ilman ALV = " . ($yht - ($yht- $alv*$rivi_tunnit["tyonmaara"])) . "e";
                    echo "<br>";
                    echo "Lopullinen hinta: " . $yht . "e - " . $ale . "e = " . ($yht - $ale) . "e ";
                    $työhinta = $työhinta + ($yht - $ale);
                } else if ($rivi_tunnit["tyotapa"] == "suunnittelu") {
                    $alv = number_format(55 * 0.76,2);
                    $ale = number_format(($alv  * (intval($rivi_kohde["suunnittelualennus"])/100)),2);
                    $yht = number_format(55 * $rivi_tunnit["tyonmaara"],2);
                    echo "Työtapa : Suunnittelua | Alennus: " . $rivi_kohde["suunnittelualennus"] . "% | Norm. hinta: 55e/tunti | Alennettu hinta:". (55 - $ale) . "e/tunti";
                    echo "| Työtunnit: " . $rivi_tunnit["tyonmaara"] . "h";
                    echo " | Hinta sis. ALV: 55e x " . $rivi_tunnit["tyonmaara"] . "h = " . $yht . "e";
                    echo " | ALV = 24%";
                    echo " | Hinta ilman ALV = " . ($yht - ($yht - $alv*$rivi_tunnit["tyonmaara"])) . "e";
                    echo "<br>";
                    echo "Lopullinen hinta: " . $yht . "e - " . $ale . "e = " . ($yht - $ale) . "e ";
                    $työhinta = $työhinta + ($yht - $ale);
                } else if ($rivi_tunnit["tyotapa"] == "aputyo") {
                    $alv = number_format(35 * 0.76,2);
                    $ale = number_format(($alv  * (intval($rivi_kohde["aputyoalennus"])/100)),2);
                    $yht = number_format(35 * $rivi_tunnit["tyonmaara"],2);
                    echo "Työtapa : Aputyötä | Alennus: " . $rivi_kohde["aputyoalennus"] . "% | Norm. hinta: 35e/tunti | Alennettu hinta:". (35 - $ale) . "e/tunti";
                    echo "| Työtunnit: " . $rivi_tunnit["tyonmaara"] . "h";
                    echo " | ALV = 24%";
                    echo " | Hinta ilman ALV = " . ($yht - ($yht - $alv*$rivi_tunnit["tyonmaara"])) . "e";
                    echo "<br>";
                    echo "Lopullinen hinta: " . $yht . "e - " . $ale . "e = " . ($yht - $ale) . "e ";
                    $työhinta = $työhinta + ($yht - $ale);
                }

                $rivi_tunnit = $kysely_tunnit->fetch();
        
            }

        } else {
            echo "<p> Projektissa ei tehty töitä </p>";
            echo "<p> Hinta 0.00 euroa </p>";
            $työhinta = $työhinta + 0.00;
        }
        
    } else {

        if (!empty($rivi_tunnit)) {

            $edellinen_pvm = date("1972-1-1");

            while($rivi_tunnit) {

                if ($edellinen_pvm == $rivi_tunnit["paivamaara"]) {
                    echo "<br>";
                } else {
                    echo "<br> <br>";
                    echo "Päivämäärä : " . $rivi_tunnit["paivamaara"] . " <br>";
                }

                if ($rivi_tunnit["tyotapa"] == "tyo") {
                    $alv = number_format(45 * 0.24,2);
                    $yht = number_format(45 * $rivi_tunnit["tyonmaara"],2);
                    echo "Työtapa : Asennustyö | Hinta: 45e/tunti | ALV: ". (45 - $alv) . "e | Työtunnit: " . $rivi_tunnit["tyonmaara"] . "h";
                    echo " | Hinta sis. ALV: 45e x " . $rivi_tunnit["tyonmaara"] . " = " . $yht . "e";
                    echo " | ALV = 24%";
                    echo " | Hinta ilman ALV = " . ($yht - ($yht - $alv*$rivi_tunnit["tyonmaara"])) . "e";
                    $työhinta = $työhinta + $yht;
                } else if ($rivi_tunnit["tyotapa"] == "suunnittelu") {
                    $alv = number_format(55 * 0.24,2);
                    $yht = number_format(55 * $rivi_tunnit["tyonmaara"],2);
                    echo "Työtapa : Suunnittelu | Työtunnit: " . $rivi_tunnit["tyonmaara"] . " x 55 e";
                    echo " | Hinta sis. ALV: 55e x " . $rivi_tunnit["tyonmaara"] . " = " . $yht . "e";
                    echo " | ALV = 24%";
                    echo " | Hinta ilman ALV = " . ($yht - ($yht - $alv*$rivi_tunnit["tyonmaara"])) . "e";
                    $työhinta = $työhinta + $yht;
                } else if ($rivi_tunnit["tyotapa"] == "aputyo") {
                    $alv = number_format(35 * 0.24,2);
                    $yht = number_format(35 * $rivi_tunnit["tyonmaara"],2);
                    echo "Työtapa : Aputyö | Työtunnit: " . $rivi_tunnit["tyonmaara"] . " x 35 e";
                    echo " | Hinta sis. ALV: 35e x " . $rivi_tunnit["tyonmaara"] . " = " . $yht . "e";
                    echo " | ALV = 24%";
                    echo " | Hinta ilman ALV = " . ($yht - ($yht - $alv*$rivi_tunnit["tyonmaara"])) . "e";
                    $työhinta = $työhinta + $yht;
                }

                $rivi_tunnit = $kysely_tunnit->fetch();
        
            }

        } else {
            echo "<p> Projektissa ei tehty töitä </p>";
            echo "<p> Hinta 0.00 euroa </p>";
            $työhinta = $työhinta + 0.00;
        }
    }

    echo "<p> Työn hinta yht. " . $työhinta . " euroa</p>";

    echo "<h3> Yhteenveto: </h3>";

    $kokonaishinta = $työhinta + $tarvikkeet;
    echo "<p> Laskun kokonaishinta: " . $kokonaishinta . " euroa</p>";
    echo "<p> Laskun kotitalous vähennettävä osuus: " . $työhinta . " euroa</p>";

?>
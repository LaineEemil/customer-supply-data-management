<?php
require 'yhteys.php';

// Haetaan asiakkaan tiedot
$kysely_asiakas = $yhteys->prepare('SELECT * FROM asiakas WHERE atunnus = ?');
$tulos_asiakas = $kysely_asiakas->execute(array($_POST["atunnus"]));
$rivi_asiakas = $kysely_asiakas->fetch();

// Haetaan kohteen tiedot
$kysely_kohde = $yhteys->prepare('SELECT * FROM tyokohde WHERE kohdetunnus = ?');
$tulos_kohde = $kysely_kohde->execute(array($_POST["kohdetunnus"]));
$rivi_kohde = $kysely_kohde->fetch();


// Haetaan tarvikkeiden tiedot
$kysely_tarvikkeet = $yhteys->prepare('SELECT * FROM tarvikkeet');
$tulos_tarvikkeet = $kysely_tarvikkeet->execute();
$rivi_tarvikkeet = $kysely_tarvikkeet->fetch();

//Laskemiseen tarvittavat attribuutit
$tarvikkeet = 0.00;
$työhinta = 0.00;
$alennusmaara = 0.00;
$edellinen_pvm = date("1972-1-1");

echo "<h1> Urakkatarjous kohteelle: " . str_replace("”","ö",str_replace("„","ä", $rivi_kohde["osoite"])) . "</h1>";

echo "<h3> Asiakkaan tiedot </h3>";
echo "<p> Nimi: " . str_replace("”","ö",str_replace("„","ä", $rivi_asiakas["nimi"])) . " </p>";
echo "<p> Laskutusosoite: " . str_replace("”","ö",str_replace("„","ä", $rivi_asiakas["osoite"])) . " </p>";
echo "<p> Postiosoite: " . $rivi_kohde["postiosoite"] . " </p>";
echo "<p> Puhelinnumero: " . $rivi_asiakas["puhnro"] . " </p>";
echo "<p> Sähköposti: " . $rivi_asiakas["sposti"] . " </p>";

echo "<h3> Kohteen tiedot </h3>";
echo "<p> Kohteen osoite: " . str_replace("”","ö",str_replace("„","ä", $rivi_kohde["osoite"])) . " </p>";
echo "<p> Postiosoite: " . $rivi_kohde["postiosoite"] . " </p>";
echo "<p> Kuvaus: " . str_replace("”","ö",str_replace("„","ä", $rivi_kohde["kuvaus"])) . " </p>";

echo "<h3> Urakan vaatimat tarvikkeet </h3>";

while($rivi_tarvikkeet) {
    if (!empty($_POST[$rivi_tarvikkeet["tarviketunnus"]])) {
        $maara = $rivi_tarvikkeet["tarviketunnus"]."maara";
        $alennus = $rivi_tarvikkeet["tarviketunnus"]."alennus";
        if ($_POST[$maara] > 0 && $_POST[$alennus] > 0) {
            echo "Tarvike : " . str_replace("”","ö",str_replace("„","ä", $rivi_tarvikkeet["nimi"]));
            echo " | Määrä: " . $_POST[$maara] . " " . $rivi_tarvikkeet["yksikko"];
            echo " | Alennus kohteelle: " . str_replace("”","ö",str_replace("„","ä", $rivi_tarvikkeet["nimi"])) . " -" . $_POST[$alennus] . "%";
            echo "<br>";
            echo "Hinta sis. alv = " . $rivi_tarvikkeet["myyntihinta"] . "e";
            $alv = number_format(($rivi_tarvikkeet["myyntihinta"]) * (1 - (intval($rivi_tarvikkeet["alv"])/100)),2);
            echo " | Hinta ilman alv = " . $alv;
            $ale = number_format(($alv * (1 - (intval($_POST[$alennus])/100))),2);
            echo "e";
            echo " | Alv = " . number_format(($rivi_tarvikkeet["myyntihinta"]) * (intval($rivi_tarvikkeet["alv"])/100),2) . "e ";
            echo " | Alv = " . $rivi_tarvikkeet["alv"] . "%";
            $yht = number_format((($rivi_tarvikkeet["myyntihinta"] - $ale) * $_POST[$maara]),2);
            echo " | Alennettu hinta: " . ($rivi_tarvikkeet["myyntihinta"] - $ale) . "e";
            echo " | Yht. " . ($rivi_tarvikkeet["myyntihinta"] - $ale) . "e x " . $_POST[$maara] . " " . $rivi_tarvikkeet["yksikko"];
            echo " = " . $yht;
            echo "e";
            echo "<br>";
            $tarvikkeet = number_format(($tarvikkeet + $yht),2);
        } else if ($_POST[$maara] > 0) {
            echo "Tarvike : " . str_replace("”","ö",str_replace("„","ä", $rivi_tarvikkeet["nimi"]));
            echo " | Määrä: " . $_POST[$maara] . " " . $rivi_tarvikkeet["yksikko"];
            echo "<br>";
            echo "Hinta sis. alv = " . $rivi_tarvikkeet["myyntihinta"] . "e ";
            echo " | Hinta ilman alv = " . number_format(($rivi_tarvikkeet["myyntihinta"]) * (1 - (intval($rivi_tarvikkeet["alv"])/100)),2) . "e ";
            echo " | Alv = " . number_format(($rivi_tarvikkeet["myyntihinta"]) * (intval($rivi_tarvikkeet["alv"])/100),2) . "e ";
            echo " | Alv = " . $rivi_tarvikkeet["alv"] . "%";
            echo " | Yht. " . $rivi_tarvikkeet["myyntihinta"] . "e x " . $_POST[$maara] . " " . $rivi_tarvikkeet["yksikko"];
            $yht = number_format($rivi_tarvikkeet["myyntihinta"] * $_POST[$maara],2);
            echo "<br>";
            $tarvikkeet = number_format((float)($tarvikkeet + $yht),2);
        }
    }
        $rivi_tarvikkeet = $kysely_tarvikkeet->fetch();
}

    echo "<p> Tarvikkeiden hinta yhteensä: " . $tarvikkeet . " euroa</p>";

    echo "<h3> Urakan vaatimat työtunnit </h3>";

    // Jos mitään työmuodoista ei ole täytetty merkitään ettei työtä tarvita.
    if ($_POST["tyo"] >= 1 || $_POST["suunnittelu"] >= 1 || $_POST["aputyo"] >= 1) {

        // Jos jokin alennuksista on asetettu päälle tulostetaan alennukset ja käytetään niitä.
        if ($_POST["suunnittelualennus"] >= 1 || $_POST["tyoalennus"] >= 1 || $_POST["aputyoalennus"] >= 1) {

            if ($_POST["suunnittelualennus"] >= 1) {
                echo "<p> Suunnittelualennus " . $_POST["suunnittelualennus"] . "% </p>";
            }
            if ($_POST["tyoalennus"] >= 1) {
                echo "<p> Asennustyöalennus " . $_POST["tyoalennus"] . "% </p>";
            }
            if ($_POST["aputyoalennus"] >= 1) {
                echo "<p> Aputyöalennus " . $_POST["aputyoalennus"] . "% </p>";
            }

            if ($_POST["tyoalennus"] >= 1) {
                $alv = number_format(45 * 0.76,2);
                $ale = number_format(($alv  * (intval($_POST["tyoalennus"])/100)),2);
                $yht = number_format(45 * $_POST["tyo"],2);
                echo "Työtapa : Asennustyö | Alennus: " . $_POST["tyoalennus"] . "% | Norm. hinta: 45e/tunti | Alennettu hinta:". (45 - $ale) . "e/tunti";
                echo " | Työtunnit: " . $_POST["tyo"] . "h";
                echo " | Hinta sis. ALV: 45e x " . $_POST["tyo"] . "h = " . $yht . "e";
                echo " | ALV = 24%";
                echo " | Hinta ilman ALV = " . ($yht - ($yht - $alv*$_POST["tyo"])) . "e";
                echo "<br>";
                echo "Lopullinen hinta: " . $yht . "e - " . $ale . "e = " . ($yht - $ale) . "e ";
                $työhinta = $työhinta + ($yht - $ale);
            } else {
                $alv = number_format(45 * 0.76,2);
                $yht = number_format(45 * $_POST["tyo"],2);
                echo "Työtapa : Asennustyö | Hinta: 45e/tunti | ALV: ". (45 - $alv) . "e | Työtunnit: " . $_POST["tyo"] . "h";
                echo " | Hinta sis. ALV: 45e x " . $_POST["tyo"] . "h = " . $yht . "e";
                echo " | ALV = 24%";
                echo " | Hinta ilman ALV = " . ($yht - ($yht - $alv*$_POST["tyo"])) . "e";
                $työhinta = $työhinta + $yht;
            }
            echo "<br>";
            if ($_POST["suunnittelualennus"] >= 1) {
                $alv = number_format(55 * 0.76,2);
                $ale = number_format(($alv  * (intval($_POST["suunnittelualennus"])/100)),2);
                $yht = number_format(55 * $_POST["suunnittelu"],2);
                echo "Työtapa : Suunnittelua | Alennus: " . $_POST["suunnittelualennus"] . "% | Norm. hinta: 55e/tunti | Alennettu hinta:". (55 - $ale) . "e/tunti";
                echo "| Työtunnit: " . $_POST["suunnittelu"] . "h";
                echo " | Hinta sis. ALV: 55e x " . $_POST["suunnittelu"] . "h = " . $yht . "e";
                echo " | ALV = 24%";
                echo " | Hinta ilman ALV = " . ($yht - ($yht - $alv*$_POST["suunnittelu"])) . "e";
                echo "<br>";
                echo "Lopullinen hinta: " . $yht . "e - " . $ale . "e = " . ($yht - $ale) . "e ";
                $työhinta = $työhinta + ($yht - $ale);
            } else {
                $alv = number_format(55 * 0.76,2);
                $yht = number_format(55 * $_POST["suunnittelu"],2);
                echo "Työtapa : Suunnittelua | Työtunnit: " . $_POST["suunnittelu"] . "h x 55 e";
                echo " | Hinta sis. ALV: 55e x " . $_POST["suunnittelu"] . "h = " . $yht . "e";
                echo " | ALV = 24%";
                echo " | Hinta ilman ALV = " . ($yht - ($yht - $alv*$_POST["suunnittelu"])) . "e";
                $työhinta = $työhinta + $yht;
            }
            echo "<br>";
            if ($_POST["aputyoalennus"] >= 1) {
                $alv = number_format(35 * 0.76,2);
                $ale = number_format(($alv  * (intval($_POST["aputyoalennus"])/100)),2);
                $yht = number_format(35 * $_POST["aputyo"],2);
                echo "Työtapa : Aputyötä | Alennus: " . $_POST["aputyoalennus"] . "% | Norm. hinta: 35e/tunti | Alennettu hinta:". (35 - $ale) . "e/tunti";
                echo "| Työtunnit: " . $_POST["aputyo"] . "h";
                echo " | ALV = 24%";
                echo " | Hinta ilman ALV = " . ($yht - ($yht - $alv*$_POST["aputyo"])) . "e";
                echo "<br>";
                echo "Lopullinen hinta: " . $yht . "e - " . $ale . "e = " . ($yht - $ale) . "e ";
                $työhinta = $työhinta + ($yht - $ale);
            } else {
                $alv = number_format(35 * 0.76,2);
                $yht = number_format(35 * $_POST["aputyo"],2);
                echo "Työtapa : Aputyötä | Työtunnit: " . $_POST["aputyo"] . "h x 35 e";
                echo " | Hinta sis. ALV: 35e x " . $_POST["aputyo"] . "h = " . $yht . "e";
                echo " | ALV = 24%";
                echo " | Hinta ilman ALV = " . ($yht - ($yht - $alv*$_POST["aputyo"])) . "e";
                $työhinta = $työhinta + $yht;
            }

            echo "<p> Kokonaishinta yht. " . $työhinta . " euroa</p>";

        } else {

            $alv = number_format(35 * 0.76,2);
            $yht = number_format(35 * $_POST["tyo"],2);
            echo "Työtapa : Aputyö | Työtunnit: " . $_POST["tyo"] . "h x 35 e";
            echo " | Hinta sis. ALV: 35e x " . $_POST["tyo"] . "h = " . $yht . "e";
            echo " | ALV = 24%";
            echo " | Hinta ilman ALV = " . ($yht - ($yht - $alv*$_POST["tyo"])) . "e";
            $työhinta = $työhinta + $yht;

            echo "<br> <br>";

           $alv = number_format(55 * 0.76,2);
            $yht = number_format(55 * $_POST["suunnittelu"],2);
            echo "Työtapa : Suunnittelu | Työtunnit: " . $_POST["suunnittelu"] . " x 55 e";
            echo " | Hinta sis. ALV: 55e x " . $_POST["suunnittelu"] . " = " . $yht . "e";
            echo " | ALV = 24%";
            echo " | Hinta ilman ALV = " . ($yht - ($yht - $alv*$_POST["suunnittelu"])) . "e";
            $työhinta = $työhinta + $yht;

            echo "<br> <br>";

            $alv = number_format(35 * 0.76,2);
            $yht = number_format(35 * $_POST["aputyo"],2);
            echo "Työtapa : Aputyö | Työtunnit: " . $_POST["aputyo"] . " x 35 e";
            echo " | Hinta sis. ALV: 35e x " . $_POST["aputyo"] . " = " . $yht . "e";
            echo " | ALV = 24%";
            echo " | Hinta ilman ALV = " . ($yht - ($yht - $alv*$_POST["aputyo"])) . "e";
            $työhinta = $työhinta + $yht;
        }
    
    } else {
        echo "<p> Projektissa ei tehty töitä </p>";
        echo "<p> Hinta 0.00 euroa </p>";
        $työhinta = $työhinta + 0.00;
    }


    echo "<h3> Yhteenveto </h3>";

    echo "<p> Työn hinta yht. " . $työhinta . " euroa</p>";

    $kokonaishinta = $työhinta + $tarvikkeet;
    echo "<p> Laskun kokonaishinta: " . $kokonaishinta . " euroa</p>";
    echo "<p> Laskun kotitalous vähennettävä osuus: " . $työhinta . " euroa</p>";

?>
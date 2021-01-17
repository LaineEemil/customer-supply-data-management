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
$kysely = $yhteys->prepare('SELECT * FROM tarvikkeet');
$tulos = $kysely->execute();
$rivi_tarvikkeet = $kysely->fetch();

//Laskemiseen tarvittavat attribuutit
$tarvikkeet = 0.00;
$työhinta = 0.00;
$alennusmaara = 0.00;
$edellinen_pvm = date("1972-1-1");


echo "<h1> Lasku kohteelle: " . str_replace("”","ö",str_replace("„","ä", $rivi_kohde["osoite"])) . "</h1> <br>";

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

echo "<h3> Käytetyt tarvikkeet </h3>";
if (!empty($rivi_käytetyt) && !empty($rivi_tarvikkeet)) {

    while($rivi_käytetyt) {

        while($rivi_tarvikkeet) {
            if ($rivi_tarvikkeet["tarviketunnus"] == $rivi_käytetyt["tarviketunnus"]) {

                if ($edellinen_pvm == $rivi_käytetyt["paivamaara"]) {
                    echo "<br>";
                    echo "Tarvike : " . str_replace("”","ö",str_replace("„","ä", $rivi_käytetyt["nimi"])) . " " . $rivi_tarvikkeet["myyntihinta"] . "e";
                    $tarvikkeet = $tarvikkeet + $rivi_tarvikkeet["myyntihinta"];
                } else {
                    echo "<br> <br>";
                    echo "Päivämäärä : " . $rivi_käytetyt["paivamaara"] . " <br>";
                    echo "Tarvike : " . str_replace("”","ö",str_replace("„","ä", $rivi_käytetyt["nimi"])) . " " . $rivi_tarvikkeet["myyntihinta"] . "e";
                    $tarvikkeet = $tarvikkeet + $rivi_tarvikkeet["myyntihinta"];
                    $edellinen_pvm = $rivi_käytetyt["paivamaara"];
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

    echo "<h3> Tehdyt työtunnit </h3>";

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
                    if ($rivi_tunnit["tyotapa"] == "tyo") {
                        echo "Työtapa : " . $rivi_tunnit["tyotapa"] . " 45 - " . intval((45 - (55.00 * 0.24 + ((100 - intval($rivi_kohde["tyoalennus"])) / 100) * (45.00 * 0.76)))) . " e";
                        $työhinta = $työhinta + 45.00 * 0.24 + ((100 - intval($rivi_kohde["tyoalennus"])) / 100) * (45.00 * 0.76);
                        $alennusmaara = $alennusmaara + 45.00 * 0.76;
                    } else if ($rivi_tunnit["tyotapa"] == "suunnittelu") {
                        echo "Työtapa : " . $rivi_tunnit["tyotapa"] . " 55 - " . intval((55 - (55.00 * 0.24 + ((100 - intval($rivi_kohde["suunnittelualennus"])) / 100) * (55.00 * 0.76)))) . " e";
                        $työhinta = $työhinta + 55.00 * 0.24  + ((100 - intval($rivi_kohde["suunnittelualennus"])) / 100) * (55.00 * 0.76);
                        $alennusmaara = $alennusmaara + 55.00 * 0.76;
                    } else if ($rivi_tunnit["tyotapa"] == "aputyo") {
                        echo "Työtapa : " . $rivi_tunnit["tyotapa"] . " 35 - " . intval((35 - (35.00 * 0.24 + ((100 - intval($rivi_kohde["aputyoalennus"])) / 100) * (35.00 * 0.76)))) . " e";
                        $työhinta = $työhinta + 35.00 * 0.24 + ((100 - intval($rivi_kohde["aputyoalennus"])) / 100) * (35.00 * 0.76);
                        $alennusmaara = $alennusmaara + 35.00 * 0.76;
                    }
                } else {
                    echo "<br> <br>";
                    echo "Päivämäärä : " . $rivi_tunnit["paivamaara"] . " <br>";
                    $edellinen_pvm = $rivi_tunnit["paivamaara"];
                    if ($rivi_tunnit["tyotapa"] == "tyo") {
                        echo "Työtapa : " . $rivi_tunnit["tyotapa"] . " 45 - " . intval((45 - (55.00 * 0.24 + ((100 - intval($rivi_kohde["tyoalennus"])) / 100) * (45.00 * 0.76)))) . " e";
                        $työhinta = $työhinta + 45.00 * 0.24 + ((100 - intval($rivi_kohde["tyoalennus"])) / 100) * (45.00 * 0.76);
                        $alennusmaara = $alennusmaara + 45.00 * 0.76;
                    } else if ($rivi_tunnit["tyotapa"] == "suunnittelu") {
                        echo "Työtapa : " . $rivi_tunnit["tyotapa"] . " 55 - " . intval((55.00 - (55.00 * 0.24 + ((100 - intval($rivi_kohde["suunnittelualennus"])) / 100) * (55.00 * 0.76)))) . " e";
                        $työhinta = $työhinta + 55.00 * 0.24  + ((100 - intval($rivi_kohde["suunnittelualennus"])) / 100) * (55.00 * 0.76);
                        $alennusmaara = $alennusmaara + 55.00 * 0.76;
                    } else if ($rivi_tunnit["tyotapa"] == "aputyo") {
                        echo "Työtapa : " . $rivi_tunnit["tyotapa"] . " 35 - " . intval((35 - (35.00 * 0.24 + ((100 - intval($rivi_kohde["aputyoalennus"])) / 100) * (35.00 * 0.76)))) . " e";
                        $työhinta = $työhinta + 35.00 * 0.24 + ((100 - intval($rivi_kohde["aputyoalennus"])) / 100) * (35.00 * 0.76);
                        $alennusmaara = $alennusmaara + 35.00 * 0.76;
                    }
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
                    if ($rivi_tunnit["tyotapa"] == "tyo") {
                        echo "Työtapa : " . $rivi_tunnit["tyotapa"] . " 45 e";
                        $työhinta = $työhinta + 45.00;
                    } else if ($rivi_tunnit["tyotapa"] == "suunnittelu") {
                        echo "Työtapa : " . $rivi_tunnit["tyotapa"] . " 55 e";
                        $työhinta = $työhinta + 55.00;
                    } else if ($rivi_tunnit["tyotapa"] == "aputyo") {
                        echo "Työtapa : " . $rivi_tunnit["tyotapa"] . " 35 e";
                        $työhinta = $työhinta + 35.00;
                    }
                } else {
                    echo "<br> <br>";
                    echo "Päivämäärä : " . $rivi_tunnit["paivamaara"] . " <br>";
                    $edellinen_pvm = $rivi_tunnit["paivamaara"];
                    if ($rivi_tunnit["tyotapa"] == "tyo") {
                        echo "Työtapa : " . $rivi_tunnit["tyotapa"] . " 45 e";
                        $työhinta = $työhinta + 45.00;
                    } else if ($rivi_tunnit["tyotapa"] == "suunnittelu") {
                        echo "Työtapa : " . $rivi_tunnit["tyotapa"] . " 55 e";
                        $työhinta = $työhinta + 55.00;
                    } else if ($rivi_tunnit["tyotapa"] == "aputyo") {
                        echo "Työtapa : " . $rivi_tunnit["tyotapa"] . " 35 e";
                        $työhinta = $työhinta + 35.00;
                    }
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

    $kokonaishinta = $työhinta + $tarvikkeet;
    echo "<p> Laskun kokonaishinta: " . $kokonaishinta . " euroa</p>";
    echo "<p> Laskun kotitalous vähennettävä osuus: " . $työhinta . " euroa</p>";

?>
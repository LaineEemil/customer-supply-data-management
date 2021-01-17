<?php
require 'yhteys.php';

echo "<link rel=stylesheet type=text/css href=styles.css>";

if ($_POST["erapaiva"] < date("Y-m-d")) {
    echo "<p id=epaonnistui>Virhe eräpäivä on aiemmin, kuin tämä hetki!</p>";
    echo "<footer>";
    echo "<h3><a href=tuntityolasku_luo.php?tyokohde=".$_GET["tyokohde"]  . ">Syötä eräpäivä uudestaan</a></h3>";
    echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
    echo "</footer>";
} else {
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
    $edellinen_pvm = date("1972-1-1");

    if (!empty($rivi_käytetyt)) {;

            while($rivi_käytetyt) {

                while($rivi_tarvikkeet) {
                    if ($rivi_tarvikkeet["tarviketunnus"] == $rivi_käytetyt["tarviketunnus"]) {
                        break;
                    }
                    $rivi_tarvikkeet = $kysely_tarvikkeet->fetch();
                }

                if ($edellinen_pvm == $rivi_käytetyt["paivamaara"]) {
                    $tarvikkeet = $tarvikkeet + $rivi_tarvikkeet["myyntihinta"];
                } else {
                    $tarvikkeet = $tarvikkeet + $rivi_tarvikkeet["myyntihinta"];
                    $edellinen_pvm = $rivi_käytetyt["paivamaara"];
                }
            
                $rivi_käytetyt = $kysely_käytetyt->fetch();

            }

        } else {
            $tarvikkeet = $tarvikkeet + 0;
        }

        // Jos jokin alennuksista on asetettu päälle tulostetaan alennukset ja käytetään niitä.
        if ($rivi_kohde["suunnittelualennus"] >= 1 || $rivi_kohde["tyoalennus"] >= 1 || $rivi_kohde["aputyoalennus"] >= 1) {

            if (!empty($rivi_tunnit)) {

                $edellinen_pvm = date("1972-1-1");

                while($rivi_tunnit) {

                    if ($edellinen_pvm == $rivi_tunnit["paivamaara"]) {
                        if ($rivi_tunnit["tyotapa"] == "tyo") {
                            $työhinta = $työhinta + 45.00 * 0.24 + ((100 - intval($rivi_kohde["tyoalennus"])) / 100) * (45.00 * 0.76);
                        } else if ($rivi_tunnit["tyotapa"] == "suunnittelu") {
                            $työhinta = $työhinta + 55.00 * 0.24  + ((100 - intval($rivi_kohde["suunnittelualennus"])) / 100) * (55.00 * 0.76);
                        } else if ($rivi_tunnit["tyotapa"] == "aputyo") {
                            $työhinta = $työhinta + 35.00 * 0.24 + ((100 - intval($rivi_kohde["aputyoalennus"])) / 100) * (35.00 * 0.76);
                        }
                    } else {
                        $edellinen_pvm = $rivi_tunnit["paivamaara"];
                        if ($rivi_tunnit["tyotapa"] == "tyo") {
                            $työhinta = $työhinta + 45.00 * 0.24 + ((100 - intval($rivi_kohde["tyoalennus"])) / 100) * (45.00 * 0.76);
                        } else if ($rivi_tunnit["tyotapa"] == "suunnittelu") {
                            $työhinta = $työhinta + 55.00 * 0.24  + ((100 - intval($rivi_kohde["suunnittelualennus"])) / 100) * (55.00 * 0.76);
                        } else if ($rivi_tunnit["tyotapa"] == "aputyo") {
                            $työhinta = $työhinta + 35.00 * 0.24 + ((100 - intval($rivi_kohde["aputyoalennus"])) / 100) * (35.00 * 0.76);
                        }
                    }

                    $rivi_tunnit = $kysely_tunnit->fetch();
            
                }

            } else {
                $työhinta = $työhinta + 0.00;
            }
            
        } else {

            if (!empty($rivi_tunnit)) {

                $edellinen_pvm = date("1972-1-1");

                while($rivi_tunnit) {

                    if ($edellinen_pvm == $rivi_tunnit["paivamaara"]) {
                        if ($rivi_tunnit["tyotapa"] == "tyo") {
                            $työhinta = $työhinta + 45.00;
                        } else if ($rivi_tunnit["tyotapa"] == "suunnittelu") {
                            $työhinta = $työhinta + 55.00;
                        } else if ($rivi_tunnit["tyotapa"] == "aputyo") {
                            $työhinta = $työhinta + 35.00;
                        }
                    } else {
                        $edellinen_pvm = $rivi_tunnit["paivamaara"];
                        if ($rivi_tunnit["tyotapa"] == "tyo") {
                            $työhinta = $työhinta + 45.00;
                        } else if ($rivi_tunnit["tyotapa"] == "suunnittelu") {
                            $työhinta = $työhinta + 55.00;
                        } else if ($rivi_tunnit["tyotapa"] == "aputyo") {
                            $työhinta = $työhinta + 35.00;
                        }
                    }

                    $rivi_tunnit = $kysely_tunnit->fetch();
            
                }

            } else {
                $työhinta = $työhinta + 0.00;
            }
        }

        $kokonaishinta = $työhinta + $tarvikkeet;

        
            $laskutunnus = uniqid("lasku");
            $viitenumero = hexdec(uniqid());
            $kysely = $yhteys->prepare('INSERT INTO lasku (laskutunnus,kohdetunnus,viitenumero,paivamaara,erapaiva,summa,korotettusumma,maksettu) VALUES (?,?,?,?,?,?,?,?)');
            $onnistuiko = $kysely->execute(array($laskutunnus,$_GET["tyokohde"], $viitenumero, $_POST["paivamaara"],$_POST["erapaiva"],$kokonaishinta,0.00,'f'));
            if ($onnistuiko) {
                echo "<p id=onnistui>Tuntityölaskun lisäys onnistui, löydät laskun, laskut kohdasta etusivulta!</p>";
                echo "<footer>";
                echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
                echo "</footer>";
            }
    
}
    

?>
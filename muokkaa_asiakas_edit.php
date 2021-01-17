<?php
require 'yhteys.php';

    $kysely = $yhteys->prepare('SELECT * FROM asiakas WHERE atunnus = ?');
    $tulos = $kysely->execute(array($_GET["asiakas"]));
    $rivi = $kysely->fetch();

    echo "<link rel=stylesheet type=text/css href=styles.css>";

    echo "<h3> Muokkaa asiakkaan: " . str_replace("”","ö",str_replace("„","ä", $rivi["nimi"])) . " tietoja </h3>";

    if (!empty($rivi)) {
        echo "<ul>" . "<li>";
        echo "<form action=muokkaa_asiakas_edit_query.php?ktunnus=$rivi[atunnus] method=post>";
    
        echo "<input type=hidden name=atunnus value=" . '"' . str_replace("”","ö",str_replace("„","ä", $_GET["asiakas"])) . '"' . ">";

        echo "<li>";
        echo "<label for=nimi > Nimi: ";
        echo "<input type=text name=nimi value=" . '"' . str_replace("”","ö",str_replace("„","ä", $rivi["nimi"])) . '"' . ">";
        echo "</li>";

        echo "<li>";
        echo "<label for=osoite > Osoite: ";
        echo "<input type=text name=osoite value=" . '"' . str_replace("”","ö",str_replace("„","ä", $rivi["osoite"])) . '"' . ">";
        echo "</li>";

        echo "<li>";
        echo "<label for=postiosoite > Postiosoite: ";
        echo "<input type=text name=postiosoite value=" . '"' . str_replace("”","ö",str_replace("„","ä", $rivi["postiosoite"])) . '"' . ">";
        echo "</li>";

        echo "<li>";
        echo "<label for=puhnro > Puhelinnumero: ";
        echo "<input type=text name=puhnro value=" . '"' . str_replace("”","ö",str_replace("„","ä", $rivi["puhnro"])) . '"' . ">";
        echo "</li>";

        echo "<li>";
        echo "<label for=sposti > Sähköposti: ";
        echo "<input type=text name=sposti value=" . '"' . str_replace("”","ö",str_replace("„","ä", $rivi["sposti"])) . '"' . ">";
        echo "</li>";

        echo "</ul>". "<input type=submit id=nappi value=Muokkaa määrää>"."</form action>";
    } else {
        echo "<ul style=list-style-type:disc;>";
        echo "<li>";
        echo "<p>Yhtäkään käytettyä tarviketta ei ole vielä lisätty!</p>";
        echo "</li>";
        echo "</ul>";
    }

    echo "<footer>";
    echo "<h3><a href=etusivu.php>Takaisin etusivulle</a></h3>";
    echo "</footer>";

?>
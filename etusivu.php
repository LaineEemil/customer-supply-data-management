
<?php
session_start();
?>

    <!DOCTYPE html>
    <html>
    <head>
    <link rel=stylesheet type=text/css href=styles.css>
        <style type="text/css"> 
            p {
                font-size: 22px;
            }
            h3 {
                font-size: 30px;
            }
        </style>
        <title>Tmi Sähkötärsky</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>

    <body>

    <h3>Tmi Sähkötärsky</h3>

    <div class="navbar">    
        <a id="on" href="lisaa_asiakas.html">Lisää asiakas</a>
        <a id="off"> </a>
        <a id="on" href="muokkaa_asiakas.php">Poista tai muokkaa asiakkaan tietoja</a>
    </div>

    <br>

    <div class="navbar">  
        <a id="on" href="lisaa_tyokohde.php">Lisää työkohde</a>
    </div>

    <br> 

    <div class="navbar">  
        <a id="on" href="tyokohteet_tunnit.php">Lisää kohteelle työtunteja</a>
    </div>  

    <br>

    <div class="navbar">  
        <a id="on" href="tyokohteet_tarvikkeet.php">Lisää kohteessa käytetyt tarvikkeet</a>
        <a id="off"> </a>
        <a id="on" href="muokkaa_tarvikkeet.php">Poista tai muokkaa käytettyjä tarvikkeita</a>
    </div>  

    <br>

    <div class="navbar">  
        <a id="on" href="lisaa_tarvike.html">Lisää uusi tarvike tietokantaan</a>
    </div>  

    <br>

    <div class="navbar">  
        <a id="on" href="hinta_arvio.php">Luo hinta-arvio</a>
    </div>    

    <br>

    <div class="navbar">  
        <a id="on" href="urakkatarjous.php">Luo urakkatarjous</a>
    </div>       

    <br>

    <div class="navbar">  
        <a id="on" href="tuntityolasku_ale.php">Luo tuntityölasku</a>
        <a id="off"> </a>
    </div>      

    <br>

    </div>
        
    </body>
    </head>

    </html>
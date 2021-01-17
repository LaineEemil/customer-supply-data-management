<!DOCTYPE html>
<html>
  <head>
    <link rel=stylesheet type=text/css href=styles.css>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Lisää työtunteja kohteelle</title>
  </head>
  <body>
    <form action="lisaa_tyotunnit_luo.php" method="POST">
      <fieldset>
        <legend>Lisää työkohteelle työtunteja</legend>
        <input type="hidden" id="kohdetunnus" name="kohdetunnus" <?php echo "value=". '"'. $_GET["tyokohde"] . '"' . "" ?>/>  <br>
        <label for="paivamaara">Päivämäärä: </label> <br>
        <input type="date" id="paivamaara" name="paivamaara" <?php echo "value=". '"'. date("Y-m-d") . '"' ." "?>> </input>  <br>
        <label for="tyonmaara">Työnmäärä: </label> <br>
        <input type="number" name="tyonmaara" step="."/> Tuntia <br>
		    <label for="tyotapa">Työtapa : </label> <br>
		    <select id="tyotapa" name="tyotapa">
          <option value="tyo">Työ</option>
          <option value="suunnittelu">Suunnittelu</option>
          <option value="aputyo">Aputyö</option>
        </select>
        <input type="submit" value="Lisää työtunteja työkohteelle" /> <br>
      </fieldset>
    </form>
    <footer>
	<p><a <?php echo "href=". '"'. "lisaa_tyotunnit.php?tyokohde=" . $_GET["tyokohde"] . '"' . "" ?>>Peruuta</a></p>
    <p><a href="etusivu.php">Takaisin etusivulle</a></p>
    </footer>
  </body>
</html>


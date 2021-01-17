<!DOCTYPE html>
<html>
  <head>
    <link rel=stylesheet type=text/css href=styles.css>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Lisää työtunteja kohteelle</title>
  </head>
  <body>
    <form action="login.php" method="POST">
      <fieldset>
        <legend>Login</legend>
        <label for="sposti">Sähköposti: </label> <br>
        <input type="text" id="sposti" name="sposti"> </input>  <br>
        <label for="salasana">Salasana: </label> <br>
        <input type="text" id="salasana" name="salasana"> </input>  <br>
        <input type="submit" value="Login" /> <br>
      </fieldset>
    </form>
    <footer>
    <p><a href="etusivu.php">Takaisin etusivulle</a></p>
    </footer>
  </body>
</html>
<?php

session_start();

//Includes
include_once 'include/db.php';

//Zu Datenbank verbinden
$db = dbConnect();

include_once 'include/functions.php';

$maxanz = file("set/maxclass.txt");

  $anz = mysqli_query($db, "SELECT * FROM klassen");

  $anz = mysqli_num_rows($anz);

  if($anz >= $maxanz[0] && $maxanz[0] != 0){
      if(!isset($_GET['nospace'])){
          header('Location:register.php?nospace=1');
          exit;
      }
  }
  else {
      if(isset($_GET['nospace'])){
          header('Location:register.php');
          exit;
      }
  }

  $regerror = "";

  //Angemeldet?
  if(isset($_SESSION['state'])){

    //Man ist angemeldet
    if($_SESSION['state'] == 1){
      header('Location:class.php');
      exit;
    }
  }
  else
  {
    $_SESSION['state'] = 0;
  }

  //Überprüfen ob Registrierung erfolgt ist
  if(isset($_POST['klasse'])){
      //Captcha prüfen
      if(md5(strtolower($_POST['captcha'])) == $_POST['ctext']){

          if(($addclass = mysqli_query($db, "INSERT INTO klassen (class, section, school, members) VALUES ('" . $_POST['klasse'] . "', '" . $_POST['section'] . "', '" . $_POST['school'] . "', '1')"))){

              //0 = admin; 1 = admin & klassensprecher; 2 = klassensprecher; 3 = user
              $classchef =  (isset($_POST['classchef'])) ? 1 : 0;

              $pw = randomPW(8);

              if(($adduser = mysqli_query($db, "INSERT INTO members (vname, nname, username, password, class, status, lastaction, position, color, email, birthday) VALUES ('" . $_POST['vname'] . "', '" . $_POST['nname'] . "', 'none', '" . md5($pw) . "', '" . mysqli_insert_id($db) . "',  '-1', '" . getDateTime() . "', '" . $classchef. "', '#00795f', 'none', 'none')"))){

                  $regerror = "<p class='success'>Registrierung erfolgreich!</p>";

              }
              else {
                  $regerror = "<p class='error'>Es ist etwas schiefgelaufen!</p>";
              }

          }
          else {
              $regerror = "<p class='error'>Es ist etwas schiefgelaufen!</p>";
          }

      }
      else {
          $regerror = "<p class='error'>Das von Ihnen eingegebene Captcha war falsch!</p>";
      }
  }

  $captcha = createCaptcha("images/captcha.png");

 ?>
<!DOCTYPE html>

<html lang="de">

<head>

    <title>Registrieren - Klassenverwaltung</title>

    <meta charset="utf-8">

    <meta name="description" content="Verwaltung von Klassen">
    <meta name="author" content="Matthias Thalmann">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#292929">

    <link href="images/favicon.ico" rel="icon"/>

    <link href="styles/style.css" rel="stylesheet" media="all">
    <link href="styles/normalize.css" rel="stylesheet" media="all">
    <link href="styles/font-awesome.min.css" rel="stylesheet" media="all" />

	<!--[if lt IE 10]>
        <script src="js/html5shiv-printshiv.js" media="all"></script>
	<![endif]-->

	<script src="https://cdn.rawgit.com/alertifyjs/alertify.js/v1.0.10/dist/js/alertify.js"></script>
	<script src="js/scripts.js"></script>

    <style>
        header{
            -webkit-box-shadow: 0 4px 2px -2px gray;
            -moz-box-shadow: 0 4px 2px -2px gray;
            box-shadow: 0 4px 2px -2px gray;
        }

        header h1{
            display: inline-block;
        }

        header .fa-graduation-cap{
            font-size: 50px !important;
        }

        #login_buttons{
            font-size: 0;
            display: inline-block;
            margin-left: 50px;
        }

        #login_buttons a{
            display: inline-block;
            padding: 5px 15px;
            background-color: #ff8b00;
            font-size: 16px;
            color: #fff;
        }

        #login_buttons a:hover{
            text-decoration: none;
            background-color: #f18300;
        }

        #login_buttons #login{
            border-radius: 5px 0 0 5px;
            border-right: 1px solid #292929;
        }

        #login_buttons #register{
            border-radius: 0 5px 5px 0;
        }

        @media screen and (max-width: 915px){
            #login_buttons{
                margin-top: 20px;
                margin-left: 0;
            }
        }
    </style>

</head>

<body>

    <header id="pageheader">

        <div class="inside">

            <i class="fa fa-graduation-cap" aria-hidden="true"></i>

            <div id="header_text">
                <h1><a href="class.php">Klassenverwaltung</a></h1>
                <div id="login_buttons">
                    <a href="login.php" id="login">Anmelden</a>
                    <a href="register.php" id="register" style="background-color: #f18300; font-weight: bold">Registrieren</a>
                </div>
            </div>

            <div class="clear"></div>

        </div>

    </header>

    <div id="header_offset"></div>

    <main>

        <div class="inside">

            <section>

                <article id="register">

                  <h2>Registrieren</h2>

                  <?php
                    echo $regerror;

                    if(isset($adduser) && $adduser){
                        echo "<p class='pw'>Ihr Einmalpasswort: <span style='text-decoration: underline; cursor: pointer;'>" . $pw . "</span></p><a href='login.php?firstlogin=1&insert=" . $pw . "'>Hier</a> einloggen!";
                    }

                     ?>

                <?php

                    if(!isset($_GET['nospace']))
                    {

                 ?>
                  <form action="register.php#top" method="post">
                      <p style="font-weight: bold;">Angaben der Klasse:</p>
                    <div class="cf">
                        <label for="klasse">Klasse </label>
                        <input type="number" name="klasse" autocomplete="off" required="on" placeholder="(z.B. 3)" id="klasse" value="<?php if($regerror != "") echo $_POST['klasse']; ?>" autofocus="on">
                    </div>

                    <div class="cf">
                        <label for="section">Sektion </label>
                        <input type="text" name="section" autocomplete="off" required="on" placeholder="z.B. Ia" id="section" value="<?php if($regerror != "") echo $_POST['section']; ?>">
                    </div>

                    <div class="cf">
                        <label for="school">Schule </label>
                        <input type="text" name="school" autocomplete="off" required="on" placeholder="z.B. TFO Max Valier" id="school" value="<?php if($regerror != "") echo $_POST['school']; ?>">
                    </div>

                    <div class="cf">
                        <label for="classchef">Sind Sie Klassensprecher? </label>
                        <input type="checkbox" name="classchef" id="classchef" <?php if($regerror != "" && isset($_POST['classchef'])) echo "checked='" . $_POST['classchef']  . "'"; ?>>
                    </div>

                    <div class="cf">
                        <label for="captcha">Captcha:</label>
                        <img src="images/captcha.png" alt="captcha" title="Captcha"><br />
                        <input type="text" name="captcha" autocomplete="off" required="on" placeholder="Geben Sie den Text ein" id="captcha" style="margin-top: 10px;">
                        <input type="hidden" value="<?php echo $captcha ?>" name="ctext">
                    </div>

                    <p style="font-weight: bold;">Persönliche Angaben:</p>

                    <div class="cf">
                        <label for="vname">Vorname:</label>
                        <input type="text" name="vname" autocomplete="off" required="on" placeholder="Max" id="vname" value="<?php if($regerror != "") echo $_POST['vname']; ?>">
                    </div>

                    <div class="cf">
                        <label for="nname">Nachname:</label>
                        <input type="text" name="nname" autocomplete="off" required="on" placeholder="Mustermann" id="nname" value="<?php if($regerror != "") echo $_POST['nname']; ?>">
                    </div>

                    <div class="cf">
                        <input type="submit" value="Registrieren">
                    </div>

                  </form>

                  <?php
                  }else{
                   ?>

                   <h3 style="color: red;">Achtung!</h3>
                   <p>Wir haben keinen Platz für weitere Klassen! Wenden Sie sich bitte an den <a href="mailto:matthiasthalmann1@hotmail.de">Systemadministrator</a>.</p>

                   <?php } ?>

                </article>

            </section>

        </div>

    </main>

    <footer>

        <div class="inside">

            <address><a href="mailto:test@example.com">test@example.com</a></address><a href="impressum.php">Impressum</a>
            <small>© 2017 Klasse Informatik A. All Rights Reserved. By <a href="mailto:matthias@thalmann.bz.it">Matthias Thalmann</a></small>

        </div>

    </footer>

</body>

</html>

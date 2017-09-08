<?php

session_start();

//Includes
include_once 'include/db.php';

//Zu Datenbank verbinden
$db = dbConnect();

include_once 'include/functions.php';

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

  $loginerr = "";

  //Abfrage
  if(!isset($_GET['firstlogin'])){
      if(isset($_POST['name'])){
          $login = mysqli_query($db, "SELECT * FROM members WHERE username='" . $_POST['name'] . "'");
          if(mysqli_num_rows($login) == 1){
              $userinfo = mysqli_fetch_array($login);
              if($userinfo['status'] >= 0){
                  if($userinfo['password'] == md5($_POST['pw'])){
                      $_SESSION['state'] = 1;
                      setUser($db, $userinfo['id']);
                      mysqli_query($db, "UPDATE members SET status='1' WHERE id='" . $userinfo['id'] . "'");
                      header('Location:class.php');
                      exit;
                  }
                  else{
                      $loginerr = "<p class='error'>Falscher Benutzername oder Passwort!</p>";
                  }
              }
              else if($userinfo['status'] == -2){
                  $loginerr = "<p class='error'>Sie sind blockiert!</p>";
              }
          }
          else {
              $loginerr = "<p class='error'>Falscher Benutzername oder Passwort!</p>";
          }
      }
  }
  else {
      if(isset($_POST['vname'])){
          $login = mysqli_query($db, "SELECT * FROM members WHERE vname='" . $_POST['vname'] . "' AND nname='" . $_POST['nname'] . "'");
          if(mysqli_num_rows($login) == 1){
              $userinfo = mysqli_fetch_array($login);
              if($userinfo['status'] == -1){
                  if($userinfo['password'] == md5($_POST['pw'])){
                      $_SESSION['state'] = -1;
                      setUser($db, $userinfo['id']);
                      header('Location:firstlogin.php');
                      exit;
                  }
                  else{
                      $loginerr = "<p class='error'>Falsches Passwort!</p>";
                  }
              }
              else {
                  session_destroy();
                  header('Location:login.php');
                  exit;
            }
        }
        else {
            $loginerr = "<p class='error'>Falscher Name!</p>";
        }
     }
  }

 ?>
<!DOCTYPE html>

<html lang="de">

<head>

    <title>Anmelden - Klassenverwaltung</title>

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
                    <a href="login.php" id="login" style="background-color: #f18300; font-weight: bold">Anmelden</a>
                    <a href="register.php" id="register">Registrieren</a>
                </div>
            </div>

            <div class="clear"></div>

        </div>

    </header>

    <div id="header_offset"></div>

    <main>

        <div class="inside">

            <section>

                <article id="login">

                  <h2>Anmelden</h2>

                  <?php echo $loginerr; ?>

                  <?php if(!isset($_GET['firstlogin'])){ ?>

                  <p>Sie benötigen einen Account um sich auf dieser Seite anzumelden. Hat Ihre Klasse bereits einen Account, fragen Sie ihren Klassensprecher nach dem Einmalpasswort!</p>

                  <form action="login.php" method="post">
                    <label for="name">Benutzername </label>
                    <input type="text" name="name" id="name" autofocus="on"/><br>

                    <label for="pw">Passwort </label>
                    <input type="password" name="pw" id="pw" autocomplete="off"/><br>
                    <input type="submit" value="Anmelden"/>
                  </form>

                  <p>Sie haben noch keinen Account? <a href="register.php">Hier</a> bekommen Sie einen.</p>
                  <p>Sie haben ein Einmalpasswort? <a href="login.php?firstlogin=1">Hier</a> einloggen!</p>

                  <?php }else{ ?>

                  <strong>Einmalpasswort</strong>

                  <form action="login.php?firstlogin=1" method="post">

                    <label for="vname">Vorname </label>
                    <input type="text" name="vname" id="vname" autocomplete="off"/><br>

                    <label for="nname">Nachname </label>
                    <input type="text" name="nname" id="nname" autocomplete="off"/><br>

                    <label for="pw">Passwort </label>
                    <input type="password" name="pw" value="<?php if(isset($_GET['insert'])) echo $_GET['insert']; ?>" id="pw" autocomplete="off"/><br>
                    <input type="submit" value="Anmelden"/>

                  </form>

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

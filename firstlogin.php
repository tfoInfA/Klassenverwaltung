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

if(!isset($_SESSION['state']) || $_SESSION['state'] != -1){
  header('Location:index.php');
  exit;
}

if(isset($_POST['username'])){
  if(mysqli_num_rows($userfree = mysqli_query($db, "SELECT * FROM members WHERE username='" . $_POST['username'] . "'")) == 0){
      if($_POST['pw1'] == $_POST['pw2']){
          if(($userupdate = mysqli_query($db, "UPDATE members SET username='" . $_POST['username'] . "', password='" . md5($_POST['pw1']) . "', status='0', lastaction='" . getDateTime() . "', email='" . $_POST['email'] . "', birthday='" . $_POST['bday'] . "' WHERE id='" . $_SESSION['user']['id'] . "'"))){
              session_destroy();
              header('Location:login.php');
              exit;
          }
          else {
              $loginerr = "<p class='error'>Achtung! Es ist ein Fehler aufgetreten!</p>";
          }
      }
  }
  else {
      $loginerr = "<p class='error'>Achtung! Ein User mit diesem Benutzernamen existiert bereits!</p>";
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

                  <h2>Daten eingeben</h2>

                  <?php echo $loginerr; ?>

                  <p>Hallo! Sie haben sich zum ersten Mal auf dieser Seite angemeldet! Wir bitten Sie, dieses Formular auszufüllen!</p>

                  <form action="firstlogin.php" method="post">
                      <div class="cf">
                          <label for="username">Benutzername:</label>
                          <input type="text" id="username" name="username" autocomplete="off" placeholder="14maxmus" autofocus="on"/>
                      </div>
                      <div class="cf">
                          <label for="email">E-Mail: </label>
                          <input type="email" id="email" name="email" autocomplete="off" placeholder="max@mustermann.com" />
                      </div>
                      <div class="cf">
                          <label for="bday">Geburtstag: </label>
                          <input type="text" id="bday" name="bday" autocomplete="off" placeholder="01.01.1999" />
                      </div>
                      <div class="cf">
                          <label for="pw1">Passwort:</label>
                          <input type="password" id="pw1" name="pw1" autocomplete="off" />
                          <label for="pw2">Wiederholen:</label>
                          <input type="password" id="pw2" name="pw2" autocomplete="off" />
                      </div>
                      <div class="cf">
                          <input type="submit" value="Anmelden"/>
                      </div>
                  </form>

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

<?php

    session_start();

    //Includes
    include_once 'include/db.php';

    //Zu Datenbank verbinden
    $db = dbConnect();

    include_once 'include/functions.php';

 ?>
<!DOCTYPE html>

<html lang="de">

<head>

    <title>Willkommen - Klassenverwaltung</title>

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

                <article id="a_pagedescription" style="border-bottom: none;">

                  <h2>Hallo!</h2>
                  <p><span>Schön, dass Sie unsere Seite gefunden haben!<br>
                    Hier können Sie ihre Klasse registrieren und sie dann von hier aus verwalten.<br>
                  Haben Sie noch kein Konto? Erstellen Sie sich <a href="register.php">hier</a> eins!</span>
                  </p>

                </article>

                <br style="clear: both;">

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

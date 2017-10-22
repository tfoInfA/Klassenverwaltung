<?php

    session_start();

    //Includes
    include_once 'include/db.php';

    //Zu Datenbank verbinden
    $db = dbConnect();

    include_once 'include/functions.php';

    if(!isset($_SESSION['user'])){
        header('Location: error/401.html');
        exit;
    }

    if(isset($_GET['action'])){
        if($_GET['action'] == 'logout'){
            logout($db, $_SESSION['user']['id'], 'index.php');
        }
    }

 ?>
<!DOCTYPE html>

<html lang="de">

<head>

    <title>Startseite - Klassenverwaltung</title>

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

</head>

<body>

    <header id="pageheader">

        <div class="inside">

            <i class="fa fa-graduation-cap" aria-hidden="true"></i>

            <div id="header_text">
                <h1><a href="class.php">Klassenverwaltung</a></h1>
                <p class="slogan"><?=$_SESSION['user']['klasse'] . ' ' . $_SESSION['user']['school']; ?></p>
            </div>

            <div class="clear"></div>

            <a href="javascript:toggleMenu()" class="fa fa-angle-down" title="Men&uuml;" id="header_menubutton"></a>

        </div>

    </header>

    <div id="header_offset"></div>

    <nav id="pagenav">

        <div class="inside">

            <ul>

                <li class="current"><a href="class.php" data-fa-icon="">Startseite</a></li>
                <li class="drop"><a data-fa-icon="" class="drop_desc">Klasse</a>
                    <ul>
                        <li><a href="klasse.php" data-fa-icon="">&Uuml;bersicht</a></li>
                        <li><a href="table.php" data-fa-icon="">Stundenplan</a></li>
                        <li><a href="exams.php" data-fa-icon="">Pr&uuml;fungen / Tests</a></li>
                        <li><a href="homeworke.php" data-fa-icon="">Hausaufgaben</a></li>
                    </ul>
                </li>
                <li><a href="profile.php" data-fa-icon="">Profil</a></li>
                <li><a href="settings.php" data-fa-icon="">Einstellungen</a></li>
                <li><a href="class.php?action=logout" data-fa-icon="" class="logout">Abmelden</a></li>

            </ul>

        </div>

    </nav>

    <main>

        <div class="inside">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
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

<?php

    session_start();

    //Includes
    include_once 'include/db.php';

    //Zu Datenbank verbinden
    $db = dbConnect();

    include_once 'include/functions.php';

    if(!isset($_SESSION['user'])){
        //header('Location: error/401.html');
        //exit;
    }

    //
    $_SESSION['user']['class'] = '3Ia';

 ?>
<!DOCTYPE html>

<html lang="de">

<head>

    <title>Startseite | Klassenverwaltung</title>

    <meta charset="utf-8">

    <meta name="description" content="Verwaltung von Klassen">
    <meta name="author" content="Matthias Thalmann">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#252525">

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

            <h1>Klassenverwaltung</h1>
            <p class="slogan"><?=$_SESSION['user']['class']; ?></p>

        </div>

    </header>

    <nav id="pagenav">

        <div class="inside">

            <ul>

                <li></li>

            </ul>

        </div>

    </nav>

</body>

</html>

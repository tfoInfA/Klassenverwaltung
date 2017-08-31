<?php
    /*
        Datenbankzugriffs Funktionen
    */

    /**
      * Stellt eine Verbindung zur Datenbank her und setzt das Standart curl_share_setopt
      * @return Variable mit der Verbindung
      */
  function dbConnect(){
      $db = mysqli_connect("localhost","class","plaplaplaeva","class") or die ("Fehler bei der Verbindung mit dem Datenbankserver!");
      mysqli_query($db,"SET NAMES 'utf8'");
      mysqli_query($db,"SET CHARACTER SET 'utf8'");
      return $db;
  }
?>

<?php
/*
	Funktionen
*/

/**
   * Generates a random password
   * @param $length Die länge des Passworts
   * @return Das Passwort
   */
 function randomPW($length){
	 $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	 $ret = "";
	 for($i = 0; $i < $length; $i++){
		 $pos = rand(0,strlen($alphabet)-1);
		 $ret .= $alphabet{$pos};
	 }
	 return $ret;
 }

 /**
 	*	Converts $_FILES array to the cleaner (IMHO) array
 	* @param $file_post The $_FILES[''] Array
 	* @return The reordert Array
 	*
 	* @author unknown
 	*/
 	function reArrayFiles(&$file_post) {
		$file_ary = array();
		$file_count = count($file_post['name']);
		$file_keys = array_keys($file_post);

		for ($i=0; $i<$file_count; $i++) {
			foreach ($file_keys as $key) {
		   		$file_ary[$i][$key] = $file_post[$key][$i];
			}
		}

		return $file_ary;
 	}

    /**
       * Löscht alle Dateien aus einem Ordner
       *
       * @author kollermedia.at
       */
    function clearDir($dirname){
        //überprüfen ob das Verzeichnis überhaupt existiert
        if (is_dir($dirname)) {
            //Ordner öffnen zur weiteren Bearbeitung
            if ($dh = opendir($dirname)) {
                //Schleife, bis alle Files im Verzeichnis ausgelesen wurden
                while (($file = readdir($dh)) !== false) {
                    //Oft werden auch die Standardordner . und .. ausgelesen, diese sollen ignoriert werden
                    if ($file != "." && $file != "..") {
                        //Files vom Server entfernen
                        unlink($dirname . $file);
                    }
                }
                //geöffnetes Verzeichnis wieder schließen
                closedir($dh);
            }
        }
    }

    /*
  * Logs out the user
  */
  function logout($db, $id, $dir){
      mysqli_query($db, "UPDATE members SET status='0' WHERE id='" . $id . "'");
      session_destroy();
      header('Location:' . $dir);
      exit;
  }

  /*
  * Schaut welcher Benutzer zu lange keine Aktivität hatte und setzt dessen
  * Status. Setzt auch den Status des aktuellen Benutzers
  * Aktivitäten:
  * - 0 min:   Online (1)
  * - 5 min:   Abwesend (2)
  * - 10 min: Offline (0)
  * @param $id Die id des aktuellen Users
  */
  function action($db, $id){
      $users = mysqli_query($db, "SELECT * FROM members WHERE status > 0");
      while($row = mysqli_fetch_array($users)){
          $time = explode(";", $row['lastaction']);
          $date = explode(".", $time[0]);
          $time = explode(":", $time[1]);

          $ctime = explode(";", getDateTime());
          $cdate = explode(".", $ctime[0]);
          $ctime = explode(":", $ctime[1]);

          $status = 1;

          if($date[2] < $cdate[2] || $date[1] < $cdate[1] || $date[0] < $cdate[0] || $time[0] < $ctime[0]){
              $status = 0;
          }
          else {
              if($time[1] < $ctime[1] - 10){
                  $status = 0;
              }
              else {
                  if($time[1] < $ctime[1] - 5){
                      $status = 2;
                  }
              }
          }

          mysqli_query($db, "UPDATE members SET status='" . $status . "' WHERE id='" . $row['id'] . "'");
      }

      mysqli_query($db, "UPDATE members SET status='1', lastaction='" . getDateTime() . "' WHERE id='" . $id . "'");

      $_SESSION['user']['lastaction'] = getDateTime();
  }

  /*
  * Generiert ein zufälliges Captcha und speichert es
  * @param $filename Der Dateiname des Captchas
  * @returns Den String, der im Text steht (strtolower), mit md5 verschlüsselt
  */
  function createCaptcha($filename){
      $im = imagecreate(250, 60);
      $bg = imagecolorallocate($im, 192, 192, 192);
      imagefill($im, 0, 0, $bg);
      $font = imagecolorallocate($im, 0, 0, 0);

      $zeichen = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      $laenge = strlen($zeichen);
      $ctext = "";

      for($i = 0; $i < 5; $i++){
          $index = floor(lcg_value()*$laenge);
          $z = substr($zeichen, $index, 1);
          $ctext .= $z;
          imagettftext ($im, 30, -35 * $i, 45 * $i + 30, 40 - $i * 6, $font, "ttf/arial.ttf", $z);
      }

      imagepng($im, $filename);
      imagedestroy($im);

      return md5(strtolower($ctext));
  }

  /*
  * @returns "aktuelles Datum";"aktuelle Uhrzeit"
  */
  function getDateTime(){
      $timestamp = time();
      $date = date("d.m.Y",$timestamp);
      $time = date("H:i",$timestamp);
      return $date . ";" . $time;
  }

  /*
    * Setzt Eigenschaften des übergebenen Users (id)
    * @param $id Die ID des Users
    */
    function setUser($db, $id){
        if(isset($db)){

          $userinfo = mysqli_query($db,"SELECT * FROM members WHERE id='" . $id . "'");

          if(mysqli_num_rows($userinfo) == 1){

              if(isset($_SESSION['user']['loggedin'])){
                  $loggedin = $_SESSION['user']['loggedin'];
              }

            //Schule & Klasse
            $_SESSION['user'] = mysqli_fetch_array($userinfo);
            $klasse = mysqli_query($db, "SELECT * FROM klassen WHERE id='" . $_SESSION['user']['class'] . "'");
            $klasse = mysqli_fetch_array($klasse);

            $school = $klasse['school'];
            $klasse = $klasse['class'] . $klasse['section'];

            $_SESSION['user']['klasse'] = $klasse;
            $_SESSION['user']['school'] = $school;

            //Profilbild
            if(file_exists("images/pb/" . $_SESSION['user']['username'] . ".jpg")){
                $_SESSION['user']['img'] = "images/pb/" . $_SESSION['user']['username'] . ".jpg";
            }
            else if(file_exists("images/pb/" . $_SESSION['user']['username'] . ".png")){
                $_SESSION['user']['img'] = "images/pb/" . $_SESSION['user']['username'] . ".png";
            }
            else{
                $_SESSION['user']['img'] = "images/user.png";
            }

            //Loggedin
            if(isset($loggedin)){
                $_SESSION['user']['loggedin'] = $loggedin;
            }
            else {
                $_SESSION['user']['loggedin'] = getDateTime();
            }

          }
          else {
            echo "Warning! No user found with ID=" . $id . "!";
          }

        }
        else {
          echo "Warning! No database connection established! Variable is not defined!";
        }
    }
?>

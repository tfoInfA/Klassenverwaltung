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
?>

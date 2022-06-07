<?php
require_once('funkcije.php');
pregledSejeAdmin();
povezi();

$poizvedba = "SELECT datum_poteka, aktivnost FROM oglasi WHERE id = ? AND id_uporabnika = ? LIMIT 1";

$stmt = $conn->prepare($poizvedba);
$stmt->bind_param("ii", $_GET["oglas"], $_SESSION["login_id"]);
$stmt->execute();
$stmt->bind_result($datum_poteka, $aktivnost);
$stmt->fetch();

$stmt->close();

if (date('Y-m-d') >= $datum_poteka && $aktivnost == 'DA') {
   if (isset($_POST["shrani1"]) && isset($_POST["naziv"])) {
      $_POST["naziv"] = htmlspecialchars($_POST["naziv"]);

      $_POST["naziv"] = strip_tags($_POST["naziv"]);

      $poizvedba = "UPDATE oglasi SET naziv = ? WHERE id = ?";

      $stmt = $conn->prepare($poizvedba);
      $stmt->bind_param("si", $_POST["naziv"], $_GET["oglas"]);
      $stmt->execute();

      $stmt->close();

      $msg = "Naziv oglasa posodobljen!";
      $klasa = "alert-success";
   }

   if (isset($_POST["shrani2"]) && isset($_POST["opcija"])) {
      $poizvedba = "UPDATE oglasi SET opcija = ? WHERE id = ?";

      $stmt = $conn->prepare($poizvedba);
      $stmt->bind_param("si", $_POST["opcija"], $_GET["oglas"]);
      $stmt->execute();

      $stmt->close();

      $msg = "Opcija oglasa posodobljena!";
      $klasa = "alert-success";
   }

   if (isset($_POST["shrani3"]) && isset($_POST["kategorija"])) {
      $poizvedba = "UPDATE oglasi SET kategorija = ? WHERE id = ?";

      $stmt = $conn->prepare($poizvedba);
      $stmt->bind_param("si", $_POST["kategorija"], $_GET["oglas"]);
      $stmt->execute();

      $stmt->close();

      $msg = "Kategorija posodobljena!";
      $klasa = "alert-success";
   }

   if (isset($_POST["shrani4"]) && isset($_POST["stanje"])) {
      $poizvedba = "UPDATE oglasi SET stanje = ? WHERE id = ?";

      $stmt = $conn->prepare($poizvedba);
      $stmt->bind_param("si", $_POST["stanje"], $_GET["oglas"]);
      $stmt->execute();

      $stmt->close();

      $msg = "Stanje oglasa posodobljeno!";
      $klasa = "alert-success";
   }

   if (isset($_POST["shrani5"]) && isset($_POST["cena"])) {
      $_POST["cena"] = htmlspecialchars($_POST["cena"]);

      $_POST["cena"] = strip_tags($_POST["cena"]);

      $poizvedba = "UPDATE oglasi SET cena = ? WHERE id = ?";

      $stmt = $conn->prepare($poizvedba);
      $stmt->bind_param("si", $_POST["cena"], $_GET["oglas"]);
      $stmt->execute();

      $stmt->close();

      $msg = "Cena oglasa posodobljena!";
      $klasa = "alert-success";
   }

   if (isset($_POST["shrani6"]) && isset($_POST["opis"])) {
      $_POST["opis"] = htmlspecialchars($_POST["opis"]);

      $_POST["opis"] = strip_tags($_POST["opis"]);

      $poizvedba = "UPDATE oglasi SET opis = ? WHERE id = ?";

      $stmt = $conn->prepare($poizvedba);
      $stmt->bind_param("si", $_POST["opis"], $_GET["oglas"]);
      $stmt->execute();

      $stmt->close();

      $msg = "Opis oglasa posodobljen!";
      $klasa = "alert-success";
   }

   if (isset($_POST["shrani0"]) && isset($_FILES["slika"]) &&  !isset($_POST["odstrani"])) {
      $poizvedba = "SELECT slika1, slika2, slika3, slika4, slika5 FROM slike_oglasov WHERE id_oglasa = ? LIMIT 1";

      $stmt = $conn->prepare($poizvedba);
      $stmt->bind_param("i", $_GET["oglas"]);
      $stmt->execute();
      $stmt->bind_result($slika1, $slika2, $slika3, $slika4, $slika5);
      $stmt->fetch();

      $stmt->close();

      $pom = 5;

      if (isset($slika1))
         $pom--;
      if (isset($slika2))
         $pom--;
      if (isset($slika3))
         $pom--;
      if (isset($slika4))
         $pom--;
      if (isset($slika5))
         $pom--;

      if (count($_FILES["slika"]["name"]) <= $pom) {
         $dovoljeni_tipi = array('image/png','image/jpeg', 'image/gif', NULL);
         if (in_array($_FILES["slika"]["type"][0], $dovoljeni_tipi) || in_array($_FILES["slika"]["type"][1], $dovoljeni_tipi) || in_array($_FILES["slika"]["type"][2], $dovoljeni_tipi) || in_array($_FILES["slika"]["type"][3], $dovoljeni_tipi) || in_array($_FILES["slika"]["type"][4], $dovoljeni_tipi)) {
            if (array_sum($_FILES["slika"]["size"]) < 4000000*$pom) {
               if ($_FILES["slika"]["name"][0] != NULL)
                  $pom_slika1 = $_SESSION["login_id"].'_'.time().'_'.$_FILES["slika"]["name"][0];
               else
                  $pom_slika1 = NULL;

               if (isset($_FILES["slika"]["name"][1]))
                  $pom_slika2 = $_SESSION["login_id"].'_'.time().'_'.$_FILES["slika"]["name"][1];
               else
                  $pom_slika2 = NULL;

               if (isset($_FILES["slika"]["name"][2]))
                  $pom_slika3 = $_SESSION["login_id"].'_'.time().'_'.$_FILES["slika"]["name"][2];
               else
                  $pom_slika3 = NULL;

               if (isset($_FILES["slika"]["name"][3]))
                  $pom_slika4 = $_SESSION["login_id"].'_'.time().'_'.$_FILES["slika"]["name"][3];
               else
                  $pom_slika4 = NULL;

               if (isset($_FILES["slika"]["name"][4]))
                  $pom_slika5 = $_SESSION["login_id"].'_'.time().'_'.$_FILES["slika"]["name"][4];
               else
                  $pom_slika5 = NULL;

               if ($pom_slika1 != NULL) {
                  $target1 = 'oglasi_slike/'.$pom_slika1;
                  move_uploaded_file($_FILES["slika"]["tmp_name"][0], $target1);
               }
               if ($pom_slika2 != NULL) {
                  $target2 = 'oglasi_slike/'.$pom_slika2;
                  move_uploaded_file($_FILES["slika"]["tmp_name"][1], $target2);
               }
               if ($pom_slika3 != NULL) {
                  $target3 = 'oglasi_slike/'.$pom_slika3;
                  move_uploaded_file($_FILES["slika"]["tmp_name"][2], $target3);
               }
               if ($pom_slika4 != NULL) {
                  $target4 = 'oglasi_slike/'.$pom_slika4;
                  move_uploaded_file($_FILES["slika"]["tmp_name"][3], $target4);
               }
               if ($pom_slika5 != NULL) {
                  $target5 = 'oglasi_slike/'.$pom_slika5;
                  move_uploaded_file($_FILES["slika"]["tmp_name"][4], $target5);
               }

               if ($pom == 5) {
                  $poizvedba = "UPDATE slike_oglasov SET slika1 = ?, slika2 = ?, slika3 = ?, slika4 = ?, slika5 = ? WHERE id_oglasa = ?";

                  $stmt = $conn->prepare($poizvedba);
                  $stmt->bind_param("sssssi", $pom_slika1, $pom_slika2, $pom_slika3, $pom_slika4, $pom_slika5, $_GET["oglas"]);
                  $stmt->execute();

                  $stmt->close();
               }
               else if ($pom == 4) {
                  $poizvedba = "UPDATE slike_oglasov SET slika2 = ?, slika3 = ?, slika4 = ?, slika5 = ? WHERE id_oglasa = ?";

                  $stmt = $conn->prepare($poizvedba);
                  $stmt->bind_param("ssssi", $pom_slika1, $pom_slika2, $pom_slika3, $pom_slika4, $_GET["oglas"]);
                  $stmt->execute();

                  $stmt->close();
               }
               else if ($pom == 3) {
                  $poizvedba = "UPDATE slike_oglasov SET slika3 = ?, slika4 = ?, slika5 = ? WHERE id_oglasa = ?";

                  $stmt = $conn->prepare($poizvedba);
                  $stmt->bind_param("sssi", $pom_slika1, $pom_slika2, $pom_slika3, $_GET["oglas"]);
                  $stmt->execute();

                  $stmt->close();
               }
               else if ($pom == 2) {
                  $poizvedba = "UPDATE slike_oglasov SET slika4 = ?, slika5 = ? WHERE id_oglasa = ?";

                  $stmt = $conn->prepare($poizvedba);
                  $stmt->bind_param("ssi", $pom_slika1, $pom_slika2, $_GET["oglas"]);
                  $stmt->execute();

                  $stmt->close();
               }
               else if ($pom == 1) {
                  $poizvedba = "UPDATE slike_oglasov SET slika5 = ? WHERE id_oglasa = ?";

                  $stmt = $conn->prepare($poizvedba);
                  $stmt->bind_param("si", $pom_slika1, $_GET["oglas"]);
                  $stmt->execute();

                  $stmt->close();
               }
               $msg = "Slike oglasa posodobljene!";
               $klasa = "alert-success";
            }
            else {
               $msg = "Skupna velikost objavljenih slik je prevelika!<br/> Maksimalna velikost je 20MB";
               $klasa = "alert-danger";
            }
         }
         else {
            $msg = "Tak tip slike ni dovoljen!";
            $klasa = "alert-danger";
         }
      }
      else {
         $msg = "Preveč vnesenih slik! Največ dovoljenih slik za oglas je 5!";
         $klasa = "alert-danger";
      }
   }

   if (isset($_POST["odstrani"]) && !isset($_POST["shrani0"]) && (isset($_POST["izbrisi1"]) || isset($_POST["izbrisi2"]) || isset($_POST["izbrisi3"]) || isset($_POST["izbrisi4"]) ||isset($_POST["izbrisi5"]))) {
      if (isset($_POST["izbrisi1"])) {
         $poizvedba = "UPDATE slike_oglasov SET slika1 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("i", $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      if (isset($_POST["izbrisi2"])) {
         $poizvedba = "UPDATE slike_oglasov SET slika2 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("i", $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      if (isset($_POST["izbrisi3"])) {
         $poizvedba = "UPDATE slike_oglasov SET slika3 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("i", $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      if (isset($_POST["izbrisi4"])) {
         $poizvedba = "UPDATE slike_oglasov SET slika4 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("i", $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      if (isset($_POST["izbrisi5"])) {
         $poizvedba = "UPDATE slike_oglasov SET slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("i", $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }

      $poizvedba = "SELECT slika1, slika2, slika3, slika4, slika5 FROM slike_oglasov WHERE id_oglasa = ? LIMIT 1";

      $stmt = $conn->prepare($poizvedba);
      $stmt->bind_param("i", $_GET["oglas"]);
      $stmt->execute();
      $stmt->bind_result($slika1, $slika2, $slika3, $slika4, $slika5);
      $stmt->fetch();

      $stmt->close();

      // 01111
      if (empty($slika1) && !empty($slika2) && !empty($slika3) && !empty($slika4) && !empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika1 = ?, slika2 = ?, slika3 = ?, slika4 = ?, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("ssssi", $slika2, $slika3, $slika4, $slika5, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 00111
      else if (empty($slika1) && empty($slika2) && !empty($slika3) && !empty($slika4) && !empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika1 = ?, slika2 = ?, slika3 = ?, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("sssi", $slika3, $slika4, $slika5, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 00011
      else if (empty($slika1) && empty($slika2) && empty($slika3) && !empty($slika4) && !empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika1 = ?, slika2 = ?, slika3 = NULL, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("ssi", $slika4, $slika5, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 00001
      else if (empty($slika1) && empty($slika2) && empty($slika3) && empty($slika4) && !empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika1 = ?, slika2 = NULL, slika3 = NULL, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("si", $slika5, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 10111
      else if (!empty($slika1) && empty($slika2) && !empty($slika3) && !empty($slika4) && !empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika2 = ?, slika3 = ?, slika4 = ?, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("sssi", $slika3, $slika4, $slika5, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 10011
      else if (!empty($slika1) && empty($slika2) && empty($slika3) && !empty($slika4) && !empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika2 = ?, slika3 = ?, slika4 = NULL, slika5 = NULL WHERE id_oglasa IN (SELECT id FROM oglasi WHERE id = ? AND id_uporabnika = ?)";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("ssi", $slika4, $slika5, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 10001
      else if (!empty($slika1) && empty($slika2) && empty($slika3) && empty($slika4) && !empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika2 = ?, slika3 = NULL, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("si", $slika5, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 11011
      else if (!empty($slika1) && !empty($slika2) && empty($slika3) && !empty($slika4) && !empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika3 = ?, slika4 = ?, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("ssi", $slika4, $slika5, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 11001
      else if (!empty($slika1) && !empty($slika2) && empty($slika3) && empty($slika4) && !empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika3 = ?, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("si", $slika5, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 11101
      else if (!empty($slika1) && !empty($slika2) && !empty($slika3) && empty($slika4) && !empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika4 = ?, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("si", $slika5, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 01110
      else if (empty($slika1) && !empty($slika2) && !empty($slika3) && !empty($slika4) && empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika1 = ?, slika2 = ?, slika3 = ?, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("sssi", $slika2, $slika3, $slika4, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 01100
      else if (empty($slika1) && !empty($slika2) && !empty($slika3) && empty($slika4) && empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika1 = ?, slika2 = ?, slika3 = NULL, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("ssi", $slika2, $slika3, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 01000
      else if (empty($slika1) && !empty($slika2) && empty($slika3) && empty($slika4) && empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika1 = ?, slika2 = NULL, slika3 = NULL, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("si", $slika2, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 00110
      else if (empty($slika1) && empty($slika2) && !empty($slika3) && !empty($slika4) && empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika1 = ?, slika2 = ?, slika3 = NULL, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("ssi", $slika3, $slika4, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 00010
      else if (empty($slika1) && empty($slika2) && empty($slika3) && !empty($slika4) && empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika1 = ?, slika2 = NULL, slika3 = NULL, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("si", $slika4, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 10110
      else if (!empty($slika1) && empty($slika2) && !empty($slika3) && !empty($slika4) && empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika2 = ?, slika3 = ?, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("ssi", $slika3, $slika4, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 10010
      else if (!empty($slika1) && empty($slika2) && empty($slika3) && !empty($slika4) && empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika2 = ?, slika3 = NULL, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("si", $slika4, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 11010
      else if (!empty($slika1) && !empty($slika2) && empty($slika3) && !empty($slika4) && empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika3 = ?, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("si", $slika4, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 01010
      else if (empty($slika1) && !empty($slika2) && empty($slika3) && !empty($slika4) && empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika1 = ?, slika2 = ?, slika3 = NULL, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("ssi", $slika2, $slika4, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 10101
      else if (!empty($slika1) && empty($slika2) && !empty($slika3) && empty($slika4) && !empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika2 = ?, slika3 = ?, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("ssi", $slika3, $slika5, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 00100
      else if (empty($slika1) && empty($slika2) && !empty($slika3) && empty($slika4) && empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika1 = ?, slika2 = NULL, slika3 = NULL, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("si", $slika3, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 00101
      else if (empty($slika1) && empty($slika2) && !empty($slika3) && empty($slika4) && !empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika1 = ?, slika2 = ?, slika3 = NULL, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("ssi", $slika3, $slika5, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 01001
      else if (empty($slika1) && !empty($slika2) && empty($slika3) && empty($slika4) && !empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika1 = ?, slika2 = ?, slika3 = NULL, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("ssi", $slika2, $slika5, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 01011
      else if (empty($slika1) && !empty($slika2) && empty($slika3) && !empty($slika4) && !empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika1 = ?, slika2 = ?, slika3 = ?, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("sssi", $slika2, $slika4, $slika5, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 01101
      else if (empty($slika1) && !empty($slika2) && !empty($slika3) && empty($slika4) && !empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika1 = ?, slika2 = ?, slika3 = ?, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("sssi", $slika2, $slika3, $slika5, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }
      // 10100
      else if (!empty($slika1) && empty($slika2) && !empty($slika3) && empty($slika4) && empty($slika5)) {
         $poizvedba = "UPDATE slike_oglasov SET slika2 = ?, slika3 = NULL, slika4 = NULL, slika5 = NULL WHERE id_oglasa = ?";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("si", $slika3, $_GET["oglas"]);
         $stmt->execute();

         $stmt->close();
      }

      $msg = "Slike oglasa posodobljene!";
      $klasa = "alert-success";
   }
}
else if (date('Y-m-d') < $datum_poteka && $aktivnost == 'NE' && (isset($_POST["shrani1"]) || isset($_POST["shrani2"]) || isset($_POST["shrani3"]) || isset($_POST["shrani4"]) || isset($_POST["shrani5"]) || isset($_POST["shrani6"]) || isset($_POST["shrani0"]) || isset($_POST["odstrani"]) || isset($_POST["ponovno_objavi_oglas"]) || isset($_POST["izbrisi_oglas"]) || isset($_POST["odstrani_oglas"]))) {
   $msg = "Oglas mora biti deaktiviran ali odstranjen iz oglasnika, da ga lahko spreminjate!";
   $klasa = "alert-danger";
}

if (isset($_POST["ponovno_objavi_oglas"])) {
   $poizvedba = "SELECT datum_objave, datum_poteka FROM oglasi WHERE id = ? AND id_uporabnika = ? LIMIT 1";

   $stmt = $conn->prepare($poizvedba);
   $stmt->bind_param("ii", $_GET["oglas"]);
   $stmt->execute();
   $stmt->bind_result($datum_objave, $datum_poteka);
   $stmt->fetch();

   $stmt->close();

   $datum_ponovne_objave = date('Y-m-d',strtotime('+5 days',strtotime(str_replace('/', '-', $datum_poteka)))) . PHP_EOL;

   if (date('Y-m-d') > $datum_ponovne_objave) {
      $dat_pon_objave = date('Y-m-d');
      $dat_pon_poteka = date('Y-m-d',strtotime('+30 days',strtotime(str_replace('/', '-', date("Y-m-d"))))) . PHP_EOL;

      $poizvedba = "UPDATE oglasi SET datum_objave = ? WHERE id = ?";

      $stmt = $conn->prepare($poizvedba);
      $stmt->bind_param("si", $dat_pon_objave, $_GET["oglas"]);
      $stmt->execute();

      $stmt->close();

      $poizvedba = "UPDATE oglasi SET datum_poteka = ?  WHERE id = ?";

      $stmt = $conn->prepare($poizvedba);
      $stmt->bind_param("si", $dat_pon_poteka, $_GET["oglas"]);
      $stmt->execute();

      $stmt->close();

      $msg = "Oglas je bil ponovno objavljen!";
      $klasa = "alert-success";
   }
   else {
      $tren_dat = date_create(date('Y-m-d'));
      $datum_ponovne_objave = date_create($datum_ponovne_objave);

      $interval = date_diff($tren_dat, $datum_ponovne_objave);
      $interval = substr($interval->format('%R%a'), 1, 2);

      if ($interval == 1)
         $msg = "Oglas lahko ponovno objavite 5 dni po poteku oglasa, torej čez ".$interval." dan!";
      else if ($interval == 0)
         $msg = "Oglas lahko ponovno objavite 5 dni po poteku oglasa, torej jutri!";
      else
         $msg = "Oglas lahko ponovno objavite 5 dni po poteku oglasa, torej čez ".$interval." dni!";
      
      $klasa = "alert-danger";
   }
}

if (isset($_POST["odstrani_oglas"])) {
   $poizvedba = "SELECT datum_objave, datum_poteka FROM oglasi WHERE id = ? LIMIT 1";

   $stmt = $conn->prepare($poizvedba);
   $stmt->bind_param("i", $_GET["oglas"]);
   $stmt->execute();
   $stmt->bind_result($datum_objave, $datum_poteka);
   $stmt->fetch();

   $stmt->close();

   $datum_poteka_pomozna = $datum_poteka;
   $datum_objave = date_create($datum_objave);
   $datum_poteka = date_create($datum_poteka);

   $razlika = date_diff($datum_objave, $datum_poteka);
   $razlika = substr($razlika->format('%R%a'), 1, 2);

   if ($razlika > 0 || date('Y-m-d') < $datum_poteka_pomozna) {
      $datum = date('Y-m-d');

      $poizvedba = "UPDATE oglasi SET datum_poteka = ? WHERE id = ?";

      $stmt = $conn->prepare($poizvedba);
      $stmt->bind_param("si", $datum, $_GET["oglas"]);
      $stmt->execute();

      $stmt->close();

      $msg = "Oglas odstranjen iz oglasnika!";
      $klasa = "alert-success";
   }
   else {
      $msg = "Oglas je že potekel ali pa bil odstranjen iz oglasnika!";
      $klasa = "alert-danger";
   }
}

if (isset($_POST["izbrisi_oglas"])) {
   $poizvedba = "SELECT slika1, slika2, slika3, slika4, slika5 FROM slike_oglasov WHERE id_oglasa = ?  LIMIT 1";

   $stmt = $conn->prepare($poizvedba);
   $stmt->bind_param("i", $_GET["oglas"]);
   $stmt->execute();
   $stmt->bind_result($slika1, $slika2, $slika3, $slika4, $slika5);
   $stmt->fetch();

   $stmt->close();

   if ($slika1!=NULL) {
   $slika1 = 'oglasi_slike/'.$slika1;
   unlink($slika1);
   }

   if ($slika2!=NULL) {
   $slika2 = 'oglasi_slike/'.$slika2;
   unlink($slika2);
   }

   if ($slika3!=NULL) {
   $slika3 = 'oglasi_slike/'.$slika3;
   unlink($slika3);
   }

   if ($slika4!=NULL) {
   $slika4 = 'oglasi_slike/'.$slika4;
   unlink($slika4);
   }

   if ($slika5!=NULL) {
   $slika5 = 'oglasi_slike/'.$slika5;
   unlink($slika5);
   }

   $poizvedba = "DELETE FROM oglasi WHERE id = ?";

   $stmt = $conn->prepare($poizvedba);
   $stmt->bind_param("i", $_GET["oglas"]);
   $stmt->execute();

   $stmt->close();
   
   $poizvedba = "UPDATE uporabniki SET st_vseh_objav = st_vseh_objav-1 WHERE id IN (SELECT id_uporabnika FROM oglasi WHERE id = ?)";

   $stmt = $conn->prepare($poizvedba);
   $stmt->bind_param("i", $_GET["oglas"]);
   $stmt->execute();

   $stmt->close();

   header("location: 8_urediadmin.php?prikazi=PRIKAŽI&izberi=oglasi&id_up=&id_og=&up_ime=&ime=&priimek=&naziv=");
}

if (isset($_POST["aktivnost"]) && isset($_POST["deaktiviraj"])) {
   $poizvedba = "UPDATE oglasi SET aktivnost = ? WHERE id = ?";

   $stmt = $conn->prepare($poizvedba);
   $stmt->bind_param("si", $_POST["aktivnost"], $_GET["oglas"]);
   $stmt->execute();

   $stmt->close();

   if ($_POST["aktivnost"] == 'DA') {
      $msg = "Oglas ponovno aktiviran!";
      $klasa = "alert-success";
   }
   else {
      $msg = "Oglas deaktiviran!";
      $klasa = "alert-success";
   }
}
?>

<!DOCTYPE html>
<html>
<head>
   <?php
		Head();
	?>
   <script>
      function triggerClick() {
         document.querySelector('#slika_form').click();
      }

      function test(pom) {
            if (pom.files[0]) {
                document.getElementById("prva_slika").style.display = "";

                let preberi = new FileReader();

                preberi.onload = function(pom) {
                    document.querySelector('#prva_slika').setAttribute('src', pom.target.result);
                }
                preberi.readAsDataURL(pom.files[0]);
            }
            if (pom.files[1]) {
                document.getElementById("druga_slika").style.display = "";

                let preberi = new FileReader();

                preberi.onload = function(pom) {
                    document.querySelector('#druga_slika').setAttribute('src', pom.target.result);
                }
                preberi.readAsDataURL(pom.files[1]);
            }
            if (pom.files[2]) {
                document.getElementById("tretja_slika").style.display = "";

                let preberi = new FileReader();

                preberi.onload = function(pom) {
                    document.querySelector('#tretja_slika').setAttribute('src', pom.target.result);
                }
                preberi.readAsDataURL(pom.files[2]);
            }
            if (pom.files[3]) {
                document.getElementById("cetrta_slika").style.display = "";

                let preberi = new FileReader();

                preberi.onload = function(pom) {
                    document.querySelector('#cetrta_slika').setAttribute('src', pom.target.result);
                }
                preberi.readAsDataURL(pom.files[3]);
            }
            if (pom.files[4]) {
                document.getElementById("peta_slika").style.display = "";

                let preberi = new FileReader();

                preberi.onload = function(pom) {
                    document.querySelector('#peta_slika').setAttribute('src', pom.target.result);
                }
                preberi.readAsDataURL(pom.files[4]);
            }
        }
   </script>
</head>
<body>

<header class="header_1">
   <div style="display: block; padding-top: 22px; text-align: center;">
      <a href="8_urediadmin.php?prikazi=PRIKAŽI&izberi=oglasi&id_up=&id_og=&up_ime=&ime=&priimek=&naziv="><button class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px; width: 100px;">NAZAJ</button></a>
   </div>
</header>

<section class="section_3" style="padding-bottom: 5px;">
   <?php
      if (isset($_GET["oglas"])) {
         $poizvedba = "SELECT id, naziv, opcija, kategorija, opis, cena, stanje, datum_objave, datum_poteka, aktivnost FROM oglasi WHERE id = ? LIMIT 1";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("i", $_GET["oglas"]);
         $stmt->execute();
         $stmt->bind_result($id, $naziv, $opcija, $kategorija, $opis, $cena, $stanje, $datum_objave, $datum_poteka, $aktivnost);
         $stmt->fetch();

         $stmt->close();

         $poizvedba = "SELECT slika1, slika2, slika3, slika4, slika5 FROM slike_oglasov WHERE id_oglasa = ? LIMIT 1";

         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("i", $_GET["oglas"]);
         $stmt->execute();
         $stmt->bind_result($slika1, $slika2, $slika3, $slika4, $slika5);
         $stmt->fetch();

         $stmt->close();

         $datum_objave1 = date_create($datum_objave);
         $datum_objave1 = $datum_objave1->format('d.m.Y');

         $datum_poteka2 = date('Y-m-d',strtotime('+30 days',strtotime(str_replace('/', '-', $datum_objave)))) . PHP_EOL;

         $datum_poteka1 = date_create($datum_poteka2);
         $datum_poteka1 = $datum_poteka1->format('d.m.Y');
   ?>

   <div style="width: 1100px; background-color: #4da9ff; box-shadow: 0 0 4px 0 #4da9ff; display: inline-block; border-radius: 10px; padding: 5px;">
      <?php
         if (date('Y-m-d') < $datum_poteka) {
            echo '<p style="font-weight: bold; font-size: 20px;">Objavljeno '.$datum_objave1.', poteče '.$datum_poteka1.' (<aktivnost style="color: green">oglas aktualen</aktivnost>)</p>';
         }
         else
            echo '<p style="font-weight: bold; font-size: 20px;">Objavljeno '.$datum_objave1.', poteče '.$datum_poteka1.' (<aktivnost style="color: red">oglas ni aktualen</aktivnost>)</p>';
      ?>
      <form action="" method="POST" accept-charset="utf-8">
         <input type="submit" name="ponovno_objavi_oglas" onclick="return confirm('Ali res želite ponovno objaviti oglas?');" id="objavi" value="PONOVNO OBJAVI OGLAS" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;" />
         <input type="submit" name="odstrani_oglas" onclick="return confirm('Ali res želite odstraniti oglas iz oglasnika?');" value="ODSTRANI OGLAS IZ OGLASNIKA" class="btn btn-warning btn-sm" style="font-weight: bold; padding: 7px;" />
         <input type="submit" name="izbrisi_oglas" onclick="return confirm('Ali res želite izbrisati vse podatke z tem oglasom?');" value="IZBRIŠI OGLAS" class="btn btn-danger btn-sm" style="font-weight: bold; padding: 7px;" />
      </form>
      <br/>
      <p style="font-weight: bold; font-size: 20px;">Aktivnost oglasa</p>
      <form action="" method="POST" accept-charset="utf-8" style="margin-top: -20px;">
         <div style="margin-top: 25px;">
            <?php if ($aktivnost == 'DA') { ?>
               
                  <input type="radio" name="aktivnost" value="DA" checked /><strong>DA</strong>
                  <input type="radio" name="aktivnost" value="NE" /><strong>NE</strong>
               
            <?php } else { ?>
               <input type="radio" name="aktivnost" value="DA" /><strong>DA</strong>
               <input type="radio" name="aktivnost" value="NE" checked /><strong>NE</strong>
            <?php } ?>
         </div>
         <input type="submit" name="deaktiviraj" value="POTRDI" onclick="return confirm('Ali res želite deaktivirati ta oglas?');" style="width: 100px; padding: 7px; font-weight: bold;" class="btn btn-danger btn-sm" />
      </form>
   </div>

   <div style="width: 1100px; background-color: #4da9ff; box-shadow: 0 0 4px 0 #4da9ff; display: inline-block; border-radius: 10px; padding: 5px; margin-top: 15px;">
      <p style="text-align: center; font-weight: bold;">Slike tega oglasa</p>

      <form action="" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
         <table style="text-align: center; margin-left: auto; margin-right: auto;">
            <tr>
            <?php
               if (isset($slika1) || isset($slika2) || isset($slika3) || isset($slika4) || isset($slika5)) {
                  if (isset($slika1)) {
                     echo '<td><img src="oglasi_slike/'.$slika1.'" style="height: 200px; width: 200px; object-fit: contain;" /></td>';
                  }
                  if (isset($slika2)) {
                     echo '<td><img src="oglasi_slike/'.$slika2.'" style="height: 200px; width: 210px; padding-left: 10px; object-fit: contain;" /></td>';
                  }
                  if (isset($slika3)) {
                     echo '<td><img src="oglasi_slike/'.$slika3.'" style="height: 200px; width: 210px; padding-left: 10px; object-fit: contain;" /></td>';
                  }
                  if (isset($slika4)) {
                     echo '<td><img src="oglasi_slike/'.$slika4.'" style="height: 200px; width: 210px; padding-left: 10px; object-fit: contain;" /></td>';
                  }
                  if (isset($slika5)) {
                     echo '<td><img src="oglasi_slike/'.$slika5.'" style="height: 200px; width: 210px; padding-left: 10px; object-fit: contain;" /></td>';
                  }
               }
               else {
                  echo '<td>Za ta oglas nimate naložene nobene slike!</td>';
               }
            ?>
            </tr>
            <tr>
            <?php if (isset($slika1)) { ?>
               <td><input type="checkbox" name="izbrisi1" />prva slika</td>
            <?php } if (isset($slika2)) { ?>
               <td><input type="checkbox" name="izbrisi2" />druga slika</td>
            <?php } if (isset($slika3)) { ?>
               <td><input type="checkbox" name="izbrisi3" />tretja slika</td>
            <?php } if (isset($slika4)) { ?>
               <td><input type="checkbox" name="izbrisi4" />četrta slika</td>
            <?php } if (isset($slika5)) { ?>
               <td><input type="checkbox" name="izbrisi5" />peta slika</td>
            <?php } ?>
            </tr>
         </table>

         <div style="text-align: center; margin-top: 10px;">
            <?php if (isset($slika1) || isset($slika2) || isset($slika3) || isset($slika4) || isset($slika5)) { ?>
               <input type="submit" name="odstrani" onclick="return confirm('Ali res želite odstraniti te slike oglasa?');" value="ODSTRANI" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;" />
            <?php } ?>
         </div>
         <div style="text-align: center; margin-top: 10px;">
            <?php if (!isset($slika1) || !isset($slika2) || !isset($slika3) || !isset($slika4) || !isset($slika5)) { ?>
               <input id="slika_form" type="file" name="slika[]" onchange="test(this)" multiple accept="image/png, image/gif, image/jpeg" style="display: none;" />
               <button type="button" onclick="triggerClick()" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;">+ DODAJ SLIKO</button>
               <img src="" id="prva_slika" style="width: 40px; height: 40px; display: none; margin-left: 5px; object-fit: contain;" />
               <img src="" id="druga_slika" style="width: 40px; height: 40px; display: none; margin-left: 10px; object-fit: contain;" />
               <img src="" id="tretja_slika" style="width: 40px; height: 40px; margin-left: 10px; display: none; object-fit: contain;" />
               <img src="" id="cetrta_slika" style="width: 40px; height: 40px; margin-left: 10px; display: none; object-fit: contain;" />
               <img src="" id="peta_slika" style="width: 40px; height: 40px; margin-left: 10px; display: none; object-fit: contain;" />
               <input type="submit" name="shrani0" value="POTRDI" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;" />
            <?php } ?>
         </div>
      </form>
   </div>

   <div style="width: 1100px; background-color: #4da9ff; box-shadow: 0 0 4px 0 #4da9ff; display: inline-block; border-radius: 10px; padding: 5px; margin-top: 15px; text-align: left;">
      <form action="" method="POST" accept-charset="utf-8" style="display: inline;" class="form-inline">
         <table style="margin-left: 3px;">
         <tr>
         <td style="font-weight: bold; width: 230px;">Spremeni naziv oglasa:</td>
         <td>
         <input type="text" name="naziv" style="color: black;" maxlength="30" size="50" value="<?php echo $naziv; ?>" class="form-control" required />
         <input type="submit" name="shrani1" value="SHRANI" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;" />
         </td>
         </tr>
      </form>

      <form action="" method="POST" accept-charset="utf-8">
         <tr>
         <td style="font-weight: bold; padding-top: 10px;">Spremeni opcijo oglasa:</td>
         <td style="padding-top: 10px;">
         <select name="opcija" class="form-control" style="width: 410px; color: black;" required >
            <?php if ($opcija == "Prodam") { ?>
               <option value="Prodam" name="prodam" selected >Prodam</option>
            <?php } else { ?>
               <option value="Prodam" name="prodam" >Prodam</option>
            <?php } if ($opcija == "Kupim") { ?>
               <option value="Kupim" name="kupim" selected >Kupim</option>
            <?php } else { ?>
               <option value="Kupim" name="kupim" >Kupim</option>
            <?php } ?>
         </select>
         <input type="submit" name="shrani2" value="SHRANI" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;" />
         </td>
         </tr>
      </form>

      <form action="" method="POST" accept-charset="utf-8">
         <tr>
         <td style="font-weight: bold; padding-top: 10px;">Spremeni kategorijo oglasa:</td>
         <td style="padding-top: 10px;">
         <select name="kategorija" class="form-control" style="width: 410px; color: black;" required >
            <?php if ($kategorija == "Telefonija") { ?>
               <option value="Telefonija" selected>Telefonija</option>
            <?php } else { ?>
               <option value="Telefonija">Telefonija</option>
            <?php } if ($kategorija == "Računalništvo") { ?>
               <option value="Računalništvo" selected>Računalništvo</option>
            <?php } else { ?>
               <option value="Računalništvo">Računalništvo</option>
            <?php } if ($kategorija == "Šport") { ?>
               <option value="Šport" selected>Šport</option>
            <?php } else { ?>
               <option value="Šport">Šport</option>
            <?php } if ($kategorija == "Živali") { ?>
               <option value="Živali" selected>Živali</option>
            <?php } else { ?>
               <option value="Živali">Živali</option>
            <?php } if ($kategorija == "Literatura") { ?>
               <option value="Literatura" selected>Literatura</option>
            <?php } else { ?>
               <option value="Literatura">Literatura</option>
            <?php } if ($kategorija == "Oblačila in obutev") { ?>
               <option value="Oblačila in obutev" selected>Oblačila in obutev</option>
            <?php } else { ?>
               <option value="Oblačila in obutev">Oblačila in obutev</option>
            <?php } if ($kategorija == "Avtomobilizem") { ?>
               <option value="Avtomobilizem" selected>Avtomobilizem</option>
            <?php } else { ?>
               <option value="Avtomobilizem">Avtomobilizem</option>
            <?php } if ($kategorija == "Motociklizem") { ?>
               <option value="Motociklizem" selected>Motociklizem</option>
            <?php } else { ?>
               <option value="Motociklizem">Motociklizem</option>
            <?php } if ($kategorija == "Stroji/orodja") { ?>
               <option value="Stroji/orodja" selected>Stroji/orodja</option>
            <?php } else { ?>
               <option value="Stroji/orodja">Stroji/orodja</option>
            <?php } if ($kategorija == "Nepremičnine") { ?>
               <option value="Nepremičnine" selected>Nepremičnine</option>
            <?php } else { ?>
               <option value="Nepremičnine">Nepremičnine</option>
            <?php } if ($kategorija == "Umetnine") { ?>
               <option value="Umetnine" selected>Umetnine</option>
            <?php } else { ?>
               <option value="Umetnine">Umetnine</option>
            <?php } if ($kategorija == "Kmetijstvo") { ?>
               <option value="Kmetijstvo" selected>Kmetijstvo</option>
            <?php } else { ?>
               <option value="Kmetijstvo">Kmetijstvo</option>
            <?php } if ($kategorija == "Zbirateljstvo") { ?>
               <option value="Zbirateljstvo" selected>Zbirateljstvo</option>
            <?php } else { ?>
               <option value="Zbirateljstvo">Zbirateljstvo</option>
            <?php } if ($kategorija == "Gradnja") { ?>
               <option value="Gradnja" selected>Gradnja</option>
            <?php } else { ?>
               <option value="Gradnja">Gradnja</option>
            <?php } if ($kategorija == "Video igre") { ?>
               <option value="Video igre" selected>Video igre</option>
            <?php } else { ?>
               <option value="Video igre">Video igre</option>
            <?php } if ($kategorija == "Dom") { ?>
               <option value="Dom" selected>Dom</option>
            <?php } else { ?>
               <option value="Dom">Dom</option>
            <?php } if ($kategorija == "Igrače") { ?>
               <option value="Igrače" selected>Igrače</option>
            <?php } else { ?>
               <option value="Igrače">Igrače</option>
            <?php } if ($kategorija == "Kozmetika") { ?>
               <option value="Kozmetika" selected>Kozmetika</option>
            <?php } else { ?>
               <option value="Kozmetika">Kozmetika</option>
            <?php } if ($kategorija == "Hobi") { ?>
               <option value="Hobi" selected>Hobi</option>
            <?php } else { ?>
               <option value="Hobi">Hobi</option>
            <?php } if ($kategorija == "Drugo") { ?>
               <option value="Drugo" seleced>Drugo</option>
            <?php } else { ?>
               <option value="Drugo">Drugo</option>
            <?php } ?>
         </select>
         <input type="submit" name="shrani3" value="SHRANI" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;" />
         </td>
         </tr>
      </form>

      <form action="" method="POST" accept-charset="utf-8">
         <tr>
         <td style="font-weight: bold; padding-top: 10px;">Spremeni stanje oglasa:</td>
         <td style="padding-top: 10px;">
         <select name="stanje" class="form-control" style="width: 410px; color: black;" required >
            <?php if ($stanje == "novo") { ?>
               <option value="novo" selected>novo</option>
            <?php } else { ?>
               <option value="novo">novo</option>
            <?php } if ($stanje == "rabljeno") { ?>
               <option value="rabljeno" selected>rabljeno</option>
            <?php } else { ?>
               <option value="rabljeno">rabljeno</option>
            <?php } if ($stanje == "poškodovano/pokvarjeno") { ?>
               <option value="poškodovano/pokvarjeno" selected>poškodovano/pokvarjeno</option>
            <?php } else { ?>
               <option value="poškodovano/pokvarjeno">poškodovano/pokvarjeno</option>
            <?php } ?>
         </select>
         <input type="submit" name="shrani4" value="SHRANI" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;" />
         </td>
         </tr>
      </form>

      <form action="" method="POST" accept-charset="utf-8">
         <tr>
         <td style="font-weight: bold; padding-top: 10px;">Spremeni ceno oglasa(v €):</td>
         <td style="padding-top: 10px;">
         <input type="number" name="cena" step="0.01" max="10000000" min="0" value="<?php echo $cena; ?>" class="form-control" style="width: 410px; color: black;" required />
         <input type="submit" name="shrani5" value="SHRANI" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;" />
         </td>
         </tr>
         </table>
      </form>

      <form action="" method="POST" accept-charset="utf-8">
         <?php
            echo '<p style="font-weight: bold; padding-top: 10px; margin-left: 3px;">Spremeni opis oglasa: </p>';
            echo '<p><textarea name="opis" maxlength="250" style="width: 500px; height: 402px; margin-left: 3px; resize: none; color: black;" class="form-control">'.$opis.'</textarea></p>';
         ?>
         <p><input type="submit" name="shrani6" value="SHRANI" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px; margin-left: 3px;" /></p>
      </form>
   </div>
   <?php if (!empty($msg)) { ?>
      <br/>
      <br/>
      <div style="border-radius: 10px; display: inline-block;" class ="alert <?php echo $klasa; ?>">
         <?php echo $msg; ?>
      </div>
   <?php }
      }
      else {
         echo '<p style="margin-top: 25px; padding-bottom: 20px; font-size: 30px;">Oglas ne obstaja!</p>';
      }
   ?>
</section>

</body>
</html>

<?php
	zapri();
?>
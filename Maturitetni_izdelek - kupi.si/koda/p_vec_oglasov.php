<?php
require_once('funkcije.php');
pregledSejeUporabnik();
povezi();

if (isset($_POST["gumb_vec_oglasov"])) {
   $novi = $_POST["stevilo_oglasov"]+6;
   
   $poizvedba = "SELECT id, naziv, cena FROM oglasi WHERE CURDATE() < datum_poteka AND aktivnost='DA' ORDER BY id DESC LIMIT 0,".$novi;
   
   $stmt = $conn->query($poizvedba);
   $rnum = $stmt->num_rows;
   
   if ($rnum > 0) {
      $poizvedba2 = "SELECT slika1 FROM slike_oglasov WHERE id_oglasa = ? LIMIT 1";
   
      $stmt1 = $conn->prepare($poizvedba2);
      foreach ($stmt as $row) {
         $stmt1->bind_param("i", $row["id"]);
         $stmt1->execute();
         $stmt1->bind_result($slika1);
         $stmt1->fetch();
   
         echo '<div class="stevilo_oglasov">';
            echo '<a href="prijavljeno_oglejoglas.php?oglas='.$row["id"].'" class="naziv_oglasa"><p style="font-size: 25px; font-weight: bold;">';
               if (strlen($row["naziv"]) > 11) {
                  for ($i=0; $i<11; $i++) {
                     echo $row["naziv"][$i];
                  }
                  echo '...';
               }
               else
                  echo $row["naziv"];
            echo '</p></a>';
         
            if ($slika1 != NULL)
               echo '<a href="prijavljeno_oglejoglas.php?oglas='.$row["id"].'" class="naziv_oglasa"><img src="oglasi_slike/'.$slika1.'" style="height: 240px; width: 240px; object-fit: contain;" /></a>';
            else
               echo '<a href="prijavljeno_oglejoglas.php?oglas='.$row["id"].'" class="naziv_oglasa"><img src="slike/placeholder.png" style="height: 240px; width: 240px; object-fit: contain;" /></a>';
   
            echo '<p style="margin-top: 10px; font-size: 22px; font-weight: bold; color: black;">'.$row["cena"].'€</p>';
         echo '</div>';
      }
      $stmt1->close();
   }
   else {
      echo '<p class="napis_nic_oglasov">NA VOLJO NI NOBENEGA OGLASA</p>';
   }
   $stmt->close();
}

zapri();
?>
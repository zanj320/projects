<?php
require_once('funkcije.php');
pregledSejeUporabnik();
povezi();

//izbris racuna
if (isset($_POST["izbrisi"]) && isset($_POST["izbrisi_geslo"])) {
   $_POST["izbrisi_geslo"] = htmlspecialchars($_POST["izbrisi_geslo"]);

   $_POST["izbrisi_geslo"] = strip_tags($_POST["izbrisi_geslo"]);

   $poizvedba = "SELECT ime, priimek, email, geslo, profilna_slika FROM uporabniki WHERE up_ime = ? LIMIT 1";

   $stmt = $conn->prepare($poizvedba);
   $stmt->bind_param("s", $_SESSION["login_user"]);
   $stmt->execute();
   $stmt->bind_result($ime, $priimek, $email, $geslo, $profilna);
   $stmt->fetch();

   $stmt->close();
   
   $profilna1 = 'profilne_slike/'.$profilna;
   $geslo_hash = hash("sha256", $_POST["izbrisi_geslo"]);
   
   if ($geslo == $geslo_hash) {
      $poizvedba ="DELETE FROM uporabniki WHERE up_ime = ?";

      $stmt = $conn->prepare($poizvedba);
      $stmt->bind_param("s", $_SESSION["login_user"]);
      $stmt->execute();
      
      $stmt->close();
      
      if ($profilna != "uporabnik.png")
         unlink($profilna1);
      
      require_once('PHPMailer/PHPMailerAutoload.php');

      $mail = new PHPMailer();
      $mail->CharSet = 'UTF-8';
      $mail->isSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = 'ssl';
      $mail->Host = 'smtp.gmail.com';
      $mail->Port = '465';
      $mail->isHTML();
      $mail->Username = 'kupiisi.si@gmail.com';
      $mail->Password = 'sikupi1234';
      $mail->SetFrom('noreply@gmail.com','noreply');
      $mail->Subject = 'Izbris računa';
      $mail->Body = '<h2 style="color: black;">Račun in vsi podatki, v povezavi s tem računom, so bili uspešno izbrisani! '.$ime.' '.$priimek.', žal nam je, da nas zapuščate!</h2>';
      $mail->addAddress($email);
      
      // $mail->Send();
      unset($mail);

      session_unset();
      session_destroy();

		?><script>
			window.location = "zacetna.php";
		</script><?php
   }
   else {
      ?>
         <script>
            $("#izbrisi_geslo").val("");
         </script>
	   <?php
      echo '<pom style="color: red; font-weight: bold;">Napačno vneseno geslo!</pom>';
   }
}

zapri();
?>
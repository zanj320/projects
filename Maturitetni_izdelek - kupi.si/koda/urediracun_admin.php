<?php
require_once('funkcije.php');
pregledSejeAdmin();
povezi();

$poizvedba = "SELECT aktivnost FROM uporabniki WHERE id = ? LIMIT 1";

$stmt = $conn->prepare($poizvedba);
$stmt->bind_param("i", $_GET["uporabnik"]);
$stmt->execute();
$stmt->bind_result($aktivnost);
$stmt->fetch();

$stmt->close();

if ($aktivnost == 'NE') {
	if (isset($_POST["potrdi1"]) && isset($_POST["ime"]) && isset($_POST["priimek"]) && isset($_POST["telefonska"])) {
		$_POST["ime"] = htmlspecialchars($_POST["ime"]);
		$_POST["priimek"] = htmlspecialchars($_POST["priimek"]);
		$_POST["telefonska"] = htmlspecialchars($_POST["telefonska"]);

		$_POST["ime"] = strip_tags($_POST["ime"]);
		$_POST["priimek"] = strip_tags($_POST["priimek"]);
		$_POST["telefonska"] = strip_tags($_POST["telefonska"]);

		$poizvedba = "UPDATE uporabniki SET ime = ?, priimek = ?, telefonska = ? WHERE id = ?";

		$stmt = $conn->prepare($poizvedba);
		$stmt->bind_param("sssi", $_POST["ime"], $_POST["priimek"], $_POST["telefonska"],  $_GET["uporabnik"]);
		$stmt->execute();

		$stmt->close();

		$msg = "Podatki uporabnika posodobljeni!";
		$klasa = "alert-success";
	}

	if (isset($_POST["odstrani"])) {
		$poizvedba = "SELECT profilna_slika FROM uporabniki WHERE id = ? LIMIT 1";

		$stmt = $conn->prepare($poizvedba);
		$stmt->bind_param("i", $_GET["uporabnik"]);
		$stmt->execute();
		$stmt->bind_result($profilna);
		$stmt->fetch();

		$stmt->close();

		$profilna1 = 'profilne_slike/'.$profilna;

		if ($profilna != "uporabnik.png")
			unlink($profilna1);

		$poizvedba = "UPDATE uporabniki SET profilna_slika = 'uporabnik.png' WHERE id = ?";

      $stmt = $conn->prepare($poizvedba);
      $stmt->bind_param("i", $_GET["uporabnik"]);
      $stmt->execute();

      $stmt->close();

      $msg = "Slika uporabnika posodobljena!";
      $klasa = "alert-success";
	}
}
else if ($aktivnost == 'DA' &&  !isset($_POST["potrdi3"]) && (isset($_POST["potrdi1"]) || isset($_POST["odstrani"]))) {
   $msg = "Račun mora biti deaktiviran, da ga lahko spreminjate!";
   $klasa = "alert-danger";
}

if (isset($_POST["potrdi3"]) && isset($_POST["aktivnost"]) && isset($_POST["razlog"])) {
	$_POST["razlog"] = htmlspecialchars($_POST["razlog"]);

	$_POST["razlog"] = strip_tags($_POST["razlog"]);

	$poizvedba = "UPDATE uporabniki SET aktivnost = ? WHERE id = ?";

	$stmt = $conn->prepare($poizvedba);
	$stmt->bind_param("si", $_POST["aktivnost"], $_GET["uporabnik"]);
	$stmt->execute();

	$stmt->close();

	$poizvedba = "SELECT email, up_ime FROM uporabniki WHERE id = ? LIMIT 1";

	$stmt = $conn->prepare($poizvedba);
	$stmt->bind_param("i", $_GET["uporabnik"]);
	$stmt->execute();
	$stmt->bind_result($email, $up_ime);
	$stmt->fetch();

	$stmt->close();

	$poizvedba = "UPDATE oglasi SET aktivnost = ? WHERE id_uporabnika = ?";

	$stmt = $conn->prepare($poizvedba);
	$stmt->bind_param("si", $_POST["aktivnost"], $_GET["uporabnik"]);
	$stmt->execute();

	$stmt->close();

	require_once('PHPMailer/PHPMailerAutoload.php');

	if ($_POST["aktivnost"] == 'NE') {
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
      $mail->Subject = 'Deaktivacija računa';
      $mail->Body = '<h2 style="color: black;">Vaš račun '.$up_ime.' spletne strani kupi.si, je bil deaktiviran!<br/>Razlog deaktivacije: '.$_POST["razlog"].'!<br/>Če mislite, da je bila storjena krivica ali pa je prišlo do nesporazuma, nas kontaktirajte na elektronski naslov kupiisi.si@gmail.com</h2>';
      $mail->addAddress($email);
      
      // $mail->Send();
		unset($mail);
		
		$msg = "Račun je bil uspešno deaktiviran!";
		$klasa = "alert-success";
	}
	else if ($_POST["aktivnost"] == 'DA') {
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
      $mail->Subject = 'Aktivacija računa';
      $mail->Body = '<h2 style="color: black;">Vaš račun '.$up_ime.' spletne strani kupi.si, je bil ponovno aktiviran!<br>Spremembe: '.$_POST["razlog"].'</h2>';
      $mail->addAddress($email);
      
      // $mail->Send();
		unset($mail);
		
		$msg = "Račun je bil uspešno aktiviran!";
		$klasa = "alert-success";
	}
}

if (isset($_POST["izbrisi"])) {
   $poizvedba = "SELECT email, geslo, profilna_slika, up_ime FROM uporabniki WHERE up_ime = ? LIMIT 1";

   $stmt = $conn->prepare($poizvedba);
   $stmt->bind_param("s", $_GET["uporabnik"]);
   $stmt->execute();
   $stmt->bind_result($email, $geslo, $profilna, $up_ime);
   $stmt->fetch();

   $stmt->close();
   
	$profilna1 = 'profilne_slike/'.$profilna;
	
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
	$mail->Body = '<h2 style="color: black;">Vaš račun '.$up_ime.' je bil izbrisan zaradi poteka ali neprimerne vsebine!</h2>';
	$mail->addAddress($email);
	
	// $mail->Send();
	unset($mail);

	$poizvedba ="DELETE FROM uporabniki WHERE id = ?";

	$stmt = $conn->prepare($poizvedba);
	$stmt->bind_param("i", $_GET["uporabnik"]);
	$stmt->execute();
	
	$stmt->close();

	header("location: 8_urediadmin.php?prikazi=PRIKAŽI&izberi=uporabniki&id_up=&id_og=&up_ime=&ime=&priimek=&naziv=");
}

if (isset($_POST["ponastavi_geslo"])) {
	$str = "1234567890qwertzuioplkjhgfdsayxcvbnm_";
	$str = str_shuffle($str);
	$str = substr($str, 0, 8);

	$novo_geslo = hash("sha256", $str);
	$datum = date('Y-m-d',strtotime('+10 days',strtotime(str_replace('/', '-', date("Y-m-d"))))) . PHP_EOL;

	$poizvedba = "UPDATE uporabniki SET geslo = ?, g_datum = ? WHERE id = ?";

	$stmt = $conn->prepare($poizvedba);
	$stmt->bind_param("ssi", $novo_geslo, $datum, $_GET["uporabnik"]);
	$stmt->execute();

	$stmt->close();
	
	$poizvedba = "SELECT email FROM uporabniki WHERE id = ? LIMIT 1";

	$stmt = $conn->prepare($poizvedba);
	$stmt->bind_param("i", $_GET["uporabnik"]);
	$stmt->execute();
	$stmt->bind_result($email);
	$stmt->fetch();

	$stmt->close();

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
	$mail->Subject = 'Posodobljeno geslo';
	$mail->Body = '<h2 style="color: black;">Vaše geslo spletne strani kupi.si je bilo posodobljeno!<br/>Vaše novo geslo: '.$str.'</h2>';
	$mail->addAddress($email);
	
	$mail->Send();
	unset($mail);

	$msg = "Geslo uporabnika ponastavljeno!";
	$klasa = "alert-success";
}

if (isset($_POST["admin"]) && isset($_POST["potrdi_admin"])) {
	if ($_POST["admin"] == 'DA') {
		$id_up = $_GET["uporabnik"];

		$poizvedba = "SELECT s.slika1, s.slika2, s.slika3, s.slika4, s.slika5 FROM slike_oglasov s INNER JOIN oglasi o ON (s.id_oglasa = o.id) INNER JOIN uporabniki u ON(o.id_uporabnika = u.id) WHERE u.id = '$id_up'";

		$stmt = $conn->query($poizvedba);

		foreach ($stmt as $row) {
			if ($row["slika1"] != NULL) {
				$pom_slika = 'oglasi_slike/'.$row["slika1"];
				unlink($pom_slika);
			}
		
			if ($row["slika2"] != NULL) {
				$pom_slika = 'oglasi_slike/'.$row["slika2"];
				unlink($pom_slika);
			}
		
			if ($row["slika3"] != NULL) {
				$pom_slika = 'oglasi_slike/'.$row["slika3"];
				unlink($pom_slika);
			}
		
			if ($row["slika4"] != NULL) {
				$pom_slika = 'oglasi_slike/'.$row["slika4"];
				unlink($pom_slika);
			}
		
			if ($row["slika5"] != NULL) {
				$pom_slika = 'oglasi_slike/'.$row["slika5"];
				unlink($pom_slika);
			}
		}
		$stmt->close();

		$poizvedba = "DELETE FROM oglasi WHERE id_uporabnika = ?";

		$stmt = $conn->prepare($poizvedba);
		$stmt->bind_param("i", $_GET["uporabnik"]);
		$stmt->execute();

		$stmt->close();

		$poizvedba = "SELECT profilna_slika FROM uporabniki WHERE id = ? LIMIT 1";

		$stmt = $conn->prepare($poizvedba);
		$stmt->bind_param("i", $_GET["uporabnik"]);
		$stmt->execute();
		$stmt->bind_result($profilna_slika);
		$stmt->fetch();
	
		$stmt->close();
	
		$profilna_slika1 = 'profilne_slike/'.$profilna_slika;
		
		if ($profilna_slika != 'uporabnik.png' && $profilna_slika != 'admin.png')
			unlink($profilna_slika1);

		$poizvedba = "UPDATE uporabniki SET pravice = 'DA', aktivnost = 'DA', token = NULL, st_vseh_objav = 0, stevec_objav = 0, cas_prve_objave = NULL, t_datum = NULL, i_datum = NULL, s_datum = NULL, g_datum = NULL, profilna_slika = 'admin.png' WHERE id = ?";

		$stmt = $conn->prepare($poizvedba);
		$stmt->bind_param("i", $_GET["uporabnik"]);
		$stmt->execute();

		$stmt->close();

		$msg = "Admin dodan!";
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
</head>
<body>

<header class="header_1">
   <div style="display: block; padding-top: 22px; text-align: center;">
        <a href="8_urediadmin.php?prikazi=PRIKAŽI&izberi=uporabniki&id_up=&id_og=&up_ime=&ime=&priimek=&naziv="><button class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px; width: 100px;">NAZAJ</button></a>
   </div>
</header>

<section class="section_3" style="padding-bottom: 5px; text-align: left; height: 420px; text-align: center;">
   <?php
		if (isset($_GET["uporabnik"])) {
			$poizvedba = "SELECT id, up_ime, email, telefonska, ime, priimek, profilna_slika, datum_nastanka, st_vseh_objav, aktivnost, pravice FROM uporabniki WHERE id = ? LIMIT 1";

			$stmt = $conn->prepare($poizvedba);
			$stmt->bind_param("i", $_GET["uporabnik"]);
			$stmt->execute();
			$stmt->bind_result($id, $up_ime, $email, $telefonska, $ime, $priimek, $profilna_slika, $datum_nastanka, $st_vseh_objav, $aktivnost, $pravice);
			$stmt->fetch();

			$stmt->close();

			$datum_nastanka = date_create($datum_nastanka);
			$datum_nastanka = $datum_nastanka->format('d.m.Y');
		}
   ?>
	<div style="padding: 5px; background-color: #4da9ff; box-shadow: 0 0 4px 0 #4da9ff; border-radius: 10px; display: inline-block; float: left; text-align: left; height: 350px;">
		<form action="" method="POST" accept-charset="utf-8">
			<table style="width: 640px;">
				<tr><td style="font-weight: bold;">Nastanek:</td><td><input type="text" value="<?php echo $datum_nastanka; ?>" style="width: 400px; color: black;	" class="form-control" disabled /></td></tr>
				<tr><td style="font-weight: bold;">Id:</td><td><input type="text" value="<?php echo $id; ?>" style="width: 400px; color: black;" class="form-control" disabled /></td></tr>
				<tr><td style="font-weight: bold;">E-mail naslov:</td><td><input type="text" value="<?php echo $email; ?>" style="width: 400px; color: black;" class="form-control" disabled /></td></tr>
				<tr><td style="font-weight: bold;">Uporabniško ime:</td><td><input type="text" value="<?php echo $up_ime; ?>" style="width: 400px; color: black;" class="form-control" disabled /></td></tr>
				<tr><td style="font-weight: bold;">Ime:</td><td><input type="text" name="ime" pattern="[A-Ža-ž]{3,50}" value="<?php echo $ime; ?>" style="width: 400px; color: black;" class="form-control" required /></td></tr>
				<tr><td style="font-weight: bold;">Priimek:</td><td><input type="text" name="priimek" pattern="[A-Ža-ž]{3,50}" value="<?php echo $priimek; ?>" style="width: 400px; color: black;" class="form-control" required /></td></tr>
				<tr><td style="font-weight: bold;">Telefonska številka:</td><td><input type="text" name="telefonska" value="<?php echo $telefonska; ?>" style="width: 400px; color: black;" class="form-control" required /></td></tr>
			</table>
			<input type="submit" id="gumb" name="potrdi1" value="POTRDI SPREMEMBE" onclick="return confirm('Ali res želite spremeniti podatke tega računa?');" style="width: 160px; margin-top: 20px; font-weight: bold; padding: 7px;" class="btn btn-primary btn-sm" />
		</form>
		<form action="" method="POST" accept-charset="utf-8">
			<input type="submit" name="ponastavi_geslo" value="PONASTAVI GESLO" onclick="return confirm('Ali res želite ponastaviti geslo tega računa?');" style="width: 150px; margin-left: 170px; margin-top: -65px; font-weight: bold; padding: 7px;" class="btn btn-warning btn-sm" />
		</form>
		<form action="" method="POST" accept-charset="utf-8">
			<input type="submit" name="izbrisi" value="IZBRIŠI RAČUN" onclick="return confirm('Ali res želite izbrisati ta račun?');" style="width: 150px; margin-left: 330px; margin-top: -111px; font-weight: bold; padding: 7px;" class="btn btn-danger btn-sm" />
		</form>
	</div>
	<div style="padding: 5px; background-color: #4da9ff; box-shadow: 0 0 4px 0 #4da9ff; border-radius: 10px; display: inline-block; margin-left: 20px; float: left; width: 720px; height: 350px; text-align: left;">
		<div style="display: inline-block; float: left; padding-left: 5px;">
			<strong>Profilna slika</strong><br/>
			<?php
			if ($profilna_slika == "uporabnik.png")
				echo '<img src="slike/uporabnik.png" id="profilna" style="height: 200px; width: 200px; object-fit: cover; border-radius: 5px; margin-top: 10px;" />';
			else if ($profilna_slika == "admin.png")
				echo '<img src="slike/admin.png" id="profilna" style="height: 200px; width: 200px; object-fit: cover; border-radius: 5px; margin-top: 10px;" />';
			else
				echo '<img src="profilne_slike/'.$profilna_slika.'" id="profilna" style="height: 200px; width: 200px; object-fit: cover; border-radius: 5px; margin-top: 10px;" />';
			?>
		</div>
		<div style="display: inline-block; margin-left: 15px;">
			<form action="" method="POST" accept-charset="utf-8">
				<input type="submit" id="gumb" name="odstrani" value="ODSTRANI SLIKO" onclick="return confirm('Ali res želite odstraniti sliko temu uporabniku?');" style="width: 140px; margin-top: 110px; padding: 7px; font-weight: bold;" class="btn btn-primary btn-sm" />
			</form>
		</div>
		<div style="margin-left: 575px; margin-top: -140px; text-align: center;">
			<strong>Pravice administratorja</strong>
			<form action="" method="POST" accept-charset="utf-8">
				<?php if ($pravice == 'NE') { ?>
					<input type="radio" name="admin" value="NE" checked /><strong>NE</strong>
					<input type="radio" name="admin" value="DA" /><strong>DA</strong><br/>
				<?php } else { ?>
					<input type="radio" name="admin" value="NE" /><strong>NE</strong>
					<input type="radio" name="admin" value="DA" checked /><strong>DA</strong><br/>
				<?php } ?>
				<input type="submit" name="potrdi_admin" onclick="return confirm('Ali res želite dati pravice administratorja temu uporabniku?');" style="width: 75px; padding: 7px; font-weight: bold;" class="btn btn-primary btn-sm" value="POTRDI" /><br/>
			</form>
		</div>
		<div style="display: inline-block; margin-top: 15px; margin-right: 400px; padding-left: 5px;"><br/>
			<strong>Aktivnost računa</strong>
			<form action="" method="POST" accept-charset="utf-8" style="margin-top: -15px;">
				<div style="margin-top: 25px;">
					<?php if ($aktivnost == 'DA') { ?>
						<input type="radio" name="aktivnost" value="DA" checked /><strong>DA</strong>
						<input type="radio" name="aktivnost" value="NE" /><strong>NE</strong>
					<?php } else { ?>
						<input type="radio" name="aktivnost" value="DA" /><strong>DA</strong>
						<input type="radio" name="aktivnost" value="NE" checked /><strong>NE</strong>
					<?php } ?>
					<textarea name="razlog" style="resize: none; width: 500px; height: 63px; margin-left: 200px; margin-top: -56px; position: absolute; color: black;" class="form-control" placeholder="Vnesi razlog" required ></textarea>
				</div>
				<input type="submit" id="gumb" name="potrdi3" value="POTRDI" onclick="return confirm('Ali res želite spremeniti stanje tega računa?');" style="width: 100px; margin-top: -53px; margin-left: 90px; padding: 7px; font-weight: bold;" class="btn btn-danger btn-sm" />
			</form>
		</div>
	</div>
	<?php if (!empty($msg)) { ?>
      <br/>
      <br/>
      <div style="border-radius: 10px; margin-top: 8px; display: inline-block; text-align: center;" class ="alert <?php echo $klasa; ?>">
         <?php echo $msg; ?>
      </div>
   <?php } ?>
</section>

</body>
</html>

<?php
	zapri();
?>
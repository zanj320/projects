<?php
ob_start();

require_once('funkcije.php');
povezi();

//prijava
if (isset($_POST["prijava"]) && !empty($_POST["up_ime"]) && !empty($_POST["geslo"])) {
	$_POST["up_ime"] = htmlspecialchars($_POST["up_ime"]);
	$_POST["geslo"] = htmlspecialchars($_POST["geslo"]);

	$_POST["up_ime"] = strip_tags($_POST["up_ime"]);
	$_POST["geslo"] = strip_tags($_POST["geslo"]);

	$geslo_hash = hash("sha256", $_POST["geslo"]);
	
	$poizvedba = "SELECT id, up_ime, geslo, aktivnost, pravice FROM uporabniki WHERE up_ime = ? AND geslo = ? LIMIT 1";
	
	$stmt = $conn->prepare($poizvedba);
	$stmt->bind_param("ss", $_POST["up_ime"], $geslo_hash);
	$stmt->execute();
	$stmt->bind_result($id, $up_ime, $geslo, $aktivnost, $pravice);
	
	if ($stmt->fetch()) {
		if ($aktivnost == 'DA') {
			session_start();

			$_SESSION["login_user"] = $up_ime;
			$_SESSION["login_id"] = $id;
			$_SESSION["last_activity"] = time();
			$_SESSION["expire_time"] = 60*30;

			$stmt->close();

			echo '<pom style="color: green; font-weight: bold;">Uspešna prijava!</pom> Preusmerjanje...';
			
			if ($pravice == 'DA') {
				?><script>
					setTimeout(function() {
						window.location = "8_urediadmin.php";
					}, 2000);
				</script><?php
			}
			else {
				?><script>
					setTimeout(function() {
						window.location = "prijavljeno.php";
					}, 2000);
				</script><?php
			}
		}
		else {
			?>
				<script>
					$("#p_geslo").val("");
					$("#p_up_ime").val("");
				</script>
			<?php
			echo '<pom style="color: red; font-weight: bold;">Neveljavno uporabniško ime ali geslo!</pom>';
		}
	}
	else {
		?>
			<script>
				$("#p_geslo").val("");
			</script>
		<?php
      echo '<pom style="color: red; font-weight: bold;">Neveljavno uporabniško ime ali geslo!</pom>';
   }
}

//pozabljeno geslo
if (isset($_POST["poslji"]) && !empty($_POST["email"])) {
	$_POST["email"] = htmlspecialchars($_POST["email"]);

	$_POST["email"] = strip_tags($_POST["email"]);

	$poizvedba = "SELECT id, aktivnost FROM uporabniki WHERE email = ? LIMIT 1";

	$stmt = $conn->prepare($poizvedba);
	$stmt->bind_param("s", $_POST["email"]);
	$stmt->execute();
	$stmt->bind_result($id, $aktivnost);
	$stmt->store_result();
	$stmt->fetch();
	$rnum = $stmt->num_rows;

	$stmt->close();
	
	if ($rnum > 0) {
		if ($aktivnost == 'DA') {
			$poizvedba = "SELECT g_datum FROM uporabniki WHERE email = ? LIMIT 1";

			$stmt = $conn->prepare($poizvedba);
			$stmt->bind_param("s", $_POST["email"]);
			$stmt->execute();
			$stmt->bind_result($datum);
			$stmt->fetch();
	
			$stmt->close();
	
			$datum1 = date("Y-m-d");

			if (empty($datum) || $datum1>=$datum) {
				$str = "1234567890qwertzuioplkjhgfdsayxcvbnm";
				$str = str_shuffle($str);
				$str = substr($str, 0, 10);

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
				$mail->Subject = 'Ponastavitev gesla spletne strani kupi.si';
				$mail->Body = '<h2 style="color: black;">Povezava za ponastavitev gesla spletne strani kupi.si: <a href="http://localhost/koda/4_ponastavigeslo.php?token='.$str.'&email='.$_POST["email"].'">kliknite tukaj</a></h2>';
				$mail->addAddress($_POST["email"]);

				$mail->Send();
				unset($mail);

				$poizvedba = "UPDATE uporabniki SET token = ? WHERE email = ?";
				
				$stmt = $conn->prepare($poizvedba);
				$stmt->bind_param("ss", $str, $_POST["email"]);
				$stmt->execute();
				
				$stmt->close();

				echo '<pom style="color: green; font-weight: bold;">Link za ponastavitev gesla je bil poslan<br/> na vaš e-mail '.$_POST["email"].'!</pom>';
			}
			else {
				echo '<pom style="color: red; font-weight: bold;">Neveljavno vnesen uporabniški e-mail naslov!</pom>';
			}
		}
		else {
			echo '<pom style="color: red; font-weight: bold;">Neveljavno vnesen uporabniški e-mail naslov!</pom>';
		}
	}
	else {
		echo '<pom style="color: red; font-weight: bold;">Neveljavno vnesen uporabniški e-mail naslov!</pom>';
	}
}

//registracija
if (isset($_POST["potrdi"]) && !empty($_POST["ime"]) && !empty($_POST["priimek"]) && !empty($_POST["up_ime"]) && !empty($_POST["email"]) && !empty($_POST["telefonska"]) && !empty($_POST["geslo"]) && !empty($_POST["potrdi_geslo"]) && $_POST["geslo"] == $_POST["potrdi_geslo"] && strlen($_POST["geslo"]) >= 6) {
	$_POST["ime"] = htmlspecialchars($_POST["ime"]);
	$_POST["priimek"] = htmlspecialchars($_POST["priimek"]);
	$_POST["up_ime"] = htmlspecialchars($_POST["up_ime"]);
	$_POST["email"] = htmlspecialchars($_POST["email"]);
	$_POST["telefonska"] = htmlspecialchars($_POST["telefonska"]);
	$_POST["geslo"] = htmlspecialchars($_POST["geslo"]);
	$_POST["potrdi_geslo"] = htmlspecialchars($_POST["potrdi_geslo"]);

	$_POST["ime"] = strip_tags($_POST["ime"]);
	$_POST["priimek"] = strip_tags($_POST["priimek"]);
	$_POST["up_ime"] = strip_tags($_POST["up_ime"]);
	$_POST["email"] = strip_tags($_POST["email"]);
	$_POST["telefonska"] = htmlspecialchars($_POST["telefonska"]);
	$_POST["geslo"] = strip_tags($_POST["geslo"]);
	$_POST["potrdi_geslo"] = strip_tags($_POST["potrdi_geslo"]);

	$profilna = "uporabnik.png";
	
	$poizvedba = "SELECT up_ime FROM uporabniki WHERE up_ime = ? LIMIT 1";
	
	$stmt = $conn->prepare($poizvedba);
	$stmt->bind_param("s", $_POST["up_ime"]);
	$stmt->execute();
	$stmt->store_result();
	$rnum1 = $stmt->num_rows;

	$stmt->close();
	
	$poizvedba = "SELECT email FROM uporabniki WHERE email = ? LIMIT 1";
	
	$stmt = $conn->prepare($poizvedba);
	$stmt->bind_param("s", $_POST["email"]);
	$stmt->execute();
	$stmt->store_result();
	$rnum2 = $stmt->num_rows;

	$stmt->close();
	
	if ($rnum1==0 && $rnum2==0) {
		if (!strpos($_POST["geslo"], ' ')) {
			$geslo_hash = hash("sha256", $_POST["geslo"]);
			$datum_nastanka = date('Y-m-d');

			$da = 'DA';
			$ne = 'NE';

			$poizvedba = "INSERT INTO uporabniki(up_ime, geslo, email, telefonska, ime, priimek, profilna_slika, datum_nastanka, aktivnost, pravice) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

			$stmt = $conn->prepare($poizvedba);
			$stmt->bind_param("ssssssssss", $_POST["up_ime"], $geslo_hash, $_POST["email"], $_POST["telefonska"], $_POST["ime"], $_POST["priimek"], $profilna, $datum_nastanka, $da, $ne);
			$stmt->execute();

			$stmt->close();

			$poizvedba = "SELECT id FROM uporabniki WHERE up_ime = ? LIMIT 1";

			$stmt = $conn->prepare($poizvedba);
			$stmt->bind_param("s", $_POST["up_ime"]);
			$stmt->execute();
			$stmt->bind_result($id);
			$stmt->fetch();

			$stmt->close();

			$poizvedba = "INSERT INTO ocene_uporabnikov(id_uporabnika) VALUES(?)";

			$stmt = $conn->prepare($poizvedba);
			$stmt->bind_param("i", $id);
			$stmt->execute();

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
			$mail->Subject = 'Uspešna registracija';
			$mail->Body = '<h2 style="color: black;">'.$_POST["ime"].' '.$_POST["priimek"].', hvala za registracijo na spletni strani kupi.si!</h2>';
			$mail->addAddress($_POST["email"]);
			
			// $mail->Send();
			unset($mail);

			session_start();
			$_SESSION["login_user"] = $_POST["up_ime"];
			$_SESSION["login_id"] = $id;
			$_SESSION["last_activity"] = time();
			$_SESSION["expire_time"] = 60*30;

			echo '<pom style="color: green; font-weight: bold;">Uspešna registracija!</pom> Preusmerjanje...';

			?><script>
				setTimeout(function() {
					window.location = "prijavljeno.php";
				}, 2000);
			</script><?php
		}
		else {
			echo '<pom style="color: red; font-weight: bold;">Geslo ne sme vsebovati presledkov!</pom>';
		}
	}
	else {
		echo '<pom style="color: red; font-weight: bold;">To uporabniško ime je že zasedeno!</pom>';
	}
}
else if (isset($_POST["potrdi"]) && !empty($_POST["geslo"]) && !empty($_POST["potrdi_geslo"]) && $_POST["geslo"] != $_POST["potrdi_geslo"]) {
	?>
		<script>
			$("#r_geslo").val("");
			$("#r_potrdi_geslo").val("");
		</script>
	<?php
	echo '<pom style="color: red; font-weight: bold;">Gesli se ne ujemata!</pom>';
}
else if (isset($_POST["potrdi"]) && !empty($_POST["geslo"]) && strlen($_POST["geslo"]) < 6) {
	?>
		<script>
			$("#r_geslo").val("");
			$("#r_potrdi_geslo").val("");
		</script>
	<?php
	echo '<pom style="color: red; font-weight: bold;">Geslo mora biti dolgo vsaj 6 znakov!</pom>';
}

zapri();
?>
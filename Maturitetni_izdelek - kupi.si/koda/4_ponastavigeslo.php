<?php
ob_start();
session_start();

require_once('funkcije.php');
povezi();

$_SESSION["last_activity"] = time();
$_SESSION["expire_time"] = 60*5;

if(time() > ($_SESSION["last_activity"] + $_SESSION["expire_time"])) {
	$poizvedba = "UPDATE uporabniki SET token = NULL WHERE email = ?";
				
	$stmt = $conn->prepare($poizvedba);
	$stmt->bind_param("s", $email);
	$stmt->execute();
	
	$stmt->close();
	
	session_unset();
	session_destroy();
	
   header('location: potek_prijave.php');
}

$_SESSION["token"] = $_GET["token"];
$_SESSION["email"] = $_GET["email"];

$poizvedba = "SELECT id FROM uporabniki WHERE token = ? LIMIT 1";

$stmt = $conn->prepare($poizvedba);
$stmt->bind_param("s", $_SESSION["token"]);
$stmt->execute();
$stmt->store_result();
$rnum = $stmt->num_rows;

$stmt->close();

if ($rnum == 0) {
	session_unset();
	session_destroy();
	
	header("location: zacetna.php");
	die();
}

if (isset($_SESSION["email"]) && isset($_SESSION["token"])) {
	if (!empty($_POST["geslo"]) && !empty($_POST["potrdi_geslo"]) && $_POST["geslo"] == $_POST["potrdi_geslo"] && strlen($_POST["geslo"]) >= 6) {
		povezi();
		
		$_POST["geslo"] = htmlspecialchars($_POST["geslo"]);
		$_POST["potrdi_geslo"] = htmlspecialchars($_POST["potrdi_geslo"]);

		$_POST["geslo"] = strip_tags($_POST["geslo"]);
		$_POST["potrdi_geslo"] = strip_tags($_POST["potrdi_geslo"]);

		$email = $_SESSION["email"];
		$token = $_SESSION["token"];
		
		$poizvedba = "SELECT id FROM uporabniki WHERE email = ? AND token = ? LIMIT 1";
		$geslo_hash = hash("sha256", $_POST["geslo"]);

		$stmt = $conn->prepare($poizvedba);
		$stmt->bind_param("ss", $email, $token);
		$stmt->execute();
		$stmt->store_result();
		$rnum = $stmt->num_rows;

		$stmt->close();
		
		if ($rnum > 0) {
			$poizvedba = "SELECT geslo FROM uporabniki WHERE email = ? AND token = ? LIMIT 1";

			$stmt = $conn->prepare($poizvedba);
			$stmt->bind_param("ss", $email, $token);
			$stmt->execute();
			$stmt->bind_result($geslo);
			$stmt->fetch();

			$stmt->close();

			if ($geslo_hash != $geslo) {
				$datum = date('Y-m-d',strtotime('+10 days',strtotime(str_replace('/', '-', date("Y-m-d"))))) . PHP_EOL;

				$poizvedba = "UPDATE uporabniki SET geslo = ?, g_datum = ?,token = NULL WHERE email = ?";
				
				$stmt = $conn->prepare($poizvedba);
				$stmt->bind_param("sss", $geslo_hash, $datum, $email);
				$stmt->execute();
				
				$stmt->close();				

				session_unset();
				session_destroy();

				$msg = "Geslo ponastavljeno!";
				$klasa = "alert-success";

				header("refresh:2; url = zacetna.php");
			}
			else {
				$msg = "Novo geslo ne mora biti enako staremu geslu!";
				$klasa = "alert-danger";
			}
		}
		else {
			$poizvedba = "UPDATE uporabniki SET token = NULL WHERE email = ?";
			
			$stmt = $conn->prepare($poizvedba);
			$stmt->bind_param("s", $email);
			$stmt->execute();

			$stmt->close();
			
			session_unset();
			session_destroy();

			header("location: zacetna.php");
		}
	}
	else if (!empty($_POST["geslo"]) && !empty($_POST["potrdi_geslo"]) && $_POST["geslo"] != $_POST["potrdi_geslo"]) {
		$msg = "Gesli se ne ujemata!";
		$klasa = "alert-danger";
	}
	else if (!empty($_POST["geslo"]) && strlen($_POST["geslo"]) < 6) {
		$msg = "Geslo mora biti<br/> dolgo vsaj 6 znakov!";
		$klasa = "alert-danger";
	}
}
else {
	session_unset();
	session_destroy();

	header("location: zacetna.php");
}
?>

<DOCTYPE html>
<html>
<head>
	<?php
		Head();
	?>
</head>
<body>

<header class="header_1">
	<div class="prvi">
		<div class="prvi_3">
			<a href="zacetna.php"><img alt="" src="slike/logo.png" style="height: 65px; width: 165px;" title="Domov" /></a>
		</div>
    </div>
    <div style="text-align: center; padding-top: 20px; padding-right: 190px;">
		<h2>PONASTAVITEV GESLA</h2>
	</div>
</header>

<section class="section_3" style="padding-bottom: 5px; width: 444px;" >
	<div class="box">
		<form action="" method="POST" accept-charset="utf-8">
			<table style="text-align: center;">
				<tr><td style="font-weight: bold;">Vnesite novo geslo:</td></tr>
				<tr><td style="padding-top: 10px;"><input type="password" style="color: black; border-radius: 20px;" name="geslo" maxlength="20" class="form-control" required /></td></tr>
				
				<tr><td style="padding-top: 15px; font-weight: bold;">Potrdite novo geslo:</td></tr>
				<tr><td style="padding-top: 10px;"><input type="password" style="color: black; border-radius: 20px;" name="potrdi_geslo" maxlength="20" class="form-control" required /></td></tr>

				<?php if (!empty($msg)) { ?>
					<tr><td style="padding-top: 15px;"><div style="border-radius: 10px;" class ="alert <?php echo $klasa; ?>">
						<?php echo $msg; ?>
					</div></td></tr>
				<?php } ?>

				<tr><td style="padding-top: 15px;"><input type="submit" name="ponastavi" value="PONASTAVI" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px; width: 376px;" /></td></tr>
			</table>
		</form>
	</div>
</section>

</body>
</html>

<?php
	zapri();
?>
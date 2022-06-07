<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "content-user-edit-data.css" ?>">
	<script src="../../external/script/javascript.js"></script>
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8" />
	<title>Uredi osebne podatke</title>
</head>

<body>
	<div class="form">
		<span class="span-login">UREDI OSEBNE PODATKE</span>
		<div class="form-split">
			<div></div>
			<div>
				<hr>
				<form action="<?= BASE_URL . "content/user-edit-data" ?>" method="post">
					<div class="name-of-input">IME</div>
					<input type="text" class="form-control form-control-lg <?php echo strlen($errorsSent["ime"])>0 ? "is-invalid" : ""; ?> search-input" pattern="^[a-zA-ZšđčćžŠĐČĆŽ]+$" placeholder="ime" name="ime" value="<?= $dataSent["ime"] ?>" required autofocus />
					<div id="error_ime" class="alert alert-danger"><?= $errorsSent["ime"] ?></div>
					
					<div class="name-of-input">PRIIMEK</div>
					<input type="text" class="form-control form-control-lg <?php echo strlen($errorsSent["priimek"])>0 ? "is-invalid" : ""; ?> search-input" pattern="^[a-zA-ZšđčćžŠĐČĆŽ]+$" placeholder="priimek" name="priimek" value="<?= $dataSent["priimek"] ?>" required />
					<div id="error_priimek" class="alert alert-danger"><?= $errorsSent["priimek"] ?></div>
					
					<div class="name-of-input">E-NASLOV</div>
					<input type="text" class="form-control form-control-lg search-input" name="email" value="<?= $_SESSION["data"]["email"] ?>" disabled />
					
					<div class="name-of-input">TELEFONSKA ŠTEVILKA</div>
					<input type="text" class="form-control form-control-lg <?php echo strlen($errorsSent["telefon"])>0 ? "is-invalid" : ""; ?> search-input" pattern="^[0-9]{9}$" placeholder="telefon" name="telefon" value="<?= $dataSent["telefon"] ?>" required />
					<div id="error_telefon" class="alert alert-danger"><?= $errorsSent["telefon"] ?></div>
					
					<div class="name-of-input">DATUM ROJSTVA</div>
					<input type="date" class="form-control form-control-lg <?php echo strlen($errorsSent["datum_rojstva"])>0 ? "is-invalid" : ""; ?> search-input-date" name="datum_rojstva" value="<?= $dataSent["datum_rojstva"] ?>" required />
					<div id="error_datumRojstva" class="alert alert-danger"><?= $errorsSent["datum_rojstva"] ?></div>
					
					<div class="name-of-input">POTRDI Z GESLOM</div>					
					<input type="password" class="form-control form-control-lg <?php echo strlen($errorsSent["geslo"])>0 ? "is-invalid" : ""; ?> search-input" name="geslo" placeholder="geslo" required />
					<div id="error_geslo" class="alert alert-danger"><?= $errorsSent["geslo"] ?></div>
					
					<div class="confirm-buttons">
						<button class="btn btn-info button-input" name="update">POSODOBI</button>
						<div></div>
						<button name="delete" class="btn btn-danger button-input" onclick="return confirm('Ali res želite izbrisati ra račun?')">DOKONČNO IZBRIŠI</button>
					</div>
				</form>
			</div>
			<div></div>
		</div>
	</div>
</body>
</html>

<script>
	let error_ime = "<?= $errorsSent['ime'] ?>";
	
	if (error_ime.length <=0) {
		document.getElementById('error_ime').style.display = "none";
	}
	
	let error_priimek = "<?= $errorsSent['priimek'] ?>";
	
	if (error_priimek.length <=0) {
		document.getElementById('error_priimek').style.display = "none";
	}
	
	let error_telefon = "<?= $errorsSent['telefon'] ?>";
	
	if (error_telefon.length <=0) {
		document.getElementById('error_telefon').style.display = "none";
	}
	
	let error_datumRojstva = "<?= $errorsSent['datum_rojstva'] ?>";
	
	if (error_datumRojstva.length <=0) {
		document.getElementById('error_datumRojstva').style.display = "none";
	}
	
	let error_geslo = "<?= $errorsSent['geslo'] ?>";
	
	if (error_geslo.length <=0) {
		document.getElementById('error_geslo').style.display = "none";
	}
</script>
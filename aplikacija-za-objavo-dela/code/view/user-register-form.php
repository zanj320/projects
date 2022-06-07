<!DOCTYPE html>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "register.css" ?>">
	<script src="../../external/script/javascript.js"></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8" />
	<title>Registracija</title>
</head>

<body>
	<div></div>
	<div class="form">
		<span class="span-login">REGISTRACIJA UPORABNIKA</span>
		<hr>
		<form action="<?= BASE_URL . "content/user-register-form" ?>" method="post">
			<input class="form-control form-control-lg <?php echo strlen($errorsSent["ime"])>0 ? "is-invalid" : ""; ?> search-input" type="text" pattern="^[a-zA-ZšđčćžŠĐČĆŽ]+$" name="ime" value="<?= $dataSent["ime"] ?>" placeholder="ime" required autofocus />
			<div id="error_ime" class="alert alert-danger errors"><?= $errorsSent["ime"] ?></div>
			
			<input class="form-control form-control-lg <?php echo strlen($errorsSent["priimek"])>0 ? "is-invalid" : ""; ?> search-input" type="text" pattern="^[a-zA-ZšđčćžŠĐČĆŽ]+$" name="priimek" value="<?= $dataSent["priimek"] ?>" placeholder="priimek" required />
			<div id="error_priimek" class="alert alert-danger errors"><?= $errorsSent["priimek"] ?></div>
			
			<input class="form-control form-control-lg <?php echo strlen($errorsSent["email"])>0 ? "is-invalid" : ""; ?> search-input" type="email" name="email" value="<?= $dataSent["email"] ?>" placeholder="e-naslov" required />
			<div id="error_email" class="alert alert-danger errors"><?= $errorsSent["email"] ?></div>
			
			<input class="form-control form-control-lg <?php echo strlen($errorsSent["telefon"])>0 ? "is-invalid" : ""; ?> search-input" type="text" pattern="^[0-9]{9}$" name="telefon" value="<?= $dataSent["telefon"] ?>" placeholder="telefonska številka" required />
			<div id="error_telefon" class="alert alert-danger errors"><?= $errorsSent["telefon"] ?></div>
			
			<div class="name-of-input">DATUM ROJSTVA</div>
			<input class="form-control form-control-lg <?php echo strlen($errorsSent["datum_rojstva"])>0 ? "is-invalid" : ""; ?> search-input-date" type="date" name="datum_rojstva" value="<?= $dataSent["datum_rojstva"] ?>" required />
			<div id="error_datumRojstva" class="alert alert-danger errors"><?= $errorsSent["datum_rojstva"] ?></div>
			
			<input class="form-control form-control-lg <?php echo strlen($errorsSent["geslo"])>0 ? "is-invalid" : ""; ?> search-input" type="password" name="geslo" value="<?= $dataSent["geslo"] ?>" placeholder="geslo" required />
			<input class="form-control form-control-lg <?php echo strlen($errorsSent["geslo"])>0 ? "is-invalid" : ""; ?> search-input" type="password" name="potrdi_geslo" value="<?= $dataSent["potrdi_geslo"] ?>" placeholder="potrdi geslo" required />
			<div id="error_geslo" class="alert alert-danger errors"><?= $errorsSent["geslo"] ?></div>
			
			<button class="btn btn-info button-input">REGISTRIRAJ ME</button>
		</form>
	</div>
	<div></div>
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
	
	let error_email = "<?= $errorsSent['email'] ?>";
	
	if (error_email.length <=0) {
		document.getElementById('error_email').style.display = "none";
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
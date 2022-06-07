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
	<div class="form">
		<span class="span-login">REGISTRACIJA PODJETJA</span>
		<hr>
		<form action="<?= BASE_URL . "content/company-register-form" ?>" method="post">
			<div class="form-split">
				<div>
					<span class="podjetje-lastnik">PODATKI LASTNIKA</span>
					<input class="form-control form-control-lg <?php echo strlen($errorsSent["ime"])>0 ? "is-invalid" : ""; ?> search-input" type="text" pattern="^[a-zA-ZšđčćžŠĐČĆŽ]+$" name="ime" value="<?= $dataSent["ime"] ?>" placeholder="ime" required autofocus />
					<div id="error_ime" class="alert alert-danger errors"><?= $errorsSent["ime"] ?></div>
					
					<input class="form-control form-control-lg <?php echo strlen($errorsSent["priimek"])>0 ? "is-invalid" : ""; ?> search-input" type="text" pattern="^[a-zA-ZšđčćžŠĐČĆŽ]+$" name="priimek" value="<?= $dataSent["priimek"] ?>" placeholder="priimek" required />
					<div id="error_priimek" class="alert alert-danger errors"><?= $errorsSent["priimek"] ?></div>
					
					<input class="form-control form-control-lg <?php echo strlen($errorsSent["email"])>0 ? "is-invalid" : ""; ?> search-input" type="email" name="email" value="<?= $dataSent["email"] ?>" placeholder="e-naslov" required />
					<div id="error_email" class="alert alert-danger errors"><?= $errorsSent["email"] ?></div>
					
					<input class="form-control form-control-lg <?php echo strlen($errorsSent["telefon"])>0 ? "is-invalid" : ""; ?> search-input" type="text" name="telefon" value="<?= $dataSent["telefon"] ?>" placeholder="telefonska številka" required />
					<div id="error_telefon" class="alert alert-danger errors"><?= $errorsSent["telefon"] ?></div>
					
					<br>
				</div>
				<div></div>
				<div>
					<span class="podjetje-lastnik">PODATKI PODJETJA</span>
					<input class="form-control form-control-lg <?php echo strlen($errorsSent["davcna"])>0 ? "is-invalid" : ""; ?> search-input" type="text" pattern="^[0-9]{8}$" name="davcna" value="<?= $dataSent["davcna"] ?>" placeholder="davčna številka" required autofocus />
					<div id="error_davcna" class="alert alert-danger errors"><?= $errorsSent["davcna"] ?></div>
					
					<input class="form-control form-control-lg <?php echo strlen($errorsSent["naziv"])>0 ? "is-invalid" : ""; ?> search-input" type="text" pattern="^[a-zA-ZšđčćžŠĐČĆŽ0-9 .-]+$" name="naziv" value="<?= $dataSent["naziv"] ?>" placeholder="naziv" required />
					<div id="error_naziv" class="alert alert-danger errors"><?= $errorsSent["naziv"] ?></div>
					
					<input class="form-control form-control-lg <?php echo strlen($errorsSent["naslov"])>0 ? "is-invalid" : ""; ?> search-input" type="text" pattern="^[a-zA-ZšđčćžŠĐČĆŽ0-9 ]+" name="naslov" value="<?= $dataSent["naslov"] ?>" placeholder="naslov sedeža" required />
					<div id="error_naslov" class="alert alert-danger errors"><?= $errorsSent["naslov"] ?></div>
					
					<input class="form-control form-control-lg <?php echo strlen($errorsSent["postna_st"])>0 ? "is-invalid" : ""; ?> search-input" type="text" pattern="^[0-9]{4}+$" name="postna_st" value="<?= $dataSent["postna_st"] ?>" placeholder="poštna številka" required />
					<div id="error_postnaSt" class="alert alert-danger errors"><?= $errorsSent["postna_st"] ?></div>
				
					<br>
				</div>
			
				<div class="password">
					<input class="form-control form-control-lg <?php echo strlen($errorsSent["geslo"])>0 ? "is-invalid" : ""; ?> search-input" type="password" name="geslo" value="<?= $dataSent["geslo"] ?>" placeholder="geslo" required />
				</div>
				<div></div>
				<div class="password_confirm">
					<input class="form-control form-control-lg <?php echo strlen($errorsSent["geslo"])>0 ? "is-invalid" : ""; ?> search-input" type="password" name="potrdi_geslo" value="<?= $dataSent["potrdi_geslo"] ?>" placeholder="potrdi geslo" required />
				</div>
			</div>
			<div id="error_geslo" class="alert alert-danger errors"><?= $errorsSent["geslo"] ?></div>
				
			<button class="btn btn-info button-input">REGISTRIRAJ ME</button>
		</form>
	</div>
</body>
</html>

<script>
	let error_davcna = "<?= $errorsSent['davcna'] ?>";
	
	if (error_davcna.length <=0) {
		document.getElementById('error_davcna').style.display = "none";
	}
	
	let error_naziv = "<?= $errorsSent['naziv'] ?>";
	
	if (error_naziv.length <=0) {
		document.getElementById('error_naziv').style.display = "none";
	}
	
	let error_naslov = "<?= $errorsSent['naslov'] ?>";
	
	if (error_naslov.length <=0) {
		document.getElementById('error_naslov').style.display = "none";
	}
	
	let error_postnaSt = "<?= $errorsSent['postna_st'] ?>";
	
	if (error_postnaSt.length <=0) {
		document.getElementById('error_postnaSt').style.display = "none";
	}


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
	
	let error_geslo = "<?= $errorsSent['geslo'] ?>";
	
	if (error_geslo.length <=0) {
		document.getElementById('error_geslo').style.display = "none";
	}
</script>
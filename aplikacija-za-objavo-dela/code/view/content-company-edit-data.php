<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "content-company-edit-data.css" ?>">
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
		<hr>
		<form action="<?= BASE_URL . "content/company-edit-data" ?>" method="post">
			<div class="form-split">
				<div>
					<span class="podjetje-lastnik">PODATKI LASTNIKA</span>
					
					<div class="elements">
						<div class="name-of-input">E-NASLOV</div>
						<input class="form-control form-control-lg search-input" type="text" name="email" value="<?= $_SESSION["data"]["email"] ?>" disabled />
						
						<div class="name-of-input">IME</div>
						<input class="form-control form-control-lg <?php echo strlen($errorsSent["ime"])>0 ? "is-invalid" : ""; ?> search-input" type="text" name="ime" placeholder="ime" value="<?= $dataSent["ime"] ?>" required autofocus />
						<div id="error_ime" class="alert alert-danger errors"><?= $errorsSent["ime"] ?></div>
						
						<div class="name-of-input">PRIIMEK</div>
						<input class="form-control form-control-lg <?php echo strlen($errorsSent["priimek"])>0 ? "is-invalid" : ""; ?> search-input" type="text" name="priimek" placeholder="priimek" value="<?= $dataSent["priimek"] ?>" required />
						<div id="error_priimek" class="alert alert-danger errors"><?= $errorsSent["priimek"] ?></div>
						
						<div class="name-of-input">TELEFON</div>
						<input class="form-control form-control-lg <?php echo strlen($errorsSent["telefon"])>0 ? "is-invalid" : ""; ?> search-input" type="text" name="telefon" placeholder="telefon" value="<?= $dataSent["telefon"] ?>" required />
						<div id="error_telefon" class="alert alert-danger errors"><?= $errorsSent["telefon"] ?></div>
					</div>
				</div>
				<div></div>
				<div>
					<span class="podjetje-lastnik">PODATKI PODJETJA</span>
					
					<div class="elements">
						<div class="name-of-input">DAVČNA ŠTEVILKA</div>
						<input class="form-control form-control-lg search-input" type="text" name="davcna" value="<?= $_SESSION["data"]["davcna"] ?>" disabled />
						
						<div class="name-of-input">NAZIV</div>
						<input class="form-control form-control-lg <?php echo strlen($errorsSent["naziv"])>0 ? "is-invalid" : ""; ?> search-input" type="text" name="naziv" placeholder="naziv" value="<?= $dataSent["naziv"] ?>" required  />
						<div id="error_naziv" class="alert alert-danger errors"><?= $errorsSent["naziv"] ?></div>
						
						<div class="name-of-input">NASLOV</div>
						<input class="form-control form-control-lg <?php echo strlen($errorsSent["naslov"])>0 ? "is-invalid" : ""; ?> search-input" type="text" name="naslov" placeholder="naslov" value="<?= $dataSent["naslov"] ?>" required />
						<div id="error_naslov" class="alert alert-danger errors"><?= $errorsSent["naslov"] ?></div>
						
						<div class="name-of-input">POŠTNA ŠTEVILKA</div>
						<input class="form-control form-control-lg <?php echo strlen($errorsSent["postna_st"])>0 ? "is-invalid" : ""; ?> search-input" type="text" name="postna_st" placeholder="poštna številka" value="<?= $dataSent["postna_st"] ?>" required />
						<div id="error_postnaSt" class="alert alert-danger errors"><?= $errorsSent["postna_st"] ?></div>
					</div>
				</div>
			</div>
			<div class="name-of-input">POTRDI Z GESLOM</div>
			<input class="form-control form-control-lg search-input" type="password" placeholder="geslo" name="geslo" required />
			<div id="error_geslo" class="alert alert-danger errors"><?= $errorsSent["geslo"] ?></div>
			<div class="confirm-buttons">	
				<button class="btn btn-info button-input" name="update">POSODOBI</button>
				<div></div>
				<button class="btn btn-danger button-input" name="delete" onclick="return confirm('Ali res želite izbrisati ra račun?')">DOKONČNO IZBRIŠI</button>
			</div>
		</form>
	</div>
</body>
</html>

<script>
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
	
	let error_telefon = "<?= $errorsSent['telefon'] ?>";
	
	if (error_telefon.length <=0) {
		document.getElementById('error_telefon').style.display = "none";
	}
	
	let error_geslo = "<?= $errorsSent['geslo'] ?>";
	
	if (error_geslo.length <=0) {
		document.getElementById('error_geslo').style.display = "none";
	}
</script>
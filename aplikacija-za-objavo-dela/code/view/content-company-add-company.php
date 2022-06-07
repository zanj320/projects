<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "content-company-post-work.css" ?>">
	<script src="../../external/script/javascript.js"></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8" >
	<title>Dodaj podjetje</title>
</head>

<body>
	<div class="form">
		<span class="span-login">DODAJ PODJETJE</span>
		<hr>
		<form action="<?= BASE_URL . "content/company-add-company" ?>" method="post">
			<div class="name-of-input">DAVČNA ŠTEVILKA</div>
			<input class="form-control form-control-lg <?php echo strlen($errorsSent["davcna"])>0 ? "is-invalid" : ""; ?> search-input" type="text" placeholder="davčna številka" name="davcna" value="<?= $dataSent["davcna"] ?>" required autofocus />
			<div id="error_davcna" class="alert alert-danger"><?= $errorsSent["davcna"] ?></div>
			
			<div class="name-of-input">NAZIV</div>
			<input class="form-control form-control-lg <?php echo strlen($errorsSent["naziv"])>0 ? "is-invalid" : ""; ?> search-input" type="text" placeholder="naziv" name="naziv" value="<?= $dataSent["naziv"] ?>" required />
			<div id="error_naziv" class="alert alert-danger"><?= $errorsSent["naziv"] ?></div>
			
			<div class="name-of-input">NASLOV</div>
			<input class="form-control form-control-lg <?php echo strlen($errorsSent["naslov"])>0 ? "is-invalid" : ""; ?> search-input" type="text" placeholder="naslov" name="naslov" value="<?= $dataSent["naslov"] ?>" required />
			<div id="error_naslov" class="alert alert-danger"><?= $errorsSent["naslov"] ?></div>
			
			<div class="name-of-input">POŠTNA ŠTEVILKA</div>
			<input class="form-control form-control-lg <?php echo strlen($errorsSent["postna_st"])>0 ? "is-invalid" : ""; ?> search-input" type="text" placeholder="poštna številka" name="postna_st" value="<?= $dataSent["postna_st"] ?>" required />
			<div id="error_postnaSt" class="alert alert-danger"><?= $errorsSent["postna_st"] ?></div>
		
			<p><button class="btn btn-info button-input">DODAJ PODJETJE</button></p>
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
</script>
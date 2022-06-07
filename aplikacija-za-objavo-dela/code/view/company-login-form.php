<!DOCTYPE html>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "login.css" ?>">
	<script src="../../external/script/javascript.js"></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8" />
	<title>Prijava</title>
</head>

<body>
	<div></div>
	<div class="form">
		<span class="span-login">PRIJAVA KOT PODJETJE</span>
		<hr>
		<form action="<?= BASE_URL . "content/company-login-form" ?>" method="post">
			<input class="form-control form-control-lg <?php echo strlen($errorsSent["all"])>0 ? "is-invalid" : ""; ?> search-input" type="text" pattern="^[0-9]{8}$" name="davcna" placeholder="davčna številka" required autofocus />
			<input class="form-control form-control-lg <?php echo strlen($errorsSent["all"])>0 ? "is-invalid" : ""; ?> search-input" type="email" name="email" placeholder="e-naslov" required autofocus />
			<input class="form-control form-control-lg <?php echo strlen($errorsSent["all"])>0 ? "is-invalid" : ""; ?> search-input" type="password" placeholder="geslo" name="geslo" required />
			<div id="error_login" class="alert alert-danger "><?= $errorsSent["all"] ?></div>
			<p><button class="btn btn-info button-input">PRIJAVA</button></p>
		</form>

		<form action="<?= BASE_URL . "content/company-register-form" ?>" method="get">
				<span class="span-register">Slučajno še nimate računa?</span> <button class="btn btn-info button-input">REGISTRACIJA</button>
		</form>
	</div>
	<div></div>
</body>

</html>

<script>
	let error = "<?= $errorsSent['all'] ?>";
	
	if (error.length <=0)
		document.getElementById('error_login').style.display="none";
</script>
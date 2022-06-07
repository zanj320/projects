<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "content-company-add-company.css" ?>">
	<script src="../../external/script/javascript.js"></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8" >
	<title>Objavi delo</title>
</head>

<body>
	<div class="form">
		<span class="span-login">OBJAVI DELO</span>
		<hr>
		<form action="<?= BASE_URL . "content/company-post-work" ?>" method="post">
			<div class="name-of-input">NAZIV</div>
			<input class="form-control form-control-lg search-input" type="text" placeholder="naziv" name="naziv" value="<?= $dataSent["naziv"] ?>" required autofocus />
			
			<div class="name-of-input">OPIS</div>
			<textarea class="form-control textarea-for-request" placeholder="opis dela" name="opis"><?= $dataSent["opis"] ?></textarea>
			
			<div class="name-of-input">PLAČA</div>
			<input class="form-control form-control-lg <?php echo strlen($errorsSent["all"])>0 ? "is-invalid" : ""; ?> search-input" type="text" placeholder="plača" name="placa" value="<?= $dataSent["placa"] ?>" required />
			
			<div id="error_data" class="alert alert-danger"><?= $errorsSent["all"] ?></div>
		
			<p><button class="btn btn-info button-input">DODAJ DELO</button></p>
		</form>
	</div>
</body>
</html>

<script>
	let error = "<?= $errorsSent['all'] ?>";
	
	if (error.length <=0)
		document.getElementById('error_data').style.display="none";
</script>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "content-not-login.css" ?>">
	<script src="../external/script/javascript.js"></script>
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<meta charset="UTF-8" />
	<title>Najdi delo</title>
</head>

<body>
	<div></div>
	<div class="left-aside">
		<div class="sidenav-home">
			<form action="<?= BASE_URL . "content" ?>" method="get">
				<button class="btn btn-info btn-lg button-home">DOMOV</button>
			</form>
		</div>
	
		<div class="sidenav-login">
		  <h2>PRIJAVA</h2>
		  <hr>
		  <span onclick="userLogin()"><form id="userLoginForm" action="<?= BASE_URL . "content/user-login-form" ?>" method="get"><u>Prijavi se kot uporabnik</u></form></span>
		  <span onclick="companyLogin()"><form id="companyLoginForm" action="<?= BASE_URL . "content/company-login-form" ?>" method="get"><u>Prijavi se kot podjetje</u></form></span>
		  <hr>
		</div>

		<div class="sidenav-register">
		  <h2>REGISTRACIJA</h2>
		  <hr>
		  <span onclick="userRegister()"><form id="userRegisterForm" action="<?= BASE_URL . "content/user-register-form" ?>" method="get"><u>Registriraj se kot uporabnik</u></form></span>
		  <span onclick="companyRegister()"><form id="companyRegisterForm" action="<?= BASE_URL . "content/company-register-form" ?>" method="get"><u>Registriraj se kot podjetje</u></form></span>
		  <hr>
		</div>
	</div>
	<div></div>
	<div class="main">
		<div class="search">
			<form action="<?= BASE_URL . "content" ?>" method="get">
				<input type="text" name="isci" placeholder="Vnesite naziv dela" class="form-control form-control-lg search-input" />
				<div></div>
				<button class="btn btn-info btn-lg button-input">IŠČI</button>
			</form>
		</div>

		<div class="works">
			<?php
				$j = 0;

				for ($i=0; true; $i++) {
					$a = "var$i";
					if (!isset($$a)) break;
					$data = $$a;
				

					$diff = round((time() - strtotime($data["datum_objave"])) / (60 * 60 * 24));
					
					$novo = $diff<=1 ? "Novo!" : "";
					
					?>
					<div class="work">
						<p class="work-title"><?= $data["naziv"] ?> <span class="new-work"><?= $novo ?></span><p/>
						<p><b>Podjetje: </b><?= $data["naziv_podjetja"] ?></p>
						<p><span class="description"><?= $data["opis"] ?></span></b></p>
						<p><b>Plača: </b><?= number_format($data["placa"], 2) ?> €/h<p/>
						<p><b>Datum objave: </b><?= date_format(date_create($data["datum_objave"]), "d.m.Y") ?><p/>
						<p><b>Lokacija: </b><?= $data["naslov"] ?></p>
					</div>
					<?php
				}
			?>
		</div>
	</div>
	<div></div>
</body>
</html>

<script>
$(document).ready(function() {
	if	($(window).width() >= 1100) {
		$(window).scroll(function(){
		  $(".left-aside").stop().animate({"marginTop": ($(window).scrollTop()) + "px", "marginLeft":($(window).scrollLeft()) + "px"}, "fast");
		});
	}
});
</script>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "content-user-login.css" ?>">
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
			<h2><?= $_SESSION["data"]["ime"] . " " . $_SESSION["data"]["priimek"] ?></h2>
			<hr>
			<span onclick="userEditData()"><form id="userEditData" action="<?= BASE_URL . "content/user-edit-data" ?>" method="get"><u>UREDI PODATKE</u></form></span>
			<span onclick="userWorkRequests()"><form id="userWorkRequests" action="<?= BASE_URL . "content/user-show-requests" ?>" method="get"><u>MOJA NAROČILA</u></form></span>
			<span onclick="userLogout()"><form id="userLogout" action="<?= BASE_URL . "content/destroy" ?>" method="get"><u>ODJAVA</u></form></span>
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
			<script>let a=true;</script>

			<br>
			<?php
				$j = 0;

				for ($i=0; true; $i++) {
					$a = "var$i";
					if (!isset($$a)) break;
					$data = $$a;
					
					$diff = round((time() - strtotime($data["datum_objave"])) / (60 * 60 * 24));
					
					$novo = $diff<=1 ? "Novo!" : "";
					
					$narocen = false;
					foreach ($_SESSION["data"]["requestedJobs"] as $el) {
						if ($el["id_delo"] == $data["id_delo"]) { $narocen = true; break; }
					}
					?>
					<div class="work">
						<p class="work-title"><?= $data["naziv"] ?><span class="new-work"><?= $novo ?></span><p/>
						<p><b>Podjetje: </b><?= $data["naziv_podjetja"] ?></p>
						<p><span class="description"><?= $data["opis"] ?></span></p>
						<p><b>Plača: </b><?= number_format($data["placa"], 2) ?> €/h<p/>
						<p><b>Datum objave: </b><?= date_format(date_create($data["datum_objave"]), "d.m.Y") ?><p/>
						<p><b>Lokacija: </b><?= $data["naslov"] ?></p>
						<div class="dropdown">
						<?php if (!$narocen) { ?>
							<div class="align-to-right">
								<button class="btn btn-info btn-lg button-show-form dropbtn" onclick="prikazi_form(<?= $j ?>)">ODDAJ PROŠNJO</button>
							</div>
							<div class="dropdown-content">
								<span class="name-of-input">BESEDILO PROŠNJE</span>
								<form action="<?= BASE_URL . "content/user-post-request" ?>" method="post">
									<input type="hidden" name="id_delo" value="<?= $data["id_delo"] ?>" />
									<!--input type="hidden" name="id_podjetje" value="<?= $data["id_podjetje"] ?>" /-->
									<textarea class="form-control textarea-for-request" maxlength="650" name="besedilo"></textarea>
									<div class="align-to-right">
										<button class="btn btn-info btn-lg button-input dropbtn">POŠLJI</button>
									</div>
								</form>
							</div>
							<?php
								$j++;
							} else {
								echo "<div class='work-status'>Ste že naročeni!</div>";
							} ?>
						</div>
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
	let count = <?= $j ?>;
	
	function prikazi_form() {
		for (let i=0; i<count; i++) {
			document.getElementsByClassName("dropdown-content")[i].style.display = "none";
			document.getElementsByClassName("dropbtn")[i].style.backgroundColor = "";
		}
		
		if (a) {
			document.getElementsByClassName("dropdown-content")[arguments[0]].style.display = "block";
		} else {
			document.getElementsByClassName("dropdown-content")[arguments[0]].style.display = "none";
		}
		a = !a;
	}
	
	$(document).ready(function() {
		if	($(window).width() >= 1100) {
			$(window).scroll(function(){
			  $(".left-aside").stop().animate({"marginTop": ($(window).scrollTop()) + "px", "marginLeft":($(window).scrollLeft()) + "px"}, "fast");
			});
		}
	});
</script>

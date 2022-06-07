<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "content-company-login.css" ?>">
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
			<h2><?= $_SESSION["data"]["naziv"] ?></h2>
			<h2><?= $_SESSION["data"]["ime"] . " " . $_SESSION["data"]["priimek"] ?></h2>
			<hr>
			<span onclick="companyEditData()"><form id="companyEditData" action="<?= BASE_URL . "content/company-edit-data" ?>" method="get"><u>UREDI PODATKE</u></form></span>
			<span onclick="companyPostWork()"><form id="companyPostWork" action="<?= BASE_URL . "content/company-post-work" ?>" method="get"><u>OBJAVI DELO</u></form></span>
			<span onclick="companyAddCompany()"><form id="companyAddCompany" action="<?= BASE_URL . "content/company-add-company" ?>" method="get"><u>DODAJ PODJETJE</u></form></span>
			<span onclick="companyViewRequests()"><form id="companyViewRequests" action="<?= BASE_URL . "content/company-view-requests" ?>" method="get"><u>OGLEJ PROŠNJE</u></form></span>
			<span onclick="userLogout()"><form id="userLogout" action="<?= BASE_URL . "content/destroy" ?>" method="get"><u>ODJAVA</u></form></span>
			<hr>
		</div>
	</div>
	<div></div>
	<div class="main">
		<div class="works">
			<div class="work">
				<div class="search">
					<span class="title">Vsa podjetja v lasti <span><?php  if (isset($errorsSent["all"])) echo $errorsSent["all"]; ?></span></span>
				</div>
				<?php
					require_once("DisplayFile.php");

					$count = 1;
					foreach ($_SESSION["allCompanies"] as $company) {
						$tmp = false;
						if ($company["id_podjetje"] != $_SESSION["data"]["id_podjetje"]) { $tmp = true; }
						?>
						<p style="display: inline-block;">
						<?php
						if (!$tmp) { echo "<b>"; }
						echo '<span>' . $count . ': ' . $company["naziv"] . ', ' . $company["naslov"] . '</span>';
						if (!$tmp) { echo "</b>"; } ?>
						
						<form style="display: inline-block;" action="<?= BASE_URL . "content/company-switch" ?>" method="post">
							<input type="hidden" name="id_podjetje" value="<?= $company["id_podjetje"] ?>" />
							<input type="hidden" name="naziv" value="<?= $company["naziv"] ?>" />
							<input type="hidden" name="naslov" value="<?= $company["naslov"] ?>" />
							<input type="hidden" name="postna_st" value="<?= $company["postna_st"] ?>" />
							<input type="hidden" name="davcna" value="<?= $company["davcna"] ?>" />
							<?php if ($tmp) {
								echo '&nbsp; &nbsp;<button class="btn btn-dark btn-sm button-input button-switch">ZAMENJAJ</button>';
							} ?>
						</form>
						<br>
						<form style="display: inline-block;" action="<?= BASE_URL . "content/company-delete-company" ?>" method="post">
							<input type="hidden" name="id_podjetje" value="<?= $company["id_podjetje"] ?>" />
							<button name="deletCompany_button" class="btn btn-warning btn-lg button-input" onclick="return confirm('Ali res želite odstraniti to podjetje?')">ODSTRANI</button>
						</form>
						</p>
						<?php
						$count++;
					}
				?>
			</div>
			
			<div class="work">
				<div class="search">
					<span class="title">Vsa objavljena dela</span>
				</div>
				<?php
					require_once("DisplayFile.php");

					$count = 1;
					foreach ($_SESSION["everyWork"] as $work) { ?>
						<hr>
						<form action="<?= BASE_URL . "content/company-edit-work" ?>" method="post">
							<input type="hidden" name="id_delo" value="<?= $work["id_delo"] ?>" />
							<div class="name-of-input">NAZIV</div>
							<input type="text" class="form-control form-control-lg search-input naziv" name="naziv" value="<?= $work["naziv"] ?>" disabled /><br/>
							<div class="name-of-input">OPIS</div>
							<textarea name="opis" class="form-control textarea-for-request opis" disabled><?= $work["opis"] ?></textarea><br/>
							<div class="name-of-input">PLAČA</div>
							<input type="text" class="form-control form-control-lg search-input placa" name="placa" value="<?= number_format($work["placa"], 2) ?>" disabled /><br/>
							<div class="name-of-input">DATUM OBJAVE</div>
							<input type="text" class="form-control form-control-lg search-input datum_objave" name="datum_objave" value="<?= $work["datum_objave"] ?>" disabled />
							<br/>
							<button name="save" class="btn btn-info btn-lg button-input save" >SHRANI</button>
							<button name="deleteWork_button" class="btn btn-danger btn-lg button-input deleteWork_button" onclick="return confirm('Ali res želite odstraniti to delo?')" >IZBRIŠI</button>
						</form>
							<button name="cancel_button" class="btn btn-warning btn-lg button-input button-input cancel" onclick="ponastavi_gumba()" >PREKLIČI</button>
						</p>
						<button class="btn btn-info btn-lg button-input allow_edit" onclick="allow_edit(<?= $count-1; ?>)">UREDI</button>
						<?php
						$count++;
					}
				?>
			</div>
		</div>
	</div>
</body>
</html>

<script>
	let count = <?= $count-1 ?>;

	window.onload = ponastavi_gumba();

	function ponastavi_gumba() {
		for (let i=0; i<count; i++) {
			document.getElementsByClassName("allow_edit")[i].style.visibility = "visible";
			document.getElementsByClassName("allow_edit")[i].style.position = "static";
			
			document.getElementsByClassName("save")[i].style.visibility = "hidden";
			document.getElementsByClassName("save")[i].style.position = "absolute";
			document.getElementsByClassName("deleteWork_button")[i].style.visibility = "hidden";
			document.getElementsByClassName("deleteWork_button")[i].style.position = "absolute";
			document.getElementsByClassName("cancel")[i].style.visibility = "hidden";
			document.getElementsByClassName("cancel")[i].style.position = "absolute";
		}
	}

	function allow_edit() {
		for (let i=0; i<count; i++) {
			document.getElementsByClassName("naziv")[i].disabled = true;
			document.getElementsByClassName("opis")[i].disabled = true;
			document.getElementsByClassName("placa")[i].disabled = true;
			
			document.getElementsByClassName("allow_edit")[i].style.visibility = "visible";
			
			ponastavi_gumba();
		}
		
		
		document.getElementsByClassName("naziv")[arguments[0]].disabled = false;
		document.getElementsByClassName("opis")[arguments[0]].disabled = false;
		document.getElementsByClassName("placa")[arguments[0]].disabled = false;
		
		document.getElementsByClassName("allow_edit")[arguments[0]].style.visibility = "hidden";
		document.getElementsByClassName("allow_edit")[arguments[0]].style.position = "absolute";
		
		document.getElementsByClassName("save")[arguments[0]].style.visibility = "visible";
		document.getElementsByClassName("save")[arguments[0]].style.position = "static";
		document.getElementsByClassName("deleteWork_button")[arguments[0]].style.visibility = "visible";
		document.getElementsByClassName("deleteWork_button")[arguments[0]].style.position = "static";
		document.getElementsByClassName("cancel")[arguments[0]].style.visibility = "visible";
		document.getElementsByClassName("cancel")[arguments[0]].style.position = "static";
	}

	$(document).ready(function() {
		if	($(window).width() >= 1100) {
			$(window).scroll(function(){
			  $(".left-aside").stop().animate({"marginTop": ($(window).scrollTop()) + "px", "marginLeft":($(window).scrollLeft()) + "px"}, "fast");
			});
		}
	});
</script>
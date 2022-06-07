<?php
function povezi() {
	global $conn;
	$conn = new mysqli("localhost", "root", "", "spletna_trgovina");
	$conn->set_charset("utf8");

	if (mysqli_connect_error()) {
		// die("Napaka pri nalaganju");
		die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
	}
}

function zapri() {
	global $conn;
	$conn->close();
}

function zForme() {
	?>
	<div id="prikaz_forme_registracija" class="div-forma">
		<div class="box_register">
			<h2 style="border-bottom: 1px solid black;">REGISTRACIJA</h2>
			<img id="x_slika_r" src="slike/x.png" style="position: fixed; margin-left: 175px; margin-top: -55px; height: 25px; width: 25px; cursor: pointer;" />
			<form id="registracija" action="" method="POST" accept-charset="utf-8">
				<table style="text-align: center;">
					<tr><td style="font-weight: bold;">Ime:</td></tr>
					<tr><td  style="padding-top: 10px;"><input type="text" id="r_ime" pattern="[A-Ža-ž]{3,50}" name="ime" maxlength="50" class="form-control" style="border-radius: 20px; color: black; padding-left: 15px;" required /></td></tr>
					
					<tr><td style="padding-top: 10px; font-weight: bold;">Priimek:</td></tr>
					<tr><td style="padding-top: 10px;"><input type="text" id="r_priimek" pattern="[A-Ža-ž]{3,50}" name="priimek" maxlength="50" class="form-control" style="border-radius: 20px; color: black; padding-left: 15px;" required /></td></tr>
					
					<tr><td style="padding-top: 10px; font-weight: bold;">Uporabniško ime:</td></tr>
					<tr><td style="padding-top: 10px;"><input type="text" id="r_up_ime" pattern="[A-Ža-ž]{3,25}" name="up_ime" maxlength="25" class="form-control" style="border-radius: 20px; color: black; padding-left: 15px;" required /></td></tr>
					
					<tr><td style="padding-top: 10px; font-weight: bold;">E-mail:</td></tr>
					<tr><td style="padding-top: 10px;"><input type="email" id="r_email" pattern=".+@gmail.com" placeholder="primer.primer@gmail.com" name="email" class="form-control" style="border-radius: 20px; color: black; padding-left: 15px;" required /></td></tr>

					<tr><td style="padding-top: 10px; font-weight: bold;">Telefonska številka:</td></tr>
					<tr><td style="padding-top: 10px;"><input type="tel" id="r_telefonska" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" maxlength="11" placeholder="format: 000-000-000" name="telefonska" class="form-control" style="border-radius: 20px; color: black; padding-left: 15px;" required /></td></tr>

					<tr><td style="padding-top: 10px; font-weight: bold;">Geslo:</td></tr>
					<tr><td style="padding-top: 10px;"><input type="password" id="r_geslo" name="geslo" class="form-control" style="border-radius: 20px; color: black; padding-left: 15px;" required /></td></tr>
					
					<tr><td style="padding-top: 10px; font-weight: bold;">Potrdi geslo:</td></tr>
					<tr><td style="padding-top: 10px;"><input type="password" id="r_potrdi_geslo" name="potrdi_geslo" class="form-control" style="border-radius: 20px; color: black; padding-left: 15px;" required /></td></tr>
					
					<tr><td style="padding-top: 15px;">
						<div id="r_mesic"></div>
					</td></tr>

					<tr><td style="padding-top: 15px;"><input type="submit" id="r_submit" name="potrdi" value="REGISTRIRAJ ME" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px; width: 376px;" /></td></tr>

					<tr><td style="padding-top: 15px;">Že imate račun? <pom id="r_prijava" class="uporabnik">Prijava</pom></td></tr>
				</table>
			</form>
		</div>
	</div>

	<div id="prikaz_forme_prijava" class="div-forma">
		<div class="box_login">
			<h2 style="border-bottom: 1px solid black;">PRIJAVA</h2>
			<img id="x_slika_p" src="slike/x.png" style="position: fixed; margin-left: 175px; margin-top: -55px; height: 25px; width: 25px; cursor: pointer;"  />
			<form id="prijava" action="zacetna_preveri_forme.php" method="POST" accept-charset="utf-8">
				<table style="text-align: center;">				
					<tr><td style="font-weight: bold;">Uporabniško ime:</td></tr>
					<tr><td style="padding-top: 10px;"><input type="text" id="p_up_ime" name="up_ime" class="form-control" style="border-radius: 20px; color: black; padding-left: 15px;" required /></td></tr>
					
					<tr><td style="padding-top: 10px; font-weight: bold;">Geslo:</td></tr>
					<tr><td style="padding-top: 10px;"><input type="password" id="p_geslo" name="geslo" class="form-control" style="border-radius: 20px; color: black; padding-left: 15px;" required /></td></tr>

					<tr><td style="padding-top: 15px;">
						<div id="p_mesic"></div>
					</td></tr>

					<tr><td style="padding-top: 15px;">Ste pozabili geslo? <pom id="pozabil_geslo" class="uporabnik">Ponastavi geslo</pom></td></tr>

					<tr><td style="padding-top: 15px;"><input type="submit" id="p_submit" name="prijava" value="PRIJAVA" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px; width: 376px;" /></td></tr>
				
					<tr><td style="padding-top: 15px;">Še nimate računa? <pom id="p_registracija" class="uporabnik">Registriraj se</pom></td></tr>
				</table>
			</form>
		</div>

		<div id="div_geslo" class="box_pozabljenogeslo">
			<form id="pozabljenogeslo" action="zacetna_preveri_forme.php" method="POST" accept-charset="utf-8">
				<table style="text-align: center;">
					<tr><td style="font-weight: bold;">Vnesite e-mail naslov za ponastavitev gesla:</td></tr>
					<tr><td style="padding-top: 10px; color: red;">Na vaš e-mail naslov bo bila poslana povezava za ponastavitev gesla spletne strani kupi.si</td></tr>
					<tr><td style="padding-top: 10px;"><input type="email" id="pg_email" placeholder="primer.primer@gmail.com" name="email" class="form-control" style="border-radius: 20px; color: black; padding-left: 15px;" required /></td></tr>

					<tr><td style="padding-top: 15px;">
						<div id="pg_mesic"></div>
					</td></tr>

					<tr><td style="padding-top: 15px;"><input type="submit" id="pg_submit" name="poslji" value="POŠLJI" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px; width: 376px;" /></td></tr>
				</table>
			</form>
		</div>
	</div>
	<?php
}

function Footer() {
	?>
	<footer>
		<div class="tretji_1">
			<strong>
				<div style="display: inline-block;">
					Podjetje kupi s. p., Planina nad Horjulom 30, 1354 Horjul<br/>
					Copyright &copy; 2019 - <?php echo date('Y'); ?>, Vse pravice pridržane<br/>
					Pravna oseba: inž. Žan Jankovec
				</div>
				<div style="display: inline-block; margin-left: 140px;">
					Kontakt in pomoč:
					<br/><img src="slike/telefon.png" style="width: 15px; height: 15px; margin-top: -3px;" /> 41 247 537
					<br/><img src="slike/email.png" style="width: 15px; height: 15px; margin-top: -3px;" /> kupiisi.si@gmail.com
				</div>
				<div style="display: inline-block; margin-left: 140px;">
					Pravna oseba:
					<br/><img src="slike/telefon.png" style="width: 15px; height: 15px; margin-top: -3px;" /> 41 247 537
					<br/><img src="slike/email.png" style="width: 15px; height: 15px; margin-top: -3px;" /> jankovec.zan@gmail.com
				</div>
			</strong>
		</div>
		<div class="tretji_2">
			<img alt="" src="slike/logo.png" style="height: 64px; width: 158px; margin-top: -3px;" />
		</div>
	</footer>
	<?php
}

function zKategorije() {
	?>
	<div class="drugi_1" id="d1">
		<p style="margin-top: 10px; font-size: 30px; font-weight: bold; color: black;">Kategorije <button class="btn btn-dark btn-sm" style="margin-top: 10px; font-size: 30px; font-weight: bold; font-size: 20px; margin-top: -7px;" onclick="prikaz_kategorij()" id="gumb_kategorij">&#11167;</button></p>

		<a href="zacetna_isci_kategorija.php?kategorija=Telefonija"><img src="slike/kategorije/telefonija.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Računalništvo"><img src="slike/kategorije/racunalnistvo.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Šport"><img src="slike/kategorije/sport.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Živali"><img src="slike/kategorije/zivali.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Literatura"><img src="slike/kategorije/literatura.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Oblačila in obutev"><img src="slike/kategorije/oblacila_obutev.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Avtomobilizem"><img src="slike/kategorije/avtomobilizem.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Motociklizem"><img src="slike/kategorije/motociklizem.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Stroji/orodja"><img src="slike/kategorije/stroji_orodja.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Nepremičnine"><img src="slike/kategorije/nepremicnine.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Umetnine"><img src="slike/kategorije/umetnine.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Kmetijstvo"><img src="slike/kategorije/kmetijstvo.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Zbirateljstvo"><img src="slike/kategorije/zbirateljstvo.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Gradnja"><img src="slike/kategorije/gradnja.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Video igre"><img src="slike/kategorije/video_igre.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Dom"><img src="slike/kategorije/dom.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Igrače"><img src="slike/kategorije/igrace.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Kozmetika"><img src="slike/kategorije/kozmetika.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Hobi"><img src="slike/kategorije/hobi.png" class="kategorije_a" /></a>
		<a href="zacetna_isci_kategorija.php?kategorija=Drugo"><img src="slike/kategorije/drugo.png" class="kategorije_a" /></a>
	</div>
	<div class="drugi_3">
		<img src="" name="slide" style="width: 240px; height: 845px; border-radius: 10px;" />
	</div>
	<?php
}

function pKategorije() {
	?>
	<div class="drugi_1" id="d1">
		<p style="margin-top: 10px; font-size: 30px; font-weight: bold; color: black;">Kategorije <button class="btn btn-dark btn-sm" style="margin-top: 10px; font-size: 30px; font-weight: bold; font-size: 20px; margin-top: -7px;" onclick="prikaz_kategorij()" id="gumb_kategorij">&#11167;</button></p>

		<a href="prijavljeno_isci_kategorija.php?kategorija=Telefonija"><img src="slike/kategorije/telefonija.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Računalništvo"><img src="slike/kategorije/racunalnistvo.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Šport"><img src="slike/kategorije/sport.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Živali"><img src="slike/kategorije/zivali.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Literatura"><img src="slike/kategorije/literatura.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Oblačila in obutev"><img src="slike/kategorije/oblacila_obutev.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Avtomobilizem"><img src="slike/kategorije/avtomobilizem.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Motociklizem"><img src="slike/kategorije/motociklizem.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Stroji/orodja"><img src="slike/kategorije/stroji_orodja.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Nepremičnine"><img src="slike/kategorije/nepremicnine.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Umetnine"><img src="slike/kategorije/umetnine.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Kmetijstvo"><img src="slike/kategorije/kmetijstvo.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Zbirateljstvo"><img src="slike/kategorije/zbirateljstvo.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Gradnja"><img src="slike/kategorije/gradnja.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Video igre"><img src="slike/kategorije/video_igre.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Dom"><img src="slike/kategorije/dom.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Igrače"><img src="slike/kategorije/igrace.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Kozmetika"><img src="slike/kategorije/kozmetika.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Hobi"><img src="slike/kategorije/hobi.png" class="kategorije_a" /></a>
		<a href="prijavljeno_isci_kategorija.php?kategorija=Drugo"><img src="slike/kategorije/drugo.png" class="kategorije_a" /></a>
	</div>
	<div class="drugi_3">
		<img src="" name="slide" style="width: 240px; height: 845px; border-radius: 10px;" />
	</div>
	<?php
}

function zHeader() {
	?>
	<header class="header_1">
		<div class="prvi_1">
			<button id="g_prijava" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;">PRIJAVA</button>
			<button id="g_registracija" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;">REGISTRACIJA</button>
		</div>
		<div class="z_prvi_2">
			<a href="zacetna.php" style="text-decoration: none; color: black;" ><button class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;">DOMOV</button></a>
			<form action="zacetna_isci.php" method="GET" accept-charset="utf-8" style="display: inline;" class="form-inline">
				<input type="text" style="color: black;" name="isci" maxlength="30" size="80" placeholder="Išči..." class="form-control" required />
				<input type="submit" value="ISKANJE" name="iskanje" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;" />
			</form>	
		</div>
		<div class="prvi_3">
			<a href="zacetna.php"><img alt="" src="slike/logo.png" style="height: 65px; width: 165px;" title="Domov" /></a>
		</div>
	</header>
	<?php
}

function GumbiSpodaj() {
	?>
	<div id="gumba-dol" style="margin-top: 15px; margin-bottom: 5px; padding-left: 295px;">
		<form id="vec_oglasov" action="p_vec_oglasov.php" method="POST" accept-charset="utf-8" style="display: inline;">
			<input type="submit" id="gumb_vec_oglasov" name="vec_oglasov" value="VEČ OGLASOV &#11167;" class="btn btn-dark btn-sm"></button>
		</form>
		<button id="gumb-top" class="btn btn-dark btn-sm" style="margin-left: 15px;">NAZAJ NA VRH &#11165;</button>
	</div>
	<?php
}

function pHeader1() {
	?>
	<div class="prvi">
		<div class="dropdown">
			<?php
				global $conn;

				$poizvedba = "SELECT ime, priimek, profilna_slika FROM uporabniki WHERE up_ime = ? LIMIT 1";
				$stmt = $conn->prepare($poizvedba);
				$stmt->bind_param("s", $_SESSION["login_user"]);
				$stmt->execute();
				$stmt->bind_result($ime, $priimek, $profilna);
				$stmt->fetch();

				$stmt->close();					

				if ($profilna != "uporabnik.png")
					$profilna = 'profilne_slike/'.$profilna;
				else
					$profilna = 'slike/'.$profilna;

				echo '<img alt="" src="'.$profilna.'" style="height: 45px; width: 45px; object-fit: cover; border-radius: 5px;" />';
			?>
			<div class="dropdown-content">
				<h3>
					<?php						
						echo '<p style="text-decoration: underline; font-size: 28px;">'.$ime.' '.$priimek.'</p>';
					?>
				</h3>
				<p><a href="odjava.php" class="uporabnik">Odjava</a></p>
				<p><a href="7_urediracun.php" class="uporabnik">Uredi račun</a></p>
				<p><a href="6_ogledoglasov.php" class="uporabnik">Ogled svojih oglasov</a></p>
			</div>
		</div>
		<div class="p_prvi_1">
            <a href="5_objavioglas.php" style="text-decoration: none; color: black;" ><button class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;">+ OBJAVI OGLAS</button></a>
		</div>
		<div class="prvi_3">
			<a href="prijavljeno.php"><img alt="" src="slike/logo.png" style="height: 65px; width: 165px;" title="Domov" /></a>
		</div>
   </div>
	<?php
}

function pHeader2() {
	?>
	<header class="header_1">
		<div class="dropdown">
			<?php
				global $conn;

				$poizvedba = "SELECT ime, priimek, profilna_slika FROM uporabniki WHERE up_ime = ? LIMIT 1";
				$stmt = $conn->prepare($poizvedba);
				$stmt->bind_param("s", $_SESSION["login_user"]);
				$stmt->execute();
				$stmt->bind_result($ime, $priimek, $profilna);
				$stmt->fetch();

				$stmt->close();					

				if ($profilna != "uporabnik.png")
					$profilna = 'profilne_slike/'.$profilna;
				else
					$profilna = 'slike/'.$profilna;

				echo '<img alt="" src="'.$profilna.'" style="height: 45px; width: 45px; object-fit: cover; border-radius: 5px;" />';
			?>
			<div class="dropdown-content">
				<h3>
					<?php
						echo '<p style="text-decoration: underline; font-size: 28px;">'.$ime.' '.$priimek.'</p>';
					?>
				</h3>
				<p><a href="odjava.php" class="uporabnik">Odjava</a></p>
				<p><a href="7_urediracun.php" class="uporabnik">Uredi račun</a></p>
				<p><a href="6_ogledoglasov.php" class="uporabnik">Ogled svojih oglasov</a></p>
			</div>
		</div>
		<div class="p_prvi_1">
			<a href="5_objavioglas.php" style="text-decoration: none; color: black;" ><button class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;">+ OBJAVI OGLAS</button></a>
		</div>
		<div class="p_prvi_2">
			<a href="prijavljeno.php" style="text-decoration: none; color: black;" ><button class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;">DOMOV</button></a>
			<form action="prijavljeno_isci.php" method="GET" accept-charset="utf-8" style="display: inline;" class="form-inline">
				<input type="text" style="color: black;" name="isci" maxlength="30" size="80" placeholder="Išči..." class="form-control" required />
				<input type="submit" name="iskanje" value="ISKANJE" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;" />
			</form>
		</div>
		<div class="prvi_3">
			<a href="prijavljeno.php"><img alt="" src="slike/logo.png" style="height: 65px; width: 165px;" title="Domov" /></a>
		</div>
	</header>
	<?php
}

function Head() {
	?>
	<title>kupi.si</title>
	<link rel="stylesheet" type="text/css" href="kupi_si.css" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="shortcut icon" type="image/png" href="slike/logo_kosarica.png" />
	<meta charset="UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<?php
}

function Oglasevanje() {
	?>
	<script>
		let i = 0;
		let images = [];
		let time = 3000;

		images[0] = 'oglasevanje_slike/vze_oglas.png';
		images[1] = 'oglasevanje_slike/filmi_oglas.png';
		images[2] = 'oglasevanje_slike/tickettime_oglas.png';

		function spremeni_slike() {
			document.slide.src = images[i];

			if (i < images.length - 1) {
				i++;
			}
			else {
				i = 0;
			}
			setTimeout("spremeni_slike()", time);
		}

		window.onload = spremeni_slike;
	</script>
	<?php
}

function pregledSejeUporabnik() {
	ob_start();
	session_start();
	
	if(!isset($_SESSION["login_user"])) {
		session_unset();
		session_destroy();
		?><script>
			window.location = "zacetna.php";
		</script><?php
	}
	else if(time() > ($_SESSION["last_activity"] + $_SESSION["expire_time"])) {
		?><script>
			window.location = "potek_prijave.php";
		</script><?php
	}
	else if(time() - $_SESSION["last_activity"] > 60) {
	  $_SESSION["last_activity"] = time();
	}
}

function pregledSejeAdmin() {
	ob_start();
	session_start();

	if(!isset($_SESSION["login_user"])) {
		session_unset();
		session_destroy();

		header("location: zacetna.php");
	}
}

function KategorijeFix() {
	?>
	<script>
		let stevec = 1;

		function prikaz_kategorij() {
			let drugi_1 = document.getElementById("d1");
			let drugi_2 = document.getElementById("d2");
			let gumb = document.getElementById("gumb_kategorij");

			if (stevec % 2 != 0) {
				let visina = drugi_2.offsetHeight;
				let visina_negativno = (visina+6)*(-1);
				let koncna_visina = visina_negativno+"px";
				
				gumb.innerHTML = "&#11164;";
				drugi_1.style.marginTop = koncna_visina;
				drugi_2.style.marginLeft = "240px";
				drugi_1.style.backgroundColor = "rgba(26, 136, 255, 0.8)";
				stevec++;
			}
			else {
				gumb.innerHTML = "&#11167;";
				drugi_1.style.backgroundColor = "rgba(26, 136, 255, 1)";
				stevec++;
			}
		}
	</script>
	<?php
}
?>
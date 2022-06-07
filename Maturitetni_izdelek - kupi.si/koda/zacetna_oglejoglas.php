<?php
ob_start();

require_once('funkcije.php');
povezi();
?>

<!DOCTYPE html>
<html>
<head>
	<?php
		Head();
	?>
   <script>
      function zamenjaj_sliko(pom) {
         let trenutna = document.getElementById("trenutna_slika");

         pom = pom.replace(/^.*[\\\/]/, '');
         pom = "oglasi_slike/"+pom;

         trenutna.src = pom;
      }

		let pom_stevec = 1;
		
		$(document).ready(function() {
			$("#x_slika_r").click(function() {
				setTimeout(function(){
					$("#r_ime").val("");
					$("#r_priimek").val("");
					$("#r_up_ime").val("");
					$("#r_email").val("");
					$("#r_telefonska").val("");
					$("#r_geslo").val("");				
					$("#r_potrdi_geslo").val("");
					$("#r_mesic").css("display", "none");
				},450);
				$("#prikaz_forme_registracija").slideUp();
			});
			$("#g_registracija").click(function() {
				$("#prikaz_forme_registracija").slideDown();
			});

			$("#x_slika_p").click(function() {
				setTimeout(function(){
					$("#p_up_ime").val("");
					$("#p_geslo").val("");
					$("#p_mesic").css("display", "none");

					$("#pg_email").val("");
					$("#pg_mesic").css("display", "none");
					$("#div_geslo").slideUp();
					if (pom_stevec % 2 == 0) pom_stevec++;
				},450);

				$("#prikaz_forme_prijava").slideUp();
			});
			$("#g_prijava").click(function() {
				$("#prikaz_forme_prijava").slideDown();
			});

			$("#pozabil_geslo").click(function() {
				if (pom_stevec % 2 == 0) {
					$("#div_geslo").slideUp();
					pom_stevec++;

					setTimeout(function(){
						$("#pg_email").val("");
						$("#pg_mesic").css("display", "none");
					},450); 
				}
				else {
					$("#div_geslo").slideDown();
					pom_stevec++;
				}
			});

			$("#p_registracija").click(function() {
				$("#prikaz_forme_prijava").slideUp();
				setTimeout(function(){
					$("#p_up_ime").val("");
					$("#p_geslo").val("");
					$("#p_mesic").css("display", "none");

					$("#pg_email").val("");
					$("#pg_mesic").css("display", "none");

					$("#prikaz_forme_registracija").slideDown();
				},450); 
			});

			$("#r_prijava").click(function() {
				$("#prikaz_forme_registracija").slideUp();
				$("#div_geslo").slideUp();
				if (pom_stevec % 2 == 0) pom_stevec++;
				setTimeout(function(){
					$("#r_ime").val("");
					$("#r_priimek").val("");
					$("#r_up_ime").val("");
					$("#r_email").val("");
					$("#r_telefonska").val("");
					$("#r_geslo").val("");				
					$("#r_potrdi_geslo").val("");
					$("#r_mesic").css("display", "none");

					$("#prikaz_forme_prijava").slideDown();
				},450); 
			});

			$("#prijava").submit(function(event) {
				event.preventDefault();
				let up_ime = $("#p_up_ime").val();
				let geslo = $("#p_geslo").val();
				let submit = $("#p_submit").val();

				$("#p_mesic").css("display", "");

				$("#p_mesic").load("zacetna_preveri_forme.php", {
					up_ime: up_ime,
					geslo: geslo,
					prijava: submit
				});
			});

			$("#pozabljenogeslo").submit(function(event) {
				event.preventDefault();
				let email = $("#pg_email").val();
				let submit = $("#pg_submit").val();

				$("#pg_mesic").css("display", "");

				$("#pg_mesic").load("zacetna_preveri_forme.php", {
					email: email,
					poslji: submit
				});
			});

			$("#registracija").submit(function(event) {
				event.preventDefault();
				let ime = $("#r_ime").val();
				let priimek = $("#r_priimek").val();
				let up_ime = $("#r_up_ime").val();
				let email = $("#r_email").val();
				let telefonska = $("#r_telefonska").val();
				let geslo = $("#r_geslo").val();				
				let potrdi_geslo = $("#r_potrdi_geslo").val();
				let submit = $("#r_submit").val();

				$("#r_mesic").css("display", "");

				$("#r_mesic").load("zacetna_preveri_forme.php", {
					ime: ime,
					priimek: priimek,
					up_ime: up_ime,
					email: email,
					telefonska: telefonska,
					geslo: geslo,
					potrdi_geslo: potrdi_geslo,
					potrdi: submit
				});
			});
		});
   </script>
</head>
<body>

<?php
	zHeader();
?>

<section class="section_oglas">
   <?php
      if (isset($_GET["oglas"])) {
         $poizvedba = "SELECT naziv, opcija, opis, cena, stanje, datum_objave, datum_poteka FROM oglasi WHERE id = ? LIMIT 1";

			$stmt = $conn->prepare($poizvedba);
			$stmt->bind_param("i", $_GET["oglas"]);
			$stmt->execute();
			$stmt->bind_result($naziv, $opcija, $opis, $cena, $stanje, $datum_objave, $datum_poteka);
         $stmt->fetch();

         $stmt->close();
         
         $poizvedba = "SELECT slika1, slika2, slika3, slika4, slika5 FROM slike_oglasov WHERE id_oglasa = ? LIMIT 1";

			$stmt = $conn->prepare($poizvedba);
			$stmt->bind_param("i", $_GET["oglas"]);
			$stmt->execute();
			$stmt->bind_result($slika1, $slika2, $slika3, $slika4, $slika5);
         $stmt->fetch();

         $stmt->close();

         $poizvedba = "SELECT u.email, u.telefonska, u.ime, u.priimek, u.profilna_slika FROM uporabniki u INNER JOIN oglasi o ON (u.id = o.id_uporabnika) WHERE o.id = ? LIMIT 1";

         $stmt = $conn->prepare($poizvedba);
			$stmt->bind_param("i", $_GET["oglas"]);
			$stmt->execute();
			$stmt->bind_result($email, $telefonska, $ime, $priimek, $profilna_slika);
         $stmt->fetch();

         $stmt->close();
      }
      else {
         echo '<p style="margin-top: 70px; font-size: 30px;">Oglas ne obstaja!</p>';
      }
   ?>
   <div class="oglas_noter_1">
      <?php if ($slika1 != NULL) { ?>
         <img src="oglasi_slike/<?php echo $slika1; ?>" id="trenutna_slika" style="width: 507px; height: 450px; display: inline-block; object-fit: contain;" />
      <?php } else { ?>
         <img src="slike/placeholder.png" id="trenutna_slika" style="width: 507px; height: 450px; display: inline-block; margin-top: 50px; object-fit: contain;" />
      <?php } ?>
      <br/>
      <?php if ($slika1 != NULL) { ?>
         <img src="oglasi_slike/<?php echo $slika1; ?>" onclick="zamenjaj_sliko(this.src)" style="width: 90px; height: 90px; display: inline-block; margin-top: 10px; cursor: pointer; object-fit: contain;" />
      <?php } if ($slika2 != NULL) { ?>
         <img src="oglasi_slike/<?php echo $slika2; ?>" onclick="zamenjaj_sliko(this.src)" style="width: 90px; height: 90px; display: inline-block; margin-top: 10px; margin-left: 10px; cursor: pointer; object-fit: contain;" />
      <?php } if ($slika3 != NULL) { ?>
         <img src="oglasi_slike/<?php echo $slika3; ?>" onclick="zamenjaj_sliko(this.src)" style="width: 90px; height: 90px; display: inline-block; margin-top: 10px; margin-left: 10px; cursor: pointer; object-fit: contain;" />
      <?php } if ($slika4 != NULL) { ?>
         <img src="oglasi_slike/<?php echo $slika4; ?>" onclick="zamenjaj_sliko(this.src)" style="width: 90px; height: 90px; display: inline-block; margin-top: 10px; margin-left: 10px; cursor: pointer; object-fit: contain;" />
      <?php } if ($slika5 != NULL) { ?>
         <img src="oglasi_slike/<?php echo $slika5; ?>" onclick="zamenjaj_sliko(this.src)" style="width: 90px; height: 90px; display: inline-block; margin-top: 10px; margin-left: 10px; cursor: pointer; object-fit: contain;" />
      <?php } ?>
   </div>
   <div class="oglas_noter_2">
      <?php
         echo $naziv;
      ?>
   </div>
   <div class="oglas_noter_3">
      <?php
         echo 'Cena: '.$cena.'€';
      ?>
   </div>
   <div class="oglas_noter_4">
      <?php
         echo $opcija.': DA';
      ?>
   </div>
   <div class="oglas_noter_5">
      <?php
         echo 'Stanje: '.$stanje;
      ?>
   </div>
   <div class="oglas_noter_6">
      <?php
         $datum = date_create($datum_objave);
         $datum = $datum->format('d.m.Y');
			
         $datum_poteka1 = date_create($datum_poteka);
         $trenutni_datum = date_create(date('Y-m-d'));

         $interval = date_diff($trenutni_datum, $datum_poteka1);
         
         if (substr($interval->format('%R%a'), 1, 2) > 1)
            echo 'Objavljeno: '.$datum.', poteče čez '.substr($interval->format('%R%a'), 1, 2).' dni';
         else if (substr($interval->format('%R%a'), 1, 2) == 1)
            echo 'Objavljeno: '.$datum.', poteče jutri';
         else if (substr($interval->format('%R%a'), 1, 2) == 0)
            echo 'Objavljeno: '.$datum.', poteče danes';
      ?>
   </div>
   <textarea class="oglas_noter_7" disabled><?php
         if (!empty($opis))
            echo $opis;
         else
            echo 'Temu oglasu uporabnik ni dodeliv opisa.';
   ?></textarea>
   <div class="oglas_noter_8">
      <?php
         if ($opcija == "Prodam")
            echo '<p style="font-weight: bold; margin-top: 3px; font-size: 28px;">PRODAJALEC</p>';
         else
            echo '<p style="font-weight: bold; margin-top: 3px; font-size: 28px;">KUPEC</p>';

		if (strlen($ime)>10 || strlen($priimek)>10) {
			echo '<p style="font-size: 22px; margin-top: -10px; font-weight: bold; white-space: nowrap;">';
			if (strlen($ime)>10) {
				for($i=0; $i<10; $i++) {
					echo $ime[$i];
				}
				echo '...';
			}
			else {
				echo $ime;
			}
			echo ' ';
			if (strlen($priimek)>10) {
				for($i=0; $i<10; $i++) {
					echo $priimek[$i];
				}
				echo '...';
			}
			else {
				echo $priimek;
			}
			echo '</p>';
			}
			else
				echo '<p style="font-size: 22px; margin-top: -10px; font-weight: bold; white-space: nowrap;">'.$ime.' '.$priimek.'</p>';

         if ($profilna_slika != "uporabnik.png")
            echo '<img src="profilne_slike/'.$profilna_slika.'" style="height: 200px; width: 200px; object-fit: cover; margin-top: -8px; border-radius: 5px;" />';
         else
            echo '<img src="slike/uporabnik.png" style="height: 200px; width: 200px; object-fit: cover; margin-top: -8px; border-radius: 5px;" />';

         echo '<p style="font-size: 20px; margin-top: 18px;">Email: <b>'.$email.'</b></p>';
         echo '<p style="font-size: 20px; margin-top: -2px;">Telefonska številka: <b>'.$telefonska.'</b></p>';
      ?>
   </div>
</section>

<?php
	zForme();
	Footer();
?>

</body>
</html>

<?php
	zapri();
?>
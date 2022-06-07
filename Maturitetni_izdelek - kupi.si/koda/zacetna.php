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
		KategorijeFix();
	?>
	<script>
		let stevec_1 = 1;
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

			$("#gumb_kategorij").click(function() {
				if (stevec_1 % 2 != 0) {
					$("#d1").animate({width: "700px"});
					$("#d1").css("position","absolute");
					stevec_1++;
				}
				else {
					$("#d1").animate({width: "240px"});
					setTimeout(function(){
						document.getElementById("d2").style.marginLeft = "0px";
						$("#d1").css("margin-top","0px");
						$("#d1").css("position","relative");
					},380);
					stevec_1++;
				}
			});

			$('#gumb-top').click(function() {
				$("html, body").animate({
					scrollTop: 0
				}, 1000);
				return false;
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

			$("#vec_oglasov").submit(function(event) {
				event.preventDefault();
				let stevilo_oglasov = $(".stevilo_oglasov").length;
				let submit = $("#gumb_vec_oglasov").val();

				$("#oglasi").css("display", "");

				$("#oglasi").load("z_vec_oglasov.php", {
					stevilo_oglasov: stevilo_oglasov,
					gumb_vec_oglasov: submit
				});
			});
		});
	</script>
	<?php
		Oglasevanje();
	?>	
</head>
<body>

<?php
	zHeader();
?>

<section class="section_1">
	<div class="drugi_2_prva_stran" id="d2">
		<div id="oglasi" style="margin-top: -11px;">
		<?php
			$poizvedba = "SELECT id, naziv, cena FROM oglasi WHERE CURDATE() < datum_poteka AND aktivnost='DA' ORDER BY id DESC LIMIT 9";
			
			$stmt = $conn->query($poizvedba);
			$rnum = $stmt->num_rows;
			
			if ($rnum > 0) {
				$poizvedba2 = "SELECT slika1 FROM slike_oglasov WHERE id_oglasa = ? LIMIT 1";
			
				$stmt1 = $conn->prepare($poizvedba2);
				foreach ($stmt as $row) {
					$stmt1->bind_param("i", $row["id"]);
					$stmt1->execute();
					$stmt1->bind_result($slika1);
					$stmt1->fetch();
			
					echo '<div class="stevilo_oglasov">';
						echo '<a href="zacetna_oglejoglas.php?oglas='.$row["id"].'" class="naziv_oglasa"><p style="font-size: 25px; font-weight: bold;">';
							if (strlen($row["naziv"]) > 11) {
								for ($i=0; $i<11; $i++) {
									echo $row["naziv"][$i];
								}
								echo '...';
							}
							else
								echo $row["naziv"];
						echo '</p></a>';
					
						if ($slika1 != NULL)
							echo '<a href="zacetna_oglejoglas.php?oglas='.$row["id"].'" class="naziv_oglasa"><img src="oglasi_slike/'.$slika1.'" style="height: 240px; width: 240px; object-fit: contain;" /></a>';
						else
							echo '<a href="zacetna_oglejoglas.php?oglas='.$row["id"].'" class="naziv_oglasa"><img src="slike/placeholder.png" style="height: 240px; width: 240px; object-fit: contain;" /></a>';
			
						echo '<p style="margin-top: 10px; font-size: 22px; font-weight: bold; color: black;">'.$row["cena"].'€</p>';
					echo '</div>';
				}
				$stmt1->close();
			}
			else {
				echo '<p class="napis_nic_oglasov">NA VOLJO NI NOBENEGA OGLASA</p>';
			}
			$stmt->close();
		?>
		</div>
		<?php
			GumbiSpodaj();
		?>
	</div>
	<?php
		zKategorije();
	?>
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
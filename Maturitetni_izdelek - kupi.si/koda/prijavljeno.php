<?php
require_once('funkcije.php');
pregledSejeUporabnik();
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
		
		$(document).ready(function() {
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

			$("#vec_oglasov").submit(function(event) {
				event.preventDefault();
				let stevilo_oglasov = $(".stevilo_oglasov").length;
				let submit = $("#gumb_vec_oglasov").val();
				console.log(stevilo_oglasov);
				$("#oglasi").css("display", "");

				$("#oglasi").load("p_vec_oglasov.php", {
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
	pHeader2();
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
						echo '<a href="prijavljeno_oglejoglas.php?oglas='.$row["id"].'" class="naziv_oglasa"><p style="font-size: 25px; font-weight: bold;">';
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
							echo '<a href="prijavljeno_oglejoglas.php?oglas='.$row["id"].'" class="naziv_oglasa"><img src="oglasi_slike/'.$slika1.'" style="height: 240px; width: 240px; object-fit: contain;" /></a>';
						else
							echo '<a href="prijavljeno_oglejoglas.php?oglas='.$row["id"].'" class="naziv_oglasa"><img src="slike/placeholder.png" style="height: 240px; width: 240px; object-fit: contain;" /></a>';
			
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
		pKategorije();
	?>
</section>

<?php
	Footer();
?>

</body>
</html>

<?php
	zapri();
?>
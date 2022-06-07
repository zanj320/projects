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
					stevec_1++;
				}
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
	<div class="drugi_2" id="d2">
		<?php
			if (!isset($_GET["kategorija"])) {
				$_GET["kategorija"] = $_COOKIE["kategorija"];
			}

			if (isset($_GET["kategorija"])) {
            $kategorija = $_GET["kategorija"];
            setcookie("kategorija", $_GET["kategorija"]);

				if (!isset($_GET["stran"]) || $_GET["stran"]=="1") {
					$zacni = 0;
				}
				else {
					$zacni = ($_GET["stran"]*15)-15;
				}

				if (isset($_GET["razvrsti"]) && isset($_GET["od"]) && isset($_GET["do"]) && isset($_GET["nacin"])) {
					if ($_GET["od"] <  $_GET["do"] || $_GET["od"] ==  $_GET["do"]) {
						$od = $_GET["od"];
						$do = $_GET["do"];
					}
					else {
						$od = $_GET["do"];
						$do = $_GET["od"];
					}

					if ($_GET["nacin"] == "katerakoli") {
						if ($_GET["razvrsti"] == "od_A_do_Z") {
							$poizvedba = "SELECT id, naziv, kategorija, opis, cena, stanje, datum_objave FROM oglasi WHERE kategorija = '$kategorija' AND cena BETWEEN $od AND $do AND CURDATE() < datum_poteka AND aktivnost='DA' ORDER BY naziv ASC LIMIT $zacni,15";
						}
						else if ($_GET["razvrsti"] == "od_Z_do_A") {
							$poizvedba = "SELECT id, naziv, kategorija, opis, cena, stanje, datum_objave FROM oglasi WHERE kategorija = '$kategorija' AND cena BETWEEN $od AND $do AND CURDATE() < datum_poteka AND aktivnost='DA' ORDER BY naziv DESC LIMIT $zacni,15";
						}
						else if ($_GET["razvrsti"] == "cenejsi_naprej") {
							$poizvedba = "SELECT id, naziv, kategorija, opis, cena, stanje, datum_objave FROM oglasi WHERE kategorija = '$kategorija' AND cena BETWEEN $od AND $do AND CURDATE() < datum_poteka AND aktivnost='DA' ORDER BY cena ASC LIMIT $zacni,15";
						}
						else if ($_GET["razvrsti"] == "drazji_naprej") {
							$poizvedba = "SELECT id, naziv, kategorija, opis, cena, stanje, datum_objave FROM oglasi WHERE kategorija = '$kategorija' AND cena BETWEEN $od AND $do AND CURDATE() < datum_poteka AND aktivnost='DA' ORDER BY cena DESC LIMIT $zacni,15";
						}
						else if ($_GET["razvrsti"] == "novejsi_naprej") {
							$poizvedba = "SELECT id, naziv, kategorija, opis, cena, stanje, datum_objave FROM oglasi WHERE kategorija = '$kategorija' AND cena BETWEEN $od AND $do AND CURDATE() < datum_poteka AND aktivnost='DA' ORDER BY datum_objave DESC LIMIT $zacni,15";
						}
						else if ($_GET["razvrsti"] == "starejsi_naprej") {
							$poizvedba = "SELECT id, naziv, kategorija, opis, cena, stanje, datum_objave FROM oglasi WHERE kategorija = '$kategorija' AND cena BETWEEN $od AND $do AND CURDATE() < datum_poteka AND aktivnost='DA' ORDER BY datum_objave ASC LIMIT $zacni,15";
						}
						else if ($_GET["razvrsti"] == "brez") {
							$poizvedba = "SELECT id, naziv, kategorija, opis, cena, stanje, datum_objave FROM oglasi WHERE kategorija = '$kategorija' AND cena BETWEEN $od AND $do AND CURDATE() < datum_poteka AND aktivnost='DA' LIMIT $zacni,15";
						}
						$poizvedba1 = "SELECT id, naziv, kategorija, opis, cena, stanje, datum_objave FROM oglasi WHERE kategorija = '$kategorija' AND cena BETWEEN $od AND $do AND CURDATE() < datum_poteka AND aktivnost='DA'";
					}
					else {
						$nacin = $_GET["nacin"];

						if ($_GET["razvrsti"] == "od_A_do_Z") {
							$poizvedba = "SELECT id, naziv, kategorija, opis, cena, stanje, datum_objave FROM oglasi WHERE kategorija = '$kategorija' AND cena BETWEEN $od AND $do AND CURDATE() < datum_poteka AND opcija = '$nacin' AND aktivnost='DA' ORDER BY naziv ASC LIMIT $zacni,15";
						}
						else if ($_GET["razvrsti"] == "od_Z_do_A") {
							$poizvedba = "SELECT id, naziv, kategorija, opis, cena, stanje, datum_objave FROM oglasi WHERE kategorija = '$kategorija' AND cena BETWEEN $od AND $do AND CURDATE() < datum_poteka AND opcija = '$nacin' AND aktivnost='DA' ORDER BY naziv DESC LIMIT $zacni,15";
						}
						else if ($_GET["razvrsti"] == "cenejsi_naprej") {
							$poizvedba = "SELECT id, naziv, kategorija, opis, cena, stanje, datum_objave FROM oglasi WHERE kategorija = '$kategorija' AND cena BETWEEN $od AND $do AND CURDATE() < datum_poteka AND opcija = '$nacin' AND aktivnost='DA' ORDER BY cena ASC LIMIT $zacni,15";
						}
						else if ($_GET["razvrsti"] == "drazji_naprej") {
							$poizvedba = "SELECT id, naziv, kategorija, opis, cena, stanje, datum_objave FROM oglasi WHERE kategorija = '$kategorija' AND cena BETWEEN $od AND $do AND CURDATE() < datum_poteka AND opcija = '$nacin' AND aktivnost='DA' ORDER BY cena DESC LIMIT $zacni,15";
						}
						else if ($_GET["razvrsti"] == "novejsi_naprej") {
							$poizvedba = "SELECT id, naziv, kategorija, opis, cena, stanje, datum_objave FROM oglasi WHERE kategorija = '$kategorija' AND cena BETWEEN $od AND $do AND CURDATE() < datum_poteka AND opcija = '$nacin' AND aktivnost='DA' ORDER BY datum_objave DESC LIMIT $zacni,15";
						}
						else if ($_GET["razvrsti"] == "starejsi_naprej") {
							$poizvedba = "SELECT id, naziv, kategorija, opis, cena, stanje, datum_objave FROM oglasi WHERE kategorija = '$kategorija' AND cena BETWEEN $od AND $do AND CURDATE() < datum_poteka AND opcija = '$nacin' AND aktivnost='DA' ORDER BY datum_objave ASC LIMIT $zacni,15";
						}
						else if ($_GET["razvrsti"] == "brez") {
							$poizvedba = "SELECT id, naziv, kategorija, opis, cena, stanje, datum_objave FROM oglasi WHERE kategorija = '$kategorija' AND cena BETWEEN $od AND $do AND CURDATE() < datum_poteka AND opcija = '$nacin' AND aktivnost='DA' LIMIT $zacni,15";
						}
						$poizvedba1 = "SELECT id, naziv, kategorija, opis, cena, stanje, datum_objave FROM oglasi WHERE kategorija = '$kategorija' AND cena BETWEEN $od AND $do AND CURDATE() < datum_poteka AND opcija = '$nacin' AND aktivnost='DA'";
					}
				}
				else if (!isset($_GET["razvrsti"]) && !isset($_GET["od"]) && !isset($_GET["do"]) && !isset($_GET["nacin"])) {
					$poizvedba = "SELECT id, naziv, kategorija, opis, cena, stanje, datum_objave FROM oglasi WHERE kategorija = '$kategorija' AND CURDATE() < datum_poteka AND aktivnost='DA' LIMIT $zacni,15";
					$poizvedba1 = "SELECT id, naziv, kategorija, opis, cena, stanje, datum_objave FROM oglasi WHERE kategorija = '$kategorija' AND CURDATE() < datum_poteka AND aktivnost='DA'";
				}

				$stmt3 = $conn->query($poizvedba1);
				$rnum1 = $stmt3->num_rows;

				$stmt3->close();

				if ($rnum1 > 0) {
				$stmt = $conn->query($poizvedba);
		?>
				<div class="ip_navigacija_1">
					<div class="navigacija_ogrodje">
						<div class="ip_navigacija_1_noter_1">
							<?php
								if ($rnum1==1) echo 'Najden '.$rnum1.' oglas za kategorijo <u>'.$kategorija.'</u>';
								else if ($rnum1==2) echo 'Najdena '.$rnum1.' oglasa za kategorijo <u>'.$kategorija.'</u>';
								else if ($rnum1==3 || $rnum1==4) echo 'Najdeni '.$rnum1.' oglasi za kategorijo <u>'.$kategorija.'</u>';
								else echo 'Najdenih '.$rnum1.' oglasov za kategorijo <u>'.$kategorija.'</u>';
							?>
						</div>
						<br/>
						<div class="ip_navigacija_1_noter_2">
							<form action="" method="GET" accept-charset="utf-8">
								<strong>Filter razvrščanja:</strong>
								<select name="razvrsti" class="filtri">
									<?php if (!isset($_GET["razvrsti"])) { ?>
										<option value="brez" selected>Brez</option>
										<option value="od_A_do_Z">od A do Ž</option>
										<option value="od_Z_do_A">od Ž do A</option>
										<option value="cenejsi_naprej">cenejši naprej</option>
										<option value="drazji_naprej">dražji naprej</option>
										<option value="starejsi_naprej">starejši naprej</option>
										<option value="novejsi_naprej">novejši naprej</option>
									<?php } else {
										if ($_GET["razvrsti"] == "brez") { ?>
											<option value="brez" selected hidden>Brez</option>
										<?php } else { ?>
											<option value="brez" hidden>Brez</option>
										<?php } if ($_GET["razvrsti"] == "od_A_do_Z") { ?>
											<option value="od_A_do_Z" selected>od A do Ž</option>
										<?php } else { ?>
											<option value="od_A_do_Z">od A do Ž</option>
										<?php } if ($_GET["razvrsti"] == "od_Z_do_A") { ?>
											<option value="od_Z_do_A" selected>od Ž do A</option>
										<?php } else { ?>
											<option value="od_Z_do_A">od Ž do A</option>
										<?php } if ($_GET["razvrsti"] == "cenejsi_naprej") { ?>
											<option value="cenejsi_naprej" selected>cenejši naprej</option>
										<?php } else { ?>
											<option value="cenejsi_naprej">cenejši naprej</option>
										<?php } if ($_GET["razvrsti"] == "drazji_naprej") { ?>
											<option value="drazji_naprej" selected>dražji naprej</option>
										<?php } else { ?>
											<option value="drazji_naprej">dražji naprej</option>
										<?php } if ($_GET["razvrsti"] == "starejsi_naprej") { ?>
											<option value="starejsi_naprej" selected>starejši naprej</option>
										<?php } else { ?>
											<option value="starejsi_naprej">starejši naprej</option>
										<?php } if ($_GET["razvrsti"] == "novejsi_naprej") { ?>
											<option value="novejsi_naprej" selected>novejši naprej</option>
										<?php } else { ?>
											<option value="novejsi_naprej">novejši naprej</option>
										<?php } ?>
									<?php } ?>
								</select>
								<strong>Opcija:</strong>
								<select name="nacin" class="filtri">
									<?php if (!isset($_GET["nacin"])) { ?>
										<option value="katerakoli" selected>Katerakoli</option>
										<option value="prodam">Prodam</option>
										<option value="kupim">Kupim</option>
									<?php } else {
										if ($_GET["nacin"] == "katerakoli") { ?>
											<option value="katerakoli" selected>Katerakoli</option>
										<?php } else { ?>
											<option value="katerakoli">Katerakoli</option>
										<?php } if ($_GET["nacin"] == "prodam") { ?>
											<option value="prodam" selected>Prodam</option>
										<?php } else { ?>
											<option value="prodam">Prodam</option>
										<?php } if ($_GET["nacin"] == "kupim") { ?>
											<option value="kupim" selected>Kupim</option>
										<?php } else { ?>
											<option value="kupim">Kupim</option>
										<?php } ?>
									<?php } ?>
								</select>
								<strong>Cena:</strong>
								<?php if (isset($_GET["od"]) && isset($_GET["do"])) { ?>
									<input type="number" name="od" min="0" max="10000000" placeholder="OD" step="0.01" value="<?php echo $_GET["od"]; ?>" class="filtri" style="width: 125px;" required />
									<input type="number" name="do" min="0" max="10000000" placeholder="DO" step="0.01" value="<?php echo $_GET["do"]; ?>" class="filtri" style="width: 125px;" required />
								<?php } else { ?>
									<input type="number" name="od" min="0" max="10000000" placeholder="OD" step="0.01" value="0" class="filtri" style="width: 125px;" required />
									<input type="number" name="do" min="0" max="10000000" placeholder="DO" step="0.01" value="10000000" class="filtri" style="width: 125px;" required />
								<?php } ?>
								<input type="submit" id="potrdi_filter" value="Potrdi" name="potrdi" />
							</form>
						</div>
					</div>
				</div>
			<?php
				$poizvedba2 = "SELECT slika1 FROM slike_oglasov WHERE id_oglasa = ? LIMIT 1";
				
				$stmt1 = $conn->prepare($poizvedba2);
				foreach ($stmt as $row) {
					$stmt1->bind_param("i", $row["id"]);
					$stmt1->execute();
					$stmt1->bind_result($slika_oglasa);
					$stmt1->fetch();

					$datum_objave = date_create($row["datum_objave"]);
					$datum_objave = $datum_objave->format('d.m.Y');

					echo '<div class="ip_ogrodje_oglasa">';
						echo '<div class="ip_noter_1"><a href="prijavljeno_oglejoglas.php?oglas='.$row["id"].'">';
							if ($slika_oglasa != NULL)
								echo '<img src="oglasi_slike/'.$slika_oglasa.'" style="height: 170px; width: 170px; object-fit: contain;" />';
							else
								echo '<img src="slike/placeholder.png" style="height: 170px; width: 170px; object-fit: contain;" />';
						echo '</a></div>';
							
						echo '<div class="ip_noter_2">';
							echo '<a href="prijavljeno_oglejoglas.php?oglas='.$row["id"].'" class="uporabnik">'.$row["naziv"].'</a>';
						echo '</div>';

						echo '<div class="ip_noter_3">';
							echo '<strong>'.$row["cena"].' €</strong>';
						echo '</div>';

						echo '<div class="ip_noter_4">';
							if ($row["opis"] != NULL) {
								if (strlen($row["opis"]) >= 60) {
									for ($i=0; $i<60; $i++) {
										echo $row["opis"][$i];
									}
									echo '...';
								}
								else {
									echo $row["opis"];
								}
							}
							else {
								echo 'Temu oglasu uporabnik ni dodeliv opisa.';
							}
						echo '</div>';

						echo '<div class="ip_noter_5">';
							echo '<i>Objavljeno: '.$datum_objave.'</i>';
						echo '</div>';

					echo '</div>';
				}
				$stmt1->close();
				$stmt->close();
			}
			else {
				echo '<div class="ip_navigacija_1_napacno">';
					echo 'Brez zadetkov za kategorijo <u>'.$kategorija.'</u>!<br/> Mogoče ste vnesli napačen niz?';
				echo '</div>';
			}
		}
		?>
		<br/>
		<?php if ($rnum1 > 0) { ?>
			<div class="ip_navigacija_2">
				<?php
					$st_vrstic = $rnum1/15;
					$st_vrstic = ceil($st_vrstic);

					for ($i=1; $i<=$st_vrstic; $i++) {
						if (isset($_GET["razvrsti"]) && isset($_GET["od"]) && isset($_GET["do"]) && isset($_GET["nacin"])) {
							if (isset($_GET["stran"]) && $i == $_GET["stran"]) {
								?><a href="prijavljeno_isci_kategorija.php?kategorija=<?php echo $_GET["kategorija"]; ?>&stran=<?php echo $i; ?>&razvrsti=<?php echo $_GET["razvrsti"]; ?>&od=<?php echo $_GET["od"]; ?>&do=<?php echo $_GET["do"]; ?>&nacin=<?php echo $_GET["nacin"]; ?>"><button class="btn btn-danger btn-sm" style="width: 30px; margin-left: 2px; margin-right: 2px;"><?php echo $i.' '; ?></button></a><?php
							}
							else {
								?><a href="prijavljeno_isci_kategorija.php?kategorija=<?php echo $_GET["kategorija"]; ?>&stran=<?php echo $i; ?>&razvrsti=<?php echo $_GET["razvrsti"]; ?>&od=<?php echo $_GET["od"]; ?>&do=<?php echo $_GET["do"]; ?>&nacin=<?php echo $_GET["nacin"]; ?>"><button class="btn btn-dark btn-sm" style="width: 26px; margin-left: 2px; margin-right: 2px;"><?php echo $i.' '; ?></button></a><?php
							}
						}
						else if (!isset($_GET["razvrsti"]) && !isset($_GET["od"]) && !isset($_GET["do"]) && !isset($_GET["nacin"])) {
							if (isset($_GET["stran"]) && $i == $_GET["stran"]) {
								?><a href="prijavljeno_isci_kategorija.php?kategorija=<?php echo $_GET["kategorija"]; ?>&stran=<?php echo $i; ?>"><button class="btn btn-danger btn-sm" style="width: 30px; margin-left: 2px; margin-right: 2px;"><?php echo $i.' '; ?></button></a><?php
							}
							else {
								?><a href="prijavljeno_isci_kategorija.php?kategorija=<?php echo $_GET["kategorija"]; ?>&stran=<?php echo $i; ?>"><button class="btn btn-dark btn-sm" style="width: 26px; margin-left: 2px; margin-right: 2px;"><?php echo $i.' '; ?></button></a><?php
							}
						}
					}
				?>
			</div>
		<?php } ?>
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
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
	?>
</head>
<body>

<header class="header_1">
	<?php
		pHeader1();
		
		$poizvedba = "SELECT st_vseh_objav FROM uporabniki WHERE id = ? LIMIT 1";

		$stmt = $conn->prepare($poizvedba);
		$stmt->bind_param("i", $_SESSION["login_id"]);
		$stmt->execute();
		$stmt->bind_result($st_vseh_objav);
		$stmt->fetch();

		$stmt->close();
    ?>
	<div style="text-align: center; padding-top: 20px;">
		<h2>VAŠI OGLASI(<?php echo $st_vseh_objav; ?>)</h2>
	</div>
</header>

<section class="section_3" style="padding-top: 15px; padding-bottom: 20px;">
    <div>
        <?php
            $poizvedba = "SELECT id FROM uporabniki where up_ime = ? LIMIT 1";

            $stmt = $conn->prepare($poizvedba);
            $stmt->bind_param("s", $_SESSION["login_user"]);
            $stmt->execute();
            $stmt->bind_result($up_id);
            $stmt->fetch();
        
            $stmt->close();

            $poizvedba = "SELECT id, naziv, kategorija, cena, stanje, datum_objave, datum_poteka FROM oglasi WHERE aktivnost='DA' AND id_uporabnika = ".$up_id;

            $stmt = $conn->query($poizvedba);
            $rnum = $stmt->num_rows;

            if ($rnum > 0) {
					$pom=1;

					$poizvedba1 = "SELECT slika1 FROM slike_oglasov WHERE id_oglasa = ? LIMIT 1";
					$stmt1 = $conn->prepare($poizvedba1);
					
					echo '<table style="margin-left: 50px; width: 1350px; font-size: 20px;">';
					echo '<tr>
						<th>Naslovna slika</th>
						<th>Naziv</th>
						<th>Cena</th>
						<th>Datum objave</th>
						<th>Aktualnost</th>
						<th style="border-bottom: none"></th>
					</tr>';
					foreach ($stmt as $row) {
						$stmt1->bind_param("i", $row["id"]);
						$stmt1->execute();
						$stmt1->bind_result($slika_oglasa);
						$stmt1->fetch();

						$datum_objave = date_create($row["datum_objave"]);
						$datum_objave = $datum_objave->format('d.m.Y');

						if ($slika_oglasa != NULL)
							echo '<tr><td style="width: 160px; padding-top: 10px; padding-bottom: 10px; border-bottom: 1px solid black;"><img src="oglasi_slike/'.$slika_oglasa.'" style="height: 80px; width: 80px; object-fit: contain;" /></td>';
						else
							echo '<tr><td style="width: 160px; padding-top: 10px; padding-bottom: 10px; border-bottom: 1px solid black;"><img src="slike/placeholder.png" style="height: 80px; width: 80px; object-fit: contain;" /></td>';	
						
						echo '<td style="width: 500px; padding-top: 10px; padding-bottom: 10px; border-bottom: 1px solid black;">'.$row["naziv"].'</td><td style="width: 160px; padding-top: 10px; padding-bottom: 10px; border-bottom: 1px solid black;">'.$row["cena"].'€</td><td style="width: 160px; padding-top: 10px; padding-bottom: 10px; border-bottom: 1px solid black;">'.$datum_objave.'</td>';
						
						if (date('Y-m-d') < $row["datum_poteka"])
							echo '<td style="color: green; width: 160px; padding-top: 10px; padding-bottom: 10px; border-bottom: 1px solid black;">Oglas aktualen</td>';
						else
							echo '<td style="color: red; width: 160px; padding-top: 10px; padding-bottom: 10px; border-bottom: 1px solid black;">Oglas potekel</td>';
							$pom++;

						echo '<td><a href="9_uredioglas.php?oglas='.$row["id"].'"><button class="btn btn-warning btn-sm" style="font-weight: bold; padding: 10px;">UREDI OGLAS</button></a></td></tr>';	
						}
					echo '</table>';
            }
            else {
                echo '<p style="font-size: 30px; padding-top: 15px;">Trenutno nimate objavljenega nobenega oglasa!</p>';
            }
            $stmt->close();
        ?>
	</div>
</section>

</body>
</html>

<?php
	zapri();
?>
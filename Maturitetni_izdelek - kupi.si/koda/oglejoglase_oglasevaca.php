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
    ?>
    <div style="display: block; text-align: center; padding-top: 1px;">
        <?php
            $poizvedba = "SELECT up_ime FROM uporabniki WHERE id = ?";

            $stmt = $conn->prepare($poizvedba);
            $stmt->bind_param("i", $_GET["oglasevalec"]);
            $stmt->execute();
            $stmt->bind_result($up_ime);
            $stmt->fetch();

            $stmt->close();
        ?>
		<h2>OGLED OGLASOV UPORABNIKA<br/><?php echo '"'.$up_ime.'"'; ?></h2>
	</div>
</header>

<section class="section_uporabnik" style="padding-bottom: 20px;">
    <?php
        $poizvedba = "SELECT id, naziv, cena FROM oglasi WHERE CURDATE() < datum_poteka AND id_uporabnika = ".$_GET["oglasevalec"];
        
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
        
                echo '<div class="stevilo_oglasov" style="margin-left: 7px;">';
                    echo '<a href="prijavljeno_oglejoglas.php?oglas='.$row["id"].'" class="naziv_oglasa"><p style="font-size: 25px; font-weight: bold;">';
                        if (strlen($row["naziv"]) > 10) {
                            for ($i=0; $i<10; $i++) {
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
        $stmt->close();
    ?>
</section>

</body>
</html>

<?php
	zapri();
?>
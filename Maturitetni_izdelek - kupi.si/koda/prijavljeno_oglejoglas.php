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
   <script>
      function zamenjaj_sliko(pom) {
         let trenutna = document.getElementById("trenutna_slika");

         pom = pom.replace(/^.*[\\\/]/, '');
         pom = "oglasi_slike/"+pom;

         trenutna.src = pom;
      }
   </script>
</head>
<body>

<?php
	pHeader2();
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
         
         $poizvedba = "SELECT u.id, u.up_ime, u.email, u.telefonska, u.ime, u.priimek, u.profilna_slika FROM uporabniki u INNER JOIN oglasi o ON (u.id = o.id_uporabnika) WHERE o.id = ? LIMIT 1";
         
         $stmt = $conn->prepare($poizvedba);
			$stmt->bind_param("i", $_GET["oglas"]);
			$stmt->execute();
			$stmt->bind_result($id, $up_ime, $email, $telefonska, $ime, $priimek, $profilna_slika);
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

         echo '<a href="oglejoglase_oglasevaca.php?oglasevalec='.$id.'" class="naziv_oglasa"><p style="font-size: 12.8px; font-weight: bold; text-decoration: underline; margin-top: 1px;">oglej vse oglase tega oglaševalca</p></a>';

         echo '<p style="font-size: 20px; margin-top: 18px;">Email: <b>'.$email.'</b></p>';
         echo '<p style="font-size: 20px; margin-top: -2px;">Telefonska številka: <b>'.$telefonska.'</b></p>';

         $poizvedba = "SELECT ROUND(vrednost/st_ocen, 1), st_ocen FROM ocene_uporabnikov WHERE id_uporabnika = ? LIMIT 1";

         $stmt = $conn->prepare($poizvedba);
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->bind_result($povprecje, $st_ocen);
         $stmt->fetch();

         $stmt->close();

         if ($povprecje == 0) {
            echo '<p>Uporabnik še ni bil ocenjen!</p>';
         }
         echo 'Oceni zanesljivost uporabnika(1 do 5)';

         if (isset($_POST["ocena"])) {
            if ($up_ime != $_SESSION["login_user"]) {
               $poizvedba = "SELECT id_ocenjevalca, id_ocenjenega FROM povezava_ocen WHERE id_ocenjevalca = ? AND id_ocenjenega = ? LIMIT 1";

               $stmt = $conn->prepare($poizvedba);
               $stmt->bind_param("ii", $_SESSION["login_id"], $id);
               $stmt->execute();
               $stmt->store_result();
               $rnum = $stmt->num_rows;
            
               $stmt->close();

               if ($rnum == 0) {
                  $_POST["ocena"] = htmlspecialchars($_POST["ocena"]);

                  $_POST["ocena"] = strip_tags($_POST["ocena"]);

                  $poizvedba = "UPDATE ocene_uporabnikov SET st_ocen = st_ocen + 1 WHERE id_uporabnika = ?";
               
                  $stmt = $conn->prepare($poizvedba);
                  $stmt->bind_param("i", $id);
                  $stmt->execute();
               
                  $stmt->close();
               
                  $poizvedba = "UPDATE ocene_uporabnikov SET vrednost = vrednost + ? WHERE id_uporabnika = ?";
               
                  $stmt = $conn->prepare($poizvedba);
                  $stmt->bind_param("ii", $_POST["ocena"], $id);
                  $stmt->execute();
               
                  $stmt->close();

                  $poizvedba = "INSERT INTO povezava_ocen(id_ocenjevalca, id_ocenjenega) VALUES(?, ?)";
                  $stmt = $conn->prepare($poizvedba);
                  $stmt->bind_param("ii", $_SESSION["login_id"], $id);
                  $stmt->execute();
            
                  $stmt->close();

                  header("refresh: 0;");
               }
               else {
                  $msg = '<p style="color: red; font-weight: bold;">Uporabnika lahko ocenite le enkrat!</p>';
               }
            }
            else {
               if ($povprecje != 0)
                  $msg = '<p style="color: red; font-weight: bold; margin-top: 35px;">Samega sebe ni mogoče oceniti!</p>';
               else
                  $msg = '<p style="color: red; font-weight: bold;">Samega sebe ni mogoče oceniti!</p>';
            }
         }
      ?>
      <form action="" method="POST" accept-charset="utf-8" >
         <div class="rate">
            <?php if ($povprecje >= 4.5) { ?>
               <input type="radio" id="star5" name="ocena" value="5" onchange='this.form.submit()' checked />
               <label for="star5" title="5 zvezdic">5 zvezdic</label>
            <?php } else { ?>
               <input type="radio" id="star5" name="ocena" value="5" onchange='this.form.submit()' />
               <label for="star5" title="5 zvezdic">5 zvezdic</label>
            <?php } if ($povprecje < 4.5 && $povprecje >= 3.5) { ?>
               <input type="radio" id="star4" name="ocena" value="4" onchange='this.form.submit()' checked />
               <label for="star4" title="4 zvezdice">4 zvezdice</label>
            <?php } else { ?>
               <input type="radio" id="star4" name="ocena" value="4" onchange='this.form.submit()' />
               <label for="star4" title="4 zvezdice">4 zvezdice</label>
            <?php } if ($povprecje < 3.5 && $povprecje >= 2.5) { ?>
               <input type="radio" id="star3" name="ocena" value="3" onchange='this.form.submit()' checked />
               <label for="star3" title="3 zvezdice">3 zvezdice</label>
            <?php } else { ?>
               <input type="radio" id="star3" name="ocena" value="3" onchange='this.form.submit()' />
               <label for="star3" title="3 zvezdice">3 zvezdice</label>
            <?php } if ($povprecje < 2.5 && $povprecje >= 1.5) { ?>
               <input type="radio" id="star2" name="ocena" value="2" onchange='this.form.submit()' checked />
               <label for="star2" title="2 zvezdice">2 zvezdice</label>
            <?php } else { ?>
               <input type="radio" id="star2" name="ocena" value="2" onchange='this.form.submit()' />
               <label for="star2" title="2 zvezdice">2 zvezdice</label>
            <?php } if ($povprecje < 1.5 && $povprecje >= 1) { ?>
               <input type="radio" id="star1" name="ocena" value="1" onchange='this.form.submit()' checked />
               <label for="star1" title="1 zvezdica">1 zvezdica</label>
            <?php } else { ?>
               <input type="radio" id="star1" name="ocena" value="1" onchange='this.form.submit()' />
               <label for="star1" title="1 zvezdica">1 zvezdica</label>
            <?php } ?>
        </div>
        <div style="margin-right: auto; margin-left: auto; width: 300px; display: inline-block;">
        <?php
            if ($st_ocen != 0) {
               if ($st_ocen==1)
                  echo '('.$st_ocen.' ocena)';
               else if ($st_ocen==2)
                  echo '('.$st_ocen.' oceni)';
               else if ($st_ocen==3 || $st_ocen==4)
                  echo '('.$st_ocen.' ocene)';
               else
                  echo '('.$st_ocen.' ocen)';
            }
         ?>
         </div>
         <?php
            if (!empty($msg)) {

               $poizvedba = "SELECT id FROM oglasi WHERE id = ? AND id_uporabnika = ? LIMIT 1";
               $stmt = $conn->prepare($poizvedba);
               $stmt->bind_param("ii", $_GET["oglas"], $_SESSION["login_id"]);
               $stmt->execute();
               $stmt->store_result();
               $rnum = $stmt->num_rows;
      
               $stmt->close();

               if ($rnum > 0)
                  echo '<div style="margin-top: -24px; margin-right: 5px;">'.$msg.'</div>';
               else
                  echo '<div style="margin-top: 10px; margin-right: 5px;">'.$msg.'</div>';
            }
         ?>
      </form>
   </div>
</section>

<?php
	Footer();
?>

</body>
</html>

<?php
	zapri();
?>
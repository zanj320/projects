<?php
require_once('funkcije.php');
pregledSejeAdmin();
povezi();

if (isset($_POST["spremeni"]) && isset($_POST["trenutno_geslo"]) && isset($_POST["novo_geslo"]) && isset($_POST["potrdi_geslo"])) {
   $poizvedba = "SELECT geslo FROM uporabniki WHERE up_ime = 'Administrator' LIMIT 1";
   
   $stmt = $conn->prepare($poizvedba);
   $stmt->execute();
   $stmt->bind_result($geslo);
   $stmt->fetch();
   
   $stmt->close();

   $staro_geslo = hash("sha256", $_POST["trenutno_geslo"]);

   if ($staro_geslo == $geslo) {
      if ($_POST["novo_geslo"] == $_POST["potrdi_geslo"]) {
         $novo_geslo = hash("sha256", $_POST["novo_geslo"]);

         $poizvedba = "UPDATE uporabniki SET geslo = ? WHERE up_ime = 'Administrator'";
         
         $stmt = $conn->prepare($poizvedba);
         $stmt->bind_param("s", $novo_geslo);
         $stmt->execute();

         $stmt->close();

         $msg = '<pom style="color: green; font-weight: bold;">DA</pom>';
      }
      else {
         $msg = '<pom style="color: red; font-weight: bold;">NE</pom>';
      }
   }
   else {
      $msg = '<pom style="color: red; font-weight: bold;">NE</pom>';
   }
}
?>

<!DOCTYPE html>
<html>
<head>
   <?php
		Head();
	?>
   <script>
		$(document).ready(function() {
         if ($("#izberi").val() == "oglasi") {
            document.getElementById("id_og").style.display = "inline-block";
            document.getElementById("id_up").style.display = "inline-block";
            document.getElementById("naziv").style.display = "inline-block";
            document.getElementById("up_ime").style.display = "inline-block";

            document.getElementById("naziv").style.marginTop = "-10px";

            document.getElementById("ime").style.display = "none";
            document.getElementById("priimek").style.display = "none";
            
            document.getElementById("glava").style.height = "258px";
         }
         else if ($("#izberi").val() == "uporabniki") {
            document.getElementById("id_up").style.display = "inline-block";
            document.getElementById("up_ime").style.display = "inline-block";
            document.getElementById("ime").style.display = "inline-block";
            document.getElementById("priimek").style.display = "inline-block";

            document.getElementById("up_ime").style.marginTop = "-10px";

            document.getElementById("id_og").style.display = "none";
            document.getElementById("naziv").style.display = "none";

            document.getElementById("glava").style.height = "258px";
         }
         else {
            document.getElementById("id_og").style.display = "none";
            document.getElementById("id_up").style.display = "none";
            document.getElementById("up_ime").style.display = "none";
            document.getElementById("ime").style.display = "none";
            document.getElementById("priimek").style.display = "none";
            document.getElementById("naziv").style.display = "none";
            document.getElementById("glava").style.height = "200px";
         }
      });
   </script>
</head>
<body>

<header class="header_1" id="glava" style="padding-left: 10px;">
   <div style="margin-left: 340px; display: inline-block;">
      <form action="" method="POST" accept-charset="utf-8">
         <input type="password" name="trenutno_geslo" style="margin-top: 10px; width: 300px; color: black;" class="form-control" placeholder="trenutno geslo" />
         <input type="password" name="novo_geslo" style="margin-top: 10px; width: 300px; color: black;" class="form-control" placeholder="novo geslo" />
         <input type="password" name="potrdi_geslo" style="margin-top: 10px; width: 300px; color: black;" class="form-control" placeholder="potrdi novo geslo" />
         <input type="submit" name="spremeni" onclick="return confirm('Ali res želite spremeniti geslo administratorja?');" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px; margin-top: 10px;" value="POTRDI" /><?php if (isset($msg)) echo ' '.$msg; ?>
      </form>
   </div>
   <div style="margin-top: -181px;">
      <a href="odjava.php" class="uporabnik"><button class="btn btn-danger btn-sm" style="font-weight: bold; padding: 7px; margin-top: -5px;">ODJAVA</button></a>
      <form action="" method="GET" accept-charset="utf-8" style="display: inline;">
         <input type="submit" name="prikazi" value="PRIKAŽI" style="font-weight: bold; padding: 7px; margin-top: -5px;" class="btn btn-primary btn-sm" />
         <select name="izberi" style="width: 150px; padding: 2px; display: inline; color: black;" id="izberi" class="form-control" required>
            <?php if (!isset($_GET["izberi"])) { ?>
               <option selected disabled hidden>izberi opcijo</option>
            <?php } if ($_GET["izberi"] == "uporabniki") {  ?>
               <option value="uporabniki" selected>UPORABNIKI</option>
            <?php } else { ?>
               <option value="uporabniki">UPORABNIKI</option>
            <?php } if ($_GET["izberi"] == "oglasi") { ?>
               <option value="oglasi" selected>OGLASI</option>
            <?php } else { ?>
               <option value="oglasi">OGLASI</option>
            <?php } ?>
         </select><br/>
         <?php if (isset($_GET["id_up"])) { ?>
            <input type="number" id="id_up" name="id_up" min="1" placeholder="Išči po id uporabnika" style="margin-top: 10px; padding-left: 3px; width: 300px;" class="form-control" value="<?php echo $_GET["id_up"]; ?>" /><br/>
         <?php } else { ?>
            <input type="number" id="id_up" name="id_up" min="1" placeholder="Išči po id uporabnika" style="margin-top: 10px; padding-left: 3px; width: 300px;" class="form-control" /><br/>
         <?php } if (isset($_GET["id_og"])) { ?>
            <input type="number" id="id_og" name="id_og" min="1" placeholder="Išči po id oglasa" style="padding-left: 3px; width: 300px; margin-top: 10px;" class="form-control" value="<?php echo $_GET["id_og"]; ?>" /><br/>
         <?php } else { ?>
            <input type="number" id="id_og" name="id_og" min="1" placeholder="Išči po id oglasa" style="padding-left: 3px; width: 300px margin-top: 10px;" class="form-control" /><br/>
         <?php } if (isset($_GET["up_ime"])) { ?>
            <input type="text" id="up_ime" name="up_ime" placeholder="Išči po uporabniškem imenu uporabnika" style="margin-top: 10px; padding-left: 3px; width: 300px;" class="form-control" value="<?php echo $_GET["up_ime"]; ?>" /><br/>
         <?php } else { ?>
            <input type="text" id="up_ime" name="up_ime" placeholder="Išči po uporabniškem imenu uporabnika" style="margin-top: 10px; padding-left: 3px; width: 300px;" class="form-control"/><br/>
         <?php } if (isset($_GET["ime"])) { ?>
            <input type="text" id="ime" name="ime" placeholder="Išči po imenu uporabnika" style="margin-top: 10px; padding-left: 3px; width: 300px;" class="form-control" value="<?php echo $_GET["ime"]; ?>" /><br/>
         <?php } else { ?>
            <input type="text" id="ime" name="ime" placeholder="Išči po imenu uporabnika" style="margin-top: 10px; padding-left: 3px; width: 300px;" class="form-control" /><br/>
         <?php } if (isset($_GET["priimek"])) { ?>
            <input type="text" id="priimek" name="priimek" placeholder="Išči po priimku uporabnika" style="margin-top: 10px; padding-left: 3px; width: 300px;" class="form-control" value="<?php echo $_GET["priimek"]; ?>" />
         <?php } else { ?>
            <input type="text" id="priimek" name="priimek" placeholder="Išči po priimku uporabnika" style="margin-top: 10px; padding-left: 3px; width: 300px;" class="form-control" />
         <?php } if (isset($_GET["naziv"])) { ?>
            <input type="text" id="naziv" name="naziv" placeholder="Išči po nazivu oglasa" style="margin-top: 10px; padding-left: 3px; width: 300px;" class="form-control" value="<?php echo $_GET["naziv"]; ?>" />
         <?php } else { ?>
            <input type="text" id="naziv" name="naziv" placeholder="Išči po nazivu oglasa" style="margin-top: 10px; padding-left: 3px; width: 300px;" class="form-control" />
         <?php } ?>
      </form>
   </div>
</header>

<section class="section_3" style="padding-bottom: 15px;">
   <?php
      if (isset($_GET["izberi"])) {
         echo '<table style="width: 1390px; font-weight: bold; text-align: center;""><tr>';
         if ($_GET["izberi"] == "uporabniki") {
            echo '
               <th style="padding-bottom: 10px; width: 120px;">Id uporabnika</th>
               <th style="padding-bottom: 10px; width: 120px;">Profilna slika</th>
               <th style="padding-bottom: 10px; width: 210px;">Ime</th>
               <th style="padding-bottom: 10px; width: 210px;">Priimek</th>
               <th style="padding-bottom: 10px; width: 210px;">Uporabniško ime</th>
               <th style="padding-bottom: 10px; width: 250px;">E-mail naslov</th>
               <th style="padding-bottom: 10px; width: 140px;">Datum nastanka</th>
            ';
         }
         else {
            echo '
               <th style="padding-bottom: 10px; width: 120px;">Id oglasa</th>
               <th style="padding-bottom: 10px; width: 120px;">Id uporabnika</th>
               <th style="padding-bottom: 10px; width: 210px;">Up. ime uporabnika</th>
               <th style="padding-bottom: 10px; width: 120px;">Zacetna slika</th>
               <th style="padding-bottom: 10px; width: 260px;">Naziv</th>
               <th style="padding-bottom: 10px; width: 140px;">Datum objave</th>
               <th style="padding-bottom: 10px; width: 140px;">Datum poteka</th>
               <th style="padding-bottom: 10px; width: 150px;">Aktualnost oglasa</th>
            ';
         }
         echo '</tr>';
      }

      // nč oglasi
      if (isset($_GET["izberi"]) && isset($_GET["prikazi"]) && $_GET["izberi"]=="oglasi" && $_GET["id_og"]==NULL && $_GET["id_up"]==NULL && $_GET["naziv"]==NULL && $_GET["up_ime"]==NULL) {
         $poizvedba = "SELECT o.*,u.up_ime FROM oglasi o INNER JOIN uporabniki u ON (o.id_uporabnika=u.id) LIMIT 30";
         $stmt = $conn->query($poizvedba);

         $poizvedba1 = "SELECT slika1 FROM slike_oglasov WHERE id_oglasa = ? LIMIT 1";
         $stmt1 = $conn->prepare($poizvedba1);

         foreach ($stmt as $row) {
            $stmt1->bind_param("i", $row["id"]);
            $stmt1->execute();
            $stmt1->bind_result($slika_oglasa);
            $stmt1->fetch();

            $datum_objave = date_create($row["datum_objave"]);
            $datum_objave = $datum_objave->format('d.m.Y');

            $datum_poteka = date_create($row["datum_poteka"]);
            $datum_poteka = $datum_poteka->format('d.m.Y');

            echo '<tr><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["id"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["id_uporabnika"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["up_ime"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">';

            if ($slika_oglasa == NULL)
               echo '<img src="slike/placeholder.png" style="width: 80px; height: 80px; object-fit: contain;" />';
            else
               echo '<img src="oglasi_slike/'.$slika_oglasa.'" style="width: 80px; height: 80px; object-fit: contain;" />';

            echo '</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["naziv"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$datum_objave.'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$datum_poteka.'</td>';
        
            if (date('Y-m-d') < $row["datum_poteka"])
               echo '<td style="color: green; padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">Oglas aktualen</td>';
            else
               echo '<td style="color: red; padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">Oglas potekel</td>';

            echo '<td><a href="uredioglas_admin.php?oglas='.$row["id"].'"><button class="btn btn-warning btn-sm" style="font-weight: bold; padding: 7px;">UREDI OGLAS</button></a></td></tr>';
         }
         $stmt->close();
         $stmt1->close();
      }
      // og_id
      else if (isset($_GET["izberi"]) && isset($_GET["prikazi"]) && $_GET["izberi"]=="oglasi" && $_GET["id_up"]==NULL && $_GET["id_og"]!=NULL && $_GET["up_ime"]==NULL && $_GET["naziv"]==NULL) {
         $id_og = $_GET["id_og"];
         $poizvedba = "SELECT o.*,u.up_ime FROM oglasi o INNER JOIN uporabniki u ON (o.id_uporabnika=u.id) WHERE o.id = $id_og LIMIT 30";
         $stmt = $conn->query($poizvedba);

         $poizvedba1 = "SELECT slika1 FROM slike_oglasov WHERE id_oglasa = ? LIMIT 1";
         $stmt1 = $conn->prepare($poizvedba1);

         foreach ($stmt as $row) {
            $stmt1->bind_param("i", $row["id"]);
            $stmt1->execute();
            $stmt1->bind_result($slika_oglasa);
            $stmt1->fetch();

            $datum_objave = date_create($row["datum_objave"]);
            $datum_objave = $datum_objave->format('d.m.Y');

            $datum_poteka = date_create($row["datum_poteka"]);
            $datum_poteka = $datum_poteka->format('d.m.Y');

            echo '<tr><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["id"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["id_uporabnika"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["up_ime"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">';

            if ($slika_oglasa == NULL)
               echo '<img src="slike/placeholder.png" style="width: 80px; height: 80px; object-fit: contain;" />';
            else
               echo '<img src="oglasi_slike/'.$slika_oglasa.'" style="width: 80px; height: 80px; object-fit: contain;" />';

            echo '</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["naziv"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$datum_objave.'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$datum_poteka.'</td>';
        
            if (date('Y-m-d') < $row["datum_poteka"])
               echo '<td style="color: green; padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">Oglas aktualen</td>';
            else
               echo '<td style="color: red; padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">Oglas potekel</td>';

            echo '<td><a href="uredioglas_admin.php?oglas='.$row["id"].'"><button class="btn btn-warning btn-sm" style="font-weight: bold; padding: 7px;">UREDI OGLAS</button></a></td></tr>';
         }
         $stmt->close();
         $stmt1->close();
      }
      // up_id
      else if (isset($_GET["izberi"]) && isset($_GET["prikazi"]) && $_GET["izberi"]=="oglasi" && $_GET["id_up"]!=NULL && $_GET["id_og"]==NULL && $_GET["up_ime"]==NULL && $_GET["naziv"]==NULL) {
         $id_up = $_GET["id_up"];
         $poizvedba = "SELECT o.*,u.up_ime FROM oglasi o INNER JOIN uporabniki u ON (o.id_uporabnika=u.id) WHERE o.id_uporabnika = $id_up LIMIT 30";
         $stmt = $conn->query($poizvedba);

         $poizvedba1 = "SELECT slika1 FROM slike_oglasov WHERE id_oglasa = ? LIMIT 1";
         $stmt1 = $conn->prepare($poizvedba1);

         foreach ($stmt as $row) {
            $stmt1->bind_param("i", $row["id"]);
            $stmt1->execute();
            $stmt1->bind_result($slika_oglasa);
            $stmt1->fetch();

            $datum_objave = date_create($row["datum_objave"]);
            $datum_objave = $datum_objave->format('d.m.Y');

            $datum_poteka = date_create($row["datum_poteka"]);
            $datum_poteka = $datum_poteka->format('d.m.Y');

            echo '<tr><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["id"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["id_uporabnika"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["up_ime"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">';

            if ($slika_oglasa == NULL)
               echo '<img src="slike/placeholder.png" style="width: 80px; height: 80px; object-fit: contain;" />';
            else
               echo '<img src="oglasi_slike/'.$slika_oglasa.'" style="width: 80px; height: 80px; object-fit: contain;" />';

            echo '</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["naziv"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$datum_objave.'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$datum_poteka.'</td>';
        
            if (date('Y-m-d') < $row["datum_poteka"])
               echo '<td style="color: green; padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">Oglas aktualen</td>';
            else
               echo '<td style="color: red; padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">Oglas potekel</td>';

            echo '<td><a href="uredioglas_admin.php?oglas='.$row["id"].'"><button class="btn btn-warning btn-sm" style="font-weight: bold; padding: 7px;">UREDI OGLAS</button></a></td></tr>';
         }
         $stmt->close();
         $stmt1->close();
      }
      // up_ime
      else if (isset($_GET["izberi"]) && isset($_GET["prikazi"]) && $_GET["izberi"]=="oglasi" && $_GET["up_ime"]!=NULL && $_GET["id_up"]==NULL && $_GET["id_og"]==NULL && $_GET["naziv"]==NULL) {         
         $up_ime = $_GET["up_ime"];
         
         $poizvedba = "SELECT o.*,u.up_ime FROM oglasi o INNER JOIN uporabniki u ON (o.id_uporabnika=u.id) WHERE u.up_ime LIKE '%$up_ime%' LIMIT 30";
         $stmt = $conn->query($poizvedba);

         $poizvedba1 = "SELECT slika1 FROM slike_oglasov WHERE id_oglasa = ? LIMIT 1";
         $stmt1 = $conn->prepare($poizvedba1);

         foreach ($stmt as $row) {
            $stmt1->bind_param("i", $row["id"]);
            $stmt1->execute();
            $stmt1->bind_result($slika_oglasa);
            $stmt1->fetch();

            $datum_objave = date_create($row["datum_objave"]);
            $datum_objave = $datum_objave->format('d.m.Y');

            $datum_poteka = date_create($row["datum_poteka"]);
            $datum_poteka = $datum_poteka->format('d.m.Y');

            echo '<tr><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["id"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["id_uporabnika"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["up_ime"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">';

            if ($slika_oglasa == NULL)
               echo '<img src="slike/placeholder.png" style="width: 80px; height: 80px; object-fit: contain;" />';
            else
               echo '<img src="oglasi_slike/'.$slika_oglasa.'" style="width: 80px; height: 80px; object-fit: contain;" />';

            echo '</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["naziv"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$datum_objave.'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$datum_poteka.'</td>';
        
            if (date('Y-m-d') < $row["datum_poteka"])
               echo '<td style="color: green; padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">Oglas aktualen</td>';
            else
               echo '<td style="color: red; padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">Oglas potekel</td>';

            echo '<td><a href="uredioglas_admin.php?oglas='.$row["id"].'"><button class="btn btn-warning btn-sm" style="font-weight: bold; padding: 7px;">UREDI OGLAS</button></a></td></tr>';
         }
         $stmt->close();
         $stmt1->close();
      }
      // naziv
      else if (isset($_GET["izberi"]) && isset($_GET["prikazi"]) && $_GET["izberi"]=="oglasi" && $_GET["id_up"]==NULL && $_GET["id_og"]==NULL && $_GET["naziv"]!=NULL && $_GET["up_ime"]==NULL) {
         $naziv = $_GET["naziv"];

         $poizvedba = "SELECT o.*,u.up_ime FROM oglasi o INNER JOIN uporabniki u ON (o.id_uporabnika=u.id) WHERE o.naziv LIKE '%$naziv%' LIMIT 30";
         $stmt = $conn->query($poizvedba);

         $poizvedba1 = "SELECT slika1 FROM slike_oglasov WHERE id_oglasa = ? LIMIT 1";
         $stmt1 = $conn->prepare($poizvedba1);

         foreach ($stmt as $row) {
            $stmt1->bind_param("i", $row["id"]);
            $stmt1->execute();
            $stmt1->bind_result($slika_oglasa);
            $stmt1->fetch();

            $datum_objave = date_create($row["datum_objave"]);
            $datum_objave = $datum_objave->format('d.m.Y');

            $datum_poteka = date_create($row["datum_poteka"]);
            $datum_poteka = $datum_poteka->format('d.m.Y');

            echo '<tr><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["id"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["id_uporabnika"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["up_ime"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">';

            if ($slika_oglasa == NULL)
               echo '<img src="slike/placeholder.png" style="width: 80px; height: 80px; object-fit: contain;" />';
            else
               echo '<img src="oglasi_slike/'.$slika_oglasa.'" style="width: 80px; height: 80px; object-fit: contain;" />';

            echo '</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["naziv"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$datum_objave.'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$datum_poteka.'</td>';
        
            if (date('Y-m-d') < $row["datum_poteka"])
               echo '<td style="color: green; padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">Oglas aktualen</td>';
            else
               echo '<td style="color: red; padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">Oglas potekel</td>';

            echo '<td><a href="uredioglas_admin.php?oglas='.$row["id"].'"><button class="btn btn-warning btn-sm" style="font-weight: bold; padding: 7px;">UREDI OGLAS</button></a></td></tr>';
         }
         $stmt->close();
         $stmt1->close();
      }
      // nč uporabniki
      else if (isset($_GET["izberi"]) && isset($_GET["prikazi"]) && $_GET["izberi"]=="uporabniki" && $_GET["id_up"]==NULL && $_GET["ime"]==NULL && $_GET["priimek"]==NULL && $_GET["up_ime"]==NULL) {
         $poizvedba = "SELECT * FROM uporabniki LIMIT 30";
         $stmt = $conn->query($poizvedba);

         foreach ($stmt as $row) {
            if ($row["up_ime"] != "Administrator") {
               $datum_nastanka = date_create($row["datum_nastanka"]);
               $datum_nastanka = $datum_nastanka->format('d.m.Y');

               echo '<tr><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["id"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">';

               if ($row["profilna_slika"] == "uporabnik.png")
                  echo '<img src="slike/uporabnik.png" style="width: 80px; height: 80px; object-fit: contain; border-radius: 5px;" />';
               else if ($row["profilna_slika"] == "admin.png")
                  echo '<img src="slike/admin.png" style="width: 80px; height: 80px; object-fit: contain; border-radius: 5px;" />';
               else
                  echo '<img src="profilne_slike/'.$row["profilna_slika"].'" style="width: 80px; height: 80px; object-fit: contain; border-radius: 5px;" />';

               echo '</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["ime"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["priimek"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["up_ime"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["email"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$datum_nastanka.'</td><td><a href="urediracun_admin.php?uporabnik='.$row["id"].'"><button class="btn btn-warning btn-sm" style="font-weight: bold; padding: 7px;">UREDI RAČUN</button></a></td></tr>';
            }
         }
         $stmt->close();
      }
      // up_id
      else if (isset($_GET["izberi"]) && isset($_GET["prikazi"]) && $_GET["izberi"]=="uporabniki" && $_GET["id_up"]!=NULL && $_GET["up_ime"]==NULL && $_GET["naziv"]==NULL && $_GET["ime"]==NULL && $_GET["priimek"]==NULL) {
         $id_up = $_GET["id_up"];
         $poizvedba = "SELECT * FROM uporabniki WHERE id = $id_up LIMIT 1";
         $stmt = $conn->query($poizvedba);

         foreach ($stmt as $row) {
            if ($row["up_ime"] != "Administrator") {
               $datum_nastanka = date_create($row["datum_nastanka"]);
               $datum_nastanka = $datum_nastanka->format('d.m.Y');

               echo '<tr><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["id"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">';

               if ($row["profilna_slika"] == "uporabnik.png")
                  echo '<img src="slike/uporabnik.png" style="width: 80px; height: 80px; object-fit: contain; border-radius: 5px;" />';
               else if ($row["profilna_slika"] == "admin.png")
                  echo '<img src="slike/admin.png" style="width: 80px; height: 80px; object-fit: contain; border-radius: 5px;" />';
               else
                  echo '<img src="profilne_slike/'.$row["profilna_slika"].'" style="width: 80px; height: 80px; object-fit: contain; border-radius: 5px;" />';

               echo '</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["ime"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["priimek"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["up_ime"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["email"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$datum_nastanka.'</td><td><a href="urediracun_admin.php?uporabnik='.$row["id"].'"><button class="btn btn-warning btn-sm" style="font-weight: bold; padding: 7px;">UREDI RAČUN</button></a></td></tr>';
            }
         }
         $stmt->close();
      }
      // up_ime
      else if (isset($_GET["izberi"]) && isset($_GET["prikazi"]) && $_GET["izberi"]=="uporabniki" && $_GET["id_up"]==NULL && $_GET["ime"]==NULL && $_GET["priimek"]==NULL && $_GET["up_ime"]!=NULL) {
         $up_ime = $_GET["up_ime"];
         $poizvedba = "SELECT * FROM uporabniki WHERE up_ime LIKE '%$up_ime%' LIMIT 30";
         $stmt = $conn->query($poizvedba);

         foreach ($stmt as $row) {
            if ($row["up_ime"] != "Administrator") {
               $datum_nastanka = date_create($row["datum_nastanka"]);
               $datum_nastanka = $datum_nastanka->format('d.m.Y');

               echo '<tr><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["id"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">';

               if ($row["profilna_slika"] == "uporabnik.png")
                  echo '<img src="slike/uporabnik.png" style="width: 80px; height: 80px; object-fit: contain; border-radius: 5px;" />';
               else if ($row["profilna_slika"] == "admin.png")
                  echo '<img src="slike/admin.png" style="width: 80px; height: 80px; object-fit: contain; border-radius: 5px;" />';
               else
                  echo '<img src="profilne_slike/'.$row["profilna_slika"].'" style="width: 80px; height: 80px; object-fit: contain; border-radius: 5px;" />';

               echo '</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["ime"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["priimek"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["up_ime"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["email"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$datum_nastanka.'</td><td><a href="urediracun_admin.php?uporabnik='.$row["id"].'"><button class="btn btn-warning btn-sm" style="font-weight: bold; padding: 7px;">UREDI RAČUN</button></a></td></tr>';
            }
         }
         $stmt->close();
      }
      // ime
      else if (isset($_GET["izberi"]) && isset($_GET["prikazi"]) && $_GET["izberi"]=="uporabniki" && $_GET["id_up"]==NULL && $_GET["ime"]!=NULL && $_GET["priimek"]==NULL && $_GET["up_ime"]==NULL) {
         $ime = $_GET["ime"];
         $poizvedba = "SELECT * FROM uporabniki WHERE ime LIKE '%$ime%' LIMIT 30";
         $stmt = $conn->query($poizvedba);

         foreach ($stmt as $row) {
            if ($row["up_ime"] != "Administrator") {
               $datum_nastanka = date_create($row["datum_nastanka"]);
               $datum_nastanka = $datum_nastanka->format('d.m.Y');

               echo '<tr><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["id"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">';

               if ($row["profilna_slika"] == "uporabnik.png")
                  echo '<img src="slike/uporabnik.png" style="width: 80px; height: 80px; object-fit: contain; border-radius: 5px;" />';
               else if ($row["profilna_slika"] == "admin.png")
                  echo '<img src="slike/admin.png" style="width: 80px; height: 80px; object-fit: contain; border-radius: 5px;" />';
               else
                  echo '<img src="profilne_slike/'.$row["profilna_slika"].'" style="width: 80px; height: 80px; object-fit: contain; border-radius: 5px;" />';

               echo '</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["ime"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["priimek"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["up_ime"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["email"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$datum_nastanka.'</td><td><a href="urediracun_admin.php?uporabnik='.$row["id"].'"><button class="btn btn-warning btn-sm" style="font-weight: bold; padding: 7px;">UREDI RAČUN</button></a></td></tr>';
            }
         }
         $stmt->close();
      }
      // priimek
      else if (isset($_GET["izberi"]) && isset($_GET["prikazi"]) && $_GET["izberi"]=="uporabniki" && $_GET["id_up"]==NULL && $_GET["ime"]==NULL && $_GET["priimek"]!=NULL && $_GET["up_ime"]==NULL) {
         $priimek = $_GET["priimek"];
         $poizvedba = "SELECT * FROM uporabniki WHERE priimek LIKE '%$priimek%' LIMIT 30";
         $stmt = $conn->query($poizvedba);

         foreach ($stmt as $row) {
            if ($row["up_ime"] != "Administrator") {
               $datum_nastanka = date_create($row["datum_nastanka"]);
               $datum_nastanka = $datum_nastanka->format('d.m.Y');

               echo '<tr><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["id"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">';

               if ($row["profilna_slika"] == "uporabnik.png")
                  echo '<img src="slike/uporabnik.png" style="width: 80px; height: 80px; object-fit: contain; border-radius: 5px;" />';
               else if ($row["profilna_slika"] == "admin.png")
                  echo '<img src="slike/admin.png" style="width: 80px; height: 80px; object-fit: contain; border-radius: 5px;" />';
               else
                  echo '<img src="profilne_slike/'.$row["profilna_slika"].'" style="width: 80px; height: 80px; object-fit: contain; border-radius: 5px;" />';

               echo '</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["ime"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["priimek"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["up_ime"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["email"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$datum_nastanka.'</td><td><a href="urediracun_admin.php?uporabnik='.$row["id"].'"><button class="btn btn-warning btn-sm" style="font-weight: bold; padding: 7px;">UREDI RAČUN</button></a></td></tr>';
            }
         }
         $stmt->close();
      }
      // priimek & ime
      else if (isset($_GET["izberi"]) && isset($_GET["prikazi"]) && $_GET["izberi"]=="uporabniki" && $_GET["id_up"]==NULL && $_GET["ime"]!=NULL && $_GET["priimek"]!=NULL && $_GET["up_ime"]==NULL) {
         $priimek = $_GET["priimek"];
         $ime = $_GET["ime"];
         $poizvedba = "SELECT * FROM uporabniki WHERE priimek LIKE '%$priimek%' AND ime LIKE '%$ime%' LIMIT 30";
         $stmt = $conn->query($poizvedba);

         foreach ($stmt as $row) {
            if ($row["up_ime"] != "Administrator") {
               $datum_nastanka = date_create($row["datum_nastanka"]);
               $datum_nastanka = $datum_nastanka->format('d.m.Y');

               echo '<tr><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["id"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">';

               if ($row["profilna_slika"] == "uporabnik.png")
                  echo '<img src="slike/uporabnik.png" style="width: 80px; height: 80px; object-fit: contain; border-radius: 5px;" />';
               else if ($row["profilna_slika"] == "admin.png")
                  echo '<img src="slike/admin.png" style="width: 80px; height: 80px; object-fit: contain; border-radius: 5px;" />';
               else
                  echo '<img src="profilne_slike/'.$row["profilna_slika"].'" style="width: 80px; height: 80px; object-fit: contain; border-radius: 5px;" />';

               echo '</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["ime"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["priimek"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["up_ime"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$row["email"].'</td><td style="padding-bottom: 10px; padding-top: 10px; border-top: 1px solid black;">'.$datum_nastanka.'</td><td><a href="urediracun_admin.php?uporabnik='.$row["id"].'"><button class="btn btn-warning btn-sm" style="font-weight: bold; padding: 7px;">UREDI RAČUN</button></a></td></tr>';
            }
         }
         $stmt->close();
      }
      else {
         echo '<h1 style="text-align: center; margin-top: 15px;">IZBERI OPCIJO</h1>';
      }

      if (isset($_GET["izberi"])) {
         echo '</table>';
      }
   ?>
</section>

</body>
</html>

<?php
	zapri();
?>
<?php
require_once('funkcije.php');
pregledSejeUporabnik();
povezi();

//slika
if (!isset($_POST["odstrani"]) && isset($_POST["shrani1"]) && isset($_FILES["slika"])) {
    $poizvedba = "SELECT s_datum FROM uporabniki WHERE up_ime = ? LIMIT 1";

    $stmt = $conn->prepare($poizvedba);
    $stmt->bind_param("s", $_SESSION["login_user"]);
    $stmt->execute();
    $stmt->bind_result($datum);
    $stmt->fetch();

    $stmt->close();

    $datum1 = date("Y-m-d");

    if (empty($datum) || $datum1>=$datum) {
        $dovoljeni_tipi = array('image/png','image/jpeg', 'image/gif');
        if (in_array($_FILES["slika"]["type"], $dovoljeni_tipi)) {
            if ($_FILES["slika"]["size"] < 4000000) {
                $poizvedba = "SELECT id, profilna_slika FROM uporabniki WHERE up_ime = ? LIMIT 1";

                $stmt = $conn->prepare($poizvedba);
                $stmt->bind_param("s", $_SESSION["login_user"]);
                $stmt->execute();
                $stmt->bind_result($up_id, $profilna);
                $stmt->fetch();

                $stmt->close();

                $ime_slike = $up_id.'_'.time().'_'.$_FILES["slika"]["name"];        

                $profilna1 = 'profilne_slike/'.$profilna;

                if ($profilna != "uporabnik.png")
                    unlink($profilna1);                
                
                $target = 'profilne_slike/'.$ime_slike;

                move_uploaded_file($_FILES["slika"]["tmp_name"], $target);

                $datum1 = date('Y-m-d',strtotime('+30 days',strtotime(str_replace('/', '-', date("Y-m-d"))))) . PHP_EOL;

                $poizvedba = "UPDATE uporabniki SET profilna_slika = ?, s_datum = ? WHERE up_ime = ?";

                $stmt = $conn->prepare($poizvedba);
                $stmt->bind_param("sss", $ime_slike, $datum1, $_SESSION["login_user"]);
                $stmt->execute();

                $stmt->close();
                
                $msg = "Profilna slika posodobljena!";
                $klasa = "alert-success";
            }
            else {
                $msg = 'Velikost datoteke je prevelika! Maksimalna velikost je 4MB';
                $klasa = "alert-danger";
            }
        }
        else {
            $msg = "Tak tip slike ni dovoljen!";
            $klasa = "alert-danger";
        }
    }
    else {
        $msg = "Profilno sliko lahko spremenite na vsake 30 dni!";
        $klasa = "alert-danger";
    }
}
else if (isset($_POST["odstrani"]) and !isset($_POST["shrani"])) {
    $poizvedba = "SELECT s_datum FROM uporabniki WHERE up_ime = ? LIMIT 1";

    $stmt = $conn->prepare($poizvedba);
    $stmt->bind_param("s", $_SESSION["login_user"]);
    $stmt->execute();
    $stmt->bind_result($datum);
    $stmt->fetch();

    $stmt->close();

    $datum1 = date("Y-m-d");

    if (empty($datum) || $datum1>=$datum) {
        $poizvedba = "SELECT profilna_slika FROM uporabniki WHERE up_ime = ? LIMIT 1";

        $stmt = $conn->prepare($poizvedba);
        $stmt->bind_param("s", $_SESSION["login_user"]);
        $stmt->execute();
        $stmt->bind_result($profilna);
        $stmt->fetch();

        $stmt->close();

        $profilna1 = 'profilne_slike/'.$profilna;

        if ($profilna != "uporabnik.png")
            unlink($profilna1);

        $poizvedba = "UPDATE uporabniki SET profilna_slika = ? WHERE up_ime = ?";

        $profilna = "uporabnik.png";

        $stmt = $conn->prepare($poizvedba);
        $stmt->bind_param("ss", $profilna, $_SESSION["login_user"]);
        $stmt->execute();

        $stmt->close();

        $msg = "Profilna slika posodobljena!";
        $klasa = "alert-success";
    }
    else {
        $msg = "Profilno sliko lahko spremenite na vsake 30 dni!";
        $klasa = "alert-danger";
    }
}

//ime & priimek
if (isset($_POST["shrani2"]) && isset($_POST["ime"]) && isset($_POST["priimek"])) {
    $_POST["ime"] = htmlspecialchars($_POST["ime"]);
    $_POST["priimek"] = htmlspecialchars($_POST["priimek"]);

    $_POST["ime"] = strip_tags($_POST["ime"]);
    $_POST["priimek"] = strip_tags($_POST["priimek"]);

    $poizvedba = "SELECT i_datum FROM uporabniki WHERE up_ime = ? LIMIT 1";

    $stmt = $conn->prepare($poizvedba);
    $stmt->bind_param("s", $_SESSION["login_user"]);
    $stmt->execute();
    $stmt->bind_result($datum);
    $stmt->fetch();

    $stmt->close();

    $datum1 = date("Y-m-d");

    if (empty($datum) || $datum1>=$datum) {
        $poizvedba = "SELECT ime, priimek FROM uporabniki WHERE up_ime = ? LIMIT 1";

        $stmt = $conn->prepare($poizvedba);
        $stmt->bind_param("s", $_SESSION["login_user"]);
        $stmt->execute();
        $stmt->bind_result($ime1, $priimek1);
        $stmt->fetch();

        $stmt->close();

        if ($ime1 != $_POST["ime"] || $priimek1 != $_POST["priimek"]) {
            $datum1 = date('Y-m-d',strtotime('+365 days',strtotime(str_replace('/', '-', date("Y-m-d"))))) . PHP_EOL;

            $poizvedba = "UPDATE uporabniki SET ime = ?, priimek = ?, i_datum = ? WHERE up_ime = ?";

            $stmt = $conn->prepare($poizvedba);
            $stmt->bind_param("ssss", $_POST["ime"], $_POST["priimek"], $datum1, $_SESSION["login_user"]);
            $stmt->execute();

            $stmt->close();

            $msg = "Ime in priimek sta bila posodobljena!";
            $klasa = "alert-success";
        }
        else {
            $msg = "Ime in priimek sta enaka!";
            $klasa = "alert-danger";
        }
    }
    else {
        $msg = "Ime in priimek lahko spremenite na vsake 365 dni!";
        $klasa = "alert-danger";
    }
}

//telefonska
if (isset($_POST["shrani4"]) && isset($_POST["telefonska"])) {
    $_POST["telefonska"] = htmlspecialchars($_POST["telefonska"]);

    $_POST["telefonska"] = strip_tags($_POST["telefonska"]);

    $poizvedba = "SELECT t_datum FROM uporabniki WHERE up_ime = ? LIMIT 1";

    $stmt = $conn->prepare($poizvedba);
    $stmt->bind_param("s", $_SESSION["login_user"]);
    $stmt->execute();
    $stmt->bind_result($datum);
    $stmt->fetch();

    $stmt->close();

    $datum1 = date("Y-m-d");

    if (empty($datum) || $datum1>=$datum) {
        $datum1 = date('Y-m-d',strtotime('+365 days',strtotime(str_replace('/', '-', date("Y-m-d"))))) . PHP_EOL;

        $poizvedba = "UPDATE uporabniki SET telefonska = ?, t_datum = ? WHERE up_ime = ?";

        $stmt = $conn->prepare($poizvedba);
        $stmt->bind_param("sss", $_POST["telefonska"], $datum1, $_SESSION["login_user"]);
        $stmt->execute();

        $stmt->close();

        $msg = "Telefonska številka je bila posodobljena!";
        $klasa = "alert-success";
    }
    else {
        $msg = "Telefonsko številko lahko spremenite na vsake 30 dni!";
        $klasa = "alert-danger";
    }
}

//geslo
if (isset($_POST["shrani3"]) && isset($_POST["trenutno_geslo"]) && isset($_POST["geslo"]) && isset($_POST["potrdi_geslo"]) && $_POST["geslo"] == $_POST["potrdi_geslo"] && strlen($_POST["geslo"]) >= 6) {
    $_POST["trenutno_geslo"] = htmlspecialchars($_POST["trenutno_geslo"]);
    $_POST["geslo"] = htmlspecialchars($_POST["geslo"]);
    $_POST["potrdi_geslo"] = htmlspecialchars($_POST["potrdi_geslo"]);

    $_POST["trenutno_geslo"] = strip_tags($_POST["trenutno_geslo"]);
    $_POST["geslo"] = strip_tags($_POST["geslo"]);
    $_POST["potrdi_geslo"] = strip_tags($_POST["potrdi_geslo"]);
    
    $poizvedba = "SELECT g_datum FROM uporabniki WHERE up_ime = ? LIMIT 1";

    $stmt = $conn->prepare($poizvedba);
    $stmt->bind_param("s", $_SESSION["login_user"]);
    $stmt->execute();
    $stmt->bind_result($datum);
    $stmt->fetch();

    $stmt->close();

    $datum1 = date("Y-m-d");
    
    if (empty($datum) || $datum1>=$datum) {
        if (!strpos($_POST["geslo"], ' ') && !strpos($_POST["potrdi_geslo"], ' ')) {
            $geslo_hash = hash("sha256", $_POST["geslo"]);

            $trenutno_geslo = hash("sha256", $_POST["trenutno_geslo"]);

            $poizvedba = "SELECT geslo FROM uporabniki WHERE up_ime = ? LIMIT 1";

            $stmt = $conn->prepare($poizvedba);
            $stmt->bind_param("s", $_SESSION["login_user"]);
            $stmt->execute();
            $stmt->bind_result($geslo);
            $stmt->fetch();

            $stmt->close();

            if ($geslo == $trenutno_geslo) {
                if ($geslo !=  $geslo_hash) {
                    $datum1 = date('Y-m-d',strtotime('+10 days',strtotime(str_replace('/', '-', date("Y-m-d"))))) . PHP_EOL;

                    $poizvedba = "UPDATE uporabniki SET geslo = ?, g_datum = ? WHERE up_ime = ?";

                    $stmt = $conn->prepare($poizvedba);
                    $stmt->bind_param("sss", $geslo_hash, $datum1, $_SESSION["login_user"]);
                    $stmt->execute();

                    $stmt->close();
                    
                    $msg = "Geslo je bilo posodobljeno!";
                    $klasa = "alert-success";
                }
                else {
                    $msg = "Novo geslo ne mora biti enako staremu geslu!";
                    $klasa = "alert-danger";
                }
            }
            else {
                $msg = "Trenutno geslo tega računa se ne ujema z vpisanim geslom!";
                $klasa = "alert-danger";
            }
        }
        else {
            $msg = "Geslo ne sme vsebovati presledkov!";
            $klasa = "alert-danger";
        }
    }
    else {
        $msg = "Geslo lahko spremenite na vsake 10 dni!";
        $klasa = "alert-danger";
    }
}
else if (!empty($_POST["geslo"]) && !empty($_POST["potrdi_geslo"]) && $_POST["geslo"] != $_POST["potrdi_geslo"]) {
    $msg = "Gesli se ne ujemata!";
    $klasa = "alert-danger";
}
else if (!empty($_POST["geslo"]) && strlen($_POST["geslo"]) < 6) {
    $msg = "Geslo je prekratko!<br/> Geslo mora biti<br/> dolgo vsaj 6 znakov!";
    $klasa = "alert-danger";
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php
		Head();
	?>
	<script>
        function triggerClick() {
            document.querySelector('#profilna_slika').click();
        }

        function displayImage(pom)  {
            if (pom.files[0]) {
                let preberi = new FileReader();

                preberi.onload = function(pom) {
                    document.querySelector('#prikazi_sliko').setAttribute('src', pom.target.result);
                }
                preberi.readAsDataURL(pom.files[0]);
            }
        }

		$(document).ready(function() {
			$("#x_slika_i").click(function() {
                $("#prikaz_forme_izbrisi").slideUp();

                setTimeout(function(){
                    $("#izbrisi_geslo").val("");
                    $("#izbrisi_submit").val("");
                    $("#izbrisi_mesic").css("display", "none");
                }, 450);
			});
			$("#g_izbrisi").click(function() {
				$("#prikaz_forme_izbrisi").slideDown();
            });
            
            $("#izbrisi_racun").submit(function(event) {
				event.preventDefault();
				let geslo = $("#izbrisi_geslo").val();
				let submit = $("#izbrisi_submit").val();

				$("#izbrisi_mesic").css("display", "");

				$("#izbrisi_mesic").load("urediracun_preveri_forme.php", {
					izbrisi_geslo: geslo,
					izbrisi: submit
				});
			});
        });
    </script>
	<meta charset="UTF-8">
</head>
<body>

<header class="header_1">
    <?php
        pHeader1();
    ?>
    <div style="text-align: center; padding-top: 20px;">
		<h2>UREDI RAČUN</h2>
	</div>
</header>

<section class="section_uporabnik" style="padding-bottom: 10px;">
    <div style="text-align: center; display: inline-block; margin-left: 70px; border-radius: 5px;">
        <p style="font-weight: bold; font-size: 20px;">TRENUTNA PROFILNA SLIKA</p>
        <?php
            $poizvedba = "SELECT profilna_slika FROM uporabniki WHERE up_ime = ? LIMIT 1";

            $stmt = $conn->prepare($poizvedba);
            $stmt->bind_param("s", $_SESSION["login_user"]);
            $stmt->execute();
            $stmt->bind_result($profilna);
            $stmt->fetch();

            $stmt->close();

            if ($profilna != "uporabnik.png")
                $profilna = 'profilne_slike/'.$profilna;
            else
                $profilna = 'slike/'.$profilna;
        ?>
        <form action="" accept-charset="utf-8" method="POST" enctype="multipart/form-data">
            <img <?php echo  'src="'.$profilna.'"'; ?> onclick="triggerClick()" id="prikazi_sliko" style="width: 275px; height: 275px; object-fit: cover; cursor: pointer; border-radius: 5px;" title="Klikni in naloži sliko" />
            <input type="file" name="slika" onchange="displayImage(this)" id="profilna_slika" style="display: none;" accept="image/png, image/gif, image/jpeg" required /><br/>
            
            <?php if (!empty($msg1)) { ?>
                <div style="border-radius: 10px; margin-top: 5px;" class ="alert <?php echo $klasa1; ?>">
                    <?php echo $msg1; ?>
                </div>
            <?php } ?>
            <p style="font-size: 19px; margin-top: 10px;">Dovoljeni tipi slik: .jpeg, .png, .gif</p>
            <input type="submit" name="shrani1" value="SHRANI" class="btn btn-primary btn-sm" style="width: 275px; font-weight: bold; padding: 7px;" /><br/><br/>
        </form>
        <form action="" accept-charset="utf-8" method="POST" enctype="multipart/form-data">
            <input type="submit" name="odstrani" value="ODSTRANI PROFILNO SLIKO" onclick="return confirm('Ali res želite odstraniti profilno sliko?');" class="btn btn-primary btn-sm" style="margin-top: -10px; width: 275px; font-weight: bold; padding: 7px;" />
        </form>
    </div>
    <p style="font-weight: bold; font-size: 20px; display: inline-block; margin-right: 430px; float: right;">UREDI OSEBNE PODATKE</p>
    <div style="text-align: center;	float: right; margin-right: 40px; margin-top: -418px;">
        <?php
            $poizvedba = "SELECT ime, priimek, telefonska, email, datum_nastanka FROM uporabniki WHERE up_ime = ? LIMIT 1";

            $stmt = $conn->prepare($poizvedba);
            $stmt->bind_param("s", $_SESSION["login_user"]);
            $stmt->execute();
            $stmt->bind_result($ime, $priimek, $telefonska, $shrani, $shrani_datum);
            $stmt->fetch();

            $stmt->close();
        ?>
        <form action="" accept-charset="utf-8" method="POST" style="display: inline;" class="form-inline">
            <table style="text-align: left;">
            <tr>
            <td style="width: 160px; font-weight: bold;">Ime in priimek:</td>
            <td>
            <input type="text" style="color: black;" name="ime" pattern="[A-Ža-ž]{3,50}" value="<?php echo $ime; ?>" size="35" maxlength="50" class="form-control" required />
            <input type="text" style="color: black;" name="priimek" pattern="[A-Ža-ž]{3,50}" value="<?php echo $priimek; ?>" size="35" maxlength="50" class="form-control" required />
            <input type="submit" name="shrani2" value="SHRANI" onclick="return confirm('Ali res želite spremeniti svoje ime in priimek?');" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;" />
            </td>
            </tr>
        </form>

        <form action="" accept-charset="utf-8" method="POST" style="display: inline;" class="form-inline">
            <tr>
            <td style="padding-top: 25px; font-weight: bold;">Telefonska številka:</td>
            <td style="padding-top: 25px;">
            <input type="tel" style="color: black;" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" maxlength="11" name="telefonska" class="form-control" value="<?php echo $telefonska; ?>" size="25" required />
            <input type="submit" name="shrani4" value="SHRANI" onclick="return confirm('Ali res želite spremeniti svojo telefonsko številko?');" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;" />
            </td>
            </tr>
        </form>

        <form action="" accept-charset="utf-8" method="POST" style="display: inline;" class="form-inline">
            <tr>
            <td style="padding-top: 25px; font-weight: bold;">Spremeni geslo:</td>
            <td style="padding-top: 25px;">
            <input type="password" style="color: black;" name="trenutno_geslo" maxlength="20" size="25" placeholder="Trenutno geslo" class="form-control" required />
            <input type="password" style="color: black;" name="geslo" maxlength="20" size="25" placeholder="Novo geslo" class="form-control" required />
            <input type="password" style="color: black;" name="potrdi_geslo" maxlength="20" size="25" placeholder="Potrdi novo geslo" class="form-control" required />
            <input type="submit" name="shrani3" value="SHRANI" onclick="return confirm('Ali res želite spremeniti svoje geslo?');" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px;" />
            </td>
            </tr>
            </table>
        </form>
    </div>
    <div style="float: right; margin-right: 238px; margin-top: -162px; width: 750px;">
        <?php
            $shrani_datum = date_create($shrani_datum);
            $shrani_datum = $shrani_datum->format('d.m.Y');

            echo '<table style="margin-top: -60px; margin-left: -2px;">';
                echo '<tr><td style="width: 160px; font-weight: bold;">Uporabniško ime:</td><td style="font-size: 17px;"><input type="text" value="'.$_SESSION["login_user"].'" style="color: black;" class="form-control" size="35" disabled /></td></tr>';
                echo '<tr><td style="padding-top: 10px; font-weight: bold; padding-top: 25px;">E-mail naslov:</td><td style="padding-top: 25px; font-size: 17px;"><input type="text" value="'.$shrani.'" style="color: black;" class="form-control" size="35" disabled /></td></tr>';
                echo '<tr><td style="padding-top: 25px; font-weight: bold;">Datum nastanka:</td><td style="padding-top: 25px; font-size: 17px;"><input type="text" value="'.$shrani_datum.'" style="color: black;" class="form-control" size="35" disabled /></td></tr>';
            echo '</table>';
        ?>
        <button id="g_izbrisi" class="btn btn-danger btn-sm" style="font-weight: bold; padding: 7px; margin-top: 17px;">IZBRIŠI RAČUN</button>
    </div>
    <?php if (!empty($msg)) { ?>
        <div style="border-radius: 10px; text-align: center; margin-top: 20px;" class ="alert <?php echo $klasa; ?>">
            <?php echo $msg; ?>
        </div>
    <?php } ?>
</section>

<div id="prikaz_forme_izbrisi" class="div-forma">
    <div class="box_izbrisi">
		<h2 style="border-bottom: 1px solid black;">IZBRIŠI RAČUN</h2>
		<img id="x_slika_i" src="slike/x.png" style="position: fixed; margin-left: 175px; margin-top: -55px; height: 25px; width: 25px; cursor: pointer;"  />
		<form action="urediracun_preveri_forme.php" id="izbrisi_racun" accept-charset="utf-8" method="POST">
			<table style="text-align: center;">
                <tr><td style="padding-top: 10px; font-weight: bold;">Vnesite geslo za potrditev:</td></tr>
				<tr><td style="padding-top: 10px;"><input type="password" id="izbrisi_geslo" name="izbrisi_geslo" class="form-control" style="border-radius: 20px; color: black; padding-left: 15px;" required /></td></tr>
                
                <tr style="color: red; font-size: 22px;"><td style="padding-top: 5px;"><strong>Ta procedura bo izbrisala vse vaše <br/>podatke v povezavi s tem računom!</strong></td></tr>

				<tr><td style="padding-top: 15px;">
					<div id="izbrisi_mesic"></div>
				</td></tr>

                <tr><td style="padding-top: 10px;"><input type="submit" id="izbrisi_submit" name="izbrisi" value="IZBRIŠI" class="btn btn-primary btn-sm" style="font-weight: bold; padding: 7px; width: 376px;" /></td></tr>
			</table>
		</form>
	</div>
</div>

</body>
</html>

<?php
	zapri();
?>
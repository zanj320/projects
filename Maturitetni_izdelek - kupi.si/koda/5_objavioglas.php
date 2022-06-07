<?php
require_once('funkcije.php');
pregledSejeUporabnik();
povezi();

if (isset($_POST["objavi"]) && isset($_POST["naziv"]) && isset($_POST["prodam_kupim"]) && isset($_POST["stanje"]) && isset($_POST["kategorija"]) && isset($_POST["opis"]) && isset($_POST["cena"])) {
    $_POST["naziv"] = htmlspecialchars($_POST["naziv"]);
    $_POST["opis"] = htmlspecialchars($_POST["opis"]);
    $_POST["cena"] = htmlspecialchars($_POST["cena"]);

    $_POST["naziv"] = strip_tags($_POST["naziv"]);
    $_POST["opis"] = strip_tags($_POST["opis"]);
    $_POST["cena"] = strip_tags($_POST["cena"]);
    
    $poizvedba = "SELECT id, cas_prve_objave, stevec_objav, st_vseh_objav FROM uporabniki WHERE up_ime = ? LIMIT 1";
    
    $stmt = $conn->prepare($poizvedba);
    $stmt->bind_param("s", $_SESSION["login_user"]);
    $stmt->execute();
    $stmt->bind_result($up_id, $cas_prve_objave, $stevec_objav, $st_vseh_objav);
    $stmt->fetch();

    $stmt->close();

    if ($st_vseh_objav < 30) {
        if (time() > $cas_prve_objave) {
            $poizvedba = "UPDATE uporabniki SET stevec_objav = 0, cas_prve_objave = NULL WHERE up_ime = ?";

            $stmt = $conn->prepare($poizvedba);
            $stmt->bind_param("s", $_SESSION["login_user"]);
            $stmt->execute();

            $stmt->close();

            $stevec_objav = 0;
            $cas_prve_objave = NULL;
        }

        if ($stevec_objav < 3) {
            $datum_objave =  date('Y-m-d');
            $datum_poteka = date('Y-m-d',strtotime('+30 days',strtotime(str_replace('/', '-', date("Y-m-d"))))) . PHP_EOL;

            $da = 'DA';

            $poizvedba = "INSERT INTO oglasi(id_uporabnika, naziv, opcija, kategorija, opis, cena, stanje, datum_objave, datum_poteka, aktivnost) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($poizvedba);
            $stmt->bind_param("isssssssss", $up_id, $_POST["naziv"], $_POST["prodam_kupim"], $_POST["kategorija"], $_POST["opis"], $_POST["cena"], $_POST["stanje"], $datum_objave, $datum_poteka, $da);
            $stmt->execute();

            $stmt->close();

            if (isset($_FILES["slika"])) {
                if (count($_FILES["slika"]["name"]) <= 5) {
                    $dovoljeni_tipi = array('image/png','image/jpeg', 'image/gif', NULL);
                    if (in_array($_FILES["slika"]["type"][0], $dovoljeni_tipi) || in_array($_FILES["slika"]["type"][1], $dovoljeni_tipi) || in_array($_FILES["slika"]["type"][2], $dovoljeni_tipi) || in_array($_FILES["slika"]["type"][3], $dovoljeni_tipi) || in_array($_FILES["slika"]["type"][4], $dovoljeni_tipi)) {
                        if (array_sum($_FILES["slika"]["size"]) < 20000000) {
                            if ($_FILES["slika"]["name"][0] != NULL)
                                $slika1 = $up_id.'_'.time().'_'.$_FILES["slika"]["name"][0];
                            else
                                $slika1 = NULL;

                            if (isset($_FILES["slika"]["name"][1]))
                                $slika2 = $up_id.'_'.time().'_'.$_FILES["slika"]["name"][1];
                            else
                                $slika2 = NULL;

                            if (isset($_FILES["slika"]["name"][2]))
                                $slika3 = $up_id.'_'.time().'_'.$_FILES["slika"]["name"][2];
                            else
                                $slika3 = NULL;

                            if (isset($_FILES["slika"]["name"][3]))
                                $slika4 = $up_id.'_'.time().'_'.$_FILES["slika"]["name"][3];
                            else
                                $slika4 = NULL;

                            if (isset($_FILES["slika"]["name"][4]))
                                $slika5 = $up_id.'_'.time().'_'.$_FILES["slika"]["name"][4];
                            else
                                $slika5 = NULL;

                            
                            if ($slika1 != NULL) {
                                $target1 = 'oglasi_slike/'.$slika1;
                                move_uploaded_file($_FILES["slika"]["tmp_name"][0], $target1);
                            }
                            if ($slika2 != NULL) {
                                $target2 = 'oglasi_slike/'.$slika2;
                                move_uploaded_file($_FILES["slika"]["tmp_name"][1], $target2);
                            }
                            if ($slika3 != NULL) {
                                $target3 = 'oglasi_slike/'.$slika3;
                                move_uploaded_file($_FILES["slika"]["tmp_name"][2], $target3);
                            }
                            if ($slika4 != NULL) {
                                $target4 = 'oglasi_slike/'.$slika4;
                                move_uploaded_file($_FILES["slika"]["tmp_name"][3], $target4);
                            }
                            if ($slika5 != NULL) {
                                $target5 = 'oglasi_slike/'.$slika5;
                                move_uploaded_file($_FILES["slika"]["tmp_name"][4], $target5);
                            }

                            $poizvedba = "SELECT id FROM oglasi WHERE id_uporabnika = ? ORDER BY id DESC LIMIT 1";
                    
                            $stmt = $conn->prepare($poizvedba);
                            $stmt->bind_param("i", $up_id);
                            $stmt->execute();
                            $stmt->bind_result($ogl_id);
                            $stmt->fetch();
                
                            $stmt->close();
                            
                            $poizvedba = "INSERT INTO slike_oglasov(id_oglasa, slika1, slika2, slika3, slika4, slika5) VALUES(?, ?, ?, ?, ?, ?)";

                            $stmt = $conn->prepare($poizvedba);
                            $stmt->bind_param("isssss", $ogl_id, $slika1, $slika2, $slika3, $slika4, $slika5);
                            $stmt->execute();

                            $stmt->close();

                            if ($cas_prve_objave == NULL) {
                                $cas_prve_objave = time()+(3*60*60);
                                $poizvedba = "UPDATE uporabniki SET stevec_objav = stevec_objav + 1, cas_prve_objave = ? WHERE up_ime = ?";

                                $stmt = $conn->prepare($poizvedba);
                                $stmt->bind_param("is", $cas_prve_objave, $_SESSION["login_user"]);
                                $stmt->execute();
                                
                                $stmt->close();
                            }
                            else {
                                $poizvedba = "UPDATE uporabniki SET stevec_objav = stevec_objav + 1 WHERE up_ime = ?";

                                $stmt = $conn->prepare($poizvedba);
                                $stmt->bind_param("s", $_SESSION["login_user"]);
                                $stmt->execute();
                                
                                $stmt->close();
                            }

                            $poizvedba = "UPDATE uporabniki SET st_vseh_objav = st_vseh_objav + 1 WHERE up_ime = ?";

                            $stmt = $conn->prepare($poizvedba);
                            $stmt->bind_param("s", $_SESSION["login_user"]);
                            $stmt->execute();

                            $stmt->close();

                            $msg = "Oglas objavljen!";
                            $klasa = "alert-success";
                        }
                        else {
                            $msg = "Skupna velikost vseh slik je prevelika! Maksimalna skupna velikost slik je 20MB";
                            $klasa = "alert-danger";
                        }
                    }
                    else {
                        $msg = "Tak tip datoteke ni dovoljen!<br/> Dovoljeni tipi: .jpeg, .png, .gif";
                        $klasa = "alert-danger";
                    }
                }
                else {
                    $msg = "Največ dovoljenih slik za določen oglas je 5!";
                    $klasa = "alert-danger";
                }
            }
        }
        else {
            $poizvedba = "SELECT cas_prve_objave FROM uporabniki WHERE up_ime = ?";
            $stmt = $conn->prepare($poizvedba);
            $stmt->bind_param("s", $_SESSION["login_user"]);
            $stmt->execute();
            $stmt->bind_result($cas_prve_objave);
            $stmt->fetch();

            $stmt->close();

            $cas = $cas_prve_objave-time();

            $ure = $cas/(60*60);

            $minute = ($ure-floor($ure))*60;

            $msg = "Na 3 ure lahko objavite največ 3 oglase! Naslednji čez ".floor($ure)."h ".floor($minute)."min";
            $klasa = "alert-danger";
        }
    }
    else {
        $msg = "Največ dovoljenih oglasov na uporabnika je 30!";
        $klasa = "alert-danger";
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
        function triggerClick() {
            document.querySelector('#slika_form').click();
        }

        function test(pom) {
            if (pom.files[0]) {
                document.getElementById("forma").style.marginLeft = "100px";
                document.getElementById("glavna").style.display = "";
                document.getElementById("celotna").style.display = "inline-block";


                let preberi = new FileReader();

                preberi.onload = function(pom) {
                    document.querySelector('#prva_slika').setAttribute('src', pom.target.result);
                }
                preberi.readAsDataURL(pom.files[0]);
            }
            if (pom.files[1]) {
                document.getElementById("stranske").style.display = "";
                document.getElementById("druga_slika").style.display = "";

                let preberi = new FileReader();

                preberi.onload = function(pom) {
                    document.querySelector('#druga_slika').setAttribute('src', pom.target.result);
                }
                preberi.readAsDataURL(pom.files[1]);
            }
            if (pom.files[2]) {
                document.getElementById("tretja_slika").style.display = "";

                let preberi = new FileReader();

                preberi.onload = function(pom) {
                    document.querySelector('#tretja_slika').setAttribute('src', pom.target.result);
                }
                preberi.readAsDataURL(pom.files[2]);
            }
            if (pom.files[3]) {
                document.getElementById("cetrta_slika").style.display = "";

                let preberi = new FileReader();

                preberi.onload = function(pom) {
                    document.querySelector('#cetrta_slika').setAttribute('src', pom.target.result);
                }
                preberi.readAsDataURL(pom.files[3]);
            }
            if (pom.files[4]) {
                document.getElementById("peta_slika").style.display = "";

                let preberi = new FileReader();

                preberi.onload = function(pom) {
                    document.querySelector('#peta_slika').setAttribute('src', pom.target.result);
                }
                preberi.readAsDataURL(pom.files[4]);
            }
        }
    </script>
</head>
<body>

<header class="header_1">
    <?php
        pHeader1();
    ?>
    <div style="text-align: center; padding-top: 20px;">
		<h2>OBJAVI OGLAS</h2>
	</div>
</header>

<section class="section_uporabnik">
    <form action="" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
        <div id="forma" style="display: inline-block; margin-left: 430px; padding: 5px;">
            <table>
            <tr>
            <td style="font-weight: bold;">Naziv oglasa:</td>
            <td style="text-align: right;"><input type="text" name="naziv" style="color: black;" maxlength="30" size="46" class="form-control" required /></td>
            </tr>
            <tr>
            <td style="font-weight: bold; padding-top: 15px;">Opcija:</td>
            <td style="padding-top: 15px;">
            <select name="prodam_kupim" style="color: black;" class="form-control" required>
                <option value="" selected disabled hidden>Izberi opcijo</option>
                <option value="Prodam">Prodam</option>
                <option value="Kupim">Kupim</option>
            </select>
            </td>
            </tr>
            <tr>
            <td style="font-weight: bold; padding-top: 15px;">Kategorija:</td>
            <td style="padding-top: 15px;">
            <select name="kategorija" style="color: black;" class="form-control" required>
                <option value="" selected disabled hidden>Izberi kategorijo</option>
                <option value="Telefonija">Telefonija</option>
                <option value="Računalništvo">Računalništvo</option>
                <option value="Šport">Šport</option>
                <option value="Živali">Živali</option>
                <option value="Literatura">Literatura</option>
                <option value="Oblačila in obutev">Oblačila in obutev</option>
                <option value="Avtomobilizem">Avtomobilizem</option>
                <option value="Motociklizem">Motociklizem</option>
                <option value="Stroji/orodja">Stroji/orodja</option>
                <option value="Nepremičnine">Nepremičnine</option>
                <option value="Umetnine">Umetnine</option>
                <option value="Kmetijstvo">Kmetijstvo</option>
                <option value="Zbirateljstvo">Zbirateljstvo</option>
                <option value="Gradnja">Gradnja</option>
                <option value="Video igre">Video igre</option>
                <option value="Dom">Dom</option>
                <option value="Igrače">Igrače</option>
                <option value="Kozmetika">Kozmetika</option>
                <option value="Hobi">Hobi</option>
                <option value="Drugo">Drugo</option>
            </select>
            </td>
            </tr>
            <tr>
            <td style="font-weight: bold; padding-top: 15px;">Cena(v €):</td>
            <td style="padding-top: 15px;">
            <input type="number" style="color: black;" name="cena" step="0.01" max="10000000" min="0" class="form-control" required />
            </td>
            </tr>
            <tr>
            <td style="font-weight: bold; padding-top: 15px;">Stanje:</td>
            <td style="padding-top: 15px;">
            <select name="stanje" style="color: black;" class="form-control" required>
                <option value="" selected disabled hidden>Izberi stanje</option>
                <option value="novo">novo</option>
                <option value="rabljeno">rabljeno</option>
                <option value="poškodovano/pokvarjeno">poškodovano/pokvarjeno</option>
            </select>
            </td>
            </tr>
            <tr>
            <td style="font-weight: bold; padding-top: 15px;">Slike(največ 5):</td>
            <td style="text-align: right;">
            <button class="btn btn-light" onclick="triggerClick()" type="button" style="margin-top: 15px; padding: 7px;">+ NALOŽI SLIKE</button>
            <input id="slika_form" type="file" name="slika[]" onchange="test(this)" multiple accept="image/png, image/gif, image/jpeg" style="display: none;" />
            </td>
            </tr>
            </table>
            <div style="text-align: center; padding-top: 15px;">
                <strong style="float: left; margin-left: 1px; margin-bottom: 10px;">Opis:</strong>
                <br/>
                <textarea name="opis" maxlength="250" style="width: 500px; height: 402px; resize: none; color: black;" class="form-control"></textarea>
                <br/>
                <input type="submit" name="objavi" onclick="return confirm('Ali res želite objaviti oglas?');" value="OBJAVI" class="btn btn-primary btn-sm" style="width: 350px; font-weight: bold; padding: 7px;" />
            </div>
        </div>
        <div id="celotna" class="celotna">
            <div id="glavna" style="display: none;">
                <p style="font-weight: bold;">Naslovna slika oglasa</p>
                <img src="" id="prva_slika" style="width: 405px; height: 405px; object-fit: contain;" />
            </div>

            <div id="stranske" style="display: none;">
                <p style="margin-top: 10px; font-weight: bold;">Ostale slike oglasa</p>
                <img src="" id="druga_slika" style="width: 130px; height: 130px; display: none; object-fit: contain;" />
                <img src="" id="tretja_slika" style="width: 130px; height: 130px; margin-left: 10px; display: none; object-fit: contain;" />
                <img src="" id="cetrta_slika" style="width: 130px; height: 130px; margin-left: 10px; display: none; object-fit: contain;" />
                <img src="" id="peta_slika" style="width: 130px; height: 130px; margin-left: 10px; display: none; object-fit: contain;" />
            </div>
        </div>
    </form>
    <?php if (!empty($msg)) { ?>
        <div style="border-radius: 10px; text-align: center; margin-top: 10px;" class ="alert <?php echo $klasa; ?>">
            <?php echo $msg; ?>
        </div>
    <?php } ?>
</section>

</body>
</html>

<?php
	zapri();
?>
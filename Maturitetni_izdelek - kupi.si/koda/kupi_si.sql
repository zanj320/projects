-- SET PASSWORD FOR 'root'@'localhost' = PASSWORD('koda123koda321');
CREATE DATABASE spletna_trgovina CHARACTER SET 'utf8';
USE spletna_trgovina ;

CREATE TABLE uporabniki (
	id INT NOT NULL auto_increment,
	up_ime VARCHAR(25) NOT NULL,
	geslo VARCHAR(64) NOT NULL,
	email VARCHAR(255) NOT NULL,
	telefonska VARCHAR(15) NOT NULL,
	ime VARCHAR(50) NOT NULL,
	priimek VARCHAR(50) NOT NULL,
	profilna_slika VARCHAR(255),
	datum_nastanka DATE NOT NULL,
	g_datum DATE,
	s_datum DATE,
	i_datum DATE,
	t_datum DATE,
	cas_prve_objave BIGINT,
	stevec_objav TINYINT default 0 NOT NULL,
	st_vseh_objav TINYINT default 0 NOT NULL,
	aktivnost enum('DA','NE') NOT NULL,
	pravice enum('DA','NE') NOT NULL,
	token VARCHAR(10),
	CONSTRAINT unique_up_ime unique (up_ime),
	CONSTRAINT unique_email unique (email),
	PRIMARY KEY (id)
) CHARACTER SET utf8;

CREATE TABLE oglasi (
	id INT NOT NULL auto_increment,
	id_uporabnika INT NOT NULL,
	naziv VARCHAR(30) NOT NULL,
	opcija VARCHAR(10) NOT NULL,
	kategorija VARCHAR(30) NOT NULL,
	opis TEXT NULL,
	cena FLOAT NOT NULL,
	stanje VARCHAR(30) NOT NULL,
	datum_objave DATE NOT NULL,
	datum_poteka DATE NOT NULL,
	aktivnost enum('DA','NE') NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_uporabnika) REFERENCES uporabniki(id)
	ON DELETE CASCADE
) CHARACTER SET utf8;

CREATE TABLE slike_oglasov (
	id_oglasa INT NOT NULL,
	slika1 VARCHAR(255),
	slika2 VARCHAR(255),
	slika3 VARCHAR(255),
	slika4 VARCHAR(255),
	slika5 VARCHAR(255),
	PRIMARY KEY (id_oglasa),
	FOREIGN KEY (id_oglasa) REFERENCES oglasi(id)
	ON DELETE CASCADE
) CHARACTER SET utf8;

CREATE TABLE ocene_uporabnikov (
	id_uporabnika INT NOT NULL,
	vrednost FLOAT default 0 NOT NULL,
	st_ocen INT default 0 NOT NULL,
	PRIMARY KEY (id_uporabnika),
	FOREIGN KEY (id_uporabnika) REFERENCES uporabniki(id)
	ON DELETE CASCADE
) CHARACTER SET utf8;

CREATE TABLE povezava_ocen (
	id_ocenjevalca INT,
	id_ocenjenega INT,
	FOREIGN KEY (id_ocenjevalca) REFERENCES uporabniki(id)
	ON DELETE CASCADE,
	FOREIGN KEY (id_ocenjenega) REFERENCES ocene_uporabnikov(id_uporabnika)
	ON DELETE CASCADE
) CHARACTER SET utf8;

delimiter $$
CREATE trigger v_zacetnica_insert BEFORE INSERT ON uporabniki
FOR EACH ROW
	BEGIN
		SET new.ime = concat(upper(substring(new.ime FROM 1 for 1)),lower(substring(new.ime FROM 2 for char_length(new.ime)-1)));
		SET new.priimek = concat(upper(substring(new.priimek FROM 1 for 1)),lower(substring(new.priimek FROM 2 for char_length(new.priimek)-1)));
	END ; $$

CREATE trigger v_zacetnica_update BEFORE UPDATE ON uporabniki
FOR EACH ROW
	BEGIN
		SET new.ime = concat(upper(substring(new.ime FROM 1 for 1)),lower(substring(new.ime FROM 2 for char_length(new.ime)-1)));
		SET new.priimek = concat(upper(substring(new.priimek FROM 1 for 1)),lower(substring(new.priimek FROM 2 for char_length(new.priimek)-1)));
	END ; $$
delimiter ;

/*
-----uporabne funkcije-----
white-space: nowrap;
header("Refresh:0");
$_POST["geslo"]=$conn->real_escape_string($_POST["geslo"]); - se ne rab ce injectas in delas z objekti
strip_tags($_POST["geslo"]);
htmlspecialchars($_POST["geslo"]);
$conn->close();

še hobiji za dodat:
- Šola

- stvari ka se ponavlajo zmec v funkcije
- youtuberja: Awa Melvine & code and coins
- admin(dajanje pravice uporabnikom)
- https://www.w3schools.com/howto/howto_js_slideshow.asp <- slideshow za oglase
- ...

-----administrator na spletni strani-----
uporabniško ime: Administrator
geslo: 321321

-----prek srvrja dostop-----
http://banana.lan:81/1_register.html

-----server-----
username: zanj
password: Jankovec123456

-----mysql-----
username: zanNative
password: Jankovec123456

-----email-----
username: kupiisi.si@gmail.com
password: sikupi1234

-----za server-----
$host = "malina.lan:3306";
$dbUsername = "zanjNative";
$dbPassword = "Jankovec123456";
$dbname = "spletna_trgovina";
	
-----za localhost-----
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "spletna_trgovina";

-----za poizvedbe-----
$stmt = $conn->prepare($poizvedba);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($str, $email);
$stmt->store_result();
$stmt->close();
$stmt->fetch();
$rnum1 = $stmt->num_rows;
*/
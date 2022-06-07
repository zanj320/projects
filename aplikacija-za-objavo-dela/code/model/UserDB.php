<?php

require_once("DBinit.php");

class UserDB {	
	public static function insertNewUser($data = array()) {
		if (!empty($data)) {
			extract($data);
			
			$role="user";

			$dbh = DBInit::getInstance();
			
			$ime = DBinit::sanitizeVariable($ime);
			$priimek = DBinit::sanitizeVariable($priimek);
			$email = DBinit::sanitizeVariable($email);
			$geslo = password_hash($geslo, PASSWORD_DEFAULT);
			$role = DBinit::sanitizeVariable($role);
			$telefon = DBinit::sanitizeVariable($telefon);
			$datum_rojstva = DBinit::sanitizeVariable($datum_rojstva);
			
			$query = "INSERT INTO uporabnik VALUES(NULL, :ime, :priimek, :email, :geslo, :role, :telefon, :datum_rojstva)";
			$stmt = $dbh->prepare($query);
			$stmt-> bindParam(':ime', $ime, PDO::PARAM_STR);
			$stmt-> bindParam(':priimek', $priimek, PDO::PARAM_STR);
			$stmt-> bindParam(':email', $email, PDO::PARAM_STR);
			$stmt-> bindParam(':geslo', $geslo, PDO::PARAM_STR);
			$stmt-> bindParam(':role', $role, PDO::PARAM_STR);
			$stmt-> bindParam(':telefon', $telefon, PDO::PARAM_STR);
			$stmt-> bindParam(':datum_rojstva', $datum_rojstva, PDO::PARAM_STR);
			
			$stmt->execute();
		}
	}
	
	public static function loginUserCheck($data = array()) {
		if (!empty($data)) {
			extract($data);
			$dbh = DBInit::getInstance();
			
			$email = DBinit::sanitizeVariable($email);			
			
			$query = "SELECT * FROM uporabnik WHERE email = :email LIMIT 1";
			$stmt = $dbh->prepare($query);

			$stmt-> bindParam(':email', $email, PDO::PARAM_STR);
			
			$stmt->execute();
			$podatki = $stmt->fetch();

			if ($podatki && password_verify($geslo, $podatki["geslo"])) {
				return $podatki;
			}
			return false;
		}
	}
	
	public static function updateUserData($data = array()) {
		if (!empty($data)) {
			extract($data);
			$dbh = DBInit::getInstance();
			
			if (isset($update)) {
				$ime = DBinit::sanitizeVariable($ime);
				$priimek = DBinit::sanitizeVariable($priimek);
				$telefon = DBinit::sanitizeVariable($telefon);
				$datum_rojstva = DBinit::sanitizeVariable($datum_rojstva);
				
				$query = "UPDATE uporabnik SET ime = :ime, priimek = :priimek, telefon = :telefon, datum_rojstva = :datum_rojstva WHERE id_uporabnik = :id_uporabnik";
				$stmt = $dbh->prepare($query);
				$stmt-> bindParam(':ime', $ime, PDO::PARAM_STR);
				$stmt-> bindParam(':priimek', $priimek, PDO::PARAM_STR);
				$stmt-> bindParam(':telefon', $telefon, PDO::PARAM_STR);
				$stmt-> bindParam(':datum_rojstva', $datum_rojstva, PDO::PARAM_STR);
				$stmt-> bindParam(':id_uporabnik', $_SESSION["data"]["id_uporabnik"], PDO::PARAM_STR);
				
				$stmt->execute();
				
				$_SESSION["data"]["ime"] = $ime;
				$_SESSION["data"]["priimek"] = $priimek;
				$_SESSION["data"]["telefon"] = $telefon;
				$_SESSION["data"]["datum_rojstva"] = $datum_rojstva;
			} else if (isset($delete)) {
				$query = "DELETE FROM uporabnik WHERE id_uporabnik=:id_uporabnik";
				$stmt = $dbh->prepare($query);

				$stmt-> bindParam(':id_uporabnik', $_SESSION["data"]["id_uporabnik"], PDO::PARAM_STR);
				
				$stmt->execute();
				
				session_destroy();
			}
		}
	}
	
	public static function getJobs($isci) {
		$dbh = DBInit::getInstance();
		
		$isci = DBinit::sanitizeVariable($isci);
		
		$query = "SELECT d.id_delo, d.naziv, d.opis, d.placa, d.datum_objave, p.naziv as naziv_podjetja, p.naslov FROM delo d JOIN podjetje p USING(id_podjetje) WHERE d.naziv LIKE :isci ORDER BY datum_objave DESC";
		$stmt = $dbh->prepare($query);
		
		$filter = "%" . $isci . "%";
		
		$stmt-> bindParam(':isci', $filter, PDO::PARAM_STR);
		
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public static function getRequestedJobs() {
		$dbh = DBInit::getInstance();
		
		$query = "SELECT id_delo, besedilo, datum_izdaje, obravnava FROM prosnja WHERE id_uporabnik = :id_uporabnik";
		$stmt = $dbh->prepare($query);
		
		$stmt-> bindParam(':id_uporabnik', $_SESSION["data"]["id_uporabnik"], PDO::PARAM_STR);
		
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public static function insertUserWorkRequest($data = array()) {
		if (!empty($data)) {
			extract($data);

			$dbh = DBInit::getInstance();
			
			$id_delo = DBinit::sanitizeVariable($id_delo);
			$besedilo = DBinit::sanitizeVariable($besedilo);
			
			$query = "INSERT INTO prosnja VALUES(:id_uporabnik, :id_delo, :besedilo, NULL, CURRENT_DATE)";
			$stmt = $dbh->prepare($query);
			$stmt-> bindParam(':id_uporabnik', $_SESSION["data"]["id_uporabnik"], PDO::PARAM_STR);
			$stmt-> bindParam(':id_delo', $id_delo, PDO::PARAM_STR);
			$stmt-> bindParam(':besedilo', $besedilo, PDO::PARAM_STR);
			
			$stmt->execute();
		}
	}
	
	public static function deleteRequest($data = array()) {
		if (!empty($data)) {
			extract($data);

			$dbh = DBInit::getInstance();
			
			$id_delo = DBinit::sanitizeVariable($id_delo);

			$query = "DELETE FROM prosnja WHERE id_uporabnik = :id_uporabnik AND id_delo = :id_delo";
			$stmt = $dbh->prepare($query);
			$stmt-> bindParam(':id_uporabnik', $_SESSION["data"]["id_uporabnik"], PDO::PARAM_STR);
			$stmt-> bindParam(':id_delo', $id_delo, PDO::PARAM_STR);
			
			$stmt->execute();
		}
	}
	
	
	public static function getByEmail($email) {
		if (isset($email)) {
			$dbh = DBInit::getInstance();
			
			$email = DBinit::sanitizeVariable($email);			
			
			$query = "SELECT count(*) as x FROM uporabnik WHERE email = :email LIMIT 1";
			$stmt = $dbh->prepare($query);

			$stmt-> bindParam(':email', $email, PDO::PARAM_STR);
			
			$stmt->execute();
			$podatki = $stmt->fetch();
			return ($podatki["x"]==0) ? true : false;
		}
	}
	public static function verifyPassword($geslo) {
		if (isset($geslo)) {
			$dbh = DBInit::getInstance();
			
			$query = "SELECT geslo FROM uporabnik WHERE id_uporabnik = :id_uporabnik LIMIT 1";
			$stmt = $dbh->prepare($query);

			$stmt-> bindParam(':id_uporabnik', $_SESSION["data"]["id_uporabnik"], PDO::PARAM_STR);
			
			$stmt->execute();
			$podatki = $stmt->fetch();
			
			return password_verify($geslo, $podatki["geslo"]);
		}
	}
}

?>
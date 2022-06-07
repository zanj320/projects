<?php

require_once("DisplayFile.php");

class UserController {
	public static function checkLoggedIn() {
		if (isset($_SESSION["data"]["role"]) && $_SESSION["data"]["role"]=="user")
			return true;
		return false;
	}
	
	public static function checkLoginTimeout() {
		if (!isset($_SESSION['CREATED'])) {
			$_SESSION['CREATED'] = time() + 60 * 15;
		} else if ($_SESSION['CREATED'] < time()) {
			session_destroy();
			DisplayFile::redirect(BASE_URL . "content");
		} else if ($_SESSION['CREATED'] > time()) {
			$_SESSION['CREATED'] = time() + 60 * 15;
		}
	}
	
	public static function showLoggedInContent() {
		if (isset($_SESSION["data"])) {
			if ($_SESSION["data"]["role"] == "user") {
				$_SESSION["data"]["requestedJobs"] = UserDB::getRequestedJobs();
				
				$filter = "";
				if (isset($_GET["isci"])) { $filter = $_GET["isci"]; }
				$indexed = UserDB::getJobs($filter);
				$allJobs = array();
				$count = 0;
				foreach ($indexed as $el) {
					$allJobs["var" . $count] = $el;
					$count++;
				}

				DisplayFile::render("view/content-user-login.php", $allJobs);
			} else if ($_SESSION["data"]["role"] == "company") {
				$_SESSION["allCompanies"] = CompanyDB::getCompanies($_SESSION["data"]["id_lastnik"]);
				$_SESSION["everyWork"] = CompanyDB::getEveryWork($_SESSION["data"]["id_podjetje"]);
				
				if (!$_SESSION["everyWork"]) $_SESSION["everyWork"] = array();

				DisplayFile::render("view/content-company-login.php");
			}
		} else {
			session_destroy();
			
			$filter = "";
			if (isset($_GET["isci"])) { $filter = $_GET["isci"]; }
			$indexed = UserDB::getJobs($filter);
			$allJobs = array();
			$count = 0;
			foreach ($indexed as $el) {
				$allJobs["var" . $count] = $el;
				$count++;
			}
			
			DisplayFile::render("view/content-not-login.php", $allJobs);
		}
	}
	
	public static function showUserLoginForm() {
		$errors = [
			"all" => ""
		];
		$vars = ["errorsSent" => $errors];
		
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			DisplayFile::render("view/user-login-form.php", $vars);
		} else {
			$valid_data = UserDB::loginUserCheck($_POST);
			
			if ($valid_data) {
				$_SESSION["data"] = $valid_data;
				DisplayFile::redirect(BASE_URL . "content");
			} else {
				$errors["all"] = "Nepravilen e-naslov ali geslo.";
				
				self::backToLogin($errors);
			}
		}
	}
	
	public static function showUserRegisterForm() {
		$data = [
			"ime" => "",
			"priimek" => "",
			"email" => "",
			"telefon" => "",
			"datum_rojstva" => "",
			"geslo" => "",
			"potrdi_geslo" => ""
		];
		
		$errors = [
			"ime" => "",
			"priimek" => "",
			"email" => "",
			"telefon" => "",
			"datum_rojstva" => "",
			"geslo" => ""
		];
		$vars = ["dataSent" => $data, "errorsSent" => $errors];
		
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			DisplayFile::render("view/user-register-form.php", $vars);
		} else {
			$rules = [
				"ime" => [
					"filter" => FILTER_VALIDATE_REGEXP,
					"options" => ["regexp" => "/^[a-zA-ZšđčćžŠĐČĆŽ]+$/"]
				],
				"priimek" => [
					"filter" => FILTER_VALIDATE_REGEXP,
					"options" => ["regexp" => "/^[a-zA-ZšđčćžŠĐČĆŽ]+$/"]
				],
				"email" => [
					"filter" => FILTER_VALIDATE_EMAIL,
				],
				"telefon" => [
					"filter" => FILTER_VALIDATE_REGEXP,
					"options" => ["regexp" => "/^[0-9]{9}$/"]
				],
				"datum_rojstva" => [
					"filter" => FILTER_CALLBACK,
					"options" => function ($value) { return ($value <= date('Y-m-d', strtotime('-16 year')) && $value > date('Y-m-d', strtotime('-65 year'))) ? $value : false; }
				],
				"geslo" => [
					"filter" => FILTER_CALLBACK,
					"options" => function ($value) { return $value; }
				],
				"potrdi_geslo" => [
					"filter" => FILTER_CALLBACK,
					"options" => function ($value) { return $value; }
				]
			];
	
			$data = filter_input_array(INPUT_POST, $rules);
			
			//-------errors-------
			$errors["ime"] = $data["ime"] === false ? "Vnesite pravilno notacijo imena." : "";
			$errors["priimek"] = $data["priimek"] === false ? "Vnesite pravilno notacijo priimka." : "";
			
			$errors["email"] = $data["email"] === false ? "Vnesite pravilno notacijo e-naslova." : "";
			if (empty($errors["email"])) {
				$errors["email"] = UserDB::getByEmail($data["email"]) === false ? "Uporabniški račun s tem e-naslovom že obstaja." : "";
			}

			$errors["telefon"] = $data["telefon"] === false ? "Vnesite pravilno notacijo telefonske številke." : "";
			$errors["datum_rojstva"] = $data["datum_rojstva"] === false ? "Vnesite pravilen datum." : "";
			
			$errors["geslo"] = strlen($data["geslo"])<5 && strlen($data["potrdi_geslo"])<5 ? "Geslo mora biti dolgo vsaj 5 črk." : "";
			if (empty($errors["geslo"]) && $data["geslo"] != $data["potrdi_geslo"]) {
				$errors["geslo"] = "Gesli se ne ujemata.";
			}
			//-------errors-------
			
			$isDataValid = true;
			foreach ($errors as $error) {
				$isDataValid = $isDataValid && empty($error);
			}
			
			if ($isDataValid) {
				UserDB::insertNewUser($_POST);
				DisplayFile::redirect(BASE_URL . "content/user-login-form");
			} else {
				self::backToRegister($_POST, $errors);
			}
		}
	}
	
	public static function showUserEditDataForm() {
		if (!UserController::checkLoggedIn()) DisplayFile::redirect(BASE_URL . "content");
		
		$data = [
			"ime" => $_SESSION["data"]["ime"],
			"priimek" => $_SESSION["data"]["priimek"],
			"telefon" => $_SESSION["data"]["telefon"],
			"datum_rojstva" => $_SESSION["data"]["datum_rojstva"],
			"geslo" => ""
		];
		
		$errors = [
			"ime" => "",
			"priimek" => "",
			"telefon" => "",
			"datum_rojstva" => "",
			"geslo" => ""
		];
        $vars = ["dataSent" => $data, "errorsSent" => $errors];
		
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			DisplayFile::render("view/content-user-edit-data.php", $vars);
		} else {
			$rules = [
				"ime" => [
					"filter" => FILTER_VALIDATE_REGEXP,
					"options" => ["regexp" => "/^[a-zA-ZšđčćžŠĐČĆŽ]+$/"]
				],
				"priimek" => [
					"filter" => FILTER_VALIDATE_REGEXP,
					"options" => ["regexp" => "/^[a-zA-ZšđčćžŠĐČĆŽ]+$/"]
				],
				"telefon" => [
					"filter" => FILTER_VALIDATE_REGEXP,
					"options" => ["regexp" => "/^[0-9]{9}$/"]
				],
				"datum_rojstva" => [
					"filter" => FILTER_CALLBACK,
					"options" => function ($value) { return ($value <= date('Y-m-d', strtotime('-16 year')) && $value > date('Y-m-d', strtotime('-65 year'))) ? $value : false; }
				],
				"geslo" => [
					"filter" => FILTER_CALLBACK,
					"options" => function ($value) { return (UserDB::verifyPassword($value)) ? true : false; }
				]
			];
	
			$data = filter_input_array(INPUT_POST, $rules);
			
			//-------errors-------
			$errors["ime"] = $data["ime"] === false ? "Vnesite pravilno notacijo imena." : "";
			$errors["priimek"] = $data["priimek"] === false ? "Vnesite pravilno notacijo priimka." : "";

			$errors["telefon"] = $data["telefon"] === false ? "Vnesite pravilno notacijo telefonske številke." : "";
			$errors["datum_rojstva"] = $data["datum_rojstva"] === false ? "Vnesite pravilen datum." : "";
			
			$errors["geslo"] = $data["geslo"] === false ? "Nepravilno geslo." : "";
			//-------errors-------
			
			$isDataValid = true;
			foreach ($errors as $error) {
				$isDataValid = $isDataValid && empty($error);
			}
			
			if ($isDataValid) {
				UserDB::updateUserData($_POST);
				//DisplayFile::redirect(BASE_URL . "content");
				$vars["dataSent"] = $_POST;
				DisplayFile::redirect(BASE_URL . "content");
			} else {
				self::backToEditUserData($_POST, $errors);
			}
		}
	}
	
	public static function insertUserPostRequest() {
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			DisplayFile::redirect(BASE_URL . "content");
		} else {
			UserDB::insertUserWorkRequest($_POST);
			DisplayFile::redirect(BASE_URL . "content");
		}
	}
	
	public static function showUserWorkRequests() {
		if (!UserController::checkLoggedIn()) DisplayFile::redirect(BASE_URL . "content");
		
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			$indexed = UserDB::getJobs("");
			$allJobs = array();
			$count = 0;
			foreach ($indexed as $el) {
				$allJobs["var" . $count] = $el;
				$count++;
			}
			
			DisplayFile::render("view/content-user-show-requests.php", $allJobs);
		} else {
			UserDB::deleteRequest($_POST);
			$_SESSION["data"]["requestedJobs"] = UserDB::getRequestedJobs();
			DisplayFile::redirect(BASE_URL . "content/user-show-requests?");
		}
	}
	
	
	public static function backToRegister($data = [], $errors = []) {
        $vars = ["dataSent" => $data, "errorsSent" => $errors];
        DisplayFile::render("view/user-register-form.php", $vars);
	}
	public static function backToLogin($errors = []) {
        $vars = ["errorsSent" => $errors];
        DisplayFile::render("view/user-login-form.php", $vars);
	}
	public static function backToEditUserData($data = [], $errors = []) {
        $vars = ["dataSent" => $data, "errorsSent" => $errors];
        DisplayFile::render("view/content-user-edit-data.php", $vars);
	}
}
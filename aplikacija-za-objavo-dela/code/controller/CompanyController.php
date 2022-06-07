<?php

require_once("DisplayFile.php");

class CompanyController {
	public static function checkLoggedIn() {
		if (isset($_SESSION["data"]["role"]) && $_SESSION["data"]["role"]=="company")
			return true;
		return false;
	}
	
	public static function showCompanyLoginForm() {
		$errors = [
			"all" => ""
		];
		$vars = ["errorsSent" => $errors];
		
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
			DisplayFile::render("view/company-login-form.php", $vars);
		} else {
			$valid_data = CompanyDB::loginCompanyCheck($_POST);
			
			if ($valid_data) {
				$_SESSION["data"] = $valid_data;
				DisplayFile::redirect(BASE_URL . "content");
			} else {
				$errors["all"] = "Nepravilen e-naslov, davčna številka ali geslo.";
				self::backToLogin($errors);
			}
		}
	}
	
	public static function showCompanyRegisterForm() {
		$data = [
			"davcna" => "",
			"naziv" => "",
			"naslov" => "",
			"postna_st" => "",
			"ime" => "",
			"priimek" => "",
			"email" => "",
			"telefon" => "",
			"geslo" => "",
			"potrdi_geslo" => ""
		];
		
		$errors = [
			"davcna" => "",
			"naziv" => "",
			"naslov" => "",
			"postna_st" => "",
			"ime" => "",
			"priimek" => "",
			"email" => "",
			"telefon" => "",
			"geslo" => "",
			"potrdi_geslo" => ""
		];
		$vars = ["dataSent" => $data, "errorsSent" => $errors];
		
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			DisplayFile::render("view/company-register-form.php", $vars);
		} else {
			$rules = [
				"davcna" => [
					"filter" => FILTER_VALIDATE_REGEXP,
					"options" => ["regexp" => "/^[0-9]{8}$/"]
				],
				"naziv" => [
					"filter" => FILTER_VALIDATE_REGEXP,
					"options" => ["regexp" => "/^[a-zA-ZšđčćžŠĐČĆŽ0-9 .-]+$/"]
				],
				"naslov" => [
					"filter" => FILTER_VALIDATE_REGEXP,
					"options" => ["regexp" => "/^[a-zA-ZšđčćžŠĐČĆŽ0-9 ]+$/"]
				],
				"postna_st" => [
					"filter" => FILTER_VALIDATE_REGEXP,
					"options" => ["regexp" => "/^[0-9]{4}+$/"]
				],
				
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
			$errors["davcna"] = $data["davcna"] === false ? "Vnesite pravilno notacijo davčne številke." : "";
			if (empty($errors["davcna"])) {
				$errors["davcna"] = CompanyDB::getByDavcna($data["davcna"]) === false ? "Napačna davčna številka" : "";
			}
			
			$errors["naziv"] = $data["naziv"] === false ? "Vnesite pravilno notacijo naziva." : "";
			$errors["naslov"] = $data["naslov"] === false ? "Vnesite pravilno notacijo naslova." : "";
			$errors["postna_st"] = $data["postna_st"] === false ? "Vnesite pravilno notacijo poštne številke." : "";
			
			
			$errors["ime"] = $data["ime"] === false ? "Vnesite pravilno notacijo imena." : "";
			$errors["priimek"] = $data["priimek"] === false ? "Vnesite pravilno notacijo priimka." : "";
			
			$errors["email"] = $data["email"] === false ? "Vnesite pravilno notacijo e-naslova." : "";
			if (empty($errors["email"])) {
				$errors["email"] = CompanyDB::getByEmail($data["email"]) === false ? "Lastnik podjetja s tem e-naslovom že obstaja." : "";
			}

			$errors["telefon"] = $data["telefon"] === false ? "Vnesite pravilno notacijo telefonske številke." : "";

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
				CompanyDB::insertNewCompany($_POST);
				// DisplayFile::render("view/company-login-form.php", $_POST);
				DisplayFile::redirect(BASE_URL . "content/company-login-form");
			} else {
				self::backToRegister($_POST, $errors);
			}
		}
	}
	
	public static function showCompanyPostWorkForm() {
		if (!CompanyController::checkLoggedIn()) DisplayFile::redirect(BASE_URL . "content");
		
		$data = [
			"naziv" => "",
			"opis" => "",
			"placa" => ""
		];
		
		$errors = [
			"all" => ""
		];
		$vars = ["dataSent" => $data, "errorsSent" => $errors];
		
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			DisplayFile::render("view/content-company-post-work.php", $vars);
		} else {
			$rules = [
				"placa" => [
					"filter" => FILTER_VALIDATE_FLOAT
				]
			];
	
			$data = filter_input_array(INPUT_POST, $rules);
			
			//-------errors-------
			$errors["all"] = $data["placa"] === false ? "Vnesite pravilno notacijo plače." : "";
			//-------errors-------
			
			$isDataValid = true;
			foreach ($errors as $error) {
				$isDataValid = $isDataValid && empty($error);
			}
			
			if ($isDataValid) {
				CompanyDB::insertNewWork($_POST);
				DisplayFile::redirect(BASE_URL . "content");
			} else {
				self::backToPostWork($_POST, $errors);
			}
		}
	}
	
	public static function showCompanyEditDataForm() {
		if (!CompanyController::checkLoggedIn()) DisplayFile::redirect(BASE_URL . "content");
		
		$data = [
			"naziv" => $_SESSION["data"]["naziv"],
			"naslov" => $_SESSION["data"]["naslov"],
			"postna_st" => $_SESSION["data"]["postna_st"],
			"ime" => $_SESSION["data"]["ime"],
			"priimek" => $_SESSION["data"]["priimek"],
			"telefon" => $_SESSION["data"]["telefon"],
			"geslo" => ""
		];
		
		$errors = [
			"naziv" => "",
			"naslov" => "",
			"postna_st" => "",
			"ime" => "",
			"priimek" => "",
			"telefon" => "",
			"geslo" => ""
		];
		$vars = ["dataSent" => $data, "errorsSent" => $errors];
		
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			DisplayFile::render("view/content-company-edit-data.php", $vars);
		} else {
			$rules = [
				"naziv" => [
					"filter" => FILTER_VALIDATE_REGEXP,
					"options" => ["regexp" => "/^[a-zA-ZšđčćžŠĐČĆŽ0-9 .]+$/"]
				],
				"naslov" => [
					"filter" => FILTER_VALIDATE_REGEXP,
					"options" => ["regexp" => "/^[a-zA-ZšđčćžŠĐČĆŽ0-9 ]+$/"]
				],
				"postna_st" => [
					"filter" => FILTER_VALIDATE_REGEXP,
					"options" => ["regexp" => "/^[0-9]{4}+$/"]
				],
				
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
				"geslo" => [
					"filter" => FILTER_CALLBACK,
					"options" => function ($value) { return (CompanyDB::verifyPassword($value)) ? true : false; }
				]
			];
	
			$data = filter_input_array(INPUT_POST, $rules);
			
			//-------errors-------
			$errors["naziv"] = $data["naziv"] === false ? "Vnesite pravilno notacijo naziva." : "";
			$errors["naslov"] = $data["naslov"] === false ? "Vnesite pravilno notacijo naslova." : "";
			$errors["postna_st"] = $data["postna_st"] === false ? "Vnesite pravilno notacijo poštne številke." : "";
			
			
			$errors["ime"] = $data["ime"] === false ? "Vnesite pravilno notacijo imena." : "";
			$errors["priimek"] = $data["priimek"] === false ? "Vnesite pravilno notacijo priimka." : "";

			$errors["telefon"] = $data["telefon"] === false ? "Vnesite pravilno notacijo telefonske številke." : "";

			$errors["geslo"] = $data["geslo"] === false ? "Nepravilno geslo." : "";
			//-------errors-------
			
			$isDataValid = true;
			foreach ($errors as $error) {
				$isDataValid = $isDataValid && empty($error);
			}
			
			if ($isDataValid) {
				CompanyDB::updateCompanyData($_POST);
				//DisplayFile::redirect(BASE_URL . "content");
				$vars["dataSent"] = $_POST;
				DisplayFile::redirect(BASE_URL . "content");
			} else {
				self::backToEditData($_POST, $errors);
			}
		}
	}
	
	public static function switchCompany() {
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			DisplayFile::redirect(BASE_URL . "content");
		} else {
			$valid_data = isset($_POST["id_podjetje"]) && !empty($_POST["id_podjetje"]) &&
						  isset($_POST["naziv"]) && !empty($_POST["naziv"]) &&
						  isset($_POST["naslov"]) && !empty($_POST["naslov"]) &&
						  isset($_POST["postna_st"]) && !empty($_POST["postna_st"]) &&
						  isset($_POST["davcna"]) && !empty($_POST["davcna"]);
			
			if ($valid_data) {
				$_SESSION["data"]["id_podjetje"] = DBInit::sanitizeVariable($_POST["id_podjetje"]);
				$_SESSION["data"]["naziv"] = DBInit::sanitizeVariable($_POST["naziv"]);
				$_SESSION["data"]["naslov"] = DBInit::sanitizeVariable($_POST["naslov"]);
				$_SESSION["data"]["postna_st"] = DBInit::sanitizeVariable($_POST["postna_st"]);
				$_SESSION["data"]["davcna"] = DBInit::sanitizeVariable($_POST["davcna"]);
			}
			DisplayFile::redirect(BASE_URL . "content");
		}
	}
	
	public static function showCompanyEditWorkForm() {
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			DisplayFile::redirect(BASE_URL . "content");
			// DisplayFile::render("view/company-register-form.php", $vars);
		} else {
			CompanyDB::updateWork($_POST);
			DisplayFile::redirect(BASE_URL . "content");
		}
	}
	
	public static function companyAddCompany() {
		if (!CompanyController::checkLoggedIn()) DisplayFile::redirect(BASE_URL . "content");
		
		$data = [
			"davcna" => "",
			"naziv" => "",
			"naslov" => "",
			"postna_st" => ""
		];

		$errors = [
			"davcna" => "",
			"naziv" => "",
			"naslov" => "",
			"postna_st" => ""
		];
		$vars = ["dataSent" => $data, "errorsSent" => $errors];
		
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			DisplayFile::render("view/content-company-add-company.php", $vars);
		} else {
			$rules = [
				"davcna" => [
					"filter" => FILTER_VALIDATE_REGEXP,
					"options" => ["regexp" => "/^[0-9]{8}$/"]
				],
				"naziv" => [
					"filter" => FILTER_VALIDATE_REGEXP,
					"options" => ["regexp" => "/^[a-zA-ZšđčćžŠĐČĆŽ0-9 .]+$/"]
				],
				"naslov" => [
					"filter" => FILTER_VALIDATE_REGEXP,
					"options" => ["regexp" => "/^[a-zA-ZšđčćžŠĐČĆŽ0-9 ]+$/"]
				],
				"postna_st" => [
					"filter" => FILTER_VALIDATE_REGEXP,
					"options" => ["regexp" => "/^[0-9]{4}+$/"]
				]
			];
	
			$data = filter_input_array(INPUT_POST, $rules);
			
			//-------errors-------
			$errors["davcna"] = $data["davcna"] === false ? "Vnesite pravilno notacijo davčne številke." : "";
			if (empty($errors["davcna"])) {
				$errors["davcna"] = CompanyDB::getByDavcna($data["davcna"]) === false ? "Napačna davčna številka" : "";
			}
			
			$errors["naziv"] = $data["naziv"] === false ? "Vnesite pravilno notacijo naziva." : "";
			$errors["naslov"] = $data["naslov"] === false ? "Vnesite pravilno notacijo naslova." : "";
			$errors["postna_st"] = $data["postna_st"] === false ? "Vnesite pravilno notacijo poštne številke." : "";
			//-------errors-------
			
			$isDataValid = true;
			foreach ($errors as $error) {
				$isDataValid = $isDataValid && empty($error);
			}
			
			if ($isDataValid) {
				CompanyDB::addCompany($_POST);
				DisplayFile::redirect(BASE_URL . "content");
			} else {
				self::backToAddCompany($_POST, $errors);
			}
		}
	}
	
	public static function companyDeleteCompany() {		
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			DisplayFile::redirect(BASE_URL . "content");
		} else {			
			if (CompanyDB::atleastOneCompany()) {
				CompanyDB::DeleteCompany($_POST);
				DisplayFile::redirect(BASE_URL . "content");
			} else {
				$errors = [
					"all" => "Podjetja ne morate izbrisati. Morate imeti vsaj 1 podjetje v lasti."
				];
				$vars = ["errorsSent" => $errors];
				
				DisplayFile::render("view/content-company-login.php", $vars);
			}
		}
	}

	public static function companyViewRequests() {
		if (!CompanyController::checkLoggedIn()) DisplayFile::redirect(BASE_URL . "content");
		
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			$indexed = CompanyDB::getRequestedUsers();
			$myReq = array();
			$count = 0;
			
			foreach ($indexed as $el) {
				$myReq["var" . $count] = $el;
				$count++;
			}
			
			DisplayFile::render("view/content-company-view-requests.php", $myReq);
		} else {
			DisplayFile::redirect(BASE_URL . "content");
		}
	}

	public static function companyManageUser() {
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			DisplayFile::redirect(BASE_URL . "content");
		} else {
			CompanyDB::companyUpdateUserRequest($_POST);
			DisplayFile::redirect(BASE_URL . "content/company-view-requests");
		}
	}
	
	
	public static function backToRegister($data = [], $errors = []) {
        $vars = ["dataSent" => $data, "errorsSent" => $errors];
        DisplayFile::render("view/company-register-form.php", $vars);
	}
	public static function backToLogin($errors = []) {
        $vars = ["errorsSent" => $errors];
        DisplayFile::render("view/company-login-form.php", $vars);
	}
	public static function backToEditData($data = [], $errors = []) {
        $vars = ["dataSent" => $data, "errorsSent" => $errors];
        DisplayFile::render("view/content-company-edit-data.php", $vars);
	}
	public static function backToPostWork($data = [], $errors = []) {
        $vars = ["dataSent" => $data, "errorsSent" => $errors];
        DisplayFile::render("view/content-company-post-work.php", $vars);
	}
	public static function backToAddCompany($data = [], $errors = []) {
        $vars = ["dataSent" => $data, "errorsSent" => $errors];
        DisplayFile::render("view/content-company-add-company.php", $vars);
	}
}
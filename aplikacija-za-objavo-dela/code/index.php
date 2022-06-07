<?php

require_once("DisplayFile.php");
require_once("controller/UserController.php");
require_once("controller/CompanyController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
//define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "external/css/");
define("EXTERNAL_FILES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "external/links.php");


$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

session_start();
UserController::checkLoginTimeout();

$urls = [
	"content" => function() {
		UserController::showLoggedInContent();
	},
	// -------------------- user --------------------
	"content/user-login-form" => function () {
		UserController::showUserLoginForm();
	},
	"content/user-register-form" => function() {
		UserController::showUserRegisterForm();
	},
	"content/user-edit-data" => function() {
		UserController::showUserEditDataForm();
	},
	"content/user-post-request" => function() {
		UserController::insertUserPostRequest();
	},
	"content/user-show-requests" => function() {
		UserController::showUserWorkRequests();
	},
	// -------------------- ---- --------------------
	
	// -------------------- company --------------------
	"content/company-login-form" => function () {
		CompanyController::showCompanyLoginForm();
	},
	"content/company-register-form" => function() {
		CompanyController::showCompanyRegisterForm();
	},
	"content/company-post-work" => function() {
		CompanyController::showCompanyPostWorkForm();
	},
	"content/company-switch" => function() {
		CompanyController::switchCompany();
	},
	"content/company-edit-data" => function() {
		CompanyController::showCompanyEditDataForm();
	},
	"content/company-edit-work" => function() {
		CompanyController::showCompanyEditWorkForm();
	},
	"content/company-add-company" => function() {
		CompanyController::companyAddCompany();
	},
	"content/company-delete-company" => function() {
		CompanyController::companyDeleteCompany();
	},
	"content/company-view-requests" => function() {
		CompanyController::companyViewRequests();
	},
	"content/company-manage-user" => function() {
		CompanyController::companyManageUser();
	},
	// -------------------- -------- --------------------
	
	// --------------------------------------------- log out ---------------------------------------------
	"content/destroy" => function () {
		session_start();
		session_destroy();
		DisplayFile::redirect(BASE_URL . "content");
    },
	// --------------------------------------------- ------- ---------------------------------------------
    "" => function () {
		DisplayFile::redirect(BASE_URL . "content");
    }
];


try {
    if (isset($urls[$path])) {
       $urls[$path]();
    } else {
		DisplayFile::error404();
        //echo "<br/>No controller for '$path'";
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    // ViewHelper::error404();
}
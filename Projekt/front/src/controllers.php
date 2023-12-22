<?php

require_once 'business/business.php';

// get_db()->users->drop();
// get_db()->screenshots->drop();
function index(&$model) {
	return "index-view";
}

function collection(&$model) {
	return "collection-view";	
}

class Auth {
	const OK = 'Zalogowano';
	const WRONG_PW = 'Nieprawidłowe hasło';
	const NO_USER = 'Nie ma takiego użytkownika';
	const USER_EXISTS = 'Istnieje już użytkownik o tym loginie';
	const PWS_DIFFER = 'Hasła nie są identyczne';
}

function register(&$model) {
	switch ($_SERVER['REQUEST_METHOD']) {
		case 'GET':
			$model['auth'] = '';
			break;
		case 'POST':
			if ($_POST['password'] !== $_POST['repeat']){
				$auth = Auth::PWS_DIFFER;
			}
			else {
				$auth = register_user($_POST['login'], $_POST['password']);
			}

			if ($auth === Auth::OK){
				$model['auth'] = 'Utworzono konto';
			}
			else{
				$model['auth'] = $auth;
			}
			break;
	}
	return "register-view";
}

function account(&$model) {
	switch ($_SERVER['REQUEST_METHOD']) {
		case 'GET':
			if (isset($_GET['perform']) && $_GET['perform'] === 'logout') {
				if(isset($_SESSION)){
					session_destroy();
					unset($_SESSION['user']);
				}
			}

			if (isset($_SESSION['user'])) {
				$user = $_SESSION['user'];
				$model['user'] = $user;
			}
			$model['auth'] = '';
			break;

		case 'POST': // tries to log in
			$auth = login_user($_POST['login'], $_POST['password']);
			if ($auth === Auth::OK) {
				$user = get_user($_POST['login']);
				$_SESSION['user'] = $user['login'];
				$model['user'] = $user['login'];
				session_start();
			}
			$model['auth'] = $auth;
			break;
	}
	return "account-view";
}

class Validation {
	const OK = 'Dziękujemy!';
	const WRONG_EXT = 'Wyślij plik <code>.png</code> lub <code>.jpg</code>';
	const TOO_BIG = 'Rozmiar przekracza 1MB';
	const WRONG_EXT_AND_SIZE = 'Wyślij plik <code>.png</code> lub <code>.jpg</code> mniejszy niż 1MB';
}

function forum(&$model) {
	$page = 1;
	switch ($_SERVER['REQUEST_METHOD']) {
		case 'GET': 
			$model['validation'] = '';
			if (isset($_GET['page'])) $page = $_GET['page'];
			break;
		case "POST":
			$validation = receive_form();
			$model['validation'] = $validation;
	}
	$model['page'] = $page;
	$model['gallery'] = get_gallery($page);
	$model['max'] = get_max_page();
	return "forum-view";
}

function receive_form() {
	$username = $_POST['username'];
	$title = $_POST['title'];
	$watermark = $_POST['watermark'];
	$screenshot = $_FILES['screenshot'];
	return handle_form($username, $title, $watermark, $screenshot);
}

function db() {
	return "db-view";
}

<?php

require_once 'business/business.php';

/* ! DANGER ZONE ! */
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
				$auth = register_user($_POST['login'], $_POST['password'], $_POST['email']);
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
			switch ($_POST['form']){
				case 'fav':
					save_favs();
					break;
				case 'upload':
					$validation = receive_form();
					$model['validation'] = $validation;
					break;
				}
	}
	$model['gallery'] = get_gallery_page($page, isset($_SESSION['user']) ? $_SESSION['user'] : null);
	$model['page'] = $page;
	if (isset($_SESSION['favs'])) {$model['favs'] = $_SESSION['favs'];};
	$model['max'] = get_max_page();
	$model['user'] = isset($_SESSION['user']) ? $_SESSION['user'] : null;
	return "forum-view";
}

function receive_form() {
	$username = $_POST['username'];
	$title = $_POST['title'];
	$watermark = $_POST['watermark'];
	$screenshot = $_FILES['screenshot'];
	$availability = isset($_POST['availability'])? $_POST['availability'] : 'public';
	return handle_form($username, $title, $watermark, $screenshot, $availability);
}

function save_favs() {
	$gallery = get_gallery();
	foreach ($gallery as $entry) {
		$file = full_encode($entry['name']);
		if (isset($_POST[$file])) {
			$_SESSION['favs'][full_decode($file)] = $_POST[$file];
		}
	}
}

function db() {
	return "db-view";
}

/* encode in a url-friendly way */
/* https://stackoverflow.com/a/12093201 */
function full_encode($str) {
	$str = urlencode($str);
	$str = str_replace('.', '%2E', $str);
	$str = str_replace('-', '%2D', $str);
	$str = str_replace(' ', '%20', $str );
	return $str;
}

function full_decode($str) {
	$str = str_replace('%2E', '.', $str);
	$str = str_replace('%2D', '-', $str);
	$str = str_replace('%20', ' ', $str );
	$str = urldecode($str);
	return $str;
}
/* */
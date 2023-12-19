<?php

require_once 'business/business.php';

function index($model) {
	return "index-view";
} // TODO : display login

function collection($model) {
	return "collection-view";	
} // TODO : display login

function account($model) { // TODO : implement
	// if not logged in
		// log in or register
	// else - logged in
		// show selected items?
	return "account-view";
}

class Validation {
	const OK = 'Dziękujemy!';
	const WRONG_EXT = 'Wyślij plik <code>.png</code> lub <code>.jpg</code>';
	const TOO_BIG = 'Rozmiar przekracza 1MB';
	const WRONG_EXT_AND_SIZE = 'Wyślij plik <code>.png</code> lub <code>.jpg</code> mniejszy niż 1MB';
}

function forum(&$model) {
	switch ($_SERVER['REQUEST_METHOD']) {
		case 'GET': 
			break;
		case "POST":
			$validation = receive_form();
			$model['validation'] = $validation;
	}
	$model['gallery'] = get_gallery();
	return "forum-view";
}				

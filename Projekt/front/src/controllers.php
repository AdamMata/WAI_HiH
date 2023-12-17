<?php

require_once 'business.php';

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

class validation {
	const OK = 'OK';
	const WRONG_EXT = 'WRONG_EXT';
	const TOO_BIG = 'TOO_BIG';
	const WRONG_EXT_AND_SIZE = 'WRONG_EXT_AND_SIZE';
}

function forum($model) {
	switch ($_SERVER['REQUEST_METHOD']) {
		case 'GET': 
			break;
		case "POST":
			$validation = receive_form();
			$model['validation'] = $validation;
	}
	return "forum-view";
}				

function receive_form() {
	$username = $_POST['username'];
	$watermark = $_POST['watermark'];
	$screenshot = $_FILES['screenshot'];
	
	echo $username;

	$wrong_type = null;
	$extension = $screenshot['type']; // FIXME : check for extension, not type
	if ($extension !== 'image/jpeg') $wrong_type = true;
	
	$too_big = null;
	if ($screenshot['size'] > 1000000) $too_big = true;

	if ($wrong_type && $too_big) return validation::WRONG_EXT_AND_SIZE;
	if ($wrong_type && !$too_big) return validation::WRONG_EXT;
	if ($too_big && !$wrong_type) return validation::TOO_BIG;
	
	save_screenshot($screenshot, $username);
	
	return validation::OK;
}
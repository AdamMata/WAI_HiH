<?php

require_once 'gallery.php';
require_once 'db.php';

function receive_form() {
	$username = $_POST['username'];
	$title = $_POST['title'];
	$watermark = $_POST['watermark'];
	$screenshot = $_FILES['screenshot'];

	$wrong_type = !check_extension($screenshot, get_extension($screenshot));
	$too_big = ($screenshot['size'] > 1000000);

	if ($wrong_type && $too_big)  return Validation::WRONG_EXT_AND_SIZE;
	if ($wrong_type && !$too_big) return Validation::WRONG_EXT;
	if ($too_big && !$wrong_type) return Validation::TOO_BIG;

	$saved_file_name = save_images($screenshot, $username, $watermark);
	save_image_metadata($saved_file_name, $username, $title);

	return Validation::OK;
}

function get_gallery() {
	$files = scandir(images_dir.'originals');
	$files = array_diff($files, array('.', '..'));

	$gallery = [];
	foreach ($files as $file){
		$meta = get_image_metadata($file);
		array_push(
			$gallery, 
			[
				'name' => $file, 
				'meta' => $meta
			]
		);
	}

	return $gallery;
}

function save_image_metadata($saved_file_name, $username, $title) {
	$db = get_db();
	$meta = [
		'author' => $username,
		'title' => $title,
	];
	$image = [
		'name' => $saved_file_name,
		'meta' => $meta
	];

	$db->screenshots->insertOne($image);
}

function get_image_metadata($file_name) {
	$db = get_db();
	$query = [
		'name' => $file_name
	];
	$image = $db->screenshots->findOne($query);
	return $image['meta'];
}

const hashing_algo = PASSWORD_DEFAULT;

function get_user($login) {
	$db = get_db();
	$query = [
		'login' => $login 
	];

	$user = $db->users->findOne($query);
	return $user;
}

function login_user() {
	$login = $_POST['login'];
	$password = $_POST['password'];

	$hash = password_hash($password, hashing_algo);
	$user = get_user($login);

	if ($user === null) return Auth::NO_USER;
	if (password_verify($password, $hash)) {
		echo 'logged in';
		return Auth::OK;
	}
	else {
		echo 'wrong password';
		return Auth::WRONG_PW;
	}	
}

function register_user($login, $password) {
	$db = get_db();

	$user = [
		'login' => $login,
		'pwhash' => password_hash($password, hashing_algo)
	];

	if ( $db->users->findOne($user) != null ) {
		echo 'user exists';
		return Auth::USER_EXISTS;
	}

	$db->users->insertOne($user);
	echo 'user created';
	return Auth::OK;
}

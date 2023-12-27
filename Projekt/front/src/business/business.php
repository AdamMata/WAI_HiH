<?php

require_once 'gallery.php';
require_once 'db.php';

function handle_form($username, $title, $watermark, $screenshot, $availability) {
	$wrong_type = !check_extension($screenshot, get_extension($screenshot));
	$too_big = ($screenshot['size'] > 1000000);

	if ($wrong_type && $too_big)  return Validation::WRONG_EXT_AND_SIZE;
	if ($wrong_type && !$too_big) return Validation::WRONG_EXT;
	if ($too_big && !$wrong_type) return Validation::TOO_BIG;

	$saved_file_name = save_images($screenshot, $username, $watermark);
	save_image_metadata($saved_file_name, $username, $title, $availability);

	return Validation::OK;
}

const page_size = 2;
function get_gallery_page($page, $user) {
	$files = scandir(images_dir.'originals');
	$files = array_diff($files, array('.', '..'));

	$db = get_db();
	$query = [];
	// show if public, or private by logged in user
	if ($user === null) {
		$query = [
			'meta.availability' => 'public'
		];
	}
	else {
		$query = [
			'$or' => [
				['meta.availability' => 'public'],
				['meta.availability' => 'private', 'meta.author' => $user]
			]
		];
	}

	$opts = [
		'skip' => ($page - 1)*page_size,
		'limit' => page_size
	];
	
	$gallery = $db->screenshots->find($query, $opts);
	
	return $gallery;
}

function get_gallery() {
	$files = scandir(images_dir.'originals');
	$files = array_diff($files, array('.', '..'));

	$db = get_db();
	$query = [

	];
	$opts = [

	];
	$gallery = $db->screenshots->find($query, $opts);
	return $gallery;
}

function get_max_page() {
	$db = get_db();
	
	$gallery = $db->screenshots->find();
	$size = 0;
	foreach ($gallery as $entry) {
		$size++;
	}
	return ceil($size/page_size);
}

function save_image_metadata($saved_file_name, $username, $title, $availability) {
	$db = get_db();
	$meta = [
		'author' => $username,
		'title' => $title,
		'availability' => $availability,
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

function login_user($login, $password) {
	$associate_hash = get_user($login)['pwhash'];
	$user = get_user($login);

	if ($user === null) return Auth::NO_USER;
	if (password_verify($password, $associate_hash)) {
		return Auth::OK;
	}
	else {
		return Auth::WRONG_PW;
	}	
}

function register_user($login, $password, $email) {
	$db = get_db();

	$user = [
		'login' => $login,
		'email' => $email,
		'pwhash' => password_hash($password, hashing_algo)
	];

	$query = [
		'login' => $login
	];

	if ( $db->users->findOne($query) != null ) {
		return Auth::USER_EXISTS;
	}

	$db->users->insertOne($user);
	return Auth::OK;
}

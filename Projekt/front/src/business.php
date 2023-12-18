<?php

function receive_form() {
	$username = $_POST['username'];
	$watermark = $_POST['watermark'];
	$screenshot = $_FILES['screenshot'];

	$wrong_type = null;
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime_type = finfo_file($finfo, $screenshot['tmp_name']);
	if ($mime_type === 'image/jpg' || $mime_type === 'image/png') {
		$screenshot = $_FILES['screenshot'];
		$wrong_type = false;
	}	
	else $wrong_type = true;
	
	$too_big = ($screenshot['size'] > 1000000);

	if ($wrong_type && $too_big)  return validation::WRONG_EXT_AND_SIZE;
	if ($wrong_type && !$too_big) return validation::WRONG_EXT;
	if ($too_big && !$wrong_type) return validation::TOO_BIG;
	
	save_screenshot($screenshot, $username);
	save_watermark($screenshot, $username, $watermark);
	save_thumbnail($screenshot, $username, $watermark);
	
	return validation::OK;
}

const images_dir = '/var/www/dev/src/web/images/'; 

function save_screenshot($screenshot, $username) {
	$file_name = basename($screenshot['name']);
	$target = images_dir.'originals/'.$username.'-'.$file_name;
	$tmp_path = $screenshot['tmp_name'];

	if(!move_uploaded_file($tmp_path, $target)) echo 'internal upload error';
}

function save_watermark($screenshot, $username, $watermark) {
	$file_name = basename($screenshot['name']);
	$target = images_dir.'watermarks/'.'watermark_'.$username.'-'.$file_name;
	$tmp_path = $screenshot['tmp_name'];

	if(!move_uploaded_file($tmp_path, $target)) echo 'internal upload error';
}

function save_thumbnail($screenshot, $username, $watermark) {
	$file_name = basename($screenshot['name']);
	$target = images_dir.'thumbnails/'.'thumb_'.$username.'_'.$file_name;
	$tmp_path = $screenshot['tmp_name'];

	if(!move_uploaded_file($tmp_path, $target)) echo 'internal upload error';
}

function get_gallery() {
	$files = scandir(images_dir.'originals');
	$files = array_diff(scandir(images_dir.'originals'), array('.', '..'));

	return $files;
}
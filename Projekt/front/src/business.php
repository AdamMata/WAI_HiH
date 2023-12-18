<?php

function receive_form() {
	$username = $_POST['username'];
	$watermark = $_POST['watermark'];
	$screenshot = $_FILES['screenshot'];

	$wrong_type = null;
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime_type = finfo_file($finfo, $screenshot['tmp_name']);
	if ($mime_type === 'image/jpeg') {
		$screenshot = $_FILES['screenshot'];
		$wrong_type = false;
	}	
	else $wrong_type = true;
	
	$too_big = ($screenshot['size'] > 1000000);

	if ($wrong_type && $too_big)  return validation::WRONG_EXT_AND_SIZE;
	if ($wrong_type && !$too_big) return validation::WRONG_EXT;
	if ($too_big && !$wrong_type) return validation::TOO_BIG;
	
	save_screenshot($screenshot, $username);
	
	return validation::OK;
}

const gallery_dir = '/var/www/dev/src/images/'; 

function save_screenshot($screenshot, $username) {
	$file_name = basename($screenshot['name']);
	$target = gallery_dir.$username.'_'.$file_name;
	$tmp_path = $screenshot['tmp_name'];

	if(!move_uploaded_file($tmp_path, $target))
		echo 'internal upload error';
}

function get_gallery() {
	$files = scandir(gallery_dir);
	$files = array_diff(scandir(gallery_dir), array('.', '..'));
	return $files;
}
<?php

const thumbnail_w = 200;
const thumbnail_h = 125;

const images_dir = '/var/www/dev/src/web/images/';

const originals_dir = images_dir.'originals/';
const thumbnails_dir = images_dir.'thumbnails/';
const watermarks_dir = images_dir.'watermarks/';

function receive_form() {
	$username = $_POST['username'];
	$watermark = $_POST['watermark'];
	$screenshot = $_FILES['screenshot'];

	$wrong_type = null;
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime_type = finfo_file($finfo, $screenshot['tmp_name']);
	$extension = substr($mime_type, 6); // 'image/...'
	if ($extension === 'jpeg' || $extension === 'png') {
		$screenshot = $_FILES['screenshot'];
		$wrong_type = false;
	}	
	else $wrong_type = true;

	$too_big = ($screenshot['size'] > 1000000);

	if ($wrong_type && $too_big)  return Validation::WRONG_EXT_AND_SIZE;
	if ($wrong_type && !$too_big) return Validation::WRONG_EXT;
	if ($too_big && !$wrong_type) return Validation::TOO_BIG;

	$GD_original = null;
	if ($extension === 'jpeg') $GD_original = imagecreatefromjpeg($screenshot['tmp_name']);
	if ($extension === 'png') $GD_original = imagecreatefrompng($screenshot['tmp_name']);

	if ($GD_original == null) throw new Exception('Image wasnt created');

	$original_w = imagesx($GD_original);
	$original_h = imagesy($GD_original);

	$GD_watermark = imagecreatetruecolor($original_w, $original_h);
	imagecopy($GD_watermark, $GD_original, 0,0, 0,0, $original_w,$original_h);
	imagestring($GD_watermark, 5, $original_w/2, $original_h/2, $watermark, 888888);
	
	$GD_thumbnail = imagecreatetruecolor(thumbnail_w, thumbnail_h);
	imagecopyresized($GD_thumbnail, $GD_watermark, 0,0, 0,0, thumbnail_w,thumbnail_h, $original_w,$original_h);
	
	$file_name = basename($screenshot['name']);
	$target_file_name = $username.'-'.$file_name;
	$tmp_path = $screenshot['tmp_name'];

	imagepng($GD_original, originals_dir.$target_file_name);
	imagepng($GD_watermark, watermarks_dir.$target_file_name);
	imagepng($GD_thumbnail, thumbnails_dir.$target_file_name);
	
	return Validation::OK;
}

function get_gallery() {
	$files = scandir(images_dir.'originals');
	$files = array_diff(scandir(images_dir.'originals'), array('.', '..'));

	return $files;
}
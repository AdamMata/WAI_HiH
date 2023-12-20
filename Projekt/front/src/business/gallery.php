<?php

const thumbnail_w = 200;
const thumbnail_h = 125;

const images_dir = '/var/www/dev/src/web/images/';

const originals_dir = images_dir.'originals/';
const thumbnails_dir = images_dir.'thumbnails/';
const watermarks_dir = images_dir.'watermarks/';

function save_images($screenshot, $username, $watermark) {
	$extension = get_extension($screenshot);

	$GD_original = null;
	if ($extension === 'jpeg') $GD_original = imagecreatefromjpeg($screenshot['tmp_name']);
	if ($extension === 'png') $GD_original = imagecreatefrompng($screenshot['tmp_name']);

	if ($GD_original == null) throw new Exception('Image wasnt created');

	$GD_watermark = create_watermark($GD_original, $watermark);
	$GD_thumbnail = create_thumbnail($GD_original, $GD_watermark);
	
	$file_name = basename($screenshot['name']);
	$target_file_name = $username.'-'.$file_name;

	imagepng($GD_original, originals_dir.$target_file_name);
	imagepng($GD_watermark, watermarks_dir.$target_file_name);
	imagepng($GD_thumbnail, thumbnails_dir.$target_file_name);

	return $target_file_name;
}

function check_extension($screenshot, $extension) {
	return (
		$extension === 'jpeg' || 
		$extension === 'png'
	);
}

function get_extension($screenshot) {
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime_type = finfo_file($finfo, $screenshot['tmp_name']);
	$extension = substr($mime_type, 6); // 'image/...'
	return $extension;
}

function create_watermark($GD_original, $watermark) {
	$original_w = imagesx($GD_original);
	$original_h = imagesy($GD_original);

	$GD_watermark = imagecreatetruecolor($original_w, $original_h);
	imagecopy($GD_watermark, $GD_original, 0,0, 0,0, $original_w,$original_h);
	imagettftext(
		$GD_watermark, 30, 0, 
		$original_w/4,$original_h/2, 
		imagecolorallocate($GD_watermark, 200, 200, 200),
		'../assets/comicz.ttf', 
		$watermark
	);

	return $GD_watermark;
}

function create_thumbnail($GD_original, $GD_watermark) {
	$original_w = imagesx($GD_original);
	$original_h = imagesy($GD_original);
	
	$GD_thumbnail = imagecreatetruecolor(thumbnail_w, thumbnail_h);
	imagecopyresized($GD_thumbnail, $GD_watermark, 0,0, 0,0, thumbnail_w,thumbnail_h, $original_w,$original_h);

	return $GD_thumbnail;
}
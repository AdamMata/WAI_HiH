<?php

require_once 'gallery.php';

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

	save_images($screenshot, $username, $watermark);

	return Validation::OK;
}

function get_gallery() {
	$files = scandir(images_dir.'originals');
	$files = array_diff(scandir(images_dir.'originals'), array('.', '..'));

	return $files;
}
<?php

function save_screenshot($screenshot, $username) {
	$upload_dir = '/var/www/dev/src/images/';

	$file_name = basename($screenshot['name']);
	$target = $upload_dir.$username.'_'.$file_name;
	$tmp_path = $screenshot['tmp_name'];

	if(!move_uploaded_file($tmp_path, $target))
		echo 'internal upload error';

}
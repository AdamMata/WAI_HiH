<?php

require_once 'controllers.php';

const ROUTING = [
	"/"=> "index",
	"/collection"=> "collection",
	"/account"=> "account",
	"/forum"=> "forum",
	"/register"=> "register"
];

function dispatch($action) {
	$controller_fn = ROUTING[$action];
	$model = [];
	$view = $controller_fn($model);

	if (strpos($view, 'redirect:') !== 0){
		render($view, $model);
	} else {
		$url = substr($view, strlen('redirect:'));
		header('Location: '.$url);
		exit;
	}
}

function render($view, $model) {
	extract($model);
	if ($view != '') require 'views/'.$view.'.php';
}
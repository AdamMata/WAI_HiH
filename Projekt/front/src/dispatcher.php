<?php

require_once 'controllers.php';

const ROUTING = [
	"/"=> "index",
	"/collection"=> "collection",
	"/account"=> "account",
	"/forum"=> "forum"
];

function dispatch($action) {
	$controller_fn = ROUTING[$action];
	$model = [];
	$view = $controller_fn($model); // populate model using controller_fn function

	if (strpos($view, 'redirect:') !== 0){
		render($view, $model);
	} else {
		$url = substr($view, strlen('redirect:')); // redirect where?
		header('Location: '.$url);
		exit;
	}
}

function render($view, $model) {
	extract($model);
	if ($view != '') require 'views/'.$view.'.php';
} // TODO : understand wtf i am doing
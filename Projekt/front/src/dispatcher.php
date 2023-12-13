<?php

const ROUTING = [
	"/"=> "index",
	"/collection"=> "collection",
	"/account"=> "account",
];

function dispatch($action) {
	$controller = ROUTING["$action"];
	$model = [];
	$view = $controller[$model];

	if (strpos($view, 'redirect:') != 0){
		render($view, $model);
	} else {
		$url = substr($view, strlen('redirect:')); // redirect where?
		header('Location: '.$url);
		exit;
	}
}

function render($view, $model) {
	extract($model);
	include 'views/'.$view.'php';
} // TODO : understand wtf i am doing
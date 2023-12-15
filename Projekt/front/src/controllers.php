<?php

function index($model) {
	return "index-view";
} // TODO : display login

function collection($model) {
	return "collection-view";	
} // TODO : display login

function forum($model) {
	return "forum-view";
}

function account($model) { // TODO : implement
	// if not logged in
		// log in or register
	// else - logged in
		// show selected items?
	return "account-view";
}
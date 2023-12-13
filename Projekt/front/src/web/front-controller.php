<?php

require_once '../dispatcher.php';

session_start();

$action = $_GET['action'];
dispatch($ROUTING, $action);
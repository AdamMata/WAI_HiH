<?php

require_once '../dispatcher.php';

if (!isset($_SESSION)) session_start();

$action = $_GET['action'];
dispatch($action);
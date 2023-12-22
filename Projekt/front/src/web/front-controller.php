<?php

require_once '../dispatcher.php';

$action = $_GET['action'];
dispatch($action);
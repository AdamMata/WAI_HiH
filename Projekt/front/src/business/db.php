<?php

require '../vendor/autoload.php';

function get_db() {
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'wai_web',
        ]);

    $db = $mongo->wai;

    return $db;
}

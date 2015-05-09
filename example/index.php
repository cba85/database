<?php
require(dirname(__DIR__) . '/vendor/autoload.php');

use \Database\PDO\SQL as DB;

$sql = new DB('host', 'db', 'user', 'pass');

$results = $sql->select('SELECT * FROM users');
$test = $results->fetchObject();

var_dump($test);

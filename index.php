<?php
include 'inc/startup.php';

$dsn = "mysql:dbname=dev;host=127.0.0.1";
$dbuser = "root";
$dbpass = "pass";

$reg = new registration($dsn, $dbuser, $dbpass);

$query = $reg->query("SELECT * FROM guestbook LIMIT 1");
$result = $query->fetch(PDO::FETCH_OBJ);


echo "<pre>";
print_r($result);
echo "</pre>";
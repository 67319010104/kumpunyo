<?php // inc/config.php session_start(); define('DB_HOST', 'localhost'); define('DB_USER', 'root'); define('DB_PASS', ''); define('DB_NAME', 'online_store'); $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); if ($mysqli->connect_errno) {     die("Database connection failed: " . $mysqli->connect_error); } $site_name = "ร้านออนไลน์ตัวอย่าง"; $primary_color = "#800000"; // maroon ?><?php
// inc/config.php
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'online_store');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    die("Database connection failed: " . $mysqli->connect_error);
}
$site_name = "THANAWAT คอมพิวเตอร์";
$primary_color = "#800000"; // maroon
?>


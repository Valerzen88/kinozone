<?php
require 'vendor/autoload.php';
include('json2mysql/config.php');
include('json2mysql/include.classloader.php');
use GuzzleHttp\Client;

$classLoader = new ClassLoader();
try {
    $classLoader->addToClasspath(ROOT);
} catch (Exception $e) {
}
$mysql = new MySQLConn(DATABASE_HOST, "phpmyadmin", "root", "Valerka11$");

if($mysql) {
    echo "connection established";
}else{
    echo "connection refused";
}
echo "<br><br>";
$sql="DELETE FROM `phpmyadmin`.`pma__userconfig` WHERE username='root'";
$result = $mysql->query($sql);
var_dump($result);
if ($result) {
    while ($row = mysqli_fetch_row($result)) {
        var_dump($row);
    }
    mysqli_free_result($result);
}else{
    var_dump($result);
}
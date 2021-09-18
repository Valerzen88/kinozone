<?php

/*
 * todo:
 * GET infos about all films and serials from kinoposik
 * and add it to the films table in the db
 * create loop over all possible film ids on kinopoisk
 * get response for existing ids
 * convert json to mysql statements
 * add information to mysql db
 */
require '../../../vendor/autoload.php';
require 'json2mysql/config.php';
require 'json2mysql/include.classloader.php';

use GuzzleHttp\Client;

$classLoader = new ClassLoader();
try {
    $classLoader->addToClasspath(ROOT);
} catch (Exception $e) {
}

$mysql = new MySQLConn(DATABASE_HOST, DATABASE_NAME, DATABASE_USER, DATABASE_PASS);

$db = new JSONtoMYSQL($mysql);

$client = new GuzzleHttp\Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://kinopoiskapiunofficial.tech/api/v2.2/films/',
    // You can set any number of default request options.
    'timeout'  => 2.0,
    'headers' => ['X-API-KEY' => 'da67006f-9505-4e51-a1ab-eb100c711635']
]);
$kinopoiskIds=array();
$sql="SELECT kinopoiskId FROM films where kinopoiskId between 1300000 and 1500000";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_row($result)) {
        array_push($kinopoiskIds, $row[0]);
    }
    mysqli_free_result($result);
}
for($i=1300000;$i<1500000;$i++) {
    if(!in_array($i,$kinopoiskIds)) {
        try {
            $response = $client->request('GET', (string)$i);
            if ($response->getStatusCode() == 200) {
                $obj = json_decode($response->getBody());
                $db->save($obj, "films");
            }
        } catch (\GuzzleHttp\Exception\GuzzleException | DatabaseException $e) {
        }
    }
}



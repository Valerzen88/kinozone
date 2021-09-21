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
include('json2mysql/config.php');
include('json2mysql/include.classloader.php');

use GuzzleHttp\Client;

$classLoader = new ClassLoader();
try {
    $classLoader->addToClasspath(ROOT);
} catch (Exception $e) {
}

$mysql = new MySQLConn(DATABASE_HOST, DATABASE_NAME, DATABASE_USER, DATABASE_PASS);

$db = new JSONtoMYSQL($mysql);

if(isset($_GET["addNewFilmsJob"])) {
    $lastId = 290;
    $time_pre = microtime(true);
    for($i=0;$i<$_GET["addNewFilmsJob"];$i++) {
        $sql = "SELECT MAX(kinopoiskId) FROM films";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            while ($row = mysqli_fetch_row($result)) {
                if ($row[0] != null) $lastId = $row[0];
            }
            mysqli_free_result($result);
        }
        $amount_ids = 10000;
        echo "+++starting job for films data with lastId=" . $lastId . ";step=".$amount_ids.";+++<br>";
        $lastId = addFilms($lastId, $amount_ids, $db, $conn);
        $time_post = microtime(true);
        $exec_time = $time_post - $time_pre;
        echo "<br>+++end job with " . $lastId . " new lines in ".sprintf('%f', $exec_time)." +++<br>";
    }
}

function addFilms($startId,$amount_ids,$db,$conn){
    $client = new GuzzleHttp\Client([
        // Base URI is used with relative requests
        'base_uri' => 'https://kinopoiskapiunofficial.tech/api/v2.2/films/',
        // You can set any number of default request options.
        'timeout'  => 2.0,
        'headers' => ['X-API-KEY' => 'da67006f-9505-4e51-a1ab-eb100c711635']
    ]);
    $kinopoiskIds = array();
    $sql = "SELECT kinopoiskId FROM films where kinopoiskId between ".$startId." and ".$amount_ids;
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($kinopoiskIds, $row[0]);
        }
    }
    $finished=false;
    for ($i = $startId+1; $i < $startId+$amount_ids; $i++) {
        if (!in_array($i, $kinopoiskIds)) {
            try {
                $response = $client->request('GET', (string)$i);
                if ($response->getStatusCode() == 200) {
                    $obj = json_decode($response->getBody());
                    $db->save($obj, "films");
                }
            } catch (\GuzzleHttp\Exception\GuzzleException | DatabaseException $e) {
            }
        }
        if($i===$startId+$amount_ids-1){$finished=true;}
    }
    $new_last_id=0;
    $sql = "SELECT MAX(kinopoiskId) FROM films";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_row($result)) {
            $new_last_id=$row[0];
        }
        mysqli_free_result($result);
    }
    if($finished){return $new_last_id;}else{return"0";}
}

if(isset($_GET['addFilmStaff'])) {
    $lastId = 1;
    $time_pre = microtime(true);
    for ($i = 0; $i < $_GET["addFilmStaff"]; $i++) {
        $sql = "SELECT MAX(kinopoiskId) FROM staff";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            while ($row = mysqli_fetch_row($result)) {
                if ($row[0] != null) $lastId = $row[0];
            }
            mysqli_free_result($result);
        }
        $amount_ids = 100;
        echo "+++starting job for staff with lastId=" . $lastId . ";step=" . $amount_ids . ";+++<br>";
        $lastId = addStaff($lastId, $amount_ids, $db, $conn);
        $time_post = microtime(true);
        $exec_time = $time_post - $time_pre;
        echo "<br>+++end job with " . $lastId . " new lines in " . sprintf('%f', $exec_time) . " +++<br>";
    }
}

function addStaff($startId,$amount_ids,$db,$conn){
    $client = new GuzzleHttp\Client([
        // Base URI is used with relative requests
        'base_uri' => 'https://kinopoiskapiunofficial.tech/api/v1/staff/',
        // You can set any number of default request options.
        'timeout'  => 2.0,
        'headers' => ['X-API-KEY' => 'da67006f-9505-4e51-a1ab-eb100c711635']
    ]);
    $kinopoiskIds = array();
    $sql = "SELECT kinopoiskId FROM films where kinopoiskId between ".$startId." and ".$amount_ids;
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($kinopoiskIds, $row[0]);
        }
    }
    $finished=false;
    for ($i = $startId+1; $i < $startId+$amount_ids; $i++) {
        if (!in_array($i, $kinopoiskIds)) {
            try {
                $response = $client->request('GET', (string)$i);
                if ($response->getStatusCode() == 200) {
                    $obj = json_decode($response->getBody());
                    $db->save($obj, "staff");
                }
            } catch (\GuzzleHttp\Exception\GuzzleException | DatabaseException $e) {
            }
        }
        if($i===$startId+$amount_ids-1){$finished=true;}
    }
    $new_last_id=0;
    $sql = "SELECT MAX(kinopoiskId) FROM films";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_row($result)) {
            $new_last_id=$row[0];
        }
        mysqli_free_result($result);
    }
    if($finished){return $new_last_id;}else{return"0";}
}



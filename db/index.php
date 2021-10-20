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
require 'vendor/autoload.php';
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
global $countEmptyLines;
$countEmptyLines= 0;

if(isset($_GET["addNewFilmsJob"])) {
    $lastId = 290;
    $time_pre = microtime(true);
    for($i=0;$i<$_GET["addNewFilmsJob"];$i++) {
        $sql = "SELECT MAX(kinopoiskId) FROM films where kinopoiskId>1200000";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            while ($row = mysqli_fetch_row($result)) {
                if ($row[0] != null) $lastId = $row[0];
            }
            mysqli_free_result($result);
        }
        $amount_ids = $_GET["step"] ?? 100;
        if(isset($_GET["startId"])){$lastId=$_GET["startId"];}
        echo "+++starting job for films data with lastId=" . $lastId . ";step=".$amount_ids.";+++<br>";
        $newlastId = addFilms($lastId, $amount_ids, $db, $conn);
        $time_post = microtime(true);
        $exec_time = $time_post - $time_pre;
        if(isset($_GET["startId"])){$lastId=$_GET["startId"]+$amount_ids;}
        echo "<br>+++end job with " . $newlastId . " lines in ".sprintf('%f', $exec_time)." +++<br>";
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
    $sql = "SELECT kinopoiskId FROM films where kinopoiskId between ".$startId." and ".intval($startId+$amount_ids);
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
                $temp="Client error: `GET https://kinopoiskapiunofficial.tech/api/v2.2/films/".$i."` resulted in a `404 Not Found`";
                if(strpos($e,$temp)) {
                    echo "got error on GET request => " . $temp . "<br>";
                    $countEmptyLines++;
                }
            }
        }
        if($i===$startId+$amount_ids-1){$finished=true;}
    }
    $new_last_id=0;
    $sql = "SELECT MAX(kinopoiskId) FROM films where kinopoiskId>1200000";
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
        $sql = "SELECT MAX(personId) FROM staff";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            while ($row = mysqli_fetch_row($result)) {
                if ($row[0] != null) $lastId = $row[0];
            }
            mysqli_free_result($result);
        }
        $amount_ids = $_GET["step"] ?? 100;
        if(isset($_GET["startId"])){$lastId=$_GET["startId"];}
        echo "+++starting job for staff with lastId=" . $lastId . ";step=" . $amount_ids . ";+++<br>";
        $newlastId = addStaff($lastId, $amount_ids, $db, $conn);
        $time_post = microtime(true);
        $exec_time = $time_post - $time_pre;
        echo "<br>+++end job with " . $newlastId . " lines in " . sprintf('%f', $exec_time) . " +++<br>";
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
    $personIds = array();
    $sql = "SELECT personId FROM staff where persondId between ".$startId." and ".intval($startId+$amount_ids);
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($personIds, $row[0]);
        }
    }
    $finished=false;
    for ($i = $startId+1; $i < $startId+$amount_ids; $i++) {
        if (!in_array($i, $personIds)) {
            try {
                $response = $client->request('GET', (string)$i);
                if ($response->getStatusCode() == 200) {
                    $obj = json_decode($response->getBody());
                    $db->save($obj, "staff");
                }
            } catch (\GuzzleHttp\Exception\GuzzleException | DatabaseException $e) {
                $temp="Client error: `GET https://kinopoiskapiunofficial.tech/api/v1/staff/".$i."` resulted in a `404 Not Found`";
                if(strpos($e,$temp)) {
                    echo "got error on GET request => " . $temp . "<br>";
                    $countEmptyLines++;
                }
            }
        }
        if($i===$startId+$amount_ids-1){$finished=true;}
    }
    $new_last_id=0;
    $sql = "SELECT MAX(personId) FROM staff";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_row($result)) {
            $new_last_id=$row[0];
        }
        mysqli_free_result($result);
    }
    if($finished){return $new_last_id;}else{return"0";}
}

if(isset($_GET["addTops"])) {
    $time_pre = microtime(true);
    echo "+++starting job for tops data +++<br>";
    $newlastId = addTops($conn);
    $time_post = microtime(true);
    $exec_time = $time_post - $time_pre;
    echo "<br>+++end job in ".sprintf('%f', $exec_time)." +++<br>";
}
function addTops($conn){
    $tops_name_arr = array(0 =>"TOP_250_BEST_FILMS",1=>"TOP_100_POPULAR_FILMS",2=>"TOP_AWAIT_FILMS");
    $client = new GuzzleHttp\Client([
        'base_uri' => 'https://kinopoiskapiunofficial.tech/api/v2.2/films/top',
        'timeout'  => 5.0,
        'headers' => ['X-API-KEY' => 'da67006f-9505-4e51-a1ab-eb100c711635']
    ]);
    $sql = "";
    $columns = "";
    for($t=0;$t<count($tops_name_arr);$t++) {
        $tops_name=$tops_name_arr[$t];
        $pagesCount=0;
        $tops_arr=array();
        try {
            $response = $client->request('GET', '?type=' . $tops_name . '&page=1');
            if ($response->getStatusCode() == 200) {
                $obj = json_decode($response->getBody());
                $pagesCount = get_object_vars($obj)['pagesCount'];
                echo "pagesCount=".$pagesCount." for type=".$tops_name."<br>";
            }
        } catch (\GuzzleHttp\Exception\GuzzleException | DatabaseException $e) {

        }

        for ($i = 1; $i <= $pagesCount; $i++) {
            $response = $client->request('GET', '?type=' . $tops_name . '&page=' . $i);
            if ($response->getStatusCode() == 200) {
                $obj = json_decode($response->getBody());
                $tops_arr[$i] = get_object_vars($obj);
            }
        }

        for ($d = 1; $d <= count($tops_arr); $d++) {
            for ($e = 0; $e < count($tops_arr[$d]['films']); $e++) {
                $curr_line = get_object_vars($tops_arr[$d]['films'][$e]);
                $columns = implode(", ", array_keys($curr_line));
                foreach ($curr_line as $k => $v) {
                    if (is_array($v)) {
                        $s = "";
                        for ($c = 0; $c < count($v); $c++) {
                            $temp = get_object_vars($v[$c]);
                            foreach ($temp as $k1 => $v1) {
                                $s .= mysqli_real_escape_string($conn, $v1 . ", ");
                            }
                        }
                        $curr_line[$k] = "'" . substr($s, 0, -2) . "'";
                    } else {
                        if ($k == "rating"&&strpos($v,"%")!=false) {
                            $v = str_ireplace("%", "", $v) / 10;
                        }
                        if (is_numeric($v)) {
                            $curr_line[$k] = $v;
                        } elseif (is_string($v)) {
                            $curr_line[$k] = "'" . mysqli_real_escape_string($conn, $v) . "'";
                        } elseif (is_bool($v)) {
                            $curr_line[$k] = (int)$v;
                        } elseif (is_null($v)) {
                            $curr_line[$k] = "NULL";
                        } else {
                            $curr_line[$k] = mysqli_real_escape_string($conn, $v);
                        }
                    }
                }
                $curr_line['top_type'] = array_search($tops_name, $tops_name_arr);
                $values = implode(", ", array_values($curr_line));
                if (count($tops_arr[$d]['films']) !== $e + 1) {
                    $sql .= "(" . $values . "),";
                } else {
                    $sql .= "(" . $values . ")";
                }
            }
            if (count($tops_arr) !== $d) {
                $sql .= ",";
            }
        }
        $sql .= ",";
    }
    $sql_0 = "DROP TABLE IF EXISTS tops;".
        "CREATE TABLE IF NOT EXISTS tops ("
        . "`id` SMALLINT NOT NULL auto_increment,"
        . "`filmId` MEDIUMINT NOT NULL,"
        . "`nameRu` TEXT NULL,"
        . "`nameEn` TEXT NULL,"
        . " `year` SMALLINT NOT NULL,"
        . " `filmLength` TEXT NOT NULL,"
        . " `countries` TEXT NOT NULL,"
        . " `genres` TEXT NOT NULL,"
        . " `rating` DOUBLE NOT NULL,"
        . " `ratingVoteCount` MEDIUMINT NOT NULL,"
        . " `posterUrl` TEXT NOT NULL,"
        . " `posterUrlPreview` TEXT NOT NULL,"
        . " `ratingChange` TEXT NULL,"
        . " `top_type` TINYINT NOT NULL,"
        . " PRIMARY KEY (`id`)"
        . ") ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
    $sql_1 = "INSERT INTO tops (".$columns.", top_type) VALUES ";
    echo $sql_0."<br>".$sql_1.substr($sql,0,-1);
    $sql_f = $sql_0.$sql_1.substr($sql,0,-1);
    $result = mysqli_query($conn, $sql_f);
    if ($result) {
        return $result;
    } else {
        return false;
    }
}
<?php
/**
 * Licensed under Creative Commons 3.0 Attribution
 * Copyright Adam Wulf 2013
 */

define("ROOT", dirname(__FILE__) . "/");
const DATABASE_HOST = "127.0.0.1:3306";
const DATABASE_NAME = "kinozone";
const DATABASE_USER = "kinozone_usr";
const DATABASE_PASS = "root";
const JSONTOMYSQL_LOCKED = false;

// Create connection
$conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$res=mysqli_select_db($conn,DATABASE_NAME);
if (!$res) {
  die("Connection failed: " . mysqli_connect_error());
}

function convertToHoursMins($time, $format = '%02d:%02d') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'год',
        'm' => 'месяц',
        'w' => 'недел',
        'd' => 'день',
        'h' => 'час',
        'i' => 'минута',
        's' => 'секунда',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            if($v==='год') {
                $v = $diff->$k . ' ' . ($diff->$k > 1 & $diff->$k < 5 ? $v . 'а' : ($diff->$k > 4 ? 'лет' : $v));
            }
            if($v==='месяц') {
                $v = $diff->$k . ' ' . ($diff->$k > 1 & $diff->$k < 5 ? $v . 'а' : ($diff->$k > 4 ? $v . 'ев' : $v));
            }
            if($v==='недел') {
                $v = $diff->$k . ' ' . ($diff->$k > 1 & $diff->$k < 5 ? $v . 'и' : ($diff->$k > 4 ? $v .'ь' : $v .'я'));
            }
            if($v==='день') {
                $v = $diff->$k . ' ' . ($diff->$k > 1 & $diff->$k < 5 ? 'дня' : ($diff->$k > 4 ? 'дней' : $v));
            }
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' назад' : 'только что';
}

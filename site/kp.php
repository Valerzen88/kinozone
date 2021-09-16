<?php

//test of the kinopoisk api
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://api.kinopoisk.cf/getFilm?filmID=448");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

$response = curl_exec($ch);
curl_close($ch);

var_dump($response);

?>
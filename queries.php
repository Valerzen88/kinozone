<?php
$films_amount_2021=array();
$films_amount_2020=array();
$films_amount_2019=array();
$sql="SELECT count(kinopoiskId) FROM films where year=2021 and nameRu IS NOT NULL";
$result=mysqli_query($conn,$sql);
if($result) {
  while ($row = mysqli_fetch_row($result)) {
	  array_push($films_amount_2021,$row);
  }
  mysqli_free_result($result);
}
$sql="SELECT count(kinopoiskId) FROM films where year=2020 and nameRu IS NOT NULL";
$result=mysqli_query($conn,$sql);
if($result) {
  while ($row = mysqli_fetch_row($result)) {
	  array_push($films_amount_2020,$row);
  }
  mysqli_free_result($result);
}
$sql="SELECT count(kinopoiskId) FROM films where year=2019 and nameRu IS NOT NULL";
$result=mysqli_query($conn,$sql);
if($result) {
  while ($row = mysqli_fetch_row($result)) {
	  array_push($films_amount_2019,$row);
  }
  mysqli_free_result($result);
}

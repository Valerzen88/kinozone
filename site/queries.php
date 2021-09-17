<?php
$films_amount=array();
$sql="SELECT count(kinopoiskId) FROM films where year=2021";
$result=mysqli_query($conn,$sql);
if($result) {
  while ($row = mysqli_fetch_row($result)) {
	  array_push($films_amount,$row);
  }
  mysqli_free_result($result);
}
$sql="SELECT count(kinopoiskId) FROM films where year=2020";
$result=mysqli_query($conn,$sql);
if($result) {
  while ($row = mysqli_fetch_row($result)) {
	  array_push($films_amount,$row);
  }
  mysqli_free_result($result);
}
$sql="SELECT count(kinopoiskId) FROM films where year=2019";
$result=mysqli_query($conn,$sql);
if($result) {
  while ($row = mysqli_fetch_row($result)) {
	  array_push($films_amount,$row);
  }
  mysqli_free_result($result);
}
?>
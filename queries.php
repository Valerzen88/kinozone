<?php
if(isset($conn)) {
    $films_amount_2021=array();
    $films_amount_2020=array();
    $films_amount_2019=array();
    $sql = "SELECT film_amount FROM years_count where year=2021";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($films_amount_2021, $row);
        }
        mysqli_free_result($result);
    }
    $sql = "SELECT film_amount FROM years_count where year=2020";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($films_amount_2020, $row);
        }
        mysqli_free_result($result);
    }
    $sql = "SELECT film_amount FROM years_count where year=2019";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($films_amount_2019, $row);
        }
        mysqli_free_result($result);
    }
}
if(isset($_POST["livesearch"])){
    include_once("config.php");
    include_once("switcher.php");
    $s = "'%".$_POST["livesearch"]."%'";
    $s_to_cyr = "'%".Switcher::toCyrillic($_POST["livesearch"])."%'";
    $s_from_cyr = "'%".Switcher::fromCyrillic($_POST["livesearch"])."%'";
    $sql = "SELECT nameRu,kinopoiskId,year FROM films WHERE year like ".$s." or nameRu like ".$s_to_cyr." or nameOriginal like "
        .$s_from_cyr." or kinopoiskId like ".$s." order by kinopoiskId limit 3";
    $result=mysqli_query($conn,$sql);
    if($result) {
        if(mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "<a href='video-page.php?filmId=" . $row["kinopoiskId"] . "'><p style='background-color: #000;'>" . $row["nameRu"] . "(" . $row["year"] . ")</p></a>";
            }
        }else{
            echo "<p>Ничего не смогли найти...</p>";
        }
        mysqli_free_result($result);
        mysqli_close($conn);
    }
}
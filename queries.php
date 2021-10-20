<?php
if(isset($conn)) {
    $films_y_amount=array();
    $sql = "SELECT year,film_amount FROM years_count where year>2018";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_row($result)) {
		$films_y_amount[$row[0]]=$row[1];
        }
        mysqli_free_result($result);
    }
}
if(isset($_POST["livesearch"])){
   /* include_once("config.php");
    include_once("switcher.php");
    $s = "'%".$_POST["livesearch"]."%'";
    $s_to_cyr = "'%".Switcher::toCyrillic($_POST["livesearch"])."%'";
    $s_from_cyr = "'%".Switcher::fromCyrillic($_POST["livesearch"])."%'";
    $sql = "SELECT nameRu,kinopoiskId,year FROM films WHERE (year like ".$s." or nameRu like ".$s_to_cyr." or nameOriginal like "
        .$s_from_cyr." or kinopoiskId like ".$s.") and nameRu is not null order by year desc limit 5";
    $result=mysqli_query($conn,$sql);
    if($result) {
        if(mysqli_num_rows($result)>0 ) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "<a href='video-page.php?filmId=" . $row["kinopoiskId"] . "'><p style='background-color: #000;'>" . $row["nameRu"] . "(" . $row["year"] . ")</p></a>";
            }
        }else{
            echo "<p>Ничего не смогли найти...</p>";
        }
        mysqli_free_result($result);
        mysqli_close($conn);
    }*/
}
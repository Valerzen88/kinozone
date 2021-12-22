<?php
include_once("header.php");
$persons=array();
$filmografie=array();
$sql = "SELECT * FROM kinozone.staff where personId=".$_GET['q'];
$result = mysqli_query($conn, $sql);
if ($result) {
    if (mysqli_num_rows($result)===1) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($persons, $row);
        }
        mysqli_free_result($result);
    }
    $sql = "SELECT * FROM kinozone.films where kinopoiskId IN (".$persons[0][16].") order by year desc";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 1) {
            while ($row = mysqli_fetch_row($result)) {
                array_push($filmografie, $row);
            }
            mysqli_free_result($result);
        }
    }
}
?>
    <div class="video-block section-padding">
        <div class="row">
            <div class="col-md-12">
                <div class="main-title">
                    <h6>Персона</h6>
                </div>
            </div>
            <?php
            foreach ($persons as $k => $v) {
                echo "<div class='col-md-12'>
                        <div class='row'>
                            <div class='col-md-3'>
                                <div class=\"channels-card\">
                                    <div class=\"channels-card-image\">
                                        <a href=\"person.php?q=" . $v[1] . "\">
                                            <img class=\"img-fluid\" src=\"".$v[6]."\" title=\"" . mb_strtoupper($v[3]) . "\" alt=\"" . mb_strtoupper($v[3]) . "\">
                                            <h6 title='".$v[3]."'>".$v[3]."<br>";
                                            if($v[4]!=null) {echo "(".$v[4].")";}
                                            echo "</h6>                            
                                        </a>
                                    </div>
                                </div>
                            </div>
                             <div class='col-md-9'>
                                <div class=\"channels-card\" style='padding-left: 15px;'>
                                   <p style='text-align: left;font-size: larger'><b>Краткие данные</b></p>
                                   <p style='text-align: left;'><b>Имя:</b> ".$v[3]."</p>";
                                    if($v[8]!=null) {
                                        echo "<p style='text-align: left;'><b>Дата рождения:</b> " . date_format(date_create($v[8]),"d.m.Y") . "</p>";
                                    }
                                    if($v[11]!=null) {
                                        echo "<p style='text-align: left;'><b>Место рождения:</b> " . $v[11] . "</p>";
                                    }
                                    if($v[9]!=null) {
                                        echo "<p style='text-align: left;'><b>Дата смерти:</b> " .date_format(date_create($v[9]),"d.m.Y") . "</p>";
                                    }
                                    if($v[12]!=null) {
                                        echo "<p style='text-align: left;'><b>Место смерти:</b> " . $v[12] . "</p>";
                                    }
                                    if($v[10]!=0) {
                                        echo "<p style='text-align: left;'><b>Возраст:</b> " . $v[10] . "</p>";
                                    }
                                    if($v[7]!=0) {
                                        echo "<p style='text-align: left;'><b>Рост:</b> " . $v[7] . "</p>";
                                    }
                                    if($v[5]!=null) {
                                        if($v[5]==="MALE") {
                                            echo "<p style='text-align: left;'><b>Пол:</b>&nbsp;мужской</p>";
                                        }
                                        if($v[5]==="FEMALE") {
                                            echo "<p style='text-align: left;'><b>Пол:</b>&nbsp;женский</p>";
                                        }
                                    }
                                    if($v[13]!=null) {
                                        $relatives=array();
                                        $sql="SELECT personId,nameRu FROM staff where personId IN (".$v[13].")";
                                        $result = mysqli_query($conn, $sql);
                                        if ($result) {
                                            if (mysqli_num_rows($result)===1) {
                                                while ($row = mysqli_fetch_row($result)) {
                                                    array_push($relatives, $row);
                                                }
                                                mysqli_free_result($result);
                                            }
                                            echo "<p style='text-align: left;'><b>Родственники:</b>&nbsp;";
                                            for($i=0;$i<count($relatives);$i++){
                                                if($i+1<count($relatives)) {
                                                    echo "<a href='person.php?q=" . $relatives[$i][0] . "'>" . $relatives[$i][1] . "</a>, \n";
                                                }else{
                                                    echo "<a href='person.php?q=" . $relatives[$i][0] . "'>" . $relatives[$i][1] . "</a>\n";
                                                }
                                            }
                                            echo "</p>\n";
                                        }
                                    }
                                    if($v[14]!=0) {
                                        echo "<p style='text-align: left;'><b>Награды:</b> " . $v[14] . "</p>\n";
                                    }
                                    if($v[15]!=null) {
                                        echo "<p style='text-align: left;'><b>Профессия:</b> " . $v[15] . "</p>\n";
                                    }
                                echo "</div>
                             </div>
                             </div>    
                             <hr>                                                      
                              <div class='row'>
                                  <div class='col-md-3'></div>
                                  <div class='col-md-9'>
                                    <div class=\"channels-card\" style='padding-left: 15px;text-align: left;'>
                                       <p style='font-size: larger;padding-left: 15px;'><b>Фильмография</b></p>";
                                    foreach ($filmografie as $k1 => $v1) {
                                        echo ($k1+1). ". <a style='text-align: left;padding-left: 15px;' href='video-page.php?filmId=".$v1[1]."'>"
                                            . $v1[3] . " (".$v1[5]."/".$v1[4].") - ".$v1[22]."</a><br>";
                                    }
                                    echo "</div>
                                 </div>
                             </div>
                             <hr>
                             </div>
                         </div>
                     </div>";
            } ?>
        </div>
    </div>
    <hr>
    </div>
    <!-- /.container-fluid -->
<?php include_once("footer.php");?>
<?php
include_once("header.php");
require 'db/vendor/autoload.php';
include('db/json2mysql/include.classloader.php');
use GuzzleHttp\Client;
$premiers_this_month=array();
$client_4 = new GuzzleHttp\Client([
    'base_uri' => 'https://kinopoiskapiunofficial.tech/api/v2.2/films/premieres',
    'timeout'  => 1.0,
    'headers' => ['X-API-KEY' => 'da67006f-9505-4e51-a1ab-eb100c711635']
]);
$get_str="";
if(isset($_GET['p_year'])&&isset($_GET['p_month'])){
    $get_str = "?year=".$_GET['p_year']."&month=".$_GET['p_month'];
} else {
    $year_last_month = date('Y', strtotime("last month"));
    $last_month = strtoupper(date('F', strtotime("last month")));
    $_GET['p_year']=$year_last_month; $_GET['p_month']=$last_month;
    $get_str = "?year=".$year_last_month."&month=".$last_month;
}
$premiers_this_month_res=array();
try {
    $response = $client_4->request('GET', $get_str);
    if ($response->getStatusCode() == 200) {
        $obj = json_decode($response->getBody());
        $arr = get_object_vars($obj)['items'];
        for ($i = 0; $i < count($arr); $i++) {
            $premiers_this_month[$i] = get_object_vars($arr[$i])['kinopoiskId'];
        }
        $sql = "SELECT * FROM films where year=" . $_GET['p_year'] . " and kinopoiskId IN(" . implode(",", $premiers_this_month) . ")";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            while ($row = mysqli_fetch_row($result)) {
                array_push($premiers_this_month_res, $row);
            }
            mysqli_free_result($result);
        }
    }
} catch (\GuzzleHttp\Exception\GuzzleException | DatabaseException $e) {}

?>
            <div class="top-category mb-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">
                            <h6>Категории</h6>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="owl-carousel owl-carousel-category">
                            <?php
                            foreach ($genres as $k => $v) {
                                echo "<div class=\"item\">
									<div class=\"category-item\">
										<a href=\"videos_list.php?genre=" . $v[0] . "\">
											<img class=\"img-fluid\" src=\"img/genres/".$v[0].".png\" title=\"" . mb_strtoupper($v[0]) . "\" alt=\"" . mb_strtoupper($v[0]) . "\">
											<h6 title=\"" . mb_strtoupper($v[0]) . "\">" . mb_strtoupper($v[0]) . "</h6>
											<p>" . $v[1] . " фильмов</p>
										</a>
									</div>
								</div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
    <div class="video-block section-padding">
        <div class="row">
            <div class="col-md-12">
                <div class="main-title">
                    <h6>Премьеры по месяцам и годам</h6>
                    <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="get">
                        <select class="custom-select" name="p_year" onchange="this.form.submit();">
                            <?php
                            for($i=1;$i<count($years_arr);$i++) {
                                if($_GET['p_year']===$years_arr[$i]) {
                                    echo "<option selected value='" . $years_arr[$i] . "'>" . $years_arr[$i] . "</option>";
                                }else{
                                    echo "<option value='" . $years_arr[$i] . "'>" . $years_arr[$i] . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <select class="custom-select" name="p_month" onchange="this.form.submit();">
                            <option <?php if(isset($_GET['p_month'])&&$_GET['p_month']=="JANUARY"){echo "selected";}; ?> value="JANUARY">Январь</option>
                            <option <?php if(isset($_GET['p_month'])&&$_GET['p_month']=="FEBRUARY"){echo "selected";}; ?> value="FEBRUARY">Февраль</option>
                            <option <?php if(isset($_GET['p_month'])&&$_GET['p_month']=="MARCH"){echo "selected";}; ?> value="MARCH">Март</option>
                            <option <?php if(isset($_GET['p_month'])&&$_GET['p_month']=="APRIL"){echo "selected";}; ?> value="APRIL">Апрель</option>
                            <option <?php if(isset($_GET['p_month'])&&$_GET['p_month']=="MAY"){echo "selected";}; ?> value="MAY">Май</option>
                            <option <?php if(isset($_GET['p_month'])&&$_GET['p_month']=="JUNE"){echo "selected";}; ?> value="JUNE">Июнь</option>
                            <option <?php if(isset($_GET['p_month'])&&$_GET['p_month']=="JULY"){echo "selected";}; ?> value="JULY">Июль</option>
                            <option <?php if(isset($_GET['p_month'])&&$_GET['p_month']=="AUGUST"){echo "selected";}; ?> value="AUGUST">Август</option>
                            <option <?php if(isset($_GET['p_month'])&&$_GET['p_month']=="SEPTEMBER"){echo "selected";}; ?> value="SEPTEMBER">Сентябрь</option>
                            <option <?php if(isset($_GET['p_month'])&&$_GET['p_month']=="OCTOBER"){echo "selected";}; ?> value="OCTOBER">Октябрь</option>
                            <option <?php if(isset($_GET['p_month'])&&$_GET['p_month']=="NOVEMBER"){echo "selected";}; ?> value="NOVEMBER">Ноябрь</option>
                            <option <?php if(isset($_GET['p_month'])&&$_GET['p_month']=="DECEMBER"){echo "selected";}; ?> value="DECEMBER">Декабрь</option>
                        </select>
                    </form>
                    <br>
                </div>
            </div>
            <?php
            if(count($premiers_this_month_res)>0) {
                foreach ($premiers_this_month_res as $k => $v) {
                    if ($v[3] !== null) {
                        echo "<div class=\"col-xl-3 col-sm-6 mb-3\">
                                    <div class=\"channels-card\">";
                        if (stripos($v[34], "мультфильм")) {
                            echo "<div class=\"time\">Мультфильм</div>";
                        } elseif ($v[30] == "FILM") {
                            echo "<div class=\"time\">Фильм</div>";
                        } elseif ($v[30] == "TV_SERIES") {
                            echo "<div class=\"time\">Сериал</div>";
                        } elseif ($v[30] == "MINI_SERIES") {
                            echo "<div class=\"time\">Мини-сериал</div>";
                        }
                        echo "<div class=\"time\" style='margin-top:18px;'>".$v[22]."</div>";
                        echo "<div class=\"channels-card-image\">
                                    <a href=\"video-page.php?filmId=" . $v[1] . "\"><img class=\"img-fluid\" src=\"" . $v[7] . "\" alt=\"\"></a>
                                   <div class=\"channels-card-image-btn\"><button type=\"button\" onclick=\"window.location.href='video-page.php?filmId=" . $v[1] . "'\"
                                   class=\"btn btn-outline-secondary btn-sm\">" . $v[3] . "";
                        if ($v[11] > 0 || $v[13] > 0) {
                            echo "<span style='padding-left: 8px;'><i class=\"fas fa-star\"></i>&nbsp;";
                            if ($v[11] > 0) {
                                echo $v[11];
                            } elseif ($v[13] > 0) {
                                echo $v[13];
                            }
                            echo "</span>";
                        }
                        echo "</a></button></div>
                                           </div>
                                            <div class=\"channels-card-body\">                                  
                                             <div class=\"channels-view\">
                                             " . str_ireplace(",", ", ", $v[34]) . "
                                            </div>
                                            </div>
                                            </div>
                                        </div>";
                    }
                }
            }
            ?>
        </div>
    </div>
            <hr>
            <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">                     
                            <h6>Топ 48 фильмов 2021 года</h6>
                        </div>
                    </div>
                    <?php
                    if(isset($top_20_films)){
                        foreach ($top_20_films as $k => $v) {
                            if ($v[3] !== null) {
                                echo "<div class=\"col-xl-3 col-sm-6 mb-3\">
                                    <div class=\"channels-card\">";
                                      if(stripos($v[34],"мультфильм")) {
                                         echo "<div class=\"time\">Мультфильм</div>";
                                      }elseif($v[30]=="FILM") {
                                         echo "<div class=\"time\">Фильм</div>";
                                      }elseif ($v[30]=="TV_SERIES") {
                                         echo "<div class=\"time\">Сериал</div>";
                                      }elseif ($v[30]=="MINI_SERIES") {
                                         echo "<div class=\"time\">Мини-сериал</div>";
                                      }
                                    echo "<div class=\"channels-card-image\">
                                    <a href=\"video-page.php?filmId=" . $v[1] . "\"><img class=\"img-fluid\" src=\"" . $v[7] . "\" alt=\"\"></a>
                                   <div class=\"channels-card-image-btn\"><button type=\"button\" onclick=\"window.location.href='video-page.php?filmId=" . $v[1] . "'\"
                                   class=\"btn btn-outline-secondary btn-sm\">" . $v[3] . "";
                                if ($v[11] > 0 || $v[13] > 0) {
                                    echo "<span style='padding-left: 8px;'><i class=\"fas fa-star\"></i>&nbsp;";
                                    if ($v[11] > 0) {
                                        echo $v[11];
                                    } elseif ($v[13] > 0) {
                                        echo $v[13];
                                    }
                                    echo "</span>";
                                }
                                echo "</a></button></div>
                                           </div>
                                            <div class=\"channels-card-body\">                                  
                                             <div class=\"channels-view\">
                                             " . str_ireplace(",",", ",$v[34]) . "
                                            </div>
                                            </div>
                                            </div>
                                        </div>";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <hr class="mt-0">         
        </div>
        <!-- /.container-fluid -->
<?php include_once("footer.php");?>
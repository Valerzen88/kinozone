<?php
include("config.php");
include("switcher.php");
include("queries.php");
require 'db/vendor/autoload.php';
include('db/json2mysql/include.classloader.php');
use GuzzleHttp\Client;

$film_info=array();
$genres = array();
$staff = array();
$serials_amount=array();
function getIPAddress() {
    //whether ip is from the share internet
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    //whether ip is from the proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
//whether ip is from the remote address
    else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
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
$sql = "SELECT * FROM genre where genre_one<>\"\"";
$result = mysqli_query($conn, $sql);
if ($result) {
    if (mysqli_num_rows($result)>0) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($genres, $row);
        }
        mysqli_free_result($result);
    }
}
$sql = "SELECT * FROM years_count where keyword='all_serials'";
$result = mysqli_query($conn, $sql);
if ($result) {
	if (mysqli_num_rows($result)>0) {
		while ($row = mysqli_fetch_row($result)) {
			$serials_amount[$row[2]]=$row[1];
		}
		mysqli_free_result($result);
	}
}
if(isset($_POST['q'])) {
     $sql = "SELECT kinopoiskId FROM films where year<2022 and nameRu like \"%" . Switcher::toCyrillic($_POST["q"]) . "%\" 
        OR nameOriginal like \"%" . Switcher::fromCyrillic($_POST["q"]) . "%\" 
        OR nameOriginal like \"%" . $_POST["q"] . "%\"
        OR kinopoiskId=\"" . $_POST["q"]
        . "\" or year like \"%" . $_POST["q"] . "%\" order by kinopoiskId desc";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_row($result)) {
                if(strpos($_SERVER["REQUEST_URI"],"index.php")) {
                    $new_uri = str_replace("index.php", "video-page.php?filmId=" . $row[0], $_SERVER["REQUEST_URI"]);
                }else if (strpos($_SERVER["REQUEST_URI"],"video-page.php")) {
                    $new_uri = str_replace("video-page.php", "video-page.php?filmId=" . $row[0], $_SERVER["REQUEST_URI"]);
                }else if (strstr($_SERVER["REQUEST_URI"],"top.php")) {
                    $new_uri = str_replace("top.php", "videos_list.php?q=" . $row[0], $_SERVER["REQUEST_URI"]);
                }

            }
            mysqli_free_result($result);
            mysqli_close($conn);
            header('Location: ' . $new_uri);
            exit();
        } else if (mysqli_num_rows($result) > 1) {
            if(strpos($_SERVER["REQUEST_URI"],"index.php")) {
                $new_uri = str_replace("index.php", "videos_list.php?q=" . $_POST["q"], $_SERVER["REQUEST_URI"]);
            }else if (strpos($_SERVER["REQUEST_URI"],"video-page.php")) {
                $new_uri = str_replace("video-page.php", "videos_list.php?q=" . $_POST["q"], $_SERVER["REQUEST_URI"]);
            }else if (strstr($_SERVER["REQUEST_URI"],"top.php")) {
                $new_uri = str_replace("top.php", "videos_list.php?q=" . $_POST["q"], $_SERVER["REQUEST_URI"]);
            }
            mysqli_free_result($result);
            mysqli_close($conn);
            header('Location: ' . $new_uri);
            exit();
        }
    }
}else if(isset($_GET['filmId'])&&strlen($_GET['filmId'])>0){
	$sql="SELECT * FROM films where kinopoiskId=".$_GET["filmId"];
	$result=mysqli_query($conn,$sql);
	if($result) {
		while ($row = mysqli_fetch_row($result)) {
		  array_push($film_info,$row);
		}
		mysqli_free_result($result);
	}
}else if(isset($_GET['filmId'])&&strlen($_GET['filmId'])==0){
    header("Location: " . str_replace("video-page.php?filmId=","",$_SERVER["REQUEST_URI"]));
}else{
    header("Location: " . str_replace("video-page.php","",$_SERVER["REQUEST_URI"]));
}
$sql = "SELECT nameRu FROM kinozone.staff where FIND_IN_SET('".$film_info[0][1]."',filmId);";
$result = mysqli_query($conn, $sql);
if ($result) {
    if (mysqli_num_rows($result)>0) {
        while ($row = mysqli_fetch_row($result)) {
           array_push($staff , $row[0]);
        }
        mysqli_free_result($result);
    }
}
$related=array();
$genres_temp=explode(",",$film_info[0][34]);
$genres_str="";
for($i=0;$i<count($genres_temp);$i++){
	$genres_str.= "genre like '%".$genres_temp[$i]."%' or ";
}
$genres_str=substr($genres_str,0,-4);
$sql = "SELECT kinopoiskId,nameRu,nameOriginal,ratingKinopoisk,ratingImdb,year,filmLength,genre,country FROM films 
where kinopoiskId<>".$_GET['filmId']." and nameRu is not null and (".$genres_str.") 
and year<2022 order by year desc, ratingImdbVoteCount desc, ratingKinopoiskVoteCount desc limit 25";
$tempsql=$sql;
/*$ip = getIPAddress();
$log = date("d.m.Y H:i:s").":: User with IP-Address=".$ip." request related for filmId='".$_GET['filmId']."'".PHP_EOL.
    date("d.m.Y H:i:s").":: sql=".$sql.";".PHP_EOL;
file_put_contents('log_'.date("j.n.Y").'.log', $log, FILE_APPEND);*/
$result = mysqli_query($conn, $sql);
if ($result) {
    if (mysqli_num_rows($result)>0) {
        while ($row = mysqli_fetch_row($result)) {
           array_push($related, $row);
        }
        mysqli_free_result($result);
    }
}
$client = new GuzzleHttp\Client([
    'base_uri' => 'https://kinopoiskapiunofficial.tech/api/v1/reviews',
    'timeout'  => 1.0,
    'headers' => ['X-API-KEY' => 'da67006f-9505-4e51-a1ab-eb100c711635']
]);
$reviews_main_arr=array();
try {
    $response = $client->request('GET', '?filmId='.$_GET['filmId']);
    if ($response->getStatusCode() == 200) {
        $obj = json_decode($response->getBody());
		$reviews_arr=get_object_vars($obj)['reviews'];
		$i=0;
		foreach($reviews_arr as $k=>$v) {
			$reviews_main_arr[$i] = get_object_vars($v);
			$i++;
		}
    }
} catch (\GuzzleHttp\Exception\GuzzleException | DatabaseException $e) {}
$client_1 = new GuzzleHttp\Client([
    'base_uri' => 'https://kinopoiskapiunofficial.tech/api/v2.1/films/'.$_GET['filmId'].'/sequels_and_prequels',
    'timeout'  => 1.0,
    'headers' => ['X-API-KEY' => 'da67006f-9505-4e51-a1ab-eb100c711635']
]);
$pre_sequels=array();
try {
    $response = $client_1->request('GET', '');
    if ($response->getStatusCode() == 200) {
        $i=0;
        $obj = json_decode($response->getBody());
        foreach($obj as $k=>$v) {
            $pre_sequels[$i] = get_object_vars($v)['filmId'];
            $i++;
        }
    }
} catch (\GuzzleHttp\Exception\GuzzleException | DatabaseException $e) {}
$sql = "SELECT kinopoiskId,nameRu,ratingKinopoisk,ratingImdb,year,filmLength,genre,country FROM films 
where nameRu is not null and (kinopoiskId IN (".implode(",",$pre_sequels).")) 
and year<2022 order by year desc, ratingKinopoiskVoteCount desc limit 15";
$result = mysqli_query($conn, $sql);
$pre_sequels_f=array();
if ($result) {
    if (mysqli_num_rows($result)>0) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($pre_sequels_f, $row);
        }
        mysqli_free_result($result);
    }
}
$client_2 = new GuzzleHttp\Client([
    'base_uri' => 'https://kinopoiskapiunofficial.tech/api/v2.2/films/'.$_GET['filmId'].'/similars',
    'timeout'  => 1.0,
    'headers' => ['X-API-KEY' => 'da67006f-9505-4e51-a1ab-eb100c711635']
]);
$similars=array();
try {
    $response = $client_2->request('GET', '');
    if ($response->getStatusCode() == 200) {
        $obj = json_decode($response->getBody());
        $arr=get_object_vars($obj)['items'];
        for($i=0;$i<count($arr);$i++) {
            $similars[$i] = get_object_vars($arr[$i])['filmId'];
        }
    }
} catch (\GuzzleHttp\Exception\GuzzleException | DatabaseException $e) {}
$sql = "SELECT kinopoiskId,nameRu,ratingKinopoisk,ratingImdb,year,filmLength,genre,country FROM films 
where nameRu is not null and (kinopoiskId IN (".implode(",",$similars).")) 
and year<2022 order by year desc, ratingKinopoiskVoteCount desc limit 15";
$result = mysqli_query($conn, $sql);
if ($result) {
    if (mysqli_num_rows($result)>0) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($pre_sequels_f, $row);
        }
        mysqli_free_result($result);
    }
}
mysqli_close($conn);
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
        "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<?php include_once("header_v_p.php"); ?>
               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-8">
                        <div class="single-video-left">
                           <div class="single-video">
                               <?php if(isset($_GET["filmId"])){ ?>
                                  <div id="yohoho" data-tv="1" data-kinopoisk="<?php echo $_GET['filmId'];?>"></div>
                                  <script src="js/yo.compressed.js"></script>
							  <?php }else{echo "<h6>Запрос не смог быть обработан. Попробуйте другой фильм. Мы приносим свои извинения за ошибку!</h6>";}?>
                           </div>
                            <!--<google-cast-launcher></google-cast-launcher>-->
                           <div class="single-video-title box mb-2">
                              <h2><i class="fab fa-youtube"></i>&nbsp;<?php echo $film_info[0][3]." (".$years.")"; ?></h2>
							  <p><?php if(isset($film_info[0][26])){echo $film_info[0][26].".";} ?></p>
                              <p class="mb-0">
                              <?php if($film_info[0][11]>0||$film_info[0][13]>0){ echo "<i class=\"fas fa-star\"></i>";
                                if($film_info[0][11]>0) {echo " Рейтинг: ".$film_info[0][11];}elseif($film_info[0][13]>0){echo " Рейтинг: ".$film_info[0][13];}}
							  $age="";
							  if ($film_info[0][32]=="age0") {
								  $age="0";
							  }else if($film_info[0][32]=="age6"){
								  $age="6";
							  }else if($film_info[0][32]=="age12"){
								  $age="12";
							  }else if($film_info[0][32]=="age16"){
								  $age="16";
							  }else if($film_info[0][32]=="age18"){
								  $age="18";
							  }
                              if($age!=="") {
                                  echo "<span style='padding-left:15px;'><i class='fas fa-user-shield'></i>&nbsp;Возраст:&nbsp;$age+&nbsp;</span>";
                              }
                              if($film_info[0][23]!=null){
                                  echo "<span style=\"padding-left:15px;\"><i class=\"fas fa-clock\"></i>&nbsp;".convertToHoursMins($film_info[0][23])."</span>";
                              }
                              if($film_info[0][30]=="FILM") {
                                  echo "<span style=\"padding-left:15px;\"><i class=\"fas fa-clipboard-list\"></i>&nbsp;Категория: Фильм</span>";
                              }elseif($film_info[0][30]=="FILM") {
                                  echo "<span style=\"padding-left:15px;\"><i class=\"fas fa-clipboard-list\"></i>&nbsp;Категория: Фильм</span>";
                              }elseif ($film_info[0][30]=="TV_SERIES") {
                                  echo "<span style=\"padding-left:15px;\"><i class=\"fas fa-clipboard-list\"></i>&nbsp;Категория: Сериал</span>";
                              }elseif ($film_info[0][30]=="MINI_SERIES") {
                                  echo "<span style=\"padding-left:15px;\"><i class=\"fas fa-clipboard-list\"></i>&nbsp;Категория: Мини-сериал</span>";
                              }
                              ?>
                              </p>
                           </div>
                            <div class="adblock mt-3">
                                <div class="img">
                                    <a href="https://www.alpari.org/register/open-account?my=open-account&partner_id=4700850" target="_blank">
                                        <img width="100%" alt="alpari forex broker"
                                             src="https://profile.alparipartners.org/static/interface/img/banners/WelcomeTo/EN/700x67.png"></a>
                                </div>
                            </div>
                           <div class="single-video-info-content box mb-3">
							  <h6>Описание:</h6>
                              <p><?php echo $film_info[0][25]; ?></p>
                              <?php if(sizeof($staff)>0){ echo "<h6>В ролях:</h6>
                              <p>".implode(", ",$staff)."</p>";}?>
							  <h6>Страна:</h6>
                              <p><?php echo str_ireplace(",",", ",$film_info[0][33]); ?></p>
                              <h6>Жанры:</h6>
                              <p><?php echo str_ireplace(",",", ",$film_info[0][34]); ?></p>
                              <?php if($film_info[0][5]!=null){
                                  echo "<h6>Оригинальное название:</h6><p>".$film_info[0][5]."</p>";
                              } ?>
                           </div>
                            <?php if(count($reviews_main_arr)>0){ ?>
						   <div class="box mb-3 single-video-comment-tabs">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="retro-comments-tab" href="#retro-comments" data-toggle="collapse" role="tab" aria-controls="retro" aria-selected="false">Комментарии</a>
                                    </li>
                                </ul>
                                    <div class="tab-pane fade show active" id="retro-comments" role="tabpanel" aria-labelledby="retro-comments-tab">
                                        <?php
                                            for($i=0;$i<count($reviews_main_arr);$i++) {
												echo '<div class="reviews-members" style="padding-top:15px;">
												<div class="media">
                                                <a href="#"><i class="fas fa-user-circle fa-7x"></i>&nbsp;</a>
                                                <div class="media-body" style="padding-left:15px;">
                                                    <div class="reviews-members-header">
                                                        <h6 class="mb-1"><a class="text-black" href="#">'.$reviews_main_arr[$i]["reviewAutor"].'</a>&nbsp;';
														if($reviews_main_arr[$i]["reviewType"]==="NEUTRAL") {
															echo '<i class="fas fa-meh-rolling-eyes"></i>';
														}
														if($reviews_main_arr[$i]["reviewType"]==="POSITIVE") {
															echo '<i class="fas fa-smile-beam"></i>';
														}
														if($reviews_main_arr[$i]["reviewType"]==="NEGATIVE") {
															echo '<i class="fas fa-frown-open"></i>';
														}
														echo '&nbsp;<small class="text-gray">'.
														time_elapsed_string($reviews_main_arr[$i]["reviewData"]).'</small></h6>
														<h6><small>'.$reviews_main_arr[$i]["reviewTitle"].'</small></h6>
                                                    </div>
                                                    <div class="reviews-members-body">';
                                                        $offset_ = stripos($reviews_main_arr[$i]["reviewDescription"]," ",-(strlen($reviews_main_arr[$i]["reviewDescription"])-300));
                                                        echo '<p>'.substr_replace($reviews_main_arr[$i]["reviewDescription"],"&nbsp;<span id='dots_".$i."'>...</span>
                                                            <span id='more_".$i."' style='display:none;'>",$offset_).substr($reviews_main_arr[$i]["reviewDescription"],
                                                                -(strlen($reviews_main_arr[$i]["reviewDescription"])-$offset_-1)).'</span>
                                                        <a href="javascript:void(0);" onclick="showMore('.$i.');" id="showMoreBtn_'.$i.'">&nbsp;читать дальше</a></p>                
                                                    </div>
                                                    <div class="reviews-members-footer">
                                                        <div><i class="fas fa-thumbs-up"></i>&nbsp;'.$reviews_main_arr[$i]["userPositiveRating"].'</a>&nbsp; 
                                                        <i class="fas fa-thumbs-down"></i>&nbsp;'.$reviews_main_arr[$i]["userNegativeRating"].'</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                                            }
                                        ?>
                                    </div>
                            </div>
                            <?php } ?>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="single-video-right">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="adblock">
                                    <div class="img">
                                        <a href="https://www.alpari.org/register/open-account?my=open-account&partner_id=4700850" target="_blank">
                                            <img alt="alpari forex broker" width="100%"
                                                 src="https://profile.alparipartners.org/static/interface/img/banners/BackUp/EN/AINT_Backup_EN_300x90.jpg"></a>
                                    </div>
                                 </div>
                                 <div class="main-title">
                                    <div class="btn-group float-right right-action" style="display:none;">
                                       <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                                       </a>
                                       <div class="dropdown-menu dropdown-menu-right">
                                          <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                          <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                          <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                       </div>
                                    </div>
                                    <h6>Похожее видео</h6>
                                 </div>
                              </div>
                              <div class="col-md-12">
							  <?php
                               for($c=0;$c<count($pre_sequels_f);$c++){
                                   $client_4 = new GuzzleHttp\Client([
                                       'base_uri' => 'https://kinopoiskapiunofficial.tech/api/v2.1/films/'.$pre_sequels_f[$c][0].'/frames',
                                       'timeout'  => 1.0,
                                       'headers' => ['X-API-KEY' => 'da67006f-9505-4e51-a1ab-eb100c711635']
                                   ]);
                                   $pics=array();
                                   try {
                                       $response = $client_4->request('GET', '');
                                       if ($response->getStatusCode() == 200) {
                                           $j=0;
                                           $obj = json_decode($response->getBody());
                                           foreach($obj as $k=>$v) {
                                               if(isset($v)&&isset($v[$j])) {
                                                   $pics[$j] = get_object_vars($v[$j])['preview'];
                                                   $j++;
                                               }
                                           }
                                       }
                                   } catch (\GuzzleHttp\Exception\GuzzleException | DatabaseException $e) {}
                                   ?>
                                   <div class="video-card video-card-list">
                                       <div class="video-card-image" style="background-color:black;">
                                           <a class="play-icon" href="video-page.php?filmId=<?php echo $pre_sequels_f[$c][0];?>"><i class="fas fa-play-circle"></i></a>
                                           <a href="video-page.php?filmId=<?php echo $pre_sequels_f[$c][0];?>">
                                               <img class="img-fluid" style="margin:auto;padding-top:4px;text-align:center;display:block;
                                               <?php if(!(isset($pics[0])&count($pics)>0)){echo 'width:64px;height:64px;';} ?>"
                                                    src="<?php if(isset($pics[0])&count($pics)>0){echo $pics[0];}else{echo "img/film.png";} ?>" title="Смотреть фильм" alt="Смотреть фильм"></a>
                                           <div class="time" style="top:unset;bottom: 5px;"><?php echo convertToHoursMins($pre_sequels_f[$c][5]);?></div>
                                       </div>
                                       <div class="video-card-body">
                                           <div class="video-title">
                                               <a href="video-page.php?filmId=<?php echo $pre_sequels_f[$c][0];?>"><?php echo $pre_sequels_f[$c][1];?></a>
                                           </div>
                                           <div class="video-page text-success" style="word-wrap: normal;">
                                               <?php echo str_ireplace(",",", ",$pre_sequels_f[$c][7])." | ".str_ireplace(",",", ",$pre_sequels_f[$c][6]);?>
                                           </div>
                                           <div class="video-view">
                                               <?php
                                               if($pre_sequels_f[$c][2]>0||$pre_sequels_f[$c][3]>0){ echo "<i class=\"fas fa-star\"></i>";
                                                   if($pre_sequels_f[$c][2]>0) {echo " Рейтинг: ".$pre_sequels_f[$c][2];}
                                                   elseif($pre_sequels_f[$c][3]>0){echo " Рейтинг: ".$pre_sequels_f[$c][3];}}
                                               ?>
                                               &nbsp; <i class="fas fa-calendar-alt"></i> <?php echo $pre_sequels_f[$c][4];?> год &nbsp;
                                               <i class="fas fa-clock"></i> <?php echo $pre_sequels_f[$c][5]." мин.";?>
                                           </div>
                                       </div>
                                   </div>
                              <?php }
							  for($i=1;$i<count($related);$i++){
								  if($related[$i][1]!==null){
                                      $client_5 = new GuzzleHttp\Client([
                                          'base_uri' => 'https://kinopoiskapiunofficial.tech/api/v2.1/films/'.$related[$i][0].'/frames',
                                          'timeout'  => 1.0,
                                          'headers' => ['X-API-KEY' => 'da67006f-9505-4e51-a1ab-eb100c711635']
                                      ]);
                                      $pics=array();
                                      try {
                                          $response = $client_5->request('GET', '');
                                          if ($response->getStatusCode() == 200) {
                                              $l=0;
                                              $obj = json_decode($response->getBody());
                                              foreach($obj as $k=>$v) {
                                                  if(isset($v)&&isset($v[$l])) {
                                                      $pics[$l] = get_object_vars($v[$l])['preview'];
                                                      $l++;
                                                  }
                                              }
                                          }
                                      } catch (\GuzzleHttp\Exception\GuzzleException | DatabaseException $e) {}
								   ?>								   
                                 <div class="video-card video-card-list">
                                    <div class="video-card-image" style="background-color:black;">
                                       <a class="play-icon" href="video-page.php?filmId=<?php echo $related[$i][0];?>"><i class="fas fa-play-circle"></i></a>
                                       <a href="video-page.php?filmId=<?php echo $related[$i][0];?>">
									   <img class="img-fluid" style="margin:auto;padding-top:4px;text-align:center;display:block;
									   <?php if(!(isset($pics)&count($pics)>0)){echo 'width:64px;height:64px;';} ?>"
									   src="<?php if(isset($pics)&count($pics)>0){echo $pics[0];}else{echo "img/film.png";} ?>"
                                            title="Смотреть '<?php echo $related[$i][1];?>'" alt="Смотреть '<?php echo $related[$i][1];?>'"></a>
                                       <div class="time" style="top:unset;bottom: 5px;"><?php echo convertToHoursMins($related[$i][6]);?></div>
                                    </div>
                                    <div class="video-card-body">                                    
                                       <div class="video-title">
                                          <a href="video-page.php?filmId=<?php echo $related[$i][0];?>"><?php echo $related[$i][1];?></a>
                                       </div>
                                       <div class="video-page text-success" style="word-wrap: normal;">
                                          <?php echo str_ireplace(",",", ",$related[$i][8])." | ".str_ireplace(",",", ",$related[$i][7]);?>
                                       </div>
                                       <div class="video-view">
										  <?php
											  if($related[$i][3]>0||$related[$i][4]>0){ echo "<i class=\"fas fa-star\"></i>";
											  if($related[$i][3]>0) {echo " Рейтинг: ".$related[$i][3];}elseif($related[$i][4]>0){echo " Рейтинг: ".$related[$i][4];}}
										  ?>
                                          &nbsp; <i class="fas fa-calendar-alt"></i> <?php echo $related[$i][5];?> год &nbsp; 
										   <i class="fas fa-clock"></i> <?php echo $related[$i][6]." мин.";?>									  
                                       </div>
                                    </div>
                                 </div>
								  <?php }} ?>                               
                        </div>
                     </div>
                  </div>
               </div>
            </div>
			</div>
			</div>
            <!-- /.container-fluid -->
            <!-- Sticky Footer -->
<?php include_once("footer.php");?>
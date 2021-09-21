<?php
include("config.php");
include("switcher.php");
include("queries.php");
$film_info=array();
$genres = array();
$staff = array();
$sql = "SELECT * FROM genre where genre_one<>\"\"";
$result = mysqli_query($conn, $sql);
if ($result) {
    if (mysqli_num_rows($result) > 1) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($genres, $row);
        }
        mysqli_free_result($result);
    }
}
if(isset($_POST['searchvalue'])) {
    $sql = "SELECT kinopoiskId FROM films where nameRu=\"" . Switcher::toCyrillic($_POST["searchvalue"]) . "\" 
	OR nameOriginal=\"" . Switcher::fromCyrillic($_POST["searchvalue"]) . "\" OR kinopoiskId=\"" . $_POST["searchvalue"]
        . "\" or year like \"%" . $_POST["searchvalue"] . "%\" order by kinopoiskId desc";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_row($result)) {
                if(strpos($_SERVER["REQUEST_URI"],"index.php")) {
                    $new_uri = str_replace("index.php", "video-page.php?filmId=" . $row[0], $_SERVER["REQUEST_URI"]);
                } else if (strpos($_SERVER["REQUEST_URI"],"video-page.php")) {
                    $new_uri = str_replace("video-page.php", "video-page.php?filmId=" . $row[0], $_SERVER["REQUEST_URI"]);
                }

            }
            mysqli_free_result($result);
            mysqli_close($conn);
            header('Location: ' . $new_uri);
            exit();
        } else if (mysqli_num_rows($result) > 1) {
            if(strpos($_SERVER["REQUEST_URI"],"index.php")) {
                $new_uri = str_replace("index.php", "videos_list.php?s=" . $_POST["searchvalue"], $_SERVER["REQUEST_URI"]);
            } else if (strpos($_SERVER["REQUEST_URI"],"video-page.php")) {
                $new_uri = str_replace("video-page.php", "videos_list.php?s=" . $_POST["searchvalue"], $_SERVER["REQUEST_URI"]);
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
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_row($result)) {
           array_push($staff , $row[0]);
        }
        mysqli_free_result($result);
    }
}
mysqli_close($conn);
?>
<?php include_once("header_v_p.php"); ?>
               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-8">
                        <div class="single-video-left">
                           <div class="single-video">
                               <div class="uitools" id="videoplayers" style="min-height:450px !important;background-image: url('//pleer.videoplayers.club/web/img/loader.gif');background-repeat: no-repeat;background-position: center;background-color: #ccc;"></div>
							  <?php if(isset($_GET["filmId"])){ ?>
                              <script>
                                 var dataUrl=window.location.href;
                                 var my_script_play = document.createElement("script");
                                 my_script_play.setAttribute("src",'//pleer.videoplayers.club/get_player?h=450&kp_id=<?php if(isset($_GET["filmId"])){echo intval($_GET["filmId"]);}else{echo 448;}?>&type=widget&players=videocdn,hdvb,apicollaps,bazon,alloha,ustore,kodik,trailer,torrent&r_id=videoplayers&ani=Плеер 3&ati=&adi=&vni=Плеер 1&vti=&vdi=&hni=Плеер 2&hti=&hdi=&bni=Плеер 4&bti=&bdi=&alni=Плеер 5&alti=&aldi=&usni=Плеер 6&usti=&usdi=&koni=Плеер 7&koti=&kodi=&tti=&ru='+dataUrl);
                                 my_script_play.async = true;
                                 document.head.appendChild(my_script_play);
                              </script>
							  <?php }else{echo "<h6>Запрос не смог быть обработан. Попробуйте другой фильм. Мы приносим свои извинения за ошибку!</h6>";}?>
                           </div>
                           <div class="single-video-title box mb-3">
                              <h2><?php echo $film_info[0][3]." (".$film_info[0][22].")"; ?></h2>
							  <p><?php echo $film_info[0][26]; ?></p>
                              <p class="mb-0">
                              <?php if($film_info[0][11]>0||$film_info[0][13]>0){ echo "<i class=\"fas fa-star\"></i>";
                                if($film_info[0][11]>0) {echo "Рейтинг: ".$film_info[0][11];}elseif($film_info[0][13]>0){echo "Рейтинг: ".$film_info[0][13];}}
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
                                  echo "<span style='padding-left:15px;'><i class='fas fa-user-shield'></i> Возраст: &nbsp;$age+&nbsp;</span>";
                              }
                              if($film_info[0][23]!=null){
                                  echo "<span style=\"padding-left:15px;\"><i class=\"fas fa-clock\"></i>&nbsp; ".$film_info[0][23]." мин.</span>";
                              }
                              if($film_info[0][30]=="FILM") {
                                  echo "<span style=\"padding-left:15px;\"><i class=\"fas fa-clipboard-list\"></i> Категория: Фильм</span>";
                              }elseif ($film_info[0][30]=="TV_SERIES") {
                                  echo "<span style=\"padding-left:15px;\"><i class=\"fas fa-clipboard-list\"></i> Категория: Сериал</span>";
                              }elseif ($film_info[0][30]=="MINI_SERIES") {
                                  echo "<span style=\"padding-left:15px;\"><i class=\"fas fa-clipboard-list\"></i> Категория: Мини-сериал</span>";
                              }
                              ?>
                              </p>
                           </div>
                           <div class="single-video-info-content box mb-3">
							  <h6>Описание:</h6>
                              <p><?php echo $film_info[0][25]; ?></p>
                              <?php if(sizeof($staff)>0){ echo "<h6>В ролях:</h6>
                              <p>".implode(", ",$staff)."</p>";}?>
                              <h6>Жанры:</h6>
                              <p><?php echo str_ireplace(",",", ",$film_info[0][34]); ?></p>
                              <?php if($film_info[0][5]!=null){
                                  echo "<h6>Оригинальное название:</h6><p>".$film_info[0][5]."</p>";
                              } ?>
                              <h6>Тэги:</h6>
                              <p class="tags mb-0">
                                 <span><a href="#">Тэг1</a></span>
                                 <span><a href="#">Тэг2</a></span>
                                 <span><a href="#">Тэг3</a></span>
                                 <span><a href="#">Тэг4</a></span>
                                 <span><a href="#">Тэг5</a></span>
                                 <span><a href="#">Тэг6</a></span>
                              </p>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="single-video-right">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="adblock">
                                    <div class="img">
                                       Google AdSense<br>
                                       336 x 280
                                    </div>
                                 </div>
                                 <div class="main-title">
                                    <div class="btn-group float-right right-action">
                                       <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                                       </a>
                                       <div class="dropdown-menu dropdown-menu-right">
                                          <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                          <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                          <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                       </div>
                                    </div>
                                    <h6>Up Next</h6>
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="video-card video-card-list">
                                    <div class="video-card-image">
                                       <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                                       <a href="#"><img class="img-fluid" src="img/v1.png" alt=""></a>
                                       <div class="time">3:50</div>
                                    </div>
                                    <div class="video-card-body">
                                       <div class="btn-group float-right right-action">
                                          <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right">
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                          </div>
                                       </div>
                                       <div class="video-title">
                                          <a href="#">Here are many variati of passages of Lorem</a>
                                       </div>
                                       <div class="video-page text-success">
                                          Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                       </div>
                                       <div class="video-view">
                                          1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                                       </div>
                                    </div>
                                 </div>
                                 <div class="video-card video-card-list">
                                    <div class="video-card-image">
                                       <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                                       <a href="#"><img class="img-fluid" src="img/v2.png" alt=""></a>
                                       <div class="time">3:50</div>
                                    </div>
                                    <div class="video-card-body">
                                       <div class="btn-group float-right right-action">
                                          <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right">
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                          </div>
                                       </div>
                                       <div class="video-title">
                                          <a href="#">Duis aute irure dolor in reprehenderit in.</a>
                                       </div>
                                       <div class="video-page text-success">
                                          Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                       </div>
                                       <div class="video-view">
                                          1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                                       </div>
                                    </div>
                                 </div>
                                 <div class="video-card video-card-list">
                                    <div class="video-card-image">
                                       <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                                       <a href="#"><img class="img-fluid" src="img/v3.png" alt=""></a>
                                       <div class="time">3:50</div>
                                    </div>
                                    <div class="video-card-body">
                                       <div class="btn-group float-right right-action">
                                          <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right">
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                          </div>
                                       </div>
                                       <div class="video-title">
                                          <a href="#">Culpa qui officia deserunt mollit anim</a>
                                       </div>
                                       <div class="video-page text-success">
                                          Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                       </div>
                                       <div class="video-view">
                                          1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                                       </div>
                                    </div>
                                 </div>
                                 <div class="video-card video-card-list">
                                    <div class="video-card-image">
                                       <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                                       <a href="#"><img class="img-fluid" src="img/v4.png" alt=""></a>
                                       <div class="time">3:50</div>
                                    </div>
                                    <div class="video-card-body">
                                       <div class="btn-group float-right right-action">
                                          <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right">
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                          </div>
                                       </div>
                                       <div class="video-title">
                                          <a href="#">Deserunt mollit anim id est laborum.</a>
                                       </div>
                                       <div class="video-page text-success">
                                          Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                       </div>
                                       <div class="video-view">
                                          1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                                       </div>
                                    </div>
                                 </div>
                                 <div class="video-card video-card-list">
                                    <div class="video-card-image">
                                       <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                                       <a href="#"><img class="img-fluid" src="img/v5.png" alt=""></a>
                                       <div class="time">3:50</div>
                                    </div>
                                    <div class="video-card-body">
                                       <div class="btn-group float-right right-action">
                                          <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right">
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                          </div>
                                       </div>
                                       <div class="video-title">
                                          <a href="#">Exercitation ullamco laboris nisi ut.</a>
                                       </div>
                                       <div class="video-page text-success">
                                          Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                       </div>
                                       <div class="video-view">
                                          1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                                       </div>
                                    </div>
                                 </div>
                                 <div class="video-card video-card-list">
                                    <div class="video-card-image">
                                       <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                                       <a href="#"><img class="img-fluid" src="img/v6.png" alt=""></a>
                                       <div class="time">3:50</div>
                                    </div>
                                    <div class="video-card-body">
                                       <div class="btn-group float-right right-action">
                                          <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right">
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                          </div>
                                       </div>
                                       <div class="video-title">
                                          <a href="#">There are many variations of passages of Lorem</a>
                                       </div>
                                       <div class="video-page text-success">
                                          Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                       </div>
                                       <div class="video-view">
                                          1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                                       </div>
                                    </div>
                                 </div>
                                 <div class="adblock mt-0">
                                    <div class="img">
                                       Google AdSense<br>
                                       336 x 280
                                    </div>
                                 </div>
                                 <div class="video-card video-card-list">
                                    <div class="video-card-image">
                                       <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                                       <a href="#"><img class="img-fluid" src="img/v2.png" alt=""></a>
                                       <div class="time">3:50</div>
                                    </div>
                                    <div class="video-card-body">
                                       <div class="btn-group float-right right-action">
                                          <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right">
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                          </div>
                                       </div>
                                       <div class="video-title">
                                          <a href="#">Duis aute irure dolor in reprehenderit in.</a>
                                       </div>
                                       <div class="video-page text-success">
                                          Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                       </div>
                                       <div class="video-view">
                                          1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                                       </div>
                                    </div>
                                 </div>
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
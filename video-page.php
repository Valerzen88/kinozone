<?php
include("config.php");
include("switcher.php");

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
$films_y_amount=array();
$sql = "SELECT year,film_amount FROM years_count where year>2018";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_row($result)) {
        $films_y_amount[$row[0]]=$row[1];
    }
    mysqli_free_result($result);
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
$sql = "SELECT nameRu,personId FROM kinozone.staff where nameRu is not null and 
                        FIND_IN_SET('".$film_info[0][1]."',filmId) and (profession like '%Актер%' or profession is null)";
$result = mysqli_query($conn, $sql);
if ($result) {
    if (mysqli_num_rows($result)>0) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($staff , $row);
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
                                  <div id="yohoho"
                                       data-tv="1"
                                       data-trailer="youtube,collaps"
                                       data-player="videocdn,iframe,kodik,collaps,hdvb,bazon,ustore,alloha,pleer,videospider,trailer"
                                       data-kinopoisk="<?php echo $_GET['filmId'];?>"></div>
                                  <script src="js/yo.compressed.js"></script>
							  <?php }else{echo "<h6>Запрос не смог быть обработан. Попробуйте другой фильм. Мы приносим свои извинения за ошибку!</h6>";}?>
                           </div>
                            <!--<google-cast-launcher></google-cast-launcher>-->
                           <div class="single-video-title box mb-2">
                              <h2><i class="fab fa-youtube"></i>&nbsp;<?php echo $film_info[0][3]." (".$years.")"; ?></h2>
							  <p><?php if(isset($film_info[0][26])){echo $film_info[0][26].".";} ?></p>
                              <p class="mb-0">
                                  <i class="fas fa-palette"></i>&nbsp;Качество: <span data-yo="quality" style="text-transform: uppercase;">???</span>&nbsp;
                              <?php if($film_info[0][11]>0||$film_info[0][13]>0){ echo "<i class=\"fas fa-star\"></i>";
                                if($film_info[0][11]>0) {echo "&nbsp;Рейтинг: ".$film_info[0][11];}elseif($film_info[0][13]>0){echo "&nbsp;Рейтинг: ".$film_info[0][13];}}
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
                                    <a href="https://apyecom.com/click/61e48d722bfa815b5b4de506/170143/275240/kinozone" target="_blank">
                                        <img width="100%" alt="Альфабанк 100 дней 0%"
                                             src="img/a_d_s/alfabank_banner_min.png"></a>
                                </div>
                            </div>
                           <div class="single-video-info-content box mb-2">
							  <h6>Описание:</h6>
                              <p><?php echo $film_info[0][25]; ?></p>
                              <?php if(sizeof($staff)>0){ echo "<h6>В ролях:</h6>";
                                   foreach($staff as $k => $v){
                                       if($k<sizeof($staff)-1) {
                                           echo "<a href='person.php?q=" . $v[1] . "'>" . $v[0] . "</a>, ";
                                       } else {
                                           echo "<a href='person.php?q=" . $v[1] . "'>" . $v[0] . "</a>";
                                       }
                                   }
                                   echo "<p></p>";
                              }?>
							  <h6>Страна:</h6>
                              <p><?php echo str_ireplace(",",", ",$film_info[0][33]); ?></p>
                              <h6>Жанры:</h6>
                              <p><?php echo str_ireplace(",",", ",$film_info[0][34]); ?></p>
                              <?php if($film_info[0][5]!=null){
                                  echo "<h6>Оригинальное название:</h6><p>".$film_info[0][5]."</p>";
                              } ?>
                           </div>
                            <div class="adblock mt-3">
                                <a href="https://apyecom.com/click/61e49a782bfa813a350dc56b/110937/275240/kinozone" target="_blank">
                                    <img width="100%" alt="Cкидки на детские игрушки на AliExpress!"
                                         src="img/a_d_s/aliexpress_banner_min.png"></a>
                            </div>
                            <div id="reviews">
                                <script>
                                    //get html for related and pre-sequels
                                    query_str="<?php echo "queries.php?getReviews=".$film_info[0][1]."&filmId=".$_GET['filmId'];?>";
                                    $.get(query_str, function(data, status){
                                        container=document.getElementById('reviews');
                                        container.innerHTML = data;
                                    }).done(function (){
                                        $('#loading').hide();
                                    });
                                </script>
                            </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="single-video-right">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="adblock">
                                    <div class="img">
                                        <a href="https://apyecom.com/click/61e48d722bfa815b5b4de506/170143/275240/kinozone" target="_blank">
                                            <img alt="alpari forex broker" width="100%"
                                                 src="img/a_d_s/alfabank_100_days_rechteck_min.png"></a>
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
                              <div class="col-md-12" id="related">
                                  <div class="video-card video-card-list" style="text-align: center !important;" id="loadingDiv">
                                      <div class="lds-ripple"><br><br>Загрузка похожих фильмов...</div>
                                  </div>
                                  <script>
                                      //get html for related and pre-sequels
                                      query_str="<?php echo "queries.php?getSequelsAndPrequels=&filmId=".$_GET['filmId'];?>";
                                      $.get(query_str, function(data, status){
                                          container=document.getElementById('related');
                                          container.innerHTML = data;
                                      }).done(function (){
                                          $('#loadingDiv').hide();
                                      });
                                  </script>
                            </div>
                           <div class="col-md-12" id="related_2">
                               <div class="video-card video-card-list" style="text-align: center !important;" id="loadingDiv_2">
                                   <div class="lds-ripple"><br><br>Загрузка похожих фильмов...</div>
                               </div>
                               <script>
                                   //get html for related and pre-sequels
                                   query_str="<?php echo "queries.php?getRelated=&genres_str=".$film_info[0][34]."&filmId=".$_GET['filmId'];?>";
                                   $.get(query_str, function(data, status){
                                       container=document.getElementById('related_2');
                                       container.innerHTML = data;
                                   }).done(function (){
                                       $('#loadingDiv_2').hide();
                                   });
                               </script>
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
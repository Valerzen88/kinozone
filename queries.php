<?php
include("config.php");
require 'db/vendor/autoload.php';
include('db/json2mysql/include.classloader.php');

if(isset($conn)) {
   if(isset($_GET['filmId'])&&isset($_GET['getReviews'])) {
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
       if(count($reviews_main_arr)>0){ ?>
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
       <?php }
   }
   if(isset($_GET['filmId'])&&isset($_GET['getSequelsAndPrequels'])) {
        $client_1 = new GuzzleHttp\Client([
            'base_uri' => 'https://kinopoiskapiunofficial.tech/api/v2.1/films/'.$_GET['filmId'].'/sequels_and_prequels',
            'timeout'  => 2.0,
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
    }
   if(isset($_GET['filmId'])&&isset($_GET['getRelated'])) {
       $related=array();
       $genres_temp=explode(",",$_GET['genres_str']);
       $genres_str="";
       for($i=0;$i<count($genres_temp);$i++){
           $genres_str.= "genre like '%".$genres_temp[$i]."%' or ";
       }
       $genres_str=substr($genres_str,0,-4);
       //films
       //where kinopoiskId<>".$_GET['filmId']." and nameRu is not null
       //and (".$genres_str.")
       //and year<2022 order by year desc, ratingImdbVoteCount desc, ratingKinopoiskVoteCount desc limit 25
       $sql = "SELECT * FROM related where kinopoiskId<>".$_GET['filmId'];
       $result = mysqli_query($conn, $sql);
       if ($result) {
           if (mysqli_num_rows($result)>0) {
               while ($row = mysqli_fetch_row($result)) {
                   array_push($related, $row);
               }
               mysqli_free_result($result);
           }
       }
       for($i=1;$i<count($related);$i++){
           if($related[$i][1]!==null){
               $client_5 = new GuzzleHttp\Client([
                   'base_uri' => 'https://kinopoiskapiunofficial.tech/api/v2.1/films/'.$related[$i][0].'/frames',
                   'timeout'  => 2.0,
                   'headers' => ['X-API-KEY' => 'da67006f-9505-4e51-a1ab-eb100c711635']
               ]);
               $pics=array();
               try {
                   $response = $client_5->request('GET', '');
                   if ($response->getStatusCode() == 200) {
                       $l=0;
                       $obj = json_decode($response->getBody());
                       foreach($obj as $k=>$v) {
                           if(isset($v)&&isset($v[0])) {
                               $pics[$l] = get_object_vars($v[0])['preview'];
                               $l++;
                               ?>
                               <div class="video-card video-card-list">
                                   <div class="video-card-image" style="background-color:black;">
                                       <a class="play-icon" href="video-page.php?filmId=<?php echo $related[$i][0];?>"><i class="fas fa-play-circle"></i></a>
                                       <a href="video-page.php?filmId=<?php echo $related[$i][0];?>">
                                           <img class="img-fluid" style="margin:auto;padding-top:4px;text-align:center;display:block;
                                            <?php if(!(isset($pics)&&count($pics)>0)){echo 'width:64px;height:64px;';} ?>"
                                                src="<?php if(isset($pics)&&count($pics)>0){echo $pics[0];}else{echo "img/film.png";} ?>"
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
                               <?php
                           }
                       }
                   }
               } catch (\GuzzleHttp\Exception\GuzzleException | DatabaseException $e) {}
           }
       }
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
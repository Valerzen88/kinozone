<?php
include_once("header.php");
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
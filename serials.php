<?php
include_once("header.php");
?>
            <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">                     
                            <h6>Сериалы по категориям</h6>
                        </div>
                    </div>
					<div class="col-md-12">
                        <div class="owl-carousel owl-carousel-category">
                    <?php
                    if(count($genre_serials)>1){
						foreach ($genre_serials as $k => $v) {
							echo "<div class=\"item\">
								<div class=\"category-item\">
									<a href=\"videos_list.php?genre_serials=" . $v[0] . "\">
										<img class=\"img-fluid\" src=\"img/genres/".$v[0].".png\" title=\"" . mb_strtoupper($v[0]) . "\" alt=\"" . mb_strtoupper($v[0]) . "\">
										<h6 title=\"" . mb_strtoupper($v[0]) . "\">" . mb_strtoupper($v[0]) . "</h6>
										<p>" . $v[1] . " сериалов</p>
									</a>
								</div>
							</div>";
                        }                   
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
                            <h6>Топ 48 сериалов 2021 года</h6>
                        </div>
                    </div>
                    <?php
                    if(isset($top_20_serials)){
                        foreach ($top_20_serials as $k => $v) {
                            if ($v[3] !== null) {
                                echo "<div class=\"col-xl-3 col-sm-6 mb-3\">
                                            <div class=\"channels-card\">
                                            <div class=\"channels-card-image\">
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
<?php include_once("footer.php");?>

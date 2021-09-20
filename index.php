<?php
include_once("header.php");
?>
            <div class="top-category section-padding mb-4">
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
                            <div class="btn-group float-right right-action" style="display: none">
                                <a href="#" class="right-action-link text-gray" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp;
                                        Close</a>
                                </div>
                            </div>
                            <h6>Топ 20 фильмов 2021 года</h6>
                        </div>
                    </div>
                    <?php
                    if(isset($top_20_films)){
                        foreach ($top_20_films as $k => $v) {
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
                                             " . $v[34] . "
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
            <div class="video-block section-padding" style="display:none;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">
                            <div class="btn-group float-right right-action">
                                <a href="#" class="right-action-link text-gray" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp;
                                        Close</a>
                                </div>
                            </div>
                            <h6>Popular Channels</h6>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="channels-card">
                            <div class="channels-card-image">
                                <a href="#"><img class="img-fluid" src="img/s1.png" alt=""></a>
                                <div class="channels-card-image-btn">
                                    <button type="button" class="btn btn-outline-danger btn-sm">Subscribe
                                        <strong>1.4M</strong></button>
                                </div>
                            </div>
                            <div class="channels-card-body">
                                <div class="channels-title">
                                    <a href="#">Channels Name</a>
                                </div>
                                <div class="channels-view">
                                    382,323 subscribers
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="channels-card">
                            <div class="channels-card-image">
                                <a href="#"><img class="img-fluid" src="img/s2.png" alt=""></a>
                                <div class="channels-card-image-btn">
                                    <button type="button" class="btn btn-outline-danger btn-sm">Subscribe
                                        <strong>1.4M</strong></button>
                                </div>
                            </div>
                            <div class="channels-card-body">
                                <div class="channels-title">
                                    <a href="#">Channels Name</a>
                                </div>
                                <div class="channels-view">
                                    382,323 subscribers
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="channels-card">
                            <div class="channels-card-image">
                                <a href="#"><img class="img-fluid" src="img/s3.png" alt=""></a>
                                <div class="channels-card-image-btn">
                                    <button type="button" class="btn btn-outline-secondary btn-sm">Subscribed <strong>1.4M</strong>
                                    </button>
                                </div>
                            </div>
                            <div class="channels-card-body">
                                <div class="channels-title">
                                    <a href="#">Channels Name <span title="" data-placement="top" data-toggle="tooltip"
                                                                    data-original-title="Verified"><i
                                                    class="fas fa-check-circle"></i></span></a>
                                </div>
                                <div class="channels-view">
                                    382,323 subscribers
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="channels-card">
                            <div class="channels-card-image">
                                <a href="#"><img class="img-fluid" src="img/s4.png" alt=""></a>
                                <div class="channels-card-image-btn">
                                    <button type="button" class="btn btn-outline-danger btn-sm">Subscribe
                                        <strong>1.4M</strong></button>
                                </div>
                            </div>
                            <div class="channels-card-body">
                                <div class="channels-title">
                                    <a href="#">Channels Name</a>
                                </div>
                                <div class="channels-view">
                                    382,323 subscribers
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
<?php include_once("footer.php");?>
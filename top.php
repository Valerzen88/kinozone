<?php
include_once("header.php");
if(!isset($_GET['qp'])){ ?>
<div class="video-block section-padding">
    <div class="row">
        <div class="col-md-12">
            <div class="main-title">
                <h6>Подборка топов</h6>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="channels-card">
                <div class="channels-card-image">
                    <a href="top.php?qp=0"><img class="img-fluid" src="img/top250.png" alt="Топ 250 лучших фильмов"></a>
                    <div class="channels-card-image-btn"><button type="button" onclick="window.location.href='top.php?qp=0'" class="btn btn-outline-secondary btn-sm">
                            <span style='padding-left: 8px;'><i class="fas fa-video"></i>&nbsp; Топ 250 фильмов</span></a></button>
                    </div>
                </div>
                <div class="channels-card-body">
                    <div class="channels-view">
                        250 лучших фильмов.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="channels-card">
                <div class="channels-card-image">
                    <a href="top.php?qp=1"><img class="img-fluid" src="img/top100.png" alt="Топ 100 фильмов"></a>
                    <div class="channels-card-image-btn"><button type="button" onclick="window.location.href='top.php?qp=1'" class="btn btn-outline-secondary btn-sm">
                            <span style='padding-left: 8px;'><i class="fas fa-video"></i>&nbsp; Топ 100 фильмов</span></a></button>
                    </div>
                </div>
                <div class="channels-card-body">
                    <div class="channels-view">
                        100 самых популярных кинокартин.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="channels-card">
                <div class="channels-card-image">
                    <a href="top.php?qp=3"><img class="img-fluid" src="img/marvel.jpeg" alt="Киновселенная Марвел"></a>
                    <div class="channels-card-image-btn"><button type="button" onclick="window.location.href='top.php?qp=3'" class="btn btn-outline-secondary btn-sm">
                            <span style='padding-left: 8px;'><i class="fas fa-video"></i>&nbsp; Киновселенная Марвел</span></a></button>
                    </div>
                </div>
                <div class="channels-card-body">
                    <div class="channels-view">
                        Все фильмы франшизы Марвел.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="channels-card">
                <div class="channels-card-image">
                    <a href="top.php?qp=4"><img class="img-fluid" src="img/harry_potter.jpeg" alt="Киновселенная Гарри Поттера"></a>
                    <div class="channels-card-image-btn"><button type="button" onclick="window.location.href='top.php?qp=4'" class="btn btn-outline-secondary btn-sm">
                            <span style='padding-left: 8px;'><i class="fas fa-video"></i>&nbsp; Киновселенная Гарри Поттера</span></a></button>
                    </div>
                </div>
                <div class="channels-card-body">
                    <div class="channels-view">
                        Все фильмы франшизы Гарри Поттера.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="channels-card">
                <div class="channels-card-image">
                    <a href="top.php?qp=5"><img class="img-fluid" src="img/starwars.jpeg" alt="Киновселенная Звездных Войн"></a>
                    <div class="channels-card-image-btn"><button type="button" onclick="window.location.href='top.php?qp=5'" class="btn btn-outline-secondary btn-sm">
                            <span style='padding-left: 8px;'><i class="fas fa-video"></i>&nbsp; Киновселенная Звездных Войн</span></a></button>
                    </div>
                </div>
                <div class="channels-card-body">
                    <div class="channels-view">
                        Все фильмы франшизы Звездных Войн.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="channels-card">
                <div class="channels-card-image">
                    <a href="top.php?qp=6"><img class="img-fluid" src="img/xmen.png" alt="Киновселенная Людей Икс"></a>
                    <div class="channels-card-image-btn"><button type="button" onclick="window.location.href='top.php?qp=6'" class="btn btn-outline-secondary btn-sm">
                            <span style='padding-left: 8px;'><i class="fas fa-video"></i>&nbsp; Киновселенная Людей Икс</span></a></button>
                    </div>
                </div>
                <div class="channels-card-body">
                    <div class="channels-view">
                        Все фильмы франшизы Людей Икс.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="channels-card">
                <div class="channels-card-image">
                    <a href="top.php?qp=7"><img class="img-fluid" src="img/transformers.png" alt="Киновселенная Трансформеров"></a>
                    <div class="channels-card-image-btn"><button type="button" onclick="window.location.href='top.php?qp=7'" class="btn btn-outline-secondary btn-sm">
                            <span style='padding-left: 8px;'><i class="fas fa-video"></i>&nbsp; Киновселенная Трансформеров</span></a></button>
                    </div>
                </div>
                <div class="channels-card-body">
                    <div class="channels-view">
                        Все фильмы франшизы Трансформеров.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="channels-card">
                <div class="channels-card-image">
                    <a href="top.php?qp=8"><img class="img-fluid" src="img/lord_of_the_rings.png" alt="Мир Средиземья"></a>
                    <div class="channels-card-image-btn"><button type="button" onclick="window.location.href='top.php?qp=8'" class="btn btn-outline-secondary btn-sm">
                            <span style='padding-left: 8px;'><i class="fas fa-video"></i>&nbsp; Мир Средиземья</span></a></button>
                    </div>
                </div>
                <div class="channels-card-body">
                    <div class="channels-view">
                        Все фильмы франшизы Властелина Колец.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="channels-card">
                <div class="channels-card-image">
                    <a href="top.php?qp=9"><img class="img-fluid" src="img/ice_age.png" alt="Ледниковый период"></a>
                    <div class="channels-card-image-btn"><button type="button" onclick="window.location.href='top.php?qp=9'" class="btn btn-outline-secondary btn-sm">
                            <span style='padding-left: 8px;'><i class="fas fa-video"></i>&nbsp; Ледниковый период</span></a></button>
                    </div>
                </div>
                <div class="channels-card-body">
                    <div class="channels-view">
                        Все фильмы франшизы Ледникового периода.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="channels-card">
                <div class="channels-card-image">
                    <a href="top.php?qp=2"><img class="img-fluid" src="img/top_awaiting.png" alt="Топ ожидаемых фильмов"></a>
                    <div class="channels-card-image-btn"><button type="button" onclick="window.location.href='top.php?qp=2'" class="btn btn-outline-secondary btn-sm">
                            <span style='padding-left: 8px;'><i class="fas fa-video"></i>&nbsp; Топ ожидаемых фильмов</span></a></button>
                    </div>
                </div>
                <div class="channels-card-body">
                    <div class="channels-view">
                       Самые ожидаемые фильмы.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 adblock">
            <div class="main-title">
                <h6>Реклама</h6>
            </div>
            <div class="img">
                <a href="https://apretailer.com.br/click/61e5da6e2bfa81370045ab92/159630/275240/kinozone" target="_blank">
                    <img alt="1xbet ставки на спорт и киберспорт" width="100%"
                         src="img/a_d_s/1xbet-bonus-pri-registracii-banner.jpeg"></a>
            </div>
        </div>
    </div>
</div>
<hr class="mt-0">
<?php } elseif(isset($_GET['qp'])){
    //$conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS);
    if($_GET['qp']==3) {
        $sql = "SELECT kinopoiskId,nameRu,year,genre,ratingKinopoisk,ratingKinopoiskVoteCount,posterUrl,type FROM films WHERE 
            kinopoiskId in(1309570,2898,690593,1008445,920265,278217,602409,838,82441,61237,411924,462762,255380,258941,160946,
                           263531,679830,843649,843650,595938,822709,676266,822708,689066,841263,679830,195496,409600,823956,
                           623250,843649,843650,843859,1219149,1198811) order by year desc";
    }else if($_GET['qp']==4){
            $sql = "SELECT kinopoiskId,nameRu,year,genre,ratingKinopoisk,ratingKinopoiskVoteCount,posterUrl,type FROM films WHERE 
            kinopoiskId in(689,688,322,8408,48356,89515,276762,407636,797840,843479,4716622) order by year desc";
    }else if($_GET['qp']==5){
        $sql = "SELECT kinopoiskId,nameRu,year,genre,ratingKinopoisk,ratingKinopoiskVoteCount,posterUrl,type FROM films WHERE 
            kinopoiskId in(718222,333,338,447,6695,844,5619,714888,718223,841277,840152,1118138,4290977) order by year desc";
    }else if($_GET['qp']==6){
        $sql = "SELECT kinopoiskId,nameRu,year,genre,ratingKinopoisk,ratingKinopoiskVoteCount,posterUrl,type FROM films WHERE 
            kinopoiskId in(298,886,61361,104904,462358,462754,597687,814016,807682,1012431,910085) order by year desc";
    }else if($_GET['qp']==7){
        $sql = "SELECT kinopoiskId,nameRu,year,genre,ratingKinopoisk,ratingKinopoiskVoteCount,posterUrl,type FROM films WHERE 
            kinopoiskId in(81288,373391,452899,651857,811609,952241) order by year desc";
    }else if($_GET['qp']==8){
        $sql = "SELECT kinopoiskId,nameRu,year,genre,ratingKinopoisk,ratingKinopoiskVoteCount,posterUrl,type FROM films WHERE 
            kinopoiskId in(278522,408876,694633,328,312,3498) order by year desc";
    }else if($_GET['qp']==9){
        $sql = "SELECT kinopoiskId,nameRu,year,genre,ratingKinopoisk,ratingKinopoiskVoteCount,posterUrl,type FROM films WHERE 
            kinopoiskId in(707,86204,392930,647578,522180,965633,818145) order by year desc";
    } else {
        $sql = "SELECT DISTINCT tops.filmId,tops.nameRu,tops.year,tops.genres,tops.rating,tops.ratingVoteCount,tops.posterUrl,films.type 
            FROM kinozone.tops inner join kinozone.films on films.kinopoiskId=tops.filmId where tops.top_type=" .
            $_GET['qp'] . " order by tops.ratingVoteCount desc";
    }
    $result = mysqli_query($conn, $sql);
    $tops=array();
    if ($result) {
        if (mysqli_num_rows($result) > 1) {
            while ($row = mysqli_fetch_row($result)) {
                array_push($tops, $row);
            }
            mysqli_free_result($result);
        }
    }
?>
<div class="video-block section-padding">
    <div class="row">
        <div class="col-md-12">
            <div class="main-title">
                <?php
                if($_GET['qp']==0) {
                    echo "<h6>Список топ 250 самых лучших фильмов</h6>";
                }elseif ($_GET['qp']==1) {
                    echo "<h6>Список самых популярных фильмов</h6>";
                }elseif ($_GET['qp']==2) {
                    echo "<h6>Список ожидаемых фильмов</h6>";
                }elseif ($_GET['qp']==3) {
                    echo "<h6>Киновселенная Марвел (".count($tops)." фильмов)</h6>";
                }elseif ($_GET['qp']==4) {
                    echo "<h6>Киновселенная Гарри Поттера (".count($tops)." фильмов)</h6>";
                }
                ?>
            </div>
        </div>
        <?php
        if(isset($tops)){
            foreach ($tops as $k => $v) {
                echo "<div class=\"col-xl-3 col-sm-6 mb-3\">
                        <div class=\"channels-card\">";
                if(stripos($v[3],"мультфильм")) {
                    echo "<div class=\"time\">Мультфильм</div>";
                }elseif($v[7]=="FILM") {
                    echo "<div class=\"time\">Фильм</div>";
                }elseif ($v[7]=="TV_SERIES") {
                    echo "<div class=\"time\">Сериал</div>";
                }elseif ($v[7]=="MINI_SERIES") {
                    echo "<div class=\"time\">Мини-сериал</div>";
                }
                echo "<div class=\"time\" style='margin-top:18px;'>".$v[2]."</div>";
                        echo "<div class=\"channels-card-image\">
                        <a href=\"video-page.php?filmId=" . $v[0] . "\"><img class=\"img-fluid\" src=\"" . $v[6] . "\" alt=\"\"></a>
                       <div class=\"channels-card-image-btn\"><button type=\"button\" onclick=\"window.location.href='video-page.php?filmId=" . $v[0] . "'\"
                       class=\"btn btn-outline-secondary btn-sm\">" . $v[1] . "";
                    echo "<span style='padding-left: 8px;'><i class=\"fas fa-star\"></i>&nbsp;".$v[4];
                    echo "</span>";
                echo "</a></button></div>
                       </div>
                        <div class=\"channels-card-body\">                                  
                         <div class=\"channels-view\">
                         " . str_ireplace(",",", ",$v[3]) . "
                        </div>
                        </div>
                        </div>
                    </div>";
            }
        }
        ?>
    </div>
</div>
<hr class="mt-0">
<?php } ?>
</div>
<?php include_once("footer.php");?>

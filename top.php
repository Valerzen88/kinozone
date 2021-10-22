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
            <a href="https://icmarkets.com/?camp=26550">
            <img class="img-fluid" style="height:250px;" src="img/icmarkets.png" alt="Топ брокер"></a>
            <a href="https://www.alpari.org/register/open-account?my=open-account&partner_id=4701374" target="_blank">
                <img class="img-fluid" style="height:250px;" src="https://profile.alparipartners.org/static/interface/img/banners/BackUp/EN/AINT_Backup_EN_497x313.jpg"></a>
        </div>
    </div>
</div>
<hr class="mt-0">
<?php } elseif(isset($_GET['qp'])){
    $conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS);
    $sql = "SELECT tops.filmId,tops.nameRu,tops.year,tops.genres,tops.rating,tops.ratingVoteCount,tops.posterUrl,films.type 
            FROM kinozone.tops inner join kinozone.films on films.kinopoiskId=tops.filmId where tops.top_type=".
            $_GET['qp']." order by tops.ratingVoteCount desc";
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
                       <div class=\"channels-card-image-btn\"><button type=\"button\" onclick=\"window.location.href='video-page.php?filmId=" . $v[1] . "'\"
                       class=\"btn btn-outline-secondary btn-sm\">" . $v[1] . "";
                    echo "<span style='padding-left: 8px;'><i class=\"fas fa-star\"></i>&nbsp;".$v[4];
                    echo "</span>";
                echo "</a></button></div>
                       </div>
                        <div class=\"channels-card-body\">                                  
                         <div class=\"channels-view\">
                         " . $v[3] . "
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

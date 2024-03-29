<?php
include("config.php");
include("switcher.php");
//include("queries.php");
$film_info = array();
$top_20_films = array();
if(isset($conn)) {
    $sql = "SELECT * FROM kinozone.films WHERE year=2021 and filmLength>10 and ratingKinopoisk>'6.0' order by ratingKinopoiskVoteCount desc limit 20";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 1) {
            while ($row = mysqli_fetch_row($result)) {
                array_push($top_20_films, $row);
            }
            mysqli_free_result($result);
        }
    }
    $genres = array();
    $sql = "SELECT * FROM genre";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 1) {
            while ($row = mysqli_fetch_row($result)) {
                array_push($genres, $row);
            }
            mysqli_free_result($result);
        }
    }
}
if (isset($_POST['searchvalue'])) {
    $sql = "SELECT kinopoiskId FROM films where nameRu=\"" . Switcher::toCyrillic($_POST["searchvalue"]) . "\" 
	OR nameOriginal=\"" . Switcher::fromCyrillic($_POST["searchvalue"]) . "\" OR kinopoiskId=\"" . $_POST["searchvalue"]
        . "\" or year like \"%" . $_POST["searchvalue"] . "%\"";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_row($result)) {
                $new_uri = str_replace("index.php", "video-page.php?filmId=" . $row[0], $_SERVER["REQUEST_URI"]);
            }
            mysqli_free_result($result);
            mysqli_close($conn);
            header('Location: ' . $new_uri);
            exit();
        } else if (mysqli_num_rows($result) > 1) {
            $new_uri = str_replace("index.php", "videos_list.php?s=" . $_POST["searchvalue"], $_SERVER["REQUEST_URI"]);
            mysqli_free_result($result);
            mysqli_close($conn);
            header('Location: ' . $new_uri);
            exit();
        }
    }
} else {
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
          content="Скучно? Начинайте смотреть фильмы онлайн бесплатно в хорошем качестве. Самая большая кинотека и удобная сортировка позволяет выбрать лучшее кино или сериал на любой вкус на любом устройстве"/>
    <meta name="keywords" content="смотреть, фильмы, сериалы, мультики, мультфильмы, онлайн, бесплатно"/>
    <meta name="author" content="KINOZONE.CO">
    <title>KINOZONE.CO - Смотри фильмы и сериалы онлайн на любом устройстве!</title>
    <!-- Favicon Icon -->
    <!-- Für Apple-Geräte -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon-180x180.png">
    <!-- Für Browser -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon/favicon-32x32.ico">
    <link rel="icon" type="image/png" sizes="96x96" href="img/favicon/favicon-96x96.png">
    <!-- Für Windows Metro -->
    <meta name="msapplication-square310x310logo" content="img/favicon/mstile-310x310.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/main.min.css" rel="stylesheet">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="vendor/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="vendor/owl-carousel/owl.theme.css">
	<link href="https://vjs.zencdn.net/7.15.4/video-js.css" rel="stylesheet" />
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.input-group input[type="text"]').on("keyup input", function () {
                /* Get input value on change */
                var inputVal = $(this).val();
                var resultDropdown = $(this).siblings(".result");
                if (inputVal.length > 3) {
                    $(".icon-container").show();
                    $.post("queries.php", {livesearch: inputVal})
                        .done(function (data) {
                            // Display the returned data in browser
                            resultDropdown.html(data).after(function () {
                                $('.icon-container').hide();
                            });
                        });
                } else if (inputVal.length === 0) {
                    resultDropdown.empty();
                }
            });
            // Set search input value on click of result item
            $(document).on("click", ".result p", function () {
                $(this).parents(".input-group").find('input[type="text"]').val($(this).text());
                $(this).parent(".result").val('');
                $(this).parent(".result").empty();
            });
        });
    </script>
</head>
<body id="page-top">
<nav class="navbar navbar-expand navbar-light bg-white static-top osahan-nav sticky-top">
    &nbsp;&nbsp;
    <button class="btn btn-link btn-sm text-secondary order-1 order-sm-0" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button> &nbsp;&nbsp;
    <a class="navbar-brand mr-1" href="/"><img class="img-fluid" alt="kinozone.co"
                                               src="img/logo_kinozone_small.png"></a>
    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-5 my-2 my-md-0 osahan-navbar-search"
          method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="input-group">
            <input type="text" class="form-control" name="searchvalue"
                   placeholder="Поиск по названию фильма или сериала...">
            <div class="icon-container" style="display: none;">
                <i class="loader"></i>
            </div>
            <div class="input-group-append">
                <button class="btn btn-light" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="result"></div>
        </div>
    </form>
    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0 osahan-right-navbar">
        <li class="nav-item mx-1">
            <a class="nav-link" href="upload-video.php">
                <i class="fas fa-plus-circle fa-fw"></i>
                Добавить
            </a>
        </li>
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false" title="Добавлено за сегодня">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger">9+</span>
            </a>
            <div style="display:none" class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
                <a class="dropdown-item" href="#"><i class="fas fa-fw fa-edit "></i> &nbsp; Action</a>
                <a class="dropdown-item" href="#"><i class="fas fa-fw fa-headphones-alt "></i> &nbsp; Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star "></i> &nbsp; Something else here</a>
            </div>
        </li>
        <li class="nav-item dropdown no-arrow mx-1">
            <div style="display:none">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-envelope fa-fw"></i>
                    <span class="badge badge-success">7</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
                    <a class="dropdown-item" href="#"><i class="fas fa-fw fa-edit "></i> &nbsp; Action</a>
                    <a class="dropdown-item" href="#"><i class="fas fa-fw fa-headphones-alt "></i> &nbsp; Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star "></i> &nbsp; Something else here</a>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown no-arrow osahan-right-navbar-user">
            <a class="nav-link dropdown-toggle user-dropdown-link" href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle fa-lg"></i><!--<img alt="Avatar" src="img/user.png">-->
                Гость
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="account.html"><i class="fas fa-fw fa-user-circle"></i> &nbsp; My Account</a>
                <a class="dropdown-item" href="subscriptions.html"><i class="fas fa-fw fa-video"></i> &nbsp;
                    Subscriptions</a>
                <a class="dropdown-item" href="settings.html"><i class="fas fa-fw fa-cog"></i> &nbsp; Settings</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i
                            class="fas fa-fw fa-sign-out-alt"></i> &nbsp; Logout</a>
            </div>
        </li>
    </ul>
</nav>
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="/">
                <i class="fas fa-fw fa-home"></i>
                <span>Главная</span>
            </a>
        </li>
        <li class="nav-item" style="display: none">
            <a class="nav-link" href="recently_added.php">
                <i class="fas fa-fw fa-users"></i>
                <span>Новинки</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="videos_list.php?year=2021">
                <i class="fas fa-fw fa-film"></i>
                <span>2021 (<?php echo $films_amount_2021[0][0]; ?>)</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="videos_list.php?year=2020">
                <i class="fas fa-fw fa-film"></i>
                <span>2020 (<?php echo $films_amount_2020[0][0]; ?>)</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="videos_list.php?year=2019">
                <i class="fas fa-fw fa-film"></i>
                <span>2019 (<?php echo $films_amount_2019[0][0]; ?>)</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="upload-video.php">
                <i class="fas fa-fw fa-cloud-upload-alt"></i>
                <span>Добавить фильм</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="history-page.html">
                <i class="fas fa-fw fa-history"></i>
                <span>История</span>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">
                <i class="fas fa-fw fa-list-alt"></i>
                <span>Категории</span>
            </a>
            <div class="dropdown-menu">
                <?php
                foreach ($genres as $k => $v) {
                    echo "<a class=\"dropdown-item\"
                           href=\"videos_list.php?genre=" . $v[0]."\">" . mb_strtoupper($v[0]) . "
                        </a>";
                }
                ?>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="categories.html" role="navigation" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="true">
                <i class="fas fa-fw fa-list-alt"></i>
                <span>Телевидение</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="1tv.php">1 канал</a>
                <a class="dropdown-item" href="ctc.php">СТС</a>
                <a class="dropdown-item" href="tnt.php">ТНТ</a>
            </div>
        </li>
    </ul>
    <div id="content-wrapper">
        <div class="container-fluid pb-0">
            <div class="top-mobile-search">
                <div class="row">
                    <div class="col-md-12">
                        <form class="mobile-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="input-group">
                                <input type="text" name="searchvalue" placeholder="Поиск по сайту..."
                                       class="form-control">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-dark"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
                    <div class="col-md-8">
                        <div class="single-video-left">
                            <div class="single-video">
							 <iframe src="https://spbtv.com/player-spbtv/?id=1051&catalogue=2&type=2&m=18423466&lang=ru&dfl=1" width="100%" height="460" frameborder="0" allowfullscreen gesture="media" allow="encrypted-media"></iframe>
							
							
                            </div>
                            <div class="single-video-title box mb-3">
                                <h2>Прямая трансляция Первого канала в HD.</h2>
                                <p>Всегда на Первом месте. Формула Первого. Первый покажет.</p>
                            </div>
                            <div class="single-video-info-content box mb-3">
                                <h6>Описание:</h6>
                                <p> Первый канал - старейший телеканал и лидер по показу самых рейтинговых программ на российском телевидении.
                                    «КВН» (Клуб Весёлых и Находчивых), «Что? Где? Когда?», «Поле чудес», «Кто хочет стать миллионером?», «Минута славы», «Пусть говорят», «Человек и закон» - вот далеко не полный список полюбившихся зрителям телепередач.
                                    Новостные и аналитические программы помогают быть в курсе текущих событий. Первый канал лидирует и по числу премьер новых фильмов и сериалов, в создании многих из которых принимает непосредственное участие.</h2>
                                </p>
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
                </div>
            </div>
        </div>
        <hr class="mt-0">
        <!-- /.container-fluid -->
        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container">
                <div style="" role="contentinfo">
                    <p>У Вас выдался тяжелый денёк? Устали после учебы или работы? Не знаете, как поднять себе
                        настроение или развлечься? Начинайте <strong>смотреть фильмы онлайн бесплатно</strong> на нашем
                        портале! Интересное кино всегда помогает расслабиться, получить заряд бодрости и позитива до
                        конца дня.</p>
                    <p>Сегодня достаточно сложно представить нашу жизнь без кинематографа. Он охватывает практически все
                        сферы деятельности человека. Ему чуть больше века, однако, это искусство постоянно
                        совершенствуется и меняется в лучшую сторону.</p>
                    <p>На сегодняшний день снимается
                        такое большое количество фильмов, что почти каждый день проходят премьеры по всему миру. Однако
                        в стремительном ритме современной жизни не у каждого есть возможность посещать кинотеатры для
                        того, чтобы насладиться просмотром желаемой кинокартины или познакомиться с новинкой, вышедшей
                        недавно на большие экраны. В данном случае прекрасной альтернативой является КиноКрад. Сегодня у
                        нас можно смотреть лучшие <strong>фильмы в хорошем качестве</strong>, не выходя из дома или
                        офиса, и все это удовольствие доступно без регистрации. Кинотека насчитывает огромное количество
                        онлайн фильмов всевозможных жанров, как <a href="https://kinozone.co/russkie/">российского</a>,
                        так и <a href="https://kinozone.co/zarubezhnye/">зарубежного</a> производства.</p>
                    <p>Представленные у нас картины заставят грустить или радоваться, заглянуть в будущее или вспомнить
                        прошлое, погрузят Вас в мир <a href="https://kinozone.co/fantastika/">фантастики</a> и леденящих
                        дух ужасов, а так же помогут узнать много нового и интересного.</p>
                    <p>Хорошей идеей будет провести свободный вечер с любимым человеком за просмотром романтической
                        драмы. Собрать всех родственников можно на просмотр интересных семейных художественных <a
                                href="/filmy-2021-novinki/">фильмов 2021</a>. Мужчинам отлично подойдут детективы и
                        триллеры. От души повеселиться можно во время сеанса смешной <a
                                href="https://kinozone.co/komediya/">комедии</a>. Вместе с детьми можно посмотреть кино
                        онлайн приключенческого жанра.</p>
                    <p>Изюминкой нашего сайта является специальный киношный фильтр, а так же сортировки в категориях,
                        предназначенные для поиска лучших фильмов в нашей огромной библиотеке. Данные модули позволяют
                        найти и отобрать на сайте самые лучшие картины, соответствующие Вашим требованиям.</p>
                    <p>Бесплатный просмотр любимой киноленты - это отличная возможность отвлечься от повседневных
                        проблем и хлопот. Популярные фильмы онлайн в высоком качестве позволят с головой погрузиться в
                        захватывающий, фантастический, сказочный или вполне реальный мир. Они способны увлечь,
                        пощекотать нервы, растрогать, а классические или новые фильмы всегда учат чему-то новому,
                        открывают неизведанные грани, а иногда даже являются хорошими помощниками и советчиками.</p>
                </div>
                <div class="row no-gutters">
                    <div class="col-lg-6 col-sm-6">Сделано с <i class="fas fa-heart text-danger"></i> в 2021 :: <strong
                                class="text-dark">KINOZONE.CO</strong>.
                        <a href="copyright_terms.php">Правообладателям</a> | <a href="/">Главная</a> | Иконки от <a target="_blank" href="https://icons8.ru">Icons8</a><br>

                        </p>
                    </div>
                    <div class="col-lg-6 col-sm-6 text-right">

                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- /#wrapper -->
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Owl Carousel -->
<script src="vendor/owl-carousel/owl.carousel.js"></script>
<!-- Custom scripts for all pages-->
<script src="js/custom.js"></script>
<script src="https://vjs.zencdn.net/7.15.4/video.min.js"></script>
</body>
</html>
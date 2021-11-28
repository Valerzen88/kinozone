<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php if(stripos($actual_link,"video-page")!=false) {?>
        <meta property="og:type" content="video.movie" />
        <meta property="og:url" content="<?php echo $actual_link; ?>" />
        <meta property="og:image" content="<?php echo $film_info[0][6]; ?>" />
    <?php }?>
    <meta name="description"
          content="Скучно? Начинайте смотреть фильмы онлайн бесплатно в хорошем качестве. Самая большая кинотека и удобная сортировка позволяет выбрать лучшее кино или сериал на любой вкус на любом устройстве"/>
    <meta name="keywords" content="киного, кинозон, кинокрад, смотреть, фильмы, сериалы, мультики, мультфильмы, онлайн, бесплатно, новинки, в хорошем качестве, 2021, 2022, лучшие"/>
    <meta name="author" content="KINOZONE.CO">
    <!-- Yandex.Metrika counter --> <script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(85895426, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/85895426" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
    <?php $years="";if($film_info[0][30]=="TV_SERIES" && $film_info[0][35]!==NULL) {$years=$film_info[0][35]." - ".$film_info[0][36];}
    else{$years=$film_info[0][22];}?>
    <title>KINOZONE.CO - <?php echo $film_info[0][3]." (".$years.")"; ?> - смотреть онлайн </title>
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
    <link href="css/osahan.css" rel="stylesheet">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="vendor/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="vendor/owl-carousel/owl.theme.css">
    <script src="https://www.gstatic.com/cv/js/sender/v1/cast_sender.js?loadCastFramework=1"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            /*$('.input-group input[type="text"]').on("keyup input", function () {
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
            });*/
            // Set search input value on click of result item
            $(document).on("click", ".result p", function () {
                $(this).parents(".input-group").find('input[type="text"]').val($(this).text());
                $(this).parent(".result").val('');
                $(this).parent(".result").empty();
            });

            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ||
                (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.platform))) {
                $('#retro-comments').collapse();
            }
        });
        window['__onGCastApiAvailable'] = function(isAvailable) {
            if (isAvailable) {
                initializeCastApi();
            }
        };
        initializeCastApi = function() {
            cast.framework.CastContext.getInstance().setOptions({
                receiverApplicationId: applicationId,
                autoJoinPolicy: chrome.cast.AutoJoinPolicy.ORIGIN_SCOPED
            });
            cast.framework.CastContext.getInstance().setOptions({
                receiverApplicationId: chrome.cast.media.DEFAULT_MEDIA_RECEIVER_APP_ID
            });
        };
        function openWhatsApp() {
            //window.open('whatsapp://send?text='');
        }
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
            <input type="text" class="form-control" name="q"
                   placeholder="Поиск по названию фильма или сериала...">
            <div class="icon-container" style="display: none;">
                <i class="loader"></i>
            </div>
            <div class="input-group-append">
                <button class="btn btn-light" type="submit" formaction="<?php echo $_SERVER['PHP_SELF']; ?>">
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
            <a class="nav-link" href="top.php">
                <i class="fas fa-star"></i>
                <span>Топ фильмы</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="videos_list.php?year=2021">
                <i class="fas fa-fw fa-film"></i>
                <span>Фильмы 2021 (<?php echo $films_y_amount[2021]; ?>)</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="videos_list.php?year=2020">
                <i class="fas fa-fw fa-film"></i>
                <span>Фильмы 2020 (<?php echo $films_y_amount[2020]; ?>)</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="videos_list.php?year=2019">
                <i class="fas fa-fw fa-film"></i>
                <span>Фильмы 2019 (<?php echo $films_y_amount[2019]; ?>)</span>
            </a>
        </li>
		<li class="nav-item">
            <a class="nav-link" href="serials.php">
                <i class="fas fa-fw fa-tv"></i>
                <span>Сериалы (<?php echo $serials_amount['all_serials']; ?>)</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="tv.php">
                <i class="fas fa-fw fa-tv"></i>
                <span>Телевидение</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="upload-video.php">
                <i class="fas fa-fw fa-cloud-upload-alt"></i>
                <span>Добавить фильм</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="history.php">
                <i class="fas fa-fw fa-history"></i>
                <span>История</span>
            </a>
        </li>
        <li class="nav-item" style="display: none;">
            <a class="nav-link dropdown-toggle" href="categories.html" data-toggle="dropdown"
               role="navigation" aria-expanded="true">
                <i class="fas fa-fw fa-list-alt"></i>
                <span>Категории</span>
            </a>
            <div class="dropdown-menu">
                <?php
                /*foreach ($genres as $k => $v) {
                    echo "<a class=\"dropdown-item\"
                           href=\"videos_list.php?genre=" . $v[0]."\">
                           <img src=\"img/genres/".$v[0].".png\" height=\"16\" width=\"16\" title=\"
                           " . mb_strtoupper($v[0]) . "\" alt=\"" . mb_strtoupper($v[0]) . "\">
                           " . mb_strtoupper($v[0]) . "
                        </a>";
                }*/
                ?>
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
                                <input type="text" name="q" placeholder="Поиск по сайту..."
                                       class="form-control">
                                <div class="input-group-append">
                                    <button type="submit" formaction="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-dark"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
<?php
include("config.php");
include("switcher.php");
include("queries.php");
$film_info = array();
$top_20_films = array();
$films_list=array();
$films_amount=array();
$results_per_page = 24;
$total_count=0;
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
}
if (isset($_POST['searchvalue'])) {
    $sql = "SELECT kinopoiskId FROM films where nameRu=\"" . Switcher::toCyrillic($_POST["searchvalue"]) . "\" 
	OR nameOriginal=\"" . Switcher::fromCyrillic($_POST["searchvalue"]) . "\" OR kinopoiskId=\"" . $_POST["searchvalue"]
        . "\" or year like \"%" . $_POST["searchvalue"] . "%\" order by kinopoiskId desc";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_row($result)) {
				if(strstr($_SERVER["REQUEST_URI"],"index.php")){
					$new_uri = str_replace("index.php", "videos_list.php?filmId=" . $row[0], $_SERVER["REQUEST_URI"]);
				}else if (strstr($_SERVER["REQUEST_URI"],"videos_list.php")) {
					$new_uri = str_replace("videos_list.php", "videos_list.php?s=" . $row[0], $_SERVER["REQUEST_URI"]);            
				}
            }			
            mysqli_free_result($result);
            mysqli_close($conn);
            header('Location: ' . $new_uri);
            exit();
        } else if (mysqli_num_rows($result) > 1) {
			if(strstr($_SERVER["REQUEST_URI"],"index.php")){
				$new_uri = str_replace("index.php", "videos_list.php?s=" . $_POST["searchvalue"], $_SERVER["REQUEST_URI"]);
			}else if (strstr($_SERVER["REQUEST_URI"],"videos_list.php")) {
				$new_uri = str_replace("videos_list.php", "videos_list.php?s=" . $_POST["searchvalue"], $_SERVER["REQUEST_URI"]);            
			}
            mysqli_free_result($result);
            mysqli_close($conn);
            header('Location: ' . $new_uri);
            exit();
        }else{
			header('Location: /');
            exit();
		}
    }else{
		header('Location: /');
        exit();
	}
}
if(isset($_GET['year'])) {
    $sql="SELECT film_amount FROM years_count where year=".$_GET['year'];
    $result=mysqli_query($conn,$sql);
    if($result) {
        while ($row = mysqli_fetch_row($result)) {
            $total_count=$row[0];
        }
        mysqli_free_result($result);
    }
    $number_of_pages = ceil ($total_count / $results_per_page);
    if (!isset ($_GET['p']) ) {
        $page = 1;
    } else {
        $page = $_GET['p'];
    }
    $page_first_result = ($page-1) * $results_per_page;
    $sql="SELECT * FROM films where filmLength is not null and ratingAwait is null and nameRu IS NOT NULL and year=".$_GET['year'].
	" order by ratingKinopoiskVoteCount desc LIMIT " . $page_first_result . ',' . $results_per_page;
    $result=mysqli_query($conn,$sql);
    if($result) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($films_list,$row);
        }
        mysqli_free_result($result);
    }
    mysqli_close($conn);
}else if(isset($_GET['s'])) {
    $sql="SELECT count(kinopoiskId) FROM films where nameRu like \"%".Switcher::toCyrillic($_GET["s"])."%\" 
	OR nameOriginal like \"%".Switcher::fromCyrillic($_GET["s"])."%\" OR kinopoiskId=\"".$_GET["s"]
        ."\" or year like \"%".$_GET["s"]."%\"";
    $result=mysqli_query($conn,$sql);
    if($result) {
        while ($row = mysqli_fetch_row($result)) {
            $total_count=$row[0];
        }
        mysqli_free_result($result);
    }
    $number_of_pages = ceil ($total_count / $results_per_page);
    if (!isset ($_GET['p']) ) {
        $page = 1;
    } else {
        $page = $_GET['p'];
    }  
    $page_first_result = ($page-1) * $results_per_page;
    $sql="SELECT * FROM films where nameRu like \"%".Switcher::toCyrillic($_GET["s"])."%\" 
	OR nameOriginal like \"%".Switcher::fromCyrillic($_GET["s"])."%\" OR kinopoiskId=\"".$_GET["s"]
        ."\" or year like \"%".$_GET["s"]."%\" order by year desc,ratingKinopoiskVoteCount desc LIMIT " . $page_first_result . ',' . $results_per_page;
    $result=mysqli_query($conn,$sql);
    if($result) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($films_list,$row);
        }
        mysqli_free_result($result);
    }
    mysqli_close($conn);
}else if(isset($_GET['genre'])) {
    $sql="SELECT films_amount FROM genre where genre_one='".$_GET["genre"]."'";
    $result=mysqli_query($conn,$sql);
    if($result) {
        while ($row = mysqli_fetch_row($result)) {
            $total_count=$row[0];
        }
        mysqli_free_result($result);
    }
    $number_of_pages = ceil ($total_count / $results_per_page);
    if (!isset ($_GET['p']) ) {
        $page = 1;
    } else {
        $page = $_GET['p'];
    }
    $page_first_result = ($page-1) * $results_per_page;
    $sql="SELECT * FROM films where nameRu is not null and year<2022 and genre like \"%".$_GET["genre"]."%\" and filmLength is not null and ratingAwait is null order by ratingKinopoiskVoteCount desc LIMIT " . $page_first_result . ',' . $results_per_page;
    $result=mysqli_query($conn,$sql);
    if($result) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($films_list,$row);
        }
        mysqli_free_result($result);
    }
    mysqli_close($conn);
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
    <link href="css/osahan.css" rel="stylesheet">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="vendor/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="vendor/owl-carousel/owl.theme.css">
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
                <button class="btn btn-light" type="button">
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
                           href=\"videos_list.php?genre=" . $v[0]."\">
                           <img src=\"img/genres/".$v[0].".png\" height=\"16\" width=\"16\" title=\"
                           " . mb_strtoupper($v[0]) . "\" alt=\"" . mb_strtoupper($v[0]) . "\">
                           " . mb_strtoupper($v[0]) . "
                        </a>";
                }
                ?>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="categories.html" role="navigation" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="true">
                <i class="fas fa-fw fa-tv"></i>
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

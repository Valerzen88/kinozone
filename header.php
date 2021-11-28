<?php
include("config.php");
include("switcher.php");
include("queries.php");
$film_info = array();
$top_20_films = array();
$top_20_serials = array();
$films_list=array();
$films_amount=array();
$serials_amount=array();
$countries=array();
$results_per_page = 24;
$total_count=0;
$filter_set=false;
$years_arr=array("Год","2021","2020","2019","2018","2017","2016","2015",
    "2014","2013","2012","2011","2010","2009","2008","2007","2006","2005","2004","2003","2002","2001","2000","1999",
    "1998","1997","1996","1995","1994","1993","1992","1991","1990","1989","1988","1987","1986","1985","1984","1983",
    "1982","1981","1980","1979","1978","1977","1976","1975","1974","1973","1972","1971","1970","1969","1968","1967",
    "1966","1965","1964","1963","1962","1961","1960","1959","1958","1957","1956","1955","1954","1953","1952","1951",
    "1950","1949","1948","1947","1946","1945","1944","1943","1942","1941","1940","1939","1938","1937","1936","1935",
    "1934","1933","1932","1931","1930","1929","1928","1927","1926","1925","1924","1923","1922","1921","1920","1919",
    "1918","1917","1916","1915","1914","1913","1912","1911","1910","1909","1908","1907","1906","1905","1904","1903",
    "1902","1901","1900","1899","1898","1897","1896","1895","1894","1893","1892","1891","1890","1889","1888","1887",
    "1885","1883","1881","1878","1874");
$types_arr=array(""=>"Тип картины","FILM"=>"Фильм","TV_SERIES"=>"Сериал","MINI_SERIES"=>"Мини-сериал");
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
function filters(){
    $sql_part="";
    if(isset($_GET['year'])&&strlen($_GET['year'])>0&&$_GET['year']!=="Год") {
        $sql_part.=" and year=".$_GET['year'];
    }
    if(isset($_GET['type'])&&strlen($_GET['type'])>0&&$_GET['type']!=="Тип картины") {
        $sql_part.=" and type='".$_GET['type']."'";
    }
    if(isset($_GET['country'])&&strlen($_GET['country'])>0&&$_GET['country']!=="Страна") {
        $sql_part.=" and country='".$_GET['country']."'";
    }
    if(isset($_GET['genre'])&&strlen($_GET['genre'])>0&&$_GET['genre']!=="Жанр") {
        $sql_part.=" and genre like \"%".$_GET['genre']."%\"";
    }
    return $sql_part;
}
function getOrder(){
    $order_sql=" DESC";
    if(isset($_GET['rating'])) {
        if($_GET['rating']==="rating_ud") {
            $order_sql = " DESC";
        }else if($_GET['rating']==="rating_du") {
            $order_sql = " ASC";
        }
    }
    return $order_sql;
}
if(isset($conn)) {
    $sql = "SELECT * FROM kinozone.top_20";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 1) {
            while ($row = mysqli_fetch_row($result)) {
                array_push($top_20_films, $row);
            }
            mysqli_free_result($result);
        }
    }
	$sql = "SELECT * FROM kinozone.top_20_serials";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 1) {
            while ($row = mysqli_fetch_row($result)) {
                array_push($top_20_serials, $row);
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
	$sql = "SELECT * FROM years_count where keyword='all_serials'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $serials_amount[$row[2]]=$row[1];
            }
            mysqli_free_result($result);
        }
    }
	$genre_serials=array();
	$sql = "SELECT * FROM kinozone.genre_serials where genre_one<>''";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 1) {
            while ($row = mysqli_fetch_row($result)) {
                array_push($genre_serials, $row);
            }
            mysqli_free_result($result);
        }
    }
    $sql = "SELECT country FROM kinozone.countries limit 0,150";
    $result = mysqli_query($conn, $sql);
    array_push($countries,array(0=>"Страна"));
    if ($result) {
        if (mysqli_num_rows($result) > 1) {
            while ($row = mysqli_fetch_row($result)) {
                array_push($countries, $row);
            }
            mysqli_free_result($result);
        }
    }
}
if (isset($_POST['q'])) {
    $sql_filters=filters();
    if(strlen($_POST['q'])==0){
        $sql = "SELECT kinopoiskId FROM films where nameRu is not null and year<2022".$sql_filters." order by year ".
            getOrder().",ratingKinopoiskVoteCount".getOrder()." limit 1000";
    } else {
        $numeric_search="";
        if(is_numeric($_POST['q'])) {
            $numeric_search = " OR kinopoiskId=\"" . $_POST["q"] . "\" OR year like \"%" . $_POST["q"] . "%\" ";
        }
        $sql = "SELECT kinopoiskId FROM films where year<2022".$sql_filters." and nameRu like \"%" . Switcher::toCyrillic($_POST["q"]) . "%\" 
	OR nameOriginal like \"%" . Switcher::fromCyrillic($_POST["q"]) . "%\"".$numeric_search."order by kinopoiskId".getOrder()." limit 10";
    }
    /*$ip = getIPAddress();
    $log = date("d.m.Y H:i:s").":: User with IP-Address=".$ip." request search for '".$_POST['q']."'".PHP_EOL.
        date("d.m.Y H:i:s").":: sql=".$sql.";".PHP_EOL;
    file_put_contents('log_'.date("j.n.Y").'.log', $log, FILE_APPEND);*/
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_row($result)) {
				if(strstr($_SERVER["REQUEST_URI"],"index.php")){
					$new_uri = str_replace("index.php", "video-page.php?filmId=" . $row[0], $_SERVER["REQUEST_URI"]);
				}else if (strstr($_SERVER["REQUEST_URI"],"videos_list.php")) {
					$new_uri = str_replace("videos_list.php", "videos_list.php?q=" . $row[0], $_SERVER["REQUEST_URI"]);
				}else if (strstr($_SERVER["REQUEST_URI"],"top.php")) {
                    $new_uri = str_replace("top.php", "videos_list.php?q=" . $row[0], $_SERVER["REQUEST_URI"]);
                }
            }			
            mysqli_free_result($result);
            mysqli_close($conn);
            header('Location: ' . $new_uri);
            exit();
        } else if (mysqli_num_rows($result) > 1) {
			if(strstr($_SERVER["REQUEST_URI"],"index.php")){
				$new_uri = str_replace("index.php", "videos_list.php?q=" . $_POST["q"], $_SERVER["REQUEST_URI"]);
			}else if (strstr($_SERVER["REQUEST_URI"],"videos_list.php")) {
				$new_uri = str_replace("videos_list.php", "videos_list.php?q=" . $_POST["q"], $_SERVER["REQUEST_URI"]);
			}else if (strstr($_SERVER["REQUEST_URI"],"top.php")) {
                $new_uri = str_replace("top.php", "videos_list.php?q=" . $_POST["q"], $_SERVER["REQUEST_URI"]);
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
if(isset($_GET['q'])) {
    $sql_filters=filters();
    if(strlen($_GET['q'])==0){
        $sql = "SELECT count(kinopoiskId) FROM films where nameRu is not null and year<2022".$sql_filters." order by year".getOrder().",ratingKinopoiskVoteCount".getOrder();
    } else {
        $numeric_search="";
        if(is_numeric($_GET['q'])) {
            $numeric_search = " OR kinopoiskId=\"" . $_GET["q"] . "\" OR year like \"%" . $_GET["q"] . "%\" ";
        }
        $sql = "SELECT count(kinopoiskId) FROM films where year<2022".$sql_filters." and nameRu like \"%" . Switcher::toCyrillic($_GET["q"]) . "%\" 
	OR nameOriginal like \"%" . Switcher::fromCyrillic($_GET["q"]) . "%\"".$numeric_search."order by kinopoiskId".getOrder();
    }
    /*$ip = getIPAddress();
    $log = date("d.m.Y H:i:s").":: User with IP-Address=".$ip." request search for '".$_GET['q']."'".PHP_EOL.
        date("d.m.Y H:i:s").":: sql=".$sql.";".PHP_EOL;
    file_put_contents('log_'.date("j.n.Y").'.log', $log, FILE_APPEND);*/
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
    if(strlen($_GET['q'])==0){
        $sql = "SELECT * FROM films where nameRu is not null and year<2022".$sql_filters." order by year".getOrder().",ratingKinopoiskVoteCount".getOrder()." limit " . $page_first_result . ',' . $results_per_page;
    } else {
        $numeric_search="";
        if(is_numeric($_GET['q'])) {
            $numeric_search = " OR kinopoiskId=\"" . $_GET["q"] . "\" OR year like \"%" . $_GET["q"] . "%\" ";
        }
        $sql = "SELECT * FROM films where year<2022".$sql_filters." and nameRu like \"%" . Switcher::toCyrillic($_GET["q"]) . "%\" 
	OR nameOriginal like \"%" . Switcher::fromCyrillic($_GET["q"]) . "%\"".$numeric_search."order by year".getOrder().",
	ratingKinopoiskVoteCount".getOrder()." LIMIT " . $page_first_result . ',' . $results_per_page;
    }
    $result=mysqli_query($conn,$sql);
    if($result) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($films_list,$row);
        }
        mysqli_free_result($result);
    }
}else if(isset($_GET['year'])) {
    $sql="SELECT count(kinopoiskId) FROM films where filmLength is not null and ratingAwait is null and nameRu IS NOT NULL".
        filters()." order by year".getOrder().", ratingKinopoiskVoteCount".getOrder();
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
    $sql="SELECT * FROM films where filmLength is not null and ratingAwait is null and nameRu IS NOT NULL".
        filters()." order by year".getOrder().", ratingKinopoiskVoteCount".getOrder()." LIMIT " . $page_first_result . ',' . $results_per_page;
    $result=mysqli_query($conn,$sql);
    if($result) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($films_list,$row);
        }
        mysqli_free_result($result);
    }
}else if(isset($_GET['genre'])) {
    $sql="SELECT count(kinopoiskId) FROM genre where nameRu is not null and year<2022".filters()." and filmLength is 
    not null and ratingAwait is null order by year".getOrder().", ratingKinopoiskVoteCount".getOrder();
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
    $sql="SELECT * FROM films where nameRu is not null and year<2022".filters()." and filmLength is 
    not null and ratingAwait is null order by year".getOrder().", ratingKinopoiskVoteCount".getOrder()." LIMIT " . $page_first_result . ',' . $results_per_page;
    $result=mysqli_query($conn,$sql);
    if($result) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($films_list,$row);
        }
        mysqli_free_result($result);
    }
}else if(isset($_GET['genre_serials'])) {
    $sql="SELECT count(kinopoiskId) FROM genre_serials where type=\"TV_SERIES\" and nameRu is not null and year<2022".filters()." and genre like \"%".
        $_GET["genre_serials"]."%\" and filmLength is not null and ratingAwait is null order by year".getOrder().", 
        ratingKinopoiskVoteCount".getOrder();
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
    $sql="SELECT * FROM films where type=\"TV_SERIES\" and nameRu is not null and year<2022".filters()." and genre like \"%".
        $_GET["genre_serials"]."%\" and filmLength is not null and ratingAwait is null order by year".getOrder().", 
        ratingKinopoiskVoteCount".getOrder()." LIMIT " . $page_first_result . ',' . $results_per_page;
    $result=mysqli_query($conn,$sql);
    if($result) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($films_list,$row);
        }
        mysqli_free_result($result);
    }
}
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
        "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <?php /*echo $sql;*/?>
    <meta name="my_id" content="541">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta property="og:title" content="KINOZONE.CO - Смотри фильмы и сериалы онлайн на любом устройстве!" />
    <?php if(stripos($actual_link,"video-page")!=false) {?>
    <meta property="og:type" content="video.movie" />
    <meta property="og:url" content="<?php echo $actual_link;_ ?>" />
    <meta property="og:image" content="<?php echo $film_info[0][6]; ?>" />
    <?php }?>
    <meta name="description"
          content="Скучно? Начинайте смотреть фильмы онлайн бесплатно в хорошем качестве. Самая большая кинотека и удобная сортировка позволяет выбрать лучшее кино или сериал на любой вкус на любом устройстве"/>
    <meta name="keywords" content="киного, кинозон, кинокрад, смотреть, фильмы, сериалы, мультики, мультфильмы, онлайн, бесплатно, новинки, в хорошем качестве, 2021, лучшие"/>
    <meta name="author" content="KINOZONE.CO">
    <!-- Yandex.Metrika counter --> <script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(85895426, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/85895426" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
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
        });
		function generateUUID() { 
			var d = new Date().getTime();//Timestamp
			var d2 = ((typeof performance !== 'undefined') && performance.now && (performance.now()*1000)) || 0;//Time in microseconds since page-load or 0 if unsupported
			return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
				var r = Math.random() * 16;//random number between 0 and 16
				if(d > 0){//Use timestamp until depleted
					r = (d + r)%16 | 0;
					d = Math.floor(d/16);
				} else {//Use microseconds since page-load if supported
					r = (d2 + r)%16 | 0;
					d2 = Math.floor(d2/16);
				}
				return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
			});
		}
		var uuser_id=generateUUID();console.log("uuser_id="+uuser_id);
		function setCookie(cname,cvalue,exdays) {
		  const d = new Date();
		  d.setTime(d.getTime() + (exdays*24*60*60*1000));
		  let expires = "expires=" + d.toGMTString();
		  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
		}

		function getCookie(cname) {
		  let name = cname + "=";
		  let decodedCookie = decodeURIComponent(document.cookie);
		  let ca = decodedCookie.split(';');
		  for(let i = 0; i < ca.length; i++) {
			let c = ca[i];
			while (c.charAt(0) == ' ') {
			  c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
			  return c.substring(name.length, c.length);
			}
		  }
		  return "";
		}

		function checkCookie() {
		  let uuser_id = getCookie("uuser_id");
		  if (uuser_id!=="") {
			//alert("Welcome again " + user);
		  } else {
			setCookie("uuser_id", uuser_id, 30);
		  }
		}
		function sendcount(uuser_id){
		 $.ajax({
				 type: "POST",
				 url: "logging.php",
				 data: {"uuser_id":uuser_id},
				 async: true,
				 success: function(data){ 
					var obj = JSON.parse(data);
					console.log(obj.msg);
			  }})
		}
    </script>
</head>
<body id="page-top" onload="checkCookie()">
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
            <a class="nav-link" onclick="sendcount(uuser_id);" href="videos_list.php?year=2021">
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

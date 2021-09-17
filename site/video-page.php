<?php
include("config.php");
include("switcher.php");
include("queries.php");
$film_info=array();
if(isset($_POST['searchvalue'])) {
	$sql="SELECT kinopoiskId FROM films where nameRu=\"".Switcher::toCyrillic($_POST["searchvalue"])."\" 
	OR nameOriginal=\"".Switcher::fromCyrillic($_POST["searchvalue"])."\" OR kinopoiskId=\"".$_POST["searchvalue"]
	."\" or year like \"%".$_POST["searchvalue"]."%\" limit 1";
	$result=mysqli_query($conn,$sql);
	if($result) {
	  while ($row = mysqli_fetch_row($result)) {
		  $new_uri = $_SERVER["REQUEST_URI"]."?filmId=".$row[0];		
	  }
	  mysqli_free_result($result);
	  header('Location: '.$new_uri);
	  exit();
	}
}
if(isset($_GET['filmId'])&&strlen($_GET['filmId'])!=0){
	$sql="SELECT * FROM films where kinopoiskId=".$_GET["filmId"];
	$result=mysqli_query($conn,$sql);
	if($result) {
		while ($row = mysqli_fetch_row($result)) {
		  array_push($film_info,$row);
		}
		mysqli_free_result($result);
	}
}else if(strlen($_GET['filmId'])==0){
     //header("Location: " . str_replace("video-page.php?filmId=","",$_SERVER["REQUEST_URI"]));
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="ru">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <meta name="description" content="Скучно? Начинайте смотреть фильмы онлайн бесплатно в хорошем качестве. Самая большая кинотека и удобная сортировка позволяет выбрать лучшее кино или сериал на любой вкус на любом устройстве" />
	  <meta name="keywords" content="смотреть, фильмы, сериалы, мультики, мультфильмы, онлайн, бесплатно" />
      <meta name="author" content="KINOZONE.CO">
      <title>KINOZONE.CO - <?php echo $film_info[0][3]." (".$film_info[0][22].")"; ?></title>
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
   </head>
   <body id="page-top">
      <nav class="navbar navbar-expand navbar-light bg-white static-top osahan-nav sticky-top">
         &nbsp;&nbsp; 
         <button class="btn btn-link btn-sm text-secondary order-1 order-sm-0" id="sidebarToggle">
         <i class="fas fa-bars"></i>
         </button> &nbsp;&nbsp;
         <a class="navbar-brand mr-1" href="/"><img class="img-fluid" alt="kinozone.co" src="img/logo_kinozone_small.png"></a>
         <!-- Navbar Search -->
         <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-5 my-2 my-md-0 osahan-navbar-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="input-group">
               <input type="text" class="form-control" name="searchvalue" placeholder="Поиск по названию фильма или сериала...">
               <div class="input-group-append">
                  <button class="btn btn-light" type="submit">
                  <i class="fas fa-search"></i> 
                  </button>
               </div>
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
               <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
               <a class="nav-link dropdown-toggle user-dropdown-link" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fas fa-user-circle fa-lg"></i><!--<img alt="Avatar" src="img/user.png">-->
               Гость 
               </a>
               <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="account.html"><i class="fas fa-fw fa-user-circle"></i> &nbsp; My Account</a>
                  <a class="dropdown-item" href="subscriptions.html"><i class="fas fa-fw fa-video"></i> &nbsp; Subscriptions</a>
                  <a class="dropdown-item" href="settings.html"><i class="fas fa-fw fa-cog"></i> &nbsp; Settings</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-fw fa-sign-out-alt"></i> &nbsp; Logout</a>
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
            <li class="nav-item">
               <a class="nav-link" href="recently_added.php">
               <i class="fas fa-fw fa-users"></i>
               <span>Новинки</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="videos_list.php?year=2021">
               <i class="fas fa-fw fa-film"></i>
               <span>2021 (<?php echo $films_amount[0][0];?>)</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="videos_list.php?year=2020">
               <i class="fas fa-fw fa-film"></i>
               <span>2020 (<?php echo $films_amount[1][0];?>)</span>
               </a>
            </li>
			<li class="nav-item">
               <a class="nav-link" href="videos_list.php?year=2019">
               <i class="fas fa-fw fa-film"></i>
               <span>2019 (<?php echo $films_amount[2][0];?>)</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="upload-video.html">
               <i class="fas fa-fw fa-cloud-upload-alt"></i>
               <span>Добавить фильм</span>
               </a>
            </li>
            <li style="display:none;" class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fas fa-fw fa-folder"></i>
               <span>Pages</span>
               </a>
               <div class="dropdown-menu">
                  <h6 class="dropdown-header">Login Screens:</h6>
                  <a class="dropdown-item" href="login.html">Login</a>
                  <a class="dropdown-item" href="register.html">Register</a>
                  <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
                  <div class="dropdown-divider"></div>
                  <h6 class="dropdown-header">Other Pages:</h6>
                  <a class="dropdown-item" href="404.html">404 Page</a>
                  <a class="dropdown-item" href="blank.html">Blank Page</a>
               </div>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="history-page.html">
               <i class="fas fa-fw fa-history"></i>
               <span>История</span>
               </a>
            </li>
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="categories.html" role="navigation" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
               <i class="fas fa-fw fa-list-alt"></i>
               <span>Категории</span>
               </a>
               <div class="dropdown-menu">
                  <a class="dropdown-item" href="categories.html">Movie</a>
                  <a class="dropdown-item" href="categories.html">Music</a>
                  <a class="dropdown-item" href="categories.html">Television</a>
               </div>
            </li>
			 <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="categories.html" role="navigation" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
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
                             <input type="text" name="searchvalue" placeholder="Поиск по сайту..." class="form-control">
                               <div class="input-group-append">
                                 <button type="submit" class="btn btn-dark"><i class="fas fa-search"></i></button>
                               </div>
                           </div>
                        </form>   
                     </div>
                  </div>
               </div>
               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-8">
                        <div class="single-video-left">
                           <div class="single-video">
                               <div class="uitools" id="videoplayers" style="min-height:450px !important;background-image: url('//pleer.videoplayers.club/web/img/loader.gif');background-repeat: no-repeat;background-position: center;background-color: #ccc;"></div>
                              <script>
                                 var dataUrl=window.location.href;
                                 var my_script_play = document.createElement("script");
                                 my_script_play.setAttribute("src",'//pleer.videoplayers.club/get_player?h=450&kp_id=<?php if(isset($_GET["filmId"])){echo intval($_GET["filmId"]);}else{echo 448;}?>&type=widget&players=videocdn,hdvb,apicollaps,bazon,alloha,ustore,kodik,trailer,torrent&r_id=videoplayers&ani=COLLAPS&ati=&adi=&vni=VIDEOCDN&vti=&vdi=&hni=HDVB&hti=&hdi=&bni=BAZON&bti=&bdi=&alni=ALLOHATV&alti=&aldi=&usni=USTOREBZ&usti=&usdi=&koni=KODIK&koti=&kodi=&tti=&ru='+dataUrl);
                                 my_script_play.async = true;
                                 document.head.appendChild(my_script_play);
                              </script>
                           </div>
                           <div class="single-video-title box mb-3">
                              <h2><?php echo $film_info[0][3]." (".$film_info[0][22].")"; ?></h2>
							  <p><?php echo $film_info[0][26]; ?></p>
                              <p class="mb-0"><i class="fas fa-star"></i> Рейтинг: <?php echo $film_info[0][11]; ?> 
							  <?php $age="";
							  if ($film_info[0][32]=="age0") {
								  $age="0";
							  }else if($film_info[0][32]=="age6"){
								  $age="6";
							  }else if($film_info[0][32]=="age12"){
								  $age="12";
							  }else if($film_info[0][32]=="age16"){
								  $age="16";
							  }else if($film_info[0][32]=="age18"){
								  $age="18";
							  }					  
							  echo "<span style='padding-left:15px;'><i class='fas fa-user-shield'></i>&nbsp;$age+&nbsp;</span>";
							  ?>						  
							  <span style="padding-left:15px;"><i class="fas fa-clock"></i> <?php echo $film_info[0][23];?> мин.</span></p>
                           </div>
                           <div class="single-video-info-content box mb-3">
							  <h6>Описание:</h6>
                              <p><?php echo $film_info[0][25]; ?></p>
                              <h6>В ролях:</h6>
                              <p>Nathan Drake , Victor Sullivan , Sam Drake , Elena Fisher</p>
                              <h6>Категории:</h6>
                              <p><?php echo $film_info[0][34]; ?></p>         
							  <h6>Оригинальное название:</h6>
                              <p><?php echo $film_info[0][5]; ?></p>       							  
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
                     <div class="col-md-4">
                        <div class="single-video-right">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="adblock">
                                    <div class="img">
                                       Google AdSense<br>
                                       336 x 280
                                    </div>
                                 </div>
                                 <div class="main-title">
                                    <div class="btn-group float-right right-action">
                                       <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                                       </a>
                                       <div class="dropdown-menu dropdown-menu-right">
                                          <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                          <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                          <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                       </div>
                                    </div>
                                    <h6>Up Next</h6>
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="video-card video-card-list">
                                    <div class="video-card-image">
                                       <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                                       <a href="#"><img class="img-fluid" src="img/v1.png" alt=""></a>
                                       <div class="time">3:50</div>
                                    </div>
                                    <div class="video-card-body">
                                       <div class="btn-group float-right right-action">
                                          <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right">
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                          </div>
                                       </div>
                                       <div class="video-title">
                                          <a href="#">Here are many variati of passages of Lorem</a>
                                       </div>
                                       <div class="video-page text-success">
                                          Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                       </div>
                                       <div class="video-view">
                                          1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                                       </div>
                                    </div>
                                 </div>
                                 <div class="video-card video-card-list">
                                    <div class="video-card-image">
                                       <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                                       <a href="#"><img class="img-fluid" src="img/v2.png" alt=""></a>
                                       <div class="time">3:50</div>
                                    </div>
                                    <div class="video-card-body">
                                       <div class="btn-group float-right right-action">
                                          <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right">
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                          </div>
                                       </div>
                                       <div class="video-title">
                                          <a href="#">Duis aute irure dolor in reprehenderit in.</a>
                                       </div>
                                       <div class="video-page text-success">
                                          Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                       </div>
                                       <div class="video-view">
                                          1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                                       </div>
                                    </div>
                                 </div>
                                 <div class="video-card video-card-list">
                                    <div class="video-card-image">
                                       <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                                       <a href="#"><img class="img-fluid" src="img/v3.png" alt=""></a>
                                       <div class="time">3:50</div>
                                    </div>
                                    <div class="video-card-body">
                                       <div class="btn-group float-right right-action">
                                          <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right">
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                          </div>
                                       </div>
                                       <div class="video-title">
                                          <a href="#">Culpa qui officia deserunt mollit anim</a>
                                       </div>
                                       <div class="video-page text-success">
                                          Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                       </div>
                                       <div class="video-view">
                                          1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                                       </div>
                                    </div>
                                 </div>
                                 <div class="video-card video-card-list">
                                    <div class="video-card-image">
                                       <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                                       <a href="#"><img class="img-fluid" src="img/v4.png" alt=""></a>
                                       <div class="time">3:50</div>
                                    </div>
                                    <div class="video-card-body">
                                       <div class="btn-group float-right right-action">
                                          <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right">
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                          </div>
                                       </div>
                                       <div class="video-title">
                                          <a href="#">Deserunt mollit anim id est laborum.</a>
                                       </div>
                                       <div class="video-page text-success">
                                          Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                       </div>
                                       <div class="video-view">
                                          1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                                       </div>
                                    </div>
                                 </div>
                                 <div class="video-card video-card-list">
                                    <div class="video-card-image">
                                       <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                                       <a href="#"><img class="img-fluid" src="img/v5.png" alt=""></a>
                                       <div class="time">3:50</div>
                                    </div>
                                    <div class="video-card-body">
                                       <div class="btn-group float-right right-action">
                                          <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right">
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                          </div>
                                       </div>
                                       <div class="video-title">
                                          <a href="#">Exercitation ullamco laboris nisi ut.</a>
                                       </div>
                                       <div class="video-page text-success">
                                          Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                       </div>
                                       <div class="video-view">
                                          1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                                       </div>
                                    </div>
                                 </div>
                                 <div class="video-card video-card-list">
                                    <div class="video-card-image">
                                       <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                                       <a href="#"><img class="img-fluid" src="img/v6.png" alt=""></a>
                                       <div class="time">3:50</div>
                                    </div>
                                    <div class="video-card-body">
                                       <div class="btn-group float-right right-action">
                                          <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right">
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                          </div>
                                       </div>
                                       <div class="video-title">
                                          <a href="#">There are many variations of passages of Lorem</a>
                                       </div>
                                       <div class="video-page text-success">
                                          Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                       </div>
                                       <div class="video-view">
                                          1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                                       </div>
                                    </div>
                                 </div>
                                 <div class="adblock mt-0">
                                    <div class="img">
                                       Google AdSense<br>
                                       336 x 280
                                    </div>
                                 </div>
                                 <div class="video-card video-card-list">
                                    <div class="video-card-image">
                                       <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                                       <a href="#"><img class="img-fluid" src="img/v2.png" alt=""></a>
                                       <div class="time">3:50</div>
                                    </div>
                                    <div class="video-card-body">
                                       <div class="btn-group float-right right-action">
                                          <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right">
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                             <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                          </div>
                                       </div>
                                       <div class="video-title">
                                          <a href="#">Duis aute irure dolor in reprehenderit in.</a>
                                       </div>
                                       <div class="video-page text-success">
                                          Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                       </div>
                                       <div class="video-view">
                                          1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- /.container-fluid -->
            <!-- Sticky Footer -->
            <footer class="sticky-footer">
               <div class="container">
                  <div class="row no-gutters">
                     <div class="col-lg-6 col-sm-6">Сделано с <i class="fas fa-heart text-danger"></i> в 2021 :: <strong class="text-dark">KINOZONE.CO</strong>. 
					 <a href="copyright_terms.php">Правообладателям</a> | <a href="/">Главная</a><br>
                         
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
      <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
      <!-- Bootstrap core JavaScript-->
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- Core plugin JavaScript-->
      <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
      <!-- Owl Carousel -->
      <script src="vendor/owl-carousel/owl.carousel.js"></script>
      <!-- Custom scripts for all pages-->
      <script src="js/custom.js"></script>
   </body>
</html>
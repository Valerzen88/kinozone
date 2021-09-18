<?php
include("config.php");
include("switcher.php");
include("queries.php");
$films_list=array();
$films_amount=array();
if(isset($_GET['year'])) {
	$sql="SELECT count(kinopoiskId) FROM films where year=".$_GET['year']." and nameRu IS NOT NULL";
	$result=mysqli_query($conn,$sql);
	if($result) {
	  while ($row = mysqli_fetch_row($result)) {
		  array_push($films_amount,$row);
	  }
	  mysqli_free_result($result);
	}
	$sql="SELECT * FROM films where year=".$_GET['year']." and nameRu IS NOT NULL order by kinopoiskId desc limit 24";
	$result=mysqli_query($conn,$sql);
	if($result) {
	  while ($row = mysqli_fetch_row($result)) {
		  array_push($films_list,$row);
	  }
	  mysqli_free_result($result);
	}
	mysqli_close($conn);
}else if(isset($_GET['s'])) {
    $sql="SELECT * FROM films where nameRu=\"".Switcher::toCyrillic($_GET["s"])."\" 
	OR nameOriginal=\"".Switcher::fromCyrillic($_GET["s"])."\" OR kinopoiskId=\"".$_GET["s"]
        ."\" or year like \"%".$_GET["s"]."%\"";
    $result=mysqli_query($conn,$sql);
    if($result) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($films_list,$row);
        }
        mysqli_free_result($result);
    }
    mysqli_close($conn);
}else{mysqli_close($conn);}
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
</head>
<body id="page-top">
<nav class="navbar navbar-expand navbar-light bg-white static-top osahan-nav sticky-top">
    &nbsp;&nbsp;
    <button class="btn btn-link btn-sm text-secondary order-1 order-sm-0" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button> &nbsp;&nbsp;
    <a class="navbar-brand mr-1" href="/"><img class="img-fluid" alt="kinozone.co" src="img/logo_kinozone_small.png"></a>
    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-5 my-2 my-md-0 osahan-navbar-search"  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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
                <span>2021 (<?php echo $films_amount_2021[0][0];?>)</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="videos_list.php?year=2020">
                <i class="fas fa-fw fa-film"></i>
                <span>2020 (<?php echo $films_amount_2020[0][0];?>)</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="videos_list.php?year=2019">
                <i class="fas fa-fw fa-film"></i>
                <span>2019 (<?php echo $films_amount_2019[0][0];?>)</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="upload-video.php">
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
                     <div class="col-md-12">
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
                           <h6>Результаты поиска</h6>
                        </div>
                     </div>
                      <?php
                        foreach ($films_list as $k => $v) {
                            if($v[3]!==null) {
                                echo "<div class=\"col-xl-3 col-sm-6 mb-3\">
                                        <div class=\"channels-card\">
                                        <div class=\"channels-card-image\">
                                        <a href=\"video-page.php?filmId=".$v[1]."\"><img class=\"img-fluid\" src=\"" . $v[7] . "\" alt=\"\"></a>
                                       <div class=\"channels-card-image-btn\"><button type=\"button\" onclick=\"window.location.href='video-page.php?filmId=".$v[1]."'\"
                                       class=\"btn btn-outline-secondary btn-sm\">" . $v[3] . "
                                       <i class=\"fas fa-star\"></i>&nbsp;".$v[11]."</a></button></div>
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
                      ?>
                      <div class="col-md-12">
                          <nav aria-label="Page navigation example">
                              <ul class="pagination justify-content-center pagination-sm mb-4">
                                  <li class="page-item disabled">
                                      <a class="page-link" href="#" tabindex="-1">Previous</a>
                                  </li>
                                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                                  <li class="page-item">
                                      <a class="page-link" href="#">Next</a>
                                  </li>
                              </ul>
                          </nav>
                          <div/>
                      </div>
                  </div>
               <hr>
               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-12">
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
                           <h6>Featured Videos</h6>
                        </div>
                     </div>
                     <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="video-card">
                           <div class="video-card-image">
                              <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                              <a href="#"><img class="img-fluid" src="img/v5.png" alt=""></a>
                              <div class="time">3:50</div>
                           </div>
                           <div class="video-card-body">
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
                     </div>
                     <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="video-card">
                           <div class="video-card-image">
                              <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                              <a href="#"><img class="img-fluid" src="img/v6.png" alt=""></a>
                              <div class="time">3:50</div>
                           </div>
                           <div class="video-card-body">
                              <div class="video-title">
                                 <a href="#">There are many variations of passages of Lorem</a>
                              </div>
                              <div class="video-page text-danger">
                                 Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Unverified"><i class="fas fa-frown text-danger"></i></a>
                              </div>
                              <div class="video-view">
                                 1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="video-card">
                           <div class="video-card-image">
                              <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                              <a href="#"><img class="img-fluid" src="img/v7.png" alt=""></a>
                              <div class="time">3:50</div>
                           </div>
                           <div class="video-card-body">
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
                     </div>
                     <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="video-card">
                           <div class="video-card-image">
                              <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                              <a href="#"><img class="img-fluid" src="img/v8.png" alt=""></a>
                              <div class="time">3:50</div>
                           </div>
                           <div class="video-card-body">
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
                    <div style="" role="contentinfo">
                        <p>У Вас выдался тяжелый денёк? Устали после учебы или работы? Не знаете, как поднять себе настроение или развлечься? Начинайте <strong>смотреть фильмы онлайн бесплатно</strong> на нашем портале! Интересное кино всегда помогает расслабиться, получить заряд бодрости и позитива до конца дня.</p>
                        <p>Сегодня достаточно сложно представить нашу жизнь без кинематографа. Он охватывает практически все сферы деятельности человека. Ему чуть больше века, однако, это искусство постоянно совершенствуется и меняется в лучшую сторону.</p>
                        <p><img alt="фильмы онлайн" src="kinozoneco.jpg" style="border-radius:10px; float:left; margin-right:10px">На сегодняшний день снимается такое большое количество фильмов, что почти каждый день проходят премьеры по всему миру. Однако в стремительном ритме современной жизни не у каждого есть возможность посещать кинотеатры для того, чтобы насладиться просмотром желаемой кинокартины или познакомиться с новинкой, вышедшей недавно на большие экраны. В данном случае прекрасной альтернативой является КиноКрад. Сегодня у нас можно смотреть лучшие <strong>фильмы в хорошем качестве</strong>, не выходя из дома или офиса, и все это удовольствие доступно без регистрации. Кинотека насчитывает огромное количество онлайн фильмов всевозможных жанров, как <a href="https://kinozone.co/russkie/">российского</a>, так и <a href="https://kinozone.co/zarubezhnye/">зарубежного</a> производства.</p>
                        <p>Представленные у нас картины заставят грустить или радоваться, заглянуть в будущее или вспомнить прошлое, погрузят Вас в мир <a href="https://kinozone.co/fantastika/">фантастики</a> и леденящих дух ужасов, а так же помогут узнать много нового и интересного.</p>
                        <p>Хорошей идеей будет провести свободный вечер с любимым человеком за просмотром романтической драмы. Собрать всех родственников можно на просмотр интересных семейных художественных <a href="/filmy-2021-novinki/">фильмов 2021</a>. Мужчинам отлично подойдут детективы и триллеры. От души повеселиться можно во время сеанса смешной <a href="https://kinozone.co/komediya/">комедии</a>. Вместе с детьми можно посмотреть кино онлайн приключенческого жанра.</p>
                        <p>Изюминкой нашего сайта является специальный киношный фильтр, а так же сортировки в категориях, предназначенные для поиска лучших фильмов в нашей огромной библиотеке. Данные модули позволяют найти и отобрать на сайте самые лучшие картины, соответствующие Вашим требованиям.</p>
                        <p>Бесплатный просмотр любимой киноленты - это отличная возможность отвлечься от повседневных проблем и хлопот. Популярные фильмы онлайн в высоком качестве позволят с головой погрузиться в захватывающий, фантастический, сказочный или вполне реальный мир. Они способны увлечь, пощекотать нервы, растрогать, а классические или новые фильмы всегда учат чему-то новому, открывают неизведанные грани, а иногда даже являются хорошими помощниками и советчиками.</p>
                    </div>
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
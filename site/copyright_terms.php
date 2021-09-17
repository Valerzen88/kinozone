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
		  $new_uri = str_replace("index.php","video-page.php",$_SERVER["REQUEST_URI"])."?filmId=".$row[0];		
	  }
	  mysqli_free_result($result);
	  mysqli_close($conn);
	  header('Location: '.$new_uri);
	  exit();
	}
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
               <a class="nav-link" href="index.html">
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
            <li class="nav-item channel-sidebar-list" style="display:none;">
               <h6>SUBSCRIPTIONS</h6>
               <ul>
                  <li>
                     <a href="subscriptions.html">
                     <img class="img-fluid" alt="" src="img/s1.png"> Your Life 
                     </a>
                  </li>
                  <li>
                     <a href="subscriptions.html">
                     <img class="img-fluid" alt="" src="img/s2.png"> Unboxing  <span class="badge badge-warning">2</span>
                     </a>
                  </li>
                  <li>
                     <a href="subscriptions.html">
                     <img class="img-fluid" alt="" src="img/s3.png"> Product / Service  
                     </a>
                  </li>
                  <li>
                     <a href="subscriptions.html">
                     <img class="img-fluid" alt="" src="img/s4.png">  Gaming 
                     </a>
                  </li>
               </ul>
         </ul>
  </li>
  <div id="content-wrapper">
            <div class="container-fluid pb-0">
               <div class="top-mobile-search">
                  <div class="row">
                     <div class="col-md-12">   
                        <form class="mobile-search">
                           <div class="input-group">
                             <input type="text" placeholder="Поиск по сайту..." class="form-control">
                               <div class="input-group-append">
                                 <button type="button" class="btn btn-dark"><i class="fas fa-search"></i></button>
                               </div>
                           </div>
                        </form>   
                     </div>
                  </div>
               </div>
<div><h2>Правообладателям</h2>
<div>
	<b>Уважаемые правообладатели!</b><br /><br />Администрация сайта kinokrad.co действует в соответствии с законами Российской Федерации и следует процедурам добровольного урегулирования споров об интеллектуальных правах в соответствии со ст. 15.7 ФЗ-149 «Об информации, информационных технологиях и о защите информации».<br /><br />Информация, размещаемая на данном ресурсе является общедоступной для просмотра ИСКЛЮЧИТЕЛЬНО В ОЗНАКОМИТЕЛЬНЫХ целях.<br /><br />Размещение информации на сайте производится пользователями сайта, путем заполнения соответствующей формы <a href="https://kinozone.co/upload-video.php">добавления фильмов</a>. Перед публикацией материал пользователя может быть дополнен или отредактирован информацией, автоматически собранной из открытых источников в сети Интернет. Видео-контент добавляется пользователями путем указания ссылки на торрент-файл, при этом, контент может быть модифицирован программами конвертации видео в автоматическом режиме.<br /><br />Таким образом, администрация сайта не несет ответственности за соблюдение авторских прав в потоке публикуемой на сайте информации.<br /><br /><span style="font-size:10pt;"><b><span style="color:#FF0000">Если вы обнаружили, что на сайте kinozone.co нарушаются ваши авторские права, просим незамедлительно сообщить по адресу <b><span style="color:#000000"><u>info@kinozone.co</u></span></b> с указанием:</span></b></span><br /><br />1) Подтверждение Ваших прав на соответствующий материал, защищенный законом об авторском праве:<br />— отсканированный, либо качественно сделанный фото снимок документа с печатью, либо…<br />— электронное письмо, полученное с официального домена компании правообладателя, либо…<br />— любой иной документ или информация, которая поможет нам однозначно распознать Вас как настоящего обладателя прав на соответствующий материал.<br /><br />2) Ссылки на страницы нашего сайта, где размещен контент, нарушающий Ваши авторские права.<br />При получении на наш электронный адрес письма, содержащего данное подтверждение, мы обязательно свяжемся с Вами для урегулирования вопроса.
	<br>

</div>
</div>
  </div>
<!-- Sticky Footer -->
            <footer class="sticky-footer">
               <div class="container">
				<div style="" role="contentinfo">			
							
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
       
         <!-- /.content-wrapper -->
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
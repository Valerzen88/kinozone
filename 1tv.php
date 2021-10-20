<?php include_once("header.php");?>
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
                        <div class="single-video-left">
                            <div class="single-video">
                                <iframe src="https://stream.1tv.ru/embed" width="100%" height="460" frameborder="0" allowfullscreen gesture="media" allow="encrypted-media"></iframe>
                            </div>
                            <div class="single-video-title box mb-3">
                                <h2><i class="fas fa-video"></i>&nbsp;Прямая трансляция Первого канала в HD</h2>
                                <p>Всегда на Первом месте. Формула Первого. Первый покажет.</p>
                            </div>
                            <div class="single-video-info-content box mb-3">
                                <h6>Описание:</h6>
                                <p> Первый канал - старейший телеканал и лидер по показу самых рейтинговых программ на российском телевидении.
                                    «КВН» (Клуб Весёлых и Находчивых), «Что? Где? Когда?», «Поле чудес», «Кто хочет стать миллионером?», «Минута славы», «Пусть говорят», «Человек и закон» - вот далеко не полный список полюбившихся зрителям телепередач.
                                    Новостные и аналитические программы помогают быть в курсе текущих событий. Первый канал лидирует и по числу премьер новых фильмов и сериалов, в создании многих из которых принимает непосредственное участие.</h2>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="mt-0">
        <!-- /.container-fluid -->
<?php include_once("footer.php");?>
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
                онлайн фильмов всевозможных жанров, как <a href="#">российского</a>,
                так и <a href="#">зарубежного</a> производства.</p>
            <p>Представленные у нас картины заставят грустить или радоваться, заглянуть в будущее или вспомнить
                прошлое, погрузят Вас в мир <a href="videos_list.php?genre=фантастика">фантастики</a> и леденящих
                дух ужасов, а так же помогут узнать много нового и интересного.</p>
            <p>Хорошей идеей будет провести свободный вечер с любимым человеком за просмотром романтической
                драмы. Собрать всех родственников можно на просмотр интересных семейных художественных <a
                    href="videos_list.php?year=2021">фильмов 2021</a>. Мужчинам отлично подойдут детективы и
                триллеры. От души повеселиться можно во время сеанса смешной <a
                    href="videos_list.php?genre=комедия">комедии</a>. Вместе с детьми можно посмотреть кино
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
<script>
    function showMore(id) {
        var dots = document.getElementById("dots_"+id);
        var moreText = document.getElementById("more_"+id);
        var btnText = document.getElementById("showMoreBtn_"+id);

        if (dots.style.display === "none") {
            dots.style.display = "inline";
            btnText.innerHTML = "читать дальше";
            moreText.style.display = "none";
        } else {
            dots.style.display = "none";
            btnText.innerHTML = "закрыть текст"
            moreText.style.display = "inline";
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('message', function(e) {
            if (!e || !e.data) return;
            var q = document.querySelector('[data-yo="quality"]');
            var t = document.querySelector('[data-yo="translate"]');
            if (e.data.quality && q) {
                q.innerHTML = e.data.quality;
            }
            if (e.data.translate && t) {
                t.innerHTML = e.data.translate;
            }
        });
    });
</script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Owl Carousel -->
<script src="vendor/owl-carousel/owl.carousel.js"></script>
<!-- Custom scripts for all pages-->
<script src="js/custom.js"></script>
</body>
</html>
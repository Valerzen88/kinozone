<?php
include_once("header.php");?>
    <div class="video-block section-padding">
        <div class="row">
            <div class="col-md-12">
                <div class="main-title">
                    <h6>Добавить фильм </h6>
                </div>
                <div class="col-md-4 col-sm-6 mb-3">
                    <form action="#">
                        <label>Кинопоиск ID*&nbsp;
                            <input type="number" name="kinopoiskId" required>
                        </label>
                        <label>IMDB ID&nbsp;
                            <input type="number" name="imdbId">
                        </label>
                        <label>Название*&nbsp;
                            <input type="text" name="nameRu" required>
                        </label>
                        <label>Название на англ.&nbsp;
                            <input type="text" name="nameEn">
                        </label>
                        <label>Год выпуска&nbsp;
                            <input type="number" name="year">
                        </label>
                        <button type="submit">Послать запрос на добавление</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once("footer.php");
?>
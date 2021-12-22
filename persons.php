<?php
include_once("header.php");
$persons=array();
$sql = "SELECT * FROM kinozone.staff where birthday like '%".date("-m-d")."' and nameRu is not null and nameRu<>'' order by nameRu asc";
//SUBSTRING_INDEX(nameRu,' ',-1) like 'а%' limit 25
$result = mysqli_query($conn, $sql);
if ($result) {
    if (mysqli_num_rows($result) > 1) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($persons, $row);
        }
        mysqli_free_result($result);
    }
}
?>
    <div class="video-block section-padding">
        <div class="row">
            <div class="col-md-12">
                <div class="main-title">
                    <h6>Сегодня день рождения у <?php echo count($persons);?> персон</h6>
                    <p style="color: red;"><i>Данная функция находиться ещё в стадии разработки!</i></p>
                </div>
            </div>
            <?php
            foreach ($persons as $k => $v) {
                echo "<div class=\"col-xl-3 col-sm-6 mb-3\">
                        <div class=\"channels-card\">
                            <div class=\"channels-card-image\">
                                <a href=\"person.php?q=" . $v[1] . "\">
                                    <img class=\"img-fluid\" src=\"".$v[6]."\" title=\"" . mb_strtoupper($v[3]) . "\" alt=\"" . mb_strtoupper($v[3]) . "\">
                                    <h6 title='".$v[3]."'>".$v[3]." ";
                                    if($v[4]!=null) {echo "(".$v[4].")";}
                                    echo "</h6>                            
                                </a>
                            </div>
                        </div>
                     </div>";
            } ?>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?php include_once("footer.php");?>
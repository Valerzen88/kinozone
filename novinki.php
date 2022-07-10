<?php include_once("header.php"); ?>

$json = file_get_contents('https://bazon.cc/api/json?token=3841baf1779f13fa4bdc4141603b111e&type=film&page=1');
$obj = json_decode($json);
echo $obj->results;
               <hr>
               
                </div>
            </div>
        </div>
            <!-- /.container-fluid -->
<?php include_once("footer.php");?>
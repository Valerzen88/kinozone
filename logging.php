<?php
include("config.php");
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

if(isset($_POST["uuser_id"])||isset($_GET["uuid"])){
	$ip = getIPAddress();
	if(isset($_POST["uuser_id"])) {$uuid=$_POST["uuser_id"];} else if(isset($_GET["uuid"])){$uuid=$_GET["uuid"];};
	$log = date("d.m.Y H:i:s").":: User with uuid=".$uuid." has IP-Address=".$ip.PHP_EOL;
	file_put_contents('log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
	return "bloob";
}

?>
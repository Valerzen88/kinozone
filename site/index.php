<?php
?>
<html>
<head><title>KinoGO Test</title></head>
<body>
<div class="uitools" id="videoplayers" style="height:45%;width:65%;background-image: url('//pleer.videoplayers.club/web/img/loader.gif');background-repeat: no-repeat;background-position: center;background-color: #ccc;"></div>
<script>
var dataUrl=window.location.href;
console.log("dataUrl="+dataUrl);
var my_script_play = document.createElement("script");
my_script_play.setAttribute("src","//pleer.videoplayers.club/get_player?w=65%&h=45%&type=widget&is_strip=&kp_id=448&players=apicollaps,videocdn,hdvb,bazon,alloha,ustore,kodik,torrent&r_id=videoplayers&ani=COLLAPS&ati=&adi=&vni=VIDEOCDN&vti=&vdi=&hni=HDVB&hti=&hdi=&bni=BAZON&bti=&bdi=&alni=ALLOHATV&alti=&aldi=&usni=USTOREBZ&usti=&usdi=&koni=KODIK&koti=&kodi=&ru="+dataUrl);
my_script_play.async = true;
document.head.appendChild(my_script_play);
</script>
</body>
</html>
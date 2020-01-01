<?php
if(isset($_GET['text'])&&isset($_GET['lang'])){

function GetRealIp()
{
 if (!empty($_SERVER['HTTP_CLIENT_IP']))
 {
   $ip=$_SERVER['HTTP_CLIENT_IP'];
 }
 elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
 {
  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
 }
 else
 {
   $ip=$_SERVER['REMOTE_ADDR'];
 }
 return $ip;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://translate.google.ru/translate_tts?ie=UTF-8&q=".urlencode($_GET['text'])."&tl=".$_GET['lang']);
curl_setopt($ch, CURLOPT_TIMEOUT, 300);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$st = curl_exec($ch);
srand((double) microtime( ) * 1000000);
$url = "translatetts/".uniqid(str_replace (".", "",rand( ).GetRealIp()), false).".mp3";
$fd = @fopen($url, "w");
fwrite($fd, $st);
@fclose($fd);

curl_close($ch);

/*echo '<object type="application/x-shockwave-flash" data="js/dewplayer.swf?mp3='.$url.'" bgcolor="#4E86D9" width="200" height="20">
<param name="movie" value="js/dewplayer.swf?mp3='.$url.'" />
</object>'; */

echo '<object type="application/x-shockwave-flash" data="swf/dewplayer.swf" width="200" height="20" id="dewplayer" name="dewplayer"> <param name="wmode" value="transparent" /><param name="movie" value="swf/dewplayer.swf" /> <param name="flashvars" value="mp3='.$url.'&amp;autostart=1" /> </object>';
}
?>

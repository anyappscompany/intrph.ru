<?php
/* $target = 'http://intrph.ru/';

$db = mysql_connect("216.227.216.46","chinp0","icAcJeH3EayDpH")or die('connect to database failed');
mysql_select_db("chinp0_mphrases", $db);
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET 'utf8'");
$result = mysql_query("SELECT COUNT(*) FROM phrases2 WHERE idn>313177 AND idn<331652");
$totalit = $posts = mysql_result($result,0,0);


$date_time_array = getdate( time() );
$date = "";

$date .= $date_time_array['weekday'].", ";
$date .= $date_time_array['mday']." ";
$date .= $date_time_array['month']." ";
$date .= $date_time_array['year']." ";
$date .= $date_time_array['seconds'].":";
$date .= $date_time_array['minutes'].":";
$date .= $date_time_array['hours']."  +0000";

$newrss = "";
$newrss .= '<?xml version="1.0"?><rss version="2.0"><channel><title>Переводчик словосочетаний</title><link>http://intrph.ru</link><description>Интернет переводчик словосочетаний</description><pubDate>'.$date.'</pubDate>';
for($i=0;$i<5;$i++){
        $rnd = rand(0,intval($totalit));
        $res = mysql_query("SELECT phraseori, translitph  FROM phrases2 WHERE idn=".(313177+$rnd));
        while($row=mysql_fetch_array($res))
        {
          $newrss .= "<item>";
    $newrss .= "<title>".$row['phraseori']."</title>";
    $newrss .= "<link>".$target.$row['translitph'].".html</link>";
    $newrss .= "<description>Читать подробнее ".$target.$row['translitph'].".html</description>";
    $newrss .= "<pubDate>".$date."</pubDate>";
    $newrss .= "<guid>".$row['phraseori']."</guid>";
    $newrss .= "</item>";
          //echo "<a href='".$row['translitph'].".html'>".$row['phraseori']."</a><br />";
        }

        }
$newrss .= @'</channel></rss>';
echo $newrss;
mysql_close($db);*/
?>




<?php
$target = 'http://intrph.ru/';

$db = mysql_connect("216.227.216.46","chinp0","icAcJeH3EayDpH")or die('connect to database failed');
mysql_select_db("chinp0_mphrases", $db);
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET 'utf8'");
$result = mysql_query("SELECT COUNT(*) FROM phrases2");
$totalit = $posts = mysql_result($result,0,0);


$date_time_array = getdate( time() );
$date = "";

$date .= $date_time_array['weekday'].", ";
$date .= $date_time_array['mday']." ";
$date .= $date_time_array['month']." ";
$date .= $date_time_array['year']." ";
$date .= $date_time_array['seconds'].":";
$date .= $date_time_array['minutes'].":";
$date .= $date_time_array['hours']."  +0000";

$newrss = "";
$newrss .= '<?xml version="1.0"?><rss version="2.0"><channel><title>Переводчик словосочетаний</title><link>http://intrph.ru</link><description>Интернет переводчик словосочетаний</description><pubDate>'.$date.'</pubDate>';
for($i=0;$i<5;$i++){
        $rnd = rand(0,intval($totalit));
        $res = mysql_query("SELECT phraseori, translitph  FROM phrases2 WHERE idn=".$rnd);
        while($row=mysql_fetch_array($res))
        {
          $newrss .= "<item>";
    $newrss .= "<title>".$row['phraseori']."</title>";
    $newrss .= "<link>".$target.$row['translitph'].".html</link>";
    $newrss .= "<description>Читать подробнее ".$target.$row['translitph'].".html</description>";
    $newrss .= "<pubDate>".$date."</pubDate>";
    $newrss .= "<guid>".$row['phraseori']."</guid>";
    $newrss .= "</item>";
          //echo "<a href='".$row['translitph'].".html'>".$row['phraseori']."</a><br />";
        }

        }
$newrss .= @'</channel></rss>';
echo $newrss;
mysql_close($db);
?>
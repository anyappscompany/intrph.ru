<?php
$title = "Интернет переводчик словосочетаний";
$kw = "Интернет переводчик словосочетаний";
$descr = "Интернет переводчик словосочетаний";
$htmlt = "";
?>

<?php
//$link = @mysql_connect("216.227.216.46","chinp0_user","hLQOEXf2YUvCG58751lm") or die("Could not connect: " . mysql_error());
/*$db = mysql_connect("localhost","root","asdf45g");
mysql_select_db("tphrases" ,$db);
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET 'utf8'");*/
// Данные для mysql сервера
//echo $_SERVER['REQUEST_URI'];
//$db = mysql_connect("localhost","root","asdf45g");
//mysql_select_db("tphrases", $db);
$db = mysql_connect("216.227.216.46","chinp0","icAcJeH3EayDpH")or die('connect to database failed');
mysql_select_db("chinp0_mphrases", $db);
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET 'utf8'");
$result = mysql_query("SELECT COUNT(*) FROM phrases2");
$totalit = $posts = mysql_result($result,0,0);
if($_SERVER['REQUEST_URI']=='/' or isset($_GET['spc'])){

$num = 25;
// Извлекаем из URL текущую страницу
$page = intval($_GET['spc']);
$page = stripslashes($page);
$page = mysql_real_escape_string($page);
settype($page,'integer');

// Определяем общее число сообщений в базе данных

// Находим общее число страниц
$total = intval(($posts - 1) / $num) + 1;
// Определяем начало сообщений для текущей страницы
$page = intval($page);
// Если значение $page меньше единицы или отрицательно
// переходим на первую страницу
// А если слишком большое, то переходим на последнюю
if(empty($page) or $page < 0) $page = 1;
  if($page > $total) $page = $total;
// Вычисляем начиная к какого номера
// следует выводить сообщения
$start = $page * $num - $num;
// Выбираем $num сообщений начиная с номера $start
//$result = mysql_query("SELECT * FROM phrases LIMIT $start, $num");
$result = mysql_query("SELECT phraseori, translitph FROM phrases2 WHERE idn>$start AND idn<($start+$num)");
// В цикле переносим результаты запроса в массив $postrow
while ( $postrow[] = mysql_fetch_array($result))

?>
<?php

for($i = 0; $i < $num; $i++)
{
  $first = mb_substr($postrow[$i]['phraseori'],0,1, 'UTF-8');//первая буква
$last = mb_substr($postrow[$i]['phraseori'],1);//все кроме первой буквы
$first = mb_strtoupper($first, 'UTF-8');
$last = mb_strtolower($last, 'UTF-8');
$incfLet = $first.$last;

$htmlt.= "<a href='".$postrow[$i]['translitph'].".html'>".$incfLet."</a><br />";
}

?>
<?php
// Проверяем нужны ли стрелки назад
if ($page != 1) $pervpage = '<a href= ./?spc=1><img src="arrows/l2.png" width="10" height="10" alt="" /></a>
                               <a href= ./?spc='. ($page - 1) .'><img src="arrows/l.png" width="10" height="10" alt="" /></a> ';
// Проверяем нужны ли стрелки вперед
if ($page != $total) $nextpage = ' <a href= ./?spc='. ($page + 1) .'><img src="arrows/r.png" width="10" height="10" alt="" /></a>
                                   <a href= ./?spc=' .$total. '><img src="arrows/r2.png" width="10" height="10" alt="" /></a>';

// Находим две ближайшие станицы с обоих краев, если они есть
if($page - 2 > 0) $page2left = ' <a href= ./?spc='. ($page - 2) .'>'. ($page - 2) .'</a> | ';
if($page - 1 > 0) $page1left = '<a href= ./?spc='. ($page - 1) .'>'. ($page - 1) .'</a> | ';
if($page + 2 <= $total) $page2right = ' | <a href= ./?spc='. ($page + 2) .'>'. ($page + 2) .'</a>';
if($page + 1 <= $total) $page1right = ' | <a href= ./?spc='. ($page + 1) .'>'. ($page + 1) .'</a>';

// Вывод меню
$htmlt.= $pervpage.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$nextpage;
}else if(array_pop(explode(".", $_SERVER['REQUEST_URI']))=='html'){

$query2 = substr(substr($_SERVER['REQUEST_URI'],0,-5), 1);
$result = mysql_query("SELECT * FROM phrases2 WHERE translitph='".mysql_real_escape_string(translitIt($query2))."'");
while ( $postrow[] = mysql_fetch_array($result));

$title = $postrow[0]['phraseori'];
$first = mb_substr($title,0,1, 'UTF-8');//первая буква
$last = mb_substr($title,1);//все кроме первой буквы
$first = mb_strtoupper($first, 'UTF-8');
$last = mb_strtolower($last, 'UTF-8');
$title = $first.$last;

$kw = $postrow[0]['phraseori'];
$first = mb_substr($kw,0,1, 'UTF-8');//первая буква
$last = mb_substr($kw,1);//все кроме первой буквы
$first = mb_strtoupper($first, 'UTF-8');
$last = mb_strtolower($last, 'UTF-8');
$kw = $first.$last;

$descr = $postrow[0]['phraseori'];
$first = mb_substr($descr,0,1, 'UTF-8');//первая буква
$last = mb_substr($descr,1);//все кроме первой буквы
$first = mb_strtoupper($first, 'UTF-8');
$last = mb_strtolower($last, 'UTF-8');
$descr = $first.$last;

//substr_replace(strtolower($postrow[0]['phraseori']), strtoupper($postrow[0]['phraseori']),0,1);
  $htmlt.= "<h1>Перевод слова/словосочетания <font color='#990000'>".$postrow[0]['phraseori']."</font> на различные языки мира.</h1>";
$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на азербайджанский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['az']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на албанский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['sq']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на английский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['en']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на арабский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['ar']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на армянский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['hy']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на африкаанс<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['af']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на баскский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['eu']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на белорусский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['be']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на бенгальский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['bn']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на болгарский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['bg']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на валлийский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['cy']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на венгерский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['hu']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на вьетнамский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['vi']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на галисийский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['gl']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на голландский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['nl']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на греческий<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['el']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на грузинский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['ka']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на гуджарати<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['gu']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на датский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['da']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на иврит<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['iw']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на индиш<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['yi']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на индонезийский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['id']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на ирландский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['ga']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на исландский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['is']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на испанский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['es']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на итальянский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['it']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на каннада<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['kn']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на каталанский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['ca']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на китайский(традиционный)<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['zh-TW']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на китайский(упрощенный)<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['zh-CN']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на корейский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['ko']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на креольский(Гаити)<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['ht']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на латынь<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['la']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на латышский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['lv']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на литовский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['lt']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на македонский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['mk']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на малайский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['ms']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на мальтийский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['mt']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на немецкий<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['de']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на норвежский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['no']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на персидский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['fa']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на польский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['pl']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на португальский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['pt']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на румынский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['ro']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на русский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['ru']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на сербский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['sr']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на словацкий<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['sk']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на словенский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['sl']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на суахили<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['sw']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на тагальский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['tl']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на тайский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['th']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на тамильский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['ta']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на телугу<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['te']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на турецкий<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['tr']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на украинский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['uk']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на урду<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['ur']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на финский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['fi']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на французский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['fr']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на хинди<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['hi']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на хорватский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['hr']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на чешский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['cs']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на шведский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['sv']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на эстонский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['et']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";

$htmlt.= "Перевод <b>".$postrow[0]['phraseori']."</b> на японский<br />";
$htmlt.= "<font color='#006600'>&nbsp;&nbsp;&nbsp;&nbsp;".$postrow[0]['ja']."</font><img src='img_ico/yes.png' width='16' height='16' alt='' /><img src='img_ico/no.png' width='16' height='16' alt='' /><br />";


}








function translitIt($str)
{   //ГОСТ 7.79-2000
    $tr = array(
                "Є"=> "YE",
            "І"=> "I",
            "Ѓ"=> "G",
            "і"=> "i",
            "№"=> "",
            "є"=> "ye",
            "ѓ"=> "g",
            "А"=> "A",
            "Б"=> "B",
            "В"=> "V",
            "Г"=> "G",
            "Д"=> "D",
            "Е"=> "E",
            "Ё"=> "YO",
            "Ж"=> "ZH",
            "З"=> "Z",
            "И"=> "I",
            "Й"=> "J",
            "К"=> "K",
            "Л"=> "L",
            "М"=> "M",
            "Н"=> "N",
            "О"=> "O",
            "П"=> "P",
            "Р"=> "R",
            "С"=> "S",
            "Т"=> "T",
            "У"=> "U",
            "Ф"=> "F",
            "Х"=> "X",
            "Ц"=> "C",
            "Ч"=> "CH",
            "Ш"=> "SH",
            "Щ"=> "SHH",
            "Ъ"=> "",
            "Ы"=> "Y",
            "Ь"=> "",
            "Э"=> "E",
            "Ю"=> "YU",
            "Я"=> "YA",
            "а"=> "a",
            "б"=> "b",
            "в"=> "v",
            "г"=> "g",
            "д"=> "d",
            "е"=> "e",
            "ё"=> "yo",
            "ж"=> "zh",
            "з"=> "z",
            "и"=> "i",
            "й"=> "j",
            "к"=> "k",
            "л"=> "l",
            "м"=> "m",
            "н"=> "n",
            "о"=> "o",
            "п"=> "p",
            "р"=> "r",
            "с"=> "s",
            "т"=> "t",
            "у"=> "u",
            "ф"=> "f",
            "х"=> "x",
            "ц"=> "c",
            "ч"=> "ch",
            "ш"=> "sh",
            "щ"=> "shh",
            "ъ"=> "",
            "ы"=> "y",
            "ь"=> "",
            "э"=> "e",
            "ю"=> "yu",
            "я"=> "ya",
            "«"=> "",
            "»"=> "",
            "—"=> "-",
            " — "=> "-",
            " - "=> "-",
            " "=> "-",
            "..."=> "",
            ".."=> "",
            ":"=> "",
            "\""=> "",
            ","=> "",
            "!"=> "",
            ";"=> "",
            "%"=> "",
            "?"=> "",
            "*"=> "",
            "("=> "",
            ")"=> "",
            "\\"=> "",
            "/"=> "",
            "="=> "",
            "'"=> "",
            "&"=> "",
            "^"=> "",
            "$"=> "",
            "#"=> "",
            "@"=> "",
            "~"=> "",
            "`"=> "",
            " "=> "-",
            "."=> "",
            "+"=> "",
    );
    return strtolower(strtr($str,$tr));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <title><?php echo $title; ?></title>
  <meta name="description" content="<?php echo $descr; ?>" />
  <meta name="keywords" content="<?php echo $kw; ?>" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" type="text/css" href="/style.css" />
  <link rel="SHORTCUT ICON" href="/favicon18.ico" type="image/x-icon">
</head>

<body>
<table align="center" width="900px" border="0">
  <tr>
    <td colspan="3" class="logo" height="100px" valign="middle" align="left">
        <img src="lang_img/flag_china.png" width="48" height="48" alt="" />
        <img src="lang_img/flag_england.png" width="48" height="48" alt="" />
        <img src="lang_img/flag_france.png" width="48" height="48" alt="" />
        <img src="lang_img/flag_germany.png" width="48" height="48" alt="" />
        <img src="lang_img/flag_italy.png" width="48" height="48" alt="" />
        <img src="lang_img/flag_japan.png" width="48" height="48" alt="" />
        <img src="lang_img/flag_russia.png" width="48" height="48" alt="" />
        <img src="lang_img/flag_usa.png" width="48" height="48" alt="" />
<img src="lang_img/intrph.png" alt="" /><br />
Поиск на сайте:&nbsp;
        <form action="http://intrph.ru/search.php" id="cse-search-box">
  <div>
    <input type="hidden" name="cx" value="partner-pub-6204413406721291:4488373609" />
    <input type="hidden" name="cof" value="FORID:10" />
    <input type="hidden" name="ie" value="UTF-8" />
    <input type="text" name="q" size="99" />
    <input type="submit" name="sa" value="&#x041f;&#x043e;&#x0438;&#x0441;&#x043a;" />
  </div>
</form>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">google.load("elements", "1", {packages: "transliteration"});</script>
<script type="text/javascript" src="http://www.google.com/cse/t13n?form=cse-search-box&t13n_langs=en"></script>

<script type="text/javascript" src="http://www.google.ru/coop/cse/brand?form=cse-search-box&amp;lang=ru"></script>




<div class="yandexform" onclick="return {'bg': '#4E86D9', 'language': 'ru', 'encoding': 'utf-8', 'suggest': false, 'tld': 'ru', 'site_suggest': false, 'webopt': false, 'fontsize': 12, 'arrow': false, 'fg': '#000000', 'logo': 'rb', 'websearch': false, 'type': 2}"><form action="http://intrph.ru/search.php" method="get"><input type="hidden" name="searchid" value="1843252"/><input name="text"/><input type="submit" value="Найти"/></form></div><script type="text/javascript" src="http://site.yandex.net/load/form/1/form.js" charset="utf-8"></script>




    </td>
  </tr>
  <tr>
    <td valign="top" align="left" colspan="3">
        <table align="center" width="100%">
            <tr>
                <td class="contwrap" valign="top" align="left">
                    <div id="cse-search-results"></div>
<script type="text/javascript">
  var googleSearchIframeName = "cse-search-results";
  var googleSearchFormName = "cse-search-box";
  var googleSearchFrameWidth = 795;
  var googleSearchDomain = "www.google.ru";
  var googleSearchPath = "/cse";
</script>
<script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>
<div id="yandex-results-outer" onclick="return {'tld': 'ru', 'language': 'ru', 'encoding': 'utf-8'}"></div><script type="text/javascript" src="http://site.yandex.net/load/site.js" charset="utf-8"></script>

                </td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td colspan="3">...</td>
  </tr>
  <tr>
    <td></td>
    <td>&copy; Интернет переводчик словосочетаний <?php echo "<a href='/'>".$title."</a>"; ?>, 1998-2012.
<noindex><A rel="nofollow" href="http://www.alexa.com/siteinfo/http://intrph.ru"><SCRIPT type='text/javascript' language='JavaScript' src='http://xslt.alexa.com/site_stats/js/t/a?url=http://intrph.ru'></SCRIPT></A></noindex>
</td>
    <td></td>
  </tr>
</table>
<?php mysql_close($db); ?>
</body>

</html>

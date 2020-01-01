<?php
$title = "Интернет переводчик словосочетаний";
$kw = "Интернет переводчик словосочетаний";
$descr = "Интернет переводчик словосочетаний";
$htmlt = "";

function ochistkaznakov($text)
{
//return str_replace ("*","",str_replace ("+","",str_replace ("#","",$text)));
$trans = array("+" => "", "*" => "", "#" => "", '\"' => "", "\'" => "", "." => "");
return strtr($text, $trans);
}
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
//$db = mysql_connect("216.227.216.46","chinp0","icAcJeH3EayDpH")or die('connect to database failed');
$db = mysql_connect("localhost","intrpuser","UqJhW0sgfWrzDhzZyOdI")or die('connect to database failed');
mysql_select_db("intrphru", $db);
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
if ($_SERVER[REQUEST_URI]!="/")
{
$title .= " страница ".$page;
$kw .= " страница ".$page;
$descr .= " страница ".$page;
}

for($i = 0; $i < $num; $i++)
{
$first = mb_substr(ochistkaznakov($postrow[$i]['phraseori']),0,1, 'UTF-8');//первая буква
$last = mb_substr(ochistkaznakov($postrow[$i]['phraseori']),1);//все кроме первой буквы
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
function my_ucfirst($string, $e ='utf-8') {
        if (function_exists('mb_strtoupper') && function_exists('mb_substr') && !empty($string)) {
            $string = mb_strtolower($string, $e);
            $upper = mb_strtoupper($string, $e);
            preg_match('#(.)#us', $upper, $matches);
            $string = $matches[1] . mb_substr($string, 1, mb_strlen($string, $e), $e);
        } else {
            $string = ucfirst($string);
        }
        return $string;
    }

$title = ochistkaznakov($postrow[0]['phraseori']);

 $title =  my_ucfirst($title);

$kw = ochistkaznakov($postrow[0]['phraseori']);

$kw = my_ucfirst($kw);

$descr = ochistkaznakov($postrow[0]['phraseori']);

$descr = my_ucfirst($descr);

//substr_replace(strtolower($postrow[0]['phraseori']), strtoupper($postrow[0]['phraseori']),0,1);
$htmlt.= "<br /><font color='#666666' size='4'>Перевод слова/словосочетания: ".ochistkaznakov($postrow[0]['phraseori'])." на различные языки мира.</font>";
$htmlt.="<br /><span lang='ru' id='test'></span><br />";
$htmlt.="<h1>".ochistkaznakov($postrow[0]['phraseori'])."</h1>";
$htmlt .= "<br /><br />";




$htmlt.= ""." На азербайджанский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['az'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['sq']."','sq','translatettsstatussq');\"/><!--</noindex>-->"." На албанский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['sq'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatussq'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['en']."','en','translatettsstatusen');\"/><!--</noindex>-->"." На английский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['en'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusen'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['ar']."','ar','translatettsstatusar');\"/><!--</noindex>-->"." На арабский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['ar'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusar'></div>";



$htmlt.= '<a class="button" onclick="$(\'#form5\').slideToggle(\'slow\');"
href="javascript://">Свернуть/Развернуть</a><br><br>
<div id="form5" style="display:none;">';



$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['hy']."','hy','translatettsstatushy');\"/><!--</noindex>-->"." На армянский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['hy'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatushy'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['af']."','af','translatettsstatusaf');\"/><!--</noindex>-->"." На африкаанс - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['af'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusaf'></div>";

$htmlt.= ""." На баскский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['eu'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= ""." На белорусский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['be'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= ""." На бенгальский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['bn'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= ""." На болгарский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['bg'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['cy']."','cy','translatettsstatuscy');\"/><!--</noindex>-->"." На валлийский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['cy'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatuscy'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['hu']."','hu','translatettsstatushu');\"/><!--</noindex>-->"." На венгерский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['hu'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatushu'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['vi']."','vi','translatettsstatusvi');\"/><!--</noindex>-->"." На вьетнамский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['vi'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusvi'></div>";

$htmlt.= ""." На галисийский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['gl'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['nl']."','nl','translatettsstatusnl');\"/><!--</noindex>-->"." На голландский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['nl'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusnl'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['el']."','el','translatettsstatusel');\"/><!--</noindex>-->"." На греческий - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['el'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusel'></div>";

$htmlt.= ""." На грузинский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['ka'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= ""." На гуджарати - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['gu'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['da']."','da','translatettsstatusda');\"/><!--</noindex>-->"." На датский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['da'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusda'></div>";

$htmlt.= ""." На иврит - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['iw'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= ""." На индиш - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['yi'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['id']."','id','translatettsstatusid');\"/><!--</noindex>-->"." На индонезийский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['id'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusid'></div>";

$htmlt.= ""." На ирландский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['ga'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['is']."','is','translatettsstatusis');\"/><!--</noindex>-->"." На исландский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['is'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusis'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['es']."','es','translatettsstatuses');\"/><!--</noindex>-->"." На испанский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['es'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatuses'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['it']."','it','translatettsstatusit');\"/><!--</noindex>-->"." На итальянский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['it'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusit'></div>";

$htmlt.= ""." На каннада - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['kn'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['ca']."','ca','translatettsstatusca');\"/><!--</noindex>-->"." На каталанский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['ca'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusca'></div>";

$htmlt.= ""." На китайский(традиционный) - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['zh-TW'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['zh-CN']."','zh-CN','translatettsstatuszh-CN');\"/><!--</noindex>-->"." На китайский(упрощенный) - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['zh-CN'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatuszh-CN'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['ko']."','ko','translatettsstatusko');\"/><!--</noindex>-->"." На корейский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['ko'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusko'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['ht']."','ht','translatettsstatusht');\"/><!--</noindex>-->"." На креольский(Гаити) - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['ht'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusht'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['la']."','la','translatettsstatusla');\"/><!--</noindex>-->"." На латынь - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['la'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusla'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['lv']."','lv','translatettsstatuslv');\"/><!--</noindex>-->"." На латышский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['lv'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatuslv'></div>";

$htmlt.= ""." На литовский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['lt'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['mk']."','mk','translatettsstatusmk');\"/><!--</noindex>-->"." На македонский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['mk'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusmk'></div>";

$htmlt.= ""." На малайский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['ms'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= ""." На мальтийский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['mt'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['de']."','de','translatettsstatusde');\"/><!--</noindex>-->"." На немецкий - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['de'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusde'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['no']."','no','translatettsstatusno');\"/><!--</noindex>-->"." На норвежский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['no'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusno'></div>";

$htmlt.= ""." На персидский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['fa'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['pl']."','pl','translatettsstatuspl');\"/><!--</noindex>-->"." На польский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['pl'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatuspl'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['pt']."','pt','translatettsstatuspt');\"/><!--</noindex>-->"." На португальский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['pt'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatuspt'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['ro']."','ro','translatettsstatusro');\"/><!--</noindex>-->"." На румынский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['ro'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusro'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['ru']."','ru','translatettsstatusru');\"/><!--</noindex>-->"." На русский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['ru'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusru'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['sr']."','sr','translatettsstatussr');\"/><!--</noindex>-->"." На сербский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['sr'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatussr'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['sk']."','sk','translatettsstatussk');\"/><!--</noindex>-->"." На словацкий - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['sk'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatussk'></div>";

$htmlt.= ""." На словенский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['sl'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['sw']."','sw','translatettsstatussw');\"/><!--</noindex>-->"." На суахили - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['sw'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatussw'></div>";

$htmlt.= ""." На тагальский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['tl'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['th']."','th','translatettsstatusth');\"/><!--</noindex>-->"." На тайский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['th'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusth'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['ta']."','ta','translatettsstatusta');\"/><!--</noindex>-->"." На тамильский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['ta'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusta'></div>";

$htmlt.= ""." На телугу - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['te'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['tr']."','tr','translatettsstatustr');\"/><!--</noindex>-->"." На турецкий - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['tr'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatustr'></div>";

$htmlt.= ""." На украинский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['uk'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= ""." На урду - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['ur'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['fi']."','fi','translatettsstatusfi');\"/><!--</noindex>-->"." На финский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['fi'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusfi'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['fr']."','fr','translatettsstatusfr');\"/><!--</noindex>-->"." На французский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['fr'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusfr'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['hi']."','hi','translatettsstatushi');\"/><!--</noindex>-->"." На хинди - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['hi'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatushi'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['hr']."','hr','translatettsstatushr');\"/><!--</noindex>-->"." На хорватский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['hr'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatushr'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['cs']."','cs','translatettsstatuscs');\"/><!--</noindex>-->"." На чешский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['cs'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatuscs'></div>";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['sv']."','sv','translatettsstatussv');\"/><!--</noindex>-->"." На шведский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['sv'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatussv'></div>";

$htmlt.= ""." На эстонский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['et'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";

$htmlt.= "<!--<noindex>--><img class='playgo' height='16px' src='img/playgogreen.png' onclick=\"ajaxFunction3t('".$postrow[0]['ja']."','ja','translatettsstatusja');\"/><!--</noindex>-->"." На японский - ";
$htmlt.= "<font color='#006600'>".ochistkaznakov($postrow[0]['ja'])."</font>. <img src='img_ico/yes.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><img src='img_ico/no.png' width='16' height='16' alt='".ochistkaznakov($postrow[0]['phraseori'])."' /><br />";
$htmlt.= "<div id='translatettsstatusja'></div>";


$htmlt.= "<!-- <noindex> --><br />Ссылка на эту страницу:<br /><textarea cols=70 rows=2><a href='http://intrph.ru/".$postrow[0]['translitph'].".html'><b>".$postrow[0]['phraseori']."</b></a></textarea><!-- </noindex> -->";


$htmlt.= '</div>';


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

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">

<head>
<meta name="propeller" content="6ee6396f3a647f4476e42b990070c325" />
<?php

function cutString($string, $maxlen) {
    $len = (mb_strlen($string) > $maxlen)
        ? mb_strripos(mb_substr($string, 0, $maxlen), ' ')
        : $maxlen
    ;
    $cutStr = mb_substr($string, 0, $len);
    return (mb_strlen($string) > $maxlen)
        ? '' . $cutStr . ' ...'
        : '' . $cutStr . ''
    ;
}


$title2 = cutString($title,120);
$kw2 = cutString($kw.",скачать ".$kw.",смотреть ".$kw.",перевод ".$kw.",читать ".$kw.",история ".$kw.",загрузить ".$kw,260);
$descr2 = cutString($descr.". Подробная информация о ".$descr,260);
?>
  <title><?php echo $title2; ?></title>
  <meta name="description" content="<?php echo $descr2; ?>" />
  <meta name="keywords" content="<?php echo $kw2; ?>" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="/style.css" />
  <link rel="SHORTCUT ICON" href="/favicon18.ico" type="image/x-icon" />

<!-- <noindex> -->
<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?47"></script>

<script type="text/javascript">
  VK.init({apiId: 2833387, onlyWidgets: true});
</script>
<!-- </noindex> -->








<?php
if(isset($_GET['spc']))
{
echo '<meta name="robots" content="noindex,follow" />';
}
?>
<script src="js/jquery.min.js" type="text/javascript"></script>



<script src="js/jquery.tabslideout.v1.2.js" type="text/javascript"></script>
<script type="text/javascript" src="js/addw.js"></script>
<script type="text/javascript">
$(function(){
	$('.panel').tabSlideOut({
		tabHandle: '.handle',
		pathToTabImage: 'img/adslov.png',
		imageHeight: '179px',
		imageWidth: '28px',
		tabLocation: 'left',
		speed: 300,
		action: 'click',
		topPos: '20px',
		fixedPosition: false
	});
});


$(function(){
	$('.panel2').tabSlideOut({
		tabHandle: '.handle2',
		pathToTabImage: 'img/intr.png',
		imageHeight: '146px',
		imageWidth: '28px',
		tabLocation: 'left',
		speed: 300,
		action: 'click',
		topPos: '310px',
		fixedPosition: false
	});
});
</script>

<script type="text/javascript" src="js/perevod.js"></script>
  <script type="text/javascript" >
   <!--
var count=100;
function load1()
{
 document.perevodch.t1.value=count
 document.perevodch.t2.value=count
}
function text1Change()
{
 a=document.perevodch.pv.value.length;
 if((a)>count)document.perevodch.pv.value=document.perevodch.pv.value.substring(0,count);
 a=document.perevodch.pv.value.length;
 document.perevodch.t2.value=count-a;
}
//-->
  </script>

<script type="text/javascript">
$(document).ready(function(){
$('#idpanel1').load('panel1.inc');
});

$(document).ready(function(){
$('#idpanel2').load('panel2.inc');
});

$(document).ready(function(){
$('#test').load('test.inc');
});

$(document).ready(function(){
$('#idplatniki').load('platniki.inc');
});

</script>


<script src="js/translatetts.js" type="text/javascript"></script>
</head>

<body onload=load1()>
<!--<img src="img/mes.png" style="margin-left:100px"/><br />
<img src="img/mes2.png" style="margin-left:100px"/>-->
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

<!--<div class="yandexform" onclick="return {'bg': '#4E86D9', 'language': 'ru', 'encoding': 'utf-8', 'suggest': false, 'tld': 'ru', 'site_suggest': false, 'webopt': false, 'fontsize': 12, 'arrow': false, 'fg': '#000000', 'logo': 'rb', 'websearch': false, 'type': 2}"><form action="http://intrph.ru/search.php" method="get"><input type="hidden" name="searchid" value="1843252"/><input name="text"/><input type="submit" value="Найти"/></form></div><script type="text/javascript" src="http://site.yandex.net/load/form/1/form.js" charset="utf-8"></script>-->
<br />+7 (499) 503 11 45 (Москва) +7 (812) 939 10 12 (Санкт-Петербург) ICQ: 635395619

    </td>
  </tr>

<tr>
    <td colspan="3" valign="middle" align="left">
<a href="perevodchik-skachat-besplatno.html"><img src="img/topm1.png" /></a>
<a href="ustnyj-perevod.html"><img src="img/topm2.png" /></a>
<a href="srochnyj-perevod.html"><img src="img/topm3.png" /></a>
<a href="pismennyj-perevod.html"><img src="img/topm4.png" /></a>
<br /><script type="text/javascript"><!--
google_ad_client = "ca-pub-6204413406721291";
/* INTRPH2 */
google_ad_slot = "0102563304";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</td>
</tr>




<tr>
    <td colspan="3" valign="middle" align="center">

</td>
</tr>




  <tr>
    <td valign="top" align="left" width="200px">
        <table align="center" width="200px">
            <tr>
                <td class="lbar" align="left" valign="top">

<script type="text/javascript"><!--
google_ad_client = "ca-pub-6204413406721291";
/* INTRPHLEFT */
google_ad_slot = "3884421579";
google_ad_width = 180;
google_ad_height = 150;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<p><b>Способы оплаты:</b></p>

<img src="img/oplata.png" height="170px" /><br /><br />



<b>О бюро</b><br />
<a class="button" onclick="$('#form2').slideToggle('slow');"
href="javascript://">Свернуть/Развернуть</a><br><br>
<div id="form2" style="display:none;">
<p><b>Бюро переводов Intrph</b> выполняет устные, письменные, срочные переводы в кротчайшие сроки. Клиентами могут быть фирмы, предприятия, частные лица, общественные организации.</p>

<p>Как известно качественный перевод текстов – это не простая задача. Грамотный перевод это трудоемкий процесс, включающий ряд трудностей, с которыми сталкивается переводчик. Наше бюро переводов имеет штат дипломированных специалистов, которые готовы выполнить переводы текстов любой сложности.</p>
<p>Постоянно растущее количество наших клиентов, говорит о качестве выполняемы переводов, а так же их не завышенной стоимости.</p>
<p>Бюро переводов Intrph следит за качеством своих работ и гарантирует своевременное их выполнение. Мы предоставляем очень выгодные и комфортные условия. Клиенты, воспользовавшиеся нашими услугами однажды, возвращаются к нам снова.</p>
</div>
</td>
            </tr>
        </table>
    </td>
    <td valign="top" align="left">
        <table align="center" width="100%">
            <tr>
                <td class="contwrap" valign="top" align="left">

<?php if ($_SERVER['REQUEST_URI'] == '/') { 
echo '<h3>Переводчик</h3>
<p>09.02.2012 Считается, что профессия переводчика является одной из самых распространенных, востребованных, а так же престижных. Профессиональные переводчики имеют свои специализации: некоторые выполняют переводы научных текстов, некоторые художественных или технических. Переводчики выполняют письменный перевод и устный.  Устный перевод может быть синхронным, последовательным. </p>
<p>Профессия переводчик имеет как свои плюсы, так и минусы. К плюсам относится возможность самореализации в различных видах переводов (перевод журналов, последовательный перевод, письменный и т.д.). Грамотные переводчики востребованы в различных туристических фирмах, PR-компаниях. Переводчик имеет возможность изучать культуру других стран и общаться с разными людьми. </p>
<p>К минусам относится нестабильный объем работы. Оплата не всегда происходит по факту, возможны задержки. Случается, что к переводчикам относятся как к людям второго сорта, хотя от них часто зависит исход деловых переговоров, переводчикам приходится сопровождать заказчика по барам, магазинам, а так же выполнять поручения.</p>
<p>Переводчики могут работать в: музеях, библиотеках, СМИ, сферах гостиничного хозяйства, книжных издательствах, туристических компаниях, министерствах иностранных дел.</p>
<p>Каждый профессиональный переводчик обязан: в совершенстве владеть одним или несколькими иностранными языками, иметь навыки литературного редактирования, знать особенности языковых групп, грамотно владеть родным языком.</p>

';

echo '
		<h3>Наша команда профессионалов</h3>
<table>
  <tr>
    <td><img src="img/angelintrph.jpg" width="107" height="134" alt="" /></td>
    <td><img src="img/buddhalintrph.jpg" width="107" height="133" alt="" /></td>
    <td><img src="img/christinalintrph.jpg" width="107" height="133" alt="" /></td>
  </tr>
  <tr>
    <td><img src="img/deborahlintrph.jpg" width="107" height="133" alt="" /></td>
    <td><img src="img/gennalintrph.jpg" width="107" height="133" alt="" /></td>
    <td><img src="img/joannelintrph.jpg" width="107" height="133" alt="" /></td>
  </tr>
  <tr>
    <td><img src="img/joellintrph.jpg" width="107" height="133" alt="" /></td>
    <td><img src="img/membolintrph.jpg" width="107" height="133" alt="" /></td>
    <td><img src="img/sandralintrph.jpg" width="107" height="133" alt="" /></td>
  </tr>
</table>';


echo "<noindex><p>23.01.2012 Наши специалисты подготовили для Вас базу словосочетаний уже переведенных на более чем 50 языков мира. Ознакомиться с базой словосочетаний Вы можете ниже. Так же Вы можете проголосовать за понравившиеся переводы или не понравившиеся. Словосочетания набравшие более 5 отрицательных отзывов будут повторно проходить проверку.</p>";
echo "<p><img src='img/home2.png' /></p>";
echo "<p>Так же напоминаем, что бы Вы не забывали добавлять свои словосочетания в нашу базу. Поскольку проект не является коммерческим, новые словосочетания будут переводиться по мере возможности.</p>";
echo "<p>В ближайшее время планируется пополнение нашей команды добровольцев. Если Вы обладаете желанием и достаточными знаниями, то свяжитесь с нами через форму обратной связи или ICQ или по телефонам, указанным в верхней части.</p>";
echo "<p><img src='img/home1.png' /></p>";
echo "<h3>Готовые переводы наших специалистов:</h3></noindex>";

}
?>
<b>Комментарии</b><br />
<a class="button" onclick="$('#form4').slideToggle('slow');"
href="javascript://">Свернуть/Развернуть</a><br><br>
<div id="form4" style="display:none;">
<!--noindex-->
<?php if(array_pop(explode(".", $_SERVER['REQUEST_URI']))=='html'){ ?>
<div id="vk_comments"></div>
<script type="text/javascript">
VK.Widgets.Comments("vk_comments", {limit: 10, width: "496", attach: false});
</script>
<?php } ?>
<!--/noindex-->
</div>

                    <?php echo $htmlt; ?>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-6204413406721291";
/* 2intrphbot */
google_ad_slot = "7720391931";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>







                </td>
            </tr>
        </table>
    </td>
    <td valign="top" align="center" width="200px">
        <table align="left" width="100%">
            <tr>
                <td valign="top" align="left" class="rbar">
<p>
<div id="idplatniki"></div>

</p>
<b>О переводчике</b><br />
<a class="button" onclick="$('#form3').slideToggle('slow');"
href="javascript://">Свернуть/Развернуть</a><br><br>
<div id="form3" style="display:none;">
<p><b>Переводчик словосочетаний Intrph</b> – это уникальный интернет справочник, который в первую очередь, полезен тем, кто изучает иностранные языки. Готовые переводы помогут ознакомиться с распространенными словосочетаниями стран мира.</p>


<p>База словосочетаний составлялась на основе литературных произведений. Для некоторых переводов возможны неточности, поэтому переводчик не рекомендуется для начинающих. Переводчик словосочетаний создан в 1998г. В 2011г. изменил свой адрес на текущий.</p>



<p>Переводчик ежедневно пополняется новыми словосочетаниями. Сегодня в базе более 10 000 словосочетаний.</p>
</div>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-6204413406721291";
/* 2intrphrightm */
google_ad_slot = "6488839642";
google_ad_width = 180;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

                    <b>Новые словосочетания:</b> <br />
    <?php
        for($i=0;$i<5;$i++){
        $rnd = rand(0,intval($totalit));
        $res = mysql_query("SELECT phraseori, translitph  FROM phrases2 WHERE idn=".$rnd);
        while($row=mysql_fetch_array($res))
        {
          echo "<a href='".$row['translitph'].".html'>".$row['phraseori']."</a><br />";
        }
        }

    ?>
<br />
<noindex>
<a rel="nofollow" href="http://clck.yandex.ru/redir/dtype=stred/pid=7/cid=1228/*http://pogoda.yandex.ru/moscow"><img src="http://info.weather.yandex.net/moscow/1.ru.png" border="0" alt="Яндекс.Погода"/><img width="1" height="1" src="http://clck.yandex.ru/click/dtype=stred/pid=7/cid=1227/*http://img.yandex.ru/i/pix.gif" alt="" border="0"/></a>
</noindex>
<br />
<noindex>
<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a rel='nofollow' href='http://www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t45.15;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet' "+
"border='0' width='31' height='31'><\/a>")
//--></script><!--/LiveInternet-->

</noindex>



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
<div class="panel" id="panel">
	<a class="handle" href="/">Content</a> <!-- Ссылка для пользователей с отключенным JavaScript -->
	<h3><span lang="ru">Добавить свое словосочетание</span></h3><br>
	<span lang="ru" id="idpanel1">

	</span>
</div>

<div class="panel2" id="panel2">
	<a class="handle2" href="/">Content</a> <!-- Ссылка для пользователей с отключенным JavaScript -->
	<h3><span lang="ru">Онлайн-переводчик</span></h3><br>
	<span lang="ru" id="idpanel2">

	</span>
</div>


</body>

</html>

<?php 
if(isset($_GET['pv']) && isset($_GET['from']) && isset($_GET['to']))
{
  $agent = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 1.1.4322)" ;
  $header [] = "Accept: text/html;" ;
  $header [] = "Accept_charset: utf-8";
  $header [] = "Accept_encoding: identity";
  $header [] = "Accept_language: en-us";
  $header [] = "Connection: Keep-Alive";
  $ch = curl_init ();
  //$url = 'http://translate.google.com/translate_a/t?client=t&text='.urlencode($text).'&sl='.$from.'&tl='.$to;

  $url = 'http://translate.google.com/translate_a/t?client=t&text='.urlencode(utf8_fast_substr($_GET['pv'],100)).'&sl='.$_GET['from'].'&tl='.$_GET['to'].'';
  curl_setopt ( $ch , CURLOPT_URL , $url );
  curl_setopt ( $ch , CURLOPT_RETURNTRANSFER , 1 );
  curl_setopt ( $ch , CURLOPT_VERBOSE , 1 );
  curl_setopt ( $ch , CURLOPT_USERAGENT , $agent );
  curl_setopt ( $ch , CURLOPT_HTTPHEADER , $header );
  curl_setopt ( $ch , CURLOPT_FOLLOWLOCATION , 1 );
  $tmp = curl_exec ( $ch );
  curl_close ( $ch );
  //echo $tmp;
  /*$tmp = substr ($tmp, 1, strlen ($tmp)-2);
  $pos1=strpos($tmp,"trans\":\"")+8;
  $pos2=strpos($tmp,"\"",$pos1);
  $tmp=substr($tmp,$pos1,$pos2-$pos1);*/
  if(preg_match('/\[\[\["(.*?)",/', $tmp, $match))
  {
    echo "<br /><b>".$match[1]."</b><br />";
  }
  //print_r($match);
}
//sleep(3);
function utf8_fast_substr($string, $length)
{
    if (function_exists('mb_substr'))
    {
        /* только при установленном пакете MultiByte. mb_substr быстрее этой функции */
        return mb_substr($string, 0, $length, 'utf-8');
    }

    $pcre = sprintf("/^.{%s}/su", $length);
    $matches = array (
    );
    if (preg_match($pcre, $string, $matches))
    {
        return $matches[0];
    } else
    {
        return $string;
    }

}

?>
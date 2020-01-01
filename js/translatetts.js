var ajax=null;

function getAjax3(){
if (window.ActiveXObject) // для IE
   return new ActiveXObject("Microsoft.XMLHTTP");
else if (window.XMLHttpRequest)
   return new XMLHttpRequest();
else {
   alert("Browser does not support AJAX.");
   return null;
  }
}

function ajaxFunction3t(text1, lang1, stat1){
ajax=getAjax3();
if (ajax != null) {
ajax.open("GET",
"tts.php?text="+encodeURI(text1)+"&lang="+encodeURI(lang1),
true);
ajax.send(null);                                   
var statusElem = document.getElementById(''+stat1);
ajax.onreadystatechange = function(){
  if(ajax.readyState==4){
    statusElem.innerHTML = ajax.statusText;
      /*alert("Ответ сервера: "+ajax.responseText);*/
      if(ajax.status == 200){

        statusElem.innerHTML = ajax.responseText;

      }
      }
  }
}
}
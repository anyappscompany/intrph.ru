var ajax=null;

function getAjax(){
if (window.ActiveXObject) // для IE
   return new ActiveXObject("Microsoft.XMLHTTP");
else if (window.XMLHttpRequest)
   return new XMLHttpRequest();
else {
   alert("Browser does not support AJAX.");
   return null;
  }
}

function ajaxFunction(){
ajax=getAjax();
if (ajax != null) {
ajax.open("POST",
"addw.php",
true);
ajax.send(null);
var statusElem = document.getElementById('addw_status');
ajax.onreadystatechange = function(){
  if(ajax.readyState==4){
    statusElem.innerHTML = ajax.statusText;
      /*alert("Ответ сервера: "+ajax.responseText);*/
      if(ajax.status == 200){
	document.getElementById("in").value = "";
        statusElem.innerHTML = "<font color='#336600'>Ваше словосочетание появится на нашем сайте сразу после его проверки модератором. Спасибо!</font>";
        alert("Ваше словосочетание добавлено");
      }
      }
  }
}
}
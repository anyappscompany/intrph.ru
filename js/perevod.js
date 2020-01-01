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

function ajaxFunction2(){ 
ajax=getAjax();
if (ajax != null) {


/*ajax.open("GET",
"perevod.php?pv="+
  encodeURI(document.getElementById("pv").value)+"&from="+encodeURI(document.getElementById('from').options[from.selectedIndex].value)+"&to="+encodeURI(document.getElementById('to').options[to.selectedIndex].value),
true);*/


ajax.open("GET","perevod.php?pv="+encodeURI(document.getElementById("pv").value)+"&from="+encodeURI(document.getElementById('from').options[from.selectedIndex].value)+"&to=" +encodeURI(document.getElementById('to').options[to.selectedIndex].value),true);


ajax.send(null);
var statusElem = document.getElementById('perevod_status');
ajax.onreadystatechange = function(){
  if(ajax.readyState==4){
    statusElem.innerHTML = ajax.statusText;
      
      if(ajax.status == 200){ 
        statusElem.innerHTML = ajax.responseText;
        
      }
      }
  }
}
}
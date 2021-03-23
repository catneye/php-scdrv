<script language=javascript>
var int=self.setInterval("timer()",3000);
function timer()
{
var element = document.getElementById('test');
$.get('./ajax.php?func=getagenturl', function(data){
    //open popup window
    var element = document.getElementById('test');
    element.innerHTML = data;
    if (data!=""){
        popup=window.open(data);
        popup.focus();
    }
});

}
</script>

<div id='test' name='test'></div>
<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once($app."lang.php");
include_once($app."connect.php");

if ( $_SESSION["username"] ){
    //$deletequery = "update medialib set deldate=now() where name='".$_GET[item]."' and deldate is null";
    //$deleteresult=pg_query($deletequery);
    //echo($arr_lang["delete-ok"]);
    //echo("<a href='index.php?action=panel&option=login'>Login</a>");
    
    echo("</br>");
}
?>
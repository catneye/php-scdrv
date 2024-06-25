<script>
function CheckName(){
var val = document.getElementById('chname').value;
var parent = document.getElementById('chchname');
$.get('./ajax.php?func=checkgatename&param='+val, function(data){
parent.innerHTML=data;
});
}
</script>

<?php

//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once($app."lang.php");
include_once($app."connect.php");

echo ("<table>");
echo ("<form method='post' action='./index.php'>");
echo ("<tr><td colspan='2'>".$arr_lang["create-gateway"]."</td></td>");
echo ("<tr><td>".$arr_lang["name"]."</td><td><input type='text' id='chname' name='chname' style='width: 100%' onchange='CheckName();' value='".$arr_lang["new-gateway"]."' /></td></tr>");
echo ("<tr><td>".$arr_lang["checkname"]."</td><td><div id='chchname' name='chchname'></div></td></tr>");
echo ("<tr><td>".$arr_lang["description"]."</td><td><input type='text' name='description' style='width: 100%' value='".$arr_lang["new-gateway"]."'/></td></tr>");
echo ("<tr><td>".$arr_lang["address"]."</td><td><input type='text' name='address' style='width: 100%' value='address' /></td></tr>");
echo ("<tr><td>".$arr_lang["user"]."</td><td><input type='text' name='user' style='width: 100%' value='user' /></td></tr>");
echo ("<tr><td>".$arr_lang["password"]."</td><td><input type='text' name='password' style='width: 100%' value='XXX'/></td></tr>");

echo ("<tr><td><input type='submit' name='select' value='".$arr_lang["select"]."'></td>");
echo ("<td><input type='hidden' name='action' value='".$_GET["action"]."'>
<input type='hidden' name='option' value='".$_GET["option"]."'>
</td></tr>");
echo ("</form></table>");


?>
<script>
CheckName();
</script>
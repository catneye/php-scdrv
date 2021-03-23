<script>
function isNotMax(oTextArea) {
var ret = oTextArea.value.length <= oTextArea.getAttribute('maxlength');
return ret; 
}
</script>
<?php

//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once($app."lang.php");
include_once($app."connect.php");

echo ("<table width=100%>");
//echo ("<tr width=20%></tr><tr width=80%></tr>");
echo ("<form method='post' action='./index.php'>");
echo ("<tr><td colspan='2'>".$arr_lang["create-ussd"]."</td></td>");


echo ("<tr><td>".$arr_lang["gateway"]."</td><td><select id='gateway' name='gateway' size='1' style='width: 100%'>");
$gwquery = "select id, name from gateways";
$gwresult=pg_query($gwquery);
if ($gwresult){
    while ($gwrow=pg_fetch_row($gwresult)){
        echo("<option value='".$gwrow[0]."'>".$gwrow[1]."</option>");
    }
}
echo("</select></td></tr>");
echo("<tr><td>".$arr_lang["port"]."</td><td><select id='port' name='port' size='1' style='width: 100%'>");
echo("<option value='1 0'>1</option>");
echo("<option value='1 1'>2</option>");
echo("<option value='1 2'>3</option>");
echo("<option value='1 3'>4</option>");
echo("</select></td></tr>");
echo("<tr><td>".$arr_lang["ussd"]."</td><td><input type='text' rows=10 cols=80 name='ussdtext' maxlength='12' onkeypress='return isNotMax(this)' style='width: 100%'/></td></tr>");
echo("<tr><td colspan='2'><div class='usedfilters'>".$arr_lang["maxlen-6"]."</div></td></td>");
echo("<tr><td><input type='submit' name='select' value='".$arr_lang["select"]."'></td>");
echo("<td><input type='hidden' name='action' value='".$_GET[action]."'>
<input type='hidden' name='option' value='".$_GET[option]."'>
</td></tr>");
echo("</form></table>");


?>

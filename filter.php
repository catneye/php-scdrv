<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once("./lang.php");

echo("
<script>
$(function() {
    $( '#bdate' ).datepicker();
    });
$(function() {
    $( '#edate' ).datepicker();
    });
</script>

<form method='get' action='./index.php'>
<table class='filtertable' border='0'>
<tr><td><div>".$arr_lang["alldate"].":&nbsp<input type='checkbox' id='alldate' name='alldate' /></td></tr>

<tr>
<td><div>".$arr_lang["begindate"].":&nbsp<input type='text' id='bdate' name='bdate' /></div></td>
<td><div>".$arr_lang["enddate"].":&nbsp<input type='text' id='edate' name='edate' /></div></td>
<td><div>".$arr_lang["src"].":&nbsp<input type='text' id='src' name='src' /></td>
<td><div>".$arr_lang["dst"].":&nbsp<input type='text' id='dst' name='dst' /></td>
<td><input type='hidden' id='action' name='action' value='".$_GET[action]."'></td>");

if ($_GET[option]){
    echo ("<td><input type='hidden' id='option' name='option' value='".$_GET[option]."'></td>");
}

echo ("</tr>");

echo ("<tr><td><input type='submit' value='".$arr_lang["refresh"]."' /></td><td></td>
</table>
</form>
");

?>
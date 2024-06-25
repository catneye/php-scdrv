<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko


include_once($app."lang.php");

echo ("<table>");
echo ("<form method='post' enctype='multipart/form-data' action='./index.php'>");
echo ("<tr><td colspan='2'>".$arr_lang["upload-base-info"]."</td></td>");
echo ("<tr><td>".$arr_lang["filename"]."</td><td><input type='file' name='media' style='width: 100%' /></td></tr>");
echo ("<tr><td>".$arr_lang["base-limit"]."</td><td><input type='text' name='limit' value='10' style='width: 100%' /></td></tr>");
echo ("<tr><td><input type='submit' name='select' value='".$arr_lang["select"]."'></td>");
echo ("<td><input type='hidden' name='action' value='".$_GET["action"]."'>
<input type='hidden' name='option' value='".$_GET["option"]."'>
<input type='hidden' name='item' value='".$_GET["item"]."'>
</td></tr>");
echo ("</form></table>");

?>
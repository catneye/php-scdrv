<?php
include_once("./lang.php");

echo ("<table>");
echo ("<form method='post' enctype='multipart/form-data' action='./index.php'>");
echo ("<tr><td colspan='2'>".$arr_lang["upload-media-info"]."</td></td>");
echo ("<tr><td>".$arr_lang["filename"]."</td><td><input type='file' name='media' style='width: 100%' /></td></tr>");
echo ("<tr><td>".$arr_lang["description"]."</td><td><input type='text' name='description' style='width: 100%' /></td></tr>");
echo ("<tr><td><input type='submit' name='select' value='".$arr_lang["select"]."'></td>");
echo ("<td><input type='hidden' name='action' value='".$_GET[action]."'><input type='hidden' name='option' value='".$_GET[option]."'></td></tr>");
echo ("</form></table>");

?>
<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once("./lang.php");

echo(
"<table class='menutable' border='0'><tr>"
."<td><div align='left'><a href=index.php?action=champing&option=list>".$arr_lang["list"]."</a></div></td>"
."<td><div align='left'><a href=index.php?action=champing&option=add>".$arr_lang["add"]."</a></div></td>"
."<td><div align='left'><a href=index.php?action=champing&option=macros>".$arr_lang["macros"]."</a></div></td>"
//."<td><div align='left'><a href=index.php?action=champing&option=panel>".$arr_lang["panel"]."</a></div></td>"
."</tr></table>"
);

?>

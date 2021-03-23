<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once($app."lang.php");

//<td><div align='left'><a href=index.php?action=list>".$arr_lang["menulist"]."</a></div></td>
echo(
"<table class='menutable' border='0'><tr>"
."<td><div align='left'><a href=index.php?action=champing>".$arr_lang["champings"]."</a></div></td>"
."<td><div align='left'><a href=index.php?action=medialib>".$arr_lang["medialib"]."</a></div></td>"
//."<td><div align='left'><a href=index.php?action=activity>".$arr_lang["activity"]."</a></div></td>"
."<td><div align='left'><a href=index.php?action=reports>".$arr_lang["reports"]."</a></div></td>"
."<td><div align='left'><a href=index.php?action=scenarios>".$arr_lang["scenarios"]."</a></div></td>"
."<td><div align='left'><a href=index.php?action=gateways>".$arr_lang["gateways"]." </a></div></td>"
."<td><div align='left'><a href=index.php?action=panel>".$arr_lang["panel"]." </a></div></td>"
."</tr></table>"
);

?>
<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once($app."lang.php");

echo("
<table class='menutable' border='0'><tr>
<td><div align='left'><a href=index.php?action=reports&option=list>".$arr_lang["menulist"]."</a></div></td>
<td><div align='left'><a href=index.php?action=reports&option=provider>".$arr_lang["providerproportion"]."</a></div></td>
<td><div align='left'><a href=index.php?action=reports&option=operator>".$arr_lang["operatorproportion"]."</a></div></td>
<td><div align='left'><a href=index.php?action=reports&option=record>".$arr_lang["records"]."</a></div></td>
</tr></table>");

?>
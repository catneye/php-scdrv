<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

session_start();
if ( !$_SESSION["username"] ) exit;

include_once($app."connect.php");
include_once($app."lang.php");

$scenarioquery = "select id, name, url from scenario where deldate is null";
$scenarioresult=pg_query($scenarioquery);

echo ("<table class='btable'><tr><td></td><td></td></tr>");
if ($scenarioresult){
    while ($scenariorow=pg_fetch_row($scenarioresult)){
        echo ("<tr>");
        echo ("<td>".$scenariorow[1]."</td>");
        echo ("<td><a href=# onclick=javascript:window.open('./".$scenariorow[2]."','','') />".$scenariorow[2]."</a></td>");
        echo ("</tr>");
    }
}

echo ("</table>");
?>
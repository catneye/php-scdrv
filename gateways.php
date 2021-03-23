<?php

//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once($app."lang.php");
include_once($app."connect.php");

$dir=$medialib;

echo("<table class='btable'><tr>");
echo("<tr>");
echo("<th class='btableth'>".$arr_lang["name"]."</th>");
echo("<th class='btableth'>".$arr_lang["description"]."</th>");
echo("<th class='btableth'>".$arr_lang["address"]."</th>");
echo("<th class='btableth'>".$arr_lang["user"]."</th>");
echo("<th class='btableth'>".$arr_lang["password"]."</th>");
echo("<th class='btableth'>".$arr_lang["action"]."</th>");
echo("</tr>");

$listquery = "select name, description, address, user, password ,id from gateways where deldate is null";
$listresult=pg_query($listquery);
if ($listresult){
    while ($listrow=pg_fetch_row($listresult)){
        echo("<tr>");
        echo("<td class='btabletd'>".$listrow[0]."</td>");
        echo("<td class='btabletd'>".$listrow[1]."</td>");
        echo("<td class='btabletd'>".$listrow[2]."</td>");
        echo("<td class='btabletd'>".$listrow[3]."</td>");
        //echo("<td class='btabletd'>".$listrow[4]."</td>");
        echo("<td class='btabletd'> ****** </td>");
        echo("<td class='btabletd'><a href=index.php?action=gateways&option=delete&item=".
                            $listrow[5].">". $arr_lang["delete"]."</a>"."<br />");
        echo("</tr>");
    }
}
echo("</table>");
?>
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
echo("<th class='btableth'>".$arr_lang["params"]."</th>");
echo("</tr>");

$listquery = "select name, description, params from macros";
$listresult=pg_query($listquery);
if ($listresult){
    while ($listrow=pg_fetch_row($listresult)){
        echo("<tr>");
        echo("<td class='btabletd'>".$listrow[0]."</td>");
        echo("<td class='btabletd'>".$listrow[1]."</td>");
        //echo("<td class='btabletd'>".$listrow[2]."</td>");
        echo("<td class='btabletd'>");
        $paramlist=preg_split("/\;/", $listrow[2]);
        foreach ($paramlist as $param) {
            $sparam=preg_split("/\:/",$param);
            echo($sparam[0]." - ".$sparam[1]."</ br>");
        }
        echo("</td>");
        echo("</tr>");
    }
}
echo("</table>");
?>
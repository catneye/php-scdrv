<?php

//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once($app."lang.php");
include_once($app."connect.php");

$dir=$medialib;

echo("<table class='btable'><tr>");
echo("<tr>");
echo("<th class='btableth'>".$arr_lang["state"]."</th>");
echo("<th class='btableth'>".$arr_lang["name"]."</th>");
echo("<th class='btableth'>".$arr_lang["description"]."</th>");
echo("<th class='btableth'>".$arr_lang["limitcnt"]."</th>");
echo("<th class='btableth'>".$arr_lang["macro"]."</th>");
echo("<th class='btableth'>".$arr_lang["macrodata"]."</th>");
echo("<th class='btableth'>".$arr_lang["defaultchannel"]."</th>");
echo("<th class='btableth'>".$arr_lang["callerid"]."</th>");
echo("<th class='btableth'>".$arr_lang["waitmsec"]."</th>");
echo("<th class='btableth'>".$arr_lang["action"]."</th>");
echo("</tr>");

$listquery = "select name, description, limitcnt,macro,macrodata,defaultchannel,callerid,waitmsec,status,id from champing where deldate is null";
$listresult=pg_query($listquery);
if ($listresult){
    while ($listrow=pg_fetch_row($listresult)){
        echo("<tr>");
        echo("<td class='btabletd'>".$listrow[8]."</td>");
        echo("<td class='btabletd'>".$listrow[0]."</td>");
        echo("<td class='btabletd'>".$listrow[1]."</td>");
        echo("<td class='btabletd'>".$listrow[2]."</td>");
        echo("<td class='btabletd'>".$listrow[3]."</td>");
        echo("<td class='btabletd'>".$listrow[4]."</td>");
        echo("<td class='btabletd'>".$listrow[5]."</td>");
        echo("<td class='btabletd'>".$listrow[6]."</td>");
        echo("<td class='btabletd'>".$listrow[7]."</td>");
        echo("<td class='btabletd'><a href=index.php?action=champing&option=delete&item=".
                            $listrow[9].">". $arr_lang["delete"]."</a>"."<br />");
        echo("<a href=index.php?action=champing&option=start&item=".
                            $listrow[9].">". $arr_lang["start"]."</a>"."<br />");
        echo("<a href=index.php?action=champing&option=stop&item=".
                            $listrow[9].">". $arr_lang["stop"]."</a>"."</td>");
        echo("</tr>");
        
        echo("<tr>");
        echo("<td colspan='7'>".$arr_lang["numbers-in-base"]."</td>");
        echo("<td>".$arr_lang["active-request"]."/".$arr_lang["all-request"]."</td>");
        $bcactive=0;
        $bcall=0;
        $bcquery="select count(id) from base where idchamping=".$listrow[9]." and priority>0";
        $bcresult=pg_query($bcquery);
        if ($bcresult){
            $bcrow=pg_fetch_row($bcresult);
            $bcactive=$bcrow[0];
        }
        $bcaquery="select count(id) from base where idchamping=".$listrow[9];
        $bcaresult=pg_query($bcaquery);
        if ($bcaresult){
            $bcarow=pg_fetch_row($bcaresult);
            $bcall=$bcarow[0];
        }
        echo("<td>".$bcactive."/".$bcall."</td>");
        echo("<td><a href=index.php?action=champing&option=clear&item=".
                            $listrow[9].">". $arr_lang["clear"]."</a>"."<br />");
        echo("<a href=index.php?action=champing&option=import&item=".
                            $listrow[9].">". $arr_lang["import"]."</a>"."</td>");
        echo("</tr>");
    }
}
echo("</table>");
?>
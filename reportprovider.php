<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

session_start();
if ( !$_SESSION["username"] ) exit;

include_once($app."connect.php");
include_once($app."lang.php");

$timestamp=time();
$bdate=date("Y-m-d 0:0:0", $timestamp);
$edate=date("Y-m-d 23:59:59", $timestamp);
$src="";
$dst="";
$filters="";

//$listquery = "select concat(concat(providers.name, ' '),providers.description) as prov, count(id), sum(billsec) from providers 
//where 1=1 " ;
$listquery = "select providers.name,providers.description, count(id), sum(billsec) from providers 
where 1=1 " ;

echo("<div class='usedfilters'><B>".$arr_lang["usedfilters"].":</B> ");

if ( !$_GET["alldate"] ) {
    if ( $_GET["bdate"] ) {
        $bdate=$_GET["bdate"]." 0:0:0";
        $edate=$_GET["bdate"]." 23:59:59";
    }
    echo($arr_lang["begindate"]." - ".$bdate."; ");
    if ( $_GET["edate"] ) {
        $edate=$_GET["edate"]." 23:59:59";
    }
    echo($arr_lang["enddate"]." - ".$edate."; ");

    $listquery = $listquery." and providers.calldate >= '".$bdate."' and providers.calldate<= '".$edate."'";
}else{
    echo($arr_lang["alldate"]."; ");
}

if ( $_GET["src"] ) {
    $src=$_GET["src"];
    $listquery = $listquery." and providers.src REGEXP '".$src."'";
    echo($arr_lang["src"]." - ".$src."; ");
}

if ( $_GET["dst"] ) {
    $dst=$_GET["dst"];
    $listquery = $listquery." and providers.dst REGEXP '".$dst."'";
    echo($arr_lang["dst"]." - ".$dst."; ");
}

$listquery .= " group by providers.name, providers.description;";
//echo ($listquery);
$listresult=pg_query($listquery);
//list dst calls
//
if ($listresult){
    echo("<table class='btable'><tr>");
    echo("<tr>");
    echo("<th class='btableth'>".$arr_lang["providername"]."</th>");
    echo("<th class='btableth'>".$arr_lang["providerdesc"]."</th>");
    echo("<th class='btableth'>".$arr_lang["count"]."</th>");
    echo("<th class='btableth'>".$arr_lang["sumsec"]."</th>");
    echo("<th class='btableth'>".$arr_lang["summin"]."</th>");
    echo("</tr>");
    while ($listrow=pg_fetch_row($listresult)){
        echo("<tr>");
        echo("<td class='btabletd'>".$listrow[0]."</td>");
        echo("<td class='btabletd'>".$listrow[1]."</td>");
        echo("<td class='btabletd'>".$listrow[2]."</td>");
        echo("<td class='btabletd'>".$listrow[3]."</td>");
        echo("<td class='btabletd'>".round($listrow[3]/60,2)."</td>");
        echo("</tr>");
    }
    echo("</table>");
}

?>
<?php

//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

session_start();
if (!$_SESSION["username"])
    exit;

include_once($app . "connect.php");
include_once($app . "lang.php");

$timestamp = time();
$bdate = date("Y-m-d 0:0:0", $timestamp);
$edate = date("Y-m-d 23:59:59", $timestamp);
$src = "";
$dst = "";
$filters = "";

$listquery = "
select src, disposition, count(dst), sum(duration), sum(billsec) from cdr
where
CHARACTER_LENGTH(src)<4
";

echo("<div class='usedfilters'><B>" . $arr_lang["usedfilters"] . ":</B> ");

if (!$_GET["alldate"]) {
    if ($_GET["bdate"]) {
        $bdate = $_GET["bdate"] . " 0:0:0";
        $edate = $_GET["bdate"] . " 23:59:59";
    }
    echo($arr_lang["begindate"] . " - " . $bdate . "; ");
    if ($_GET["edate"]) {
        $edate = $_GET["edate"] . " 23:59:59";
    }
    echo($arr_lang["enddate"] . " - " . $edate . "; ");

    $listquery = $listquery . " and cdr.calldate >= '" . $bdate . "' and cdr.calldate<= '" . $edate . "'";
} else {
    echo($arr_lang["alldate"] . "; ");
}

if ($_GET["src"]) {
    $src = $_GET["src"];
    $listquery = $listquery . " and cdr.src REGEXP '" . $src . "'";
    echo($arr_lang["src"] . " - " . $src . "; ");
}

if ($_GET["dst"]) {
    $dst = $_GET["dst"];
    $listquery = $listquery . " and cdr.dst REGEXP '" . $dst . "'";
    echo($arr_lang["dst"] . " - " . $dst . "; ");
}

$listquery .= " group by src, disposition";
$listquery .= " order by src, disposition";
//echo ($listquery);
$listresult = pg_query($listquery);

if ($listresult) {
    echo("<table class='btable'><tr>");
    echo("<tr>");
    echo("<th class='btableth'>" . $arr_lang["src"] . "</th>");
    echo("<th class='btableth'>" . $arr_lang["disposition"] . "</th>");
    echo("<th class='btableth'>" . $arr_lang["count"] . "</th>");
    echo("<th class='btableth'>" . $arr_lang["duration"] . "</th>");
    echo("<th class='btableth'>" . $arr_lang["billsec"] . "</th>");
    echo("/<tr>");
    while ($listrow = pg_fetch_row($listresult)) {
        echo("<tr>");
        echo("<td class='btabletd'>" . $listrow[0] . "</td>");
        echo("<td class='btabletd'>" . $arr_lang[$listrow[1]] . "</td>");
        echo("<td class='btabletd'>" . $listrow[2] . "</td>");
        echo("<td class='btabletd'>" . $listrow[3] . "</td>");
        echo("<td class='btabletd'>" . $listrow[4] . "</td>");
        echo("</tr>");
    }
    echo("</table>");
}
?>

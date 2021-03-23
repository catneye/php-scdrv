<html>
<head>
<link rel='SHORTCUT ICON' href='img/icon.ico' type='image/x-icon' />
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<title></title>
<link href='./css/main.css' rel='stylesheet' type='text/css' media='all' />
<link href='./css/base/jquery.ui.base.css' rel='stylesheet' type='text/css' media='all' />
<link href='./css/base/jquery.ui.datepicker.css' rel='stylesheet' type='text/css' media='all' />
<link href='./css/smoothness/jquery-ui-1.8.11.custom.css' rel='stylesheet' type='text/css' media='all' />
<script src='./js/jquery-1.4.4.min.js' type='text/javascript'></script>
<script src='./js/jquery-ui-1.8.11.custom.min.js' type='text/javascript'></script>
<script src='./js/jquery.ui.datepicker-ru.js' type='text/javascript'></script>

<script>
function setStatus(){
var val = document.getElementById('champing').value;
var parent = document.getElementById('status');
$.get('./ajax.php?func=champingstate&param='+val, function(data){
parent.innerHTML=data;
});
}
</script>

<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko
$app="/var/www/scdrv/";

session_start();

include_once( $app."lang.php" );
include_once( $app."connect.php" );

session_start();
$_SESSION["username"]="admin";
$_SESSION["userrole"]="admin";

echo("</head>
<body>");

echo("<table class='mtable' border='0'>");

echo("<tr valign='top'><td>
<div></div>");
echo("</td></tr>");
//form: number1, number2, status, start, stop

echo ("<table>");
echo ("<form method='post' action='./index1.php'>");
echo ("<tr><td colspan='2'>".$arr_lang["create-champing"]."</td></td>");
echo ("<tr><td>".$arr_lang["number"]." - куда звоним    </td><td><input type='text' id='nameq' name='nameq' style='width: 100%' /></td></tr>");
echo ("<tr><td>".$arr_lang["number"]." - куда возвращаем</td><td><input type='text' id='names' name='names' style='width: 100%' /></td></tr>");
echo ("<tr><td>".$arr_lang["amount-requests"]."</td><td><input type='text' id='amm' name='amm' style='width: 100%' value='1000'/></td></tr>");
echo ("<tr><td>".$arr_lang["champing"]."</td><td><select id='champing' name='champing' size='1' style='width: 100%'>");
$listquery = "select id,name from champing where deldate is null";
$listresult=mysql_query($listquery);
if ($listresult){
    while ($listrow=mysql_fetch_row($listresult)){
        echo("<option value='".$listrow[0]."'>".$listrow[1]."</option>");
    }
}
echo("</select></td></tr>");
//current status
echo("<tr><td>".$arr_lang["current-status"]."</td><td><div id='status' name='status'><div></td></tr>");
//
echo ("<tr><td>".$arr_lang["action"]."</td><td><select id='action' name='action' size='1' style='width: 100%' onchange='setStatus();'>");
echo("<option value='start'>".$arr_lang["start"]."</option>");
echo("<option value='stop'>".$arr_lang["stop"]."</option>");
echo("</select></td></tr>");

echo ("<tr><td><input type='submit' name='select' value='".$arr_lang["select"]."'></td>");
echo ("<td></td></tr>");
echo ("</form></table>");


//start: set champing start, add request up to 1000
if ( ($_SESSION["username"]) && ($_POST[select]) && ($_POST[action] == "start") 
&& ($_POST[names] != "") && ($_POST[names] != "") ){
    $startsql="update champing set status='start', macrodata='".$_POST[names]."' where id=".$_POST[champing];
    //echo($startsql);
    $startres=mysql_query($startsql);
    //for ($i=0;$i<1000;$i++){
    for ($i=0;$i<$_POST[amm];$i++){
        $basesql="insert into base (name,adddate,idchamping,priority) 
        values ('".$_POST[nameq]."',now(),".$_POST[champing].",10)";
        //echo($basesql);
        $baseres=mysql_query($basesql);
    }
    echo("started");
}
//stop: set champing stop
if ( ($_SESSION["username"]) && ($_POST[select]) && ($_POST[action] == "stop") ){
    //$clearsql="update base set priority=0 where priority>0 and idchamping=".$_POST[champing];
    $clearsql="delete from base";
    $clearres=mysql_query($clearsql);
    $stopsql="update champing set status='stop' where id=".$_POST[champing];
    $stopres=mysql_query($stopsql);
    echo("stoped");
}

echo("</table>");
?>
<script>
setStatus();
</script>

</body></html>

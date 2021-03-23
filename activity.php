<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko
include_once($app."lang.php");
include_once($app."lib/astphp/AsteriskManager.php");

echo("
<table class='activitytable' border='0'>
<tr><td><td></tr>
</table>
");
$params = array('server' => '127.0.0.1', 'port' => '5038');
$ast = new Net_AsteriskManager($params);
try {
    $ast->connect();
} catch (PEAR_Exception $e) {
    echo $e;
}
try {
    $ast->login('scdrv', 'scdrv');
} catch(PEAR_Exception $e) {
    echo $e;
}
try {
    $sipstatus = $ast->command("sip show peers");
} catch(PEAR_Exception $e) {
    echo $e;
}

$siparrlines=preg_split("#\n(?!s)#",$sipstatus);
#$siparrlines=split("[/r/n]",$sipstatus);

echo("<table class='btable' border='0'>");
$i=0;
foreach($siparrlines as $sipline){
    //echo($sipline)."----<br />";
    if($i==2){
        echo("<tr>");
        $siparrcells=preg_split("/[\s,]+/",$sipline);
        foreach($siparrcells as $sipcell){
            echo("<th>".$sipcell."</td>");
        }
        echo("</tr>");
    }
    if ( ($i>2) && ($i < (count($siparrlines)-4)) ){
        //$siparrcells=preg_split("/[\s,]+/",$sipline);
        $siparrcells=preg_split("/\\s+/",$sipline);
        echo("<tr>");
        foreach($siparrcells as $sipcell){
            echo("<td>".$sipcell."</td>");
        }
        echo("</tr>");
    }
    $i++;
}
echo("</table>");
try {
    $ast->logout();
} catch(PEAR_Exception $e) {
    echo $e;
}

?>
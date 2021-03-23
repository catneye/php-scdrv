<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once("./lang.php");
include_once("./connect.php");

$allfields=false;

if ( ($_POST[chname])&&($_POST[chname]!="")&&
 ($_POST[description])&&($_POST[description]!="")&&
 ($_POST[limitcnt])&&($_POST[limitcnt]>0)&&
 ($_POST[macro])&&($_POST[macro]!="")&&
 ($_POST[defaultchannel])&&($_POST[defaultchannel]!="")&&
 ($_POST[callerid])&&($_POST[callerid]!="")&&
 ($_POST[waitmsec])&&($_POST[waitmsec]>0)
 ){
    $allfields=true;
}

$count=0;
$paramquery = "select count(id) from champing where name='".$_POST[chname]."'";
$paramresult=pg_query($paramquery);
if ($paramresult){
    $paramrow=pg_fetch_row($paramresult);
    $count=$paramrow[0];
}
if ($count>0){
    $allfields=false;
}

//echo("123123".$_POST[macrodata1]);
//echo("123123".$_POST[dmacrodata]);
//echo("123123".$_POST[hmacrodata]);
/*$i=1;
$macrodata="";
while ($_POST["hmacrodata".i]){
    if ($macrodata!=""){
        $macrodata.=",";
    }
    $macrodata.=$_POST[hmacrodata.i];
}*/

if ($allfields){
    $chquery="insert into champing (name,description,limitcnt,macro,macrodata,defaultchannel,callerid,waitmsec,status)
    values ('".$_POST[chname]."','".$_POST[description]."',".$_POST[limitcnt].",'".$_POST[macro].
    "','".$_POST[hmacrodata]."','".$_POST[defaultchannel]."','".$_POST[callerid]."',".$_POST[waitmsec].",'stop',
    )";
    $chresult=pg_query($chquery);
    //echo($chquery);
    echo($arr_lang["add-ok"]);
}else{
echo($arr_lang["form-not-field"]);
}


?>
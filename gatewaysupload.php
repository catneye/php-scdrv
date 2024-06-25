<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once("./lang.php");
include_once("./connect.php");

$allfields=false;
if ( ($_POST["chname"])&&($_POST["chname"]!="")&&
 ($_POST["description"])&&($_POST["description"]!="")&&
 ($_POST["user"])&&($_POST["user"]!="")&&
 ($_POST["password"])&&($_POST["password"]!="")&&
 ($_POST["address"])&&($_POST["address"]!="")
 ){
    $allfields=true;
}

$count=0;
$paramquery = "select count(id) from gateways where name='".$_POST["chname"]."'";
$paramresult=pg_query($paramquery);
if ($paramresult){
    $paramrow=pg_fetch_row($paramresult);
    $count=$paramrow[0];
}
if ($count>0){
    $allfields=false;
}
if ($allfields){
    $chquery="insert into gateways (name,description,user,password,address)
    values ('".$_POST["chname"]."','".$_POST["description"]."','".$_POST["user"]."','".$_POST["password"].
    "','".$_POST["address"]."'
    )";
    echo($chquery);
    $chresult=pg_query($chquery);
    echo($arr_lang["add-ok"]);
}else{
echo($arr_lang["form-not-field"]);
}


?>
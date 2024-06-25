<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once("./lang.php");
include_once("./connect.php");

if ( ($_SESSION["username"]) && ($_GET["option"]) && 
( ($_GET["option"] == "start")||($_GET["option"] == "stop")) && ($_GET["item"]) ){
    
    $champquery = "update champing set status='".$_GET["option"]."' where id=".$_GET["item"];
    $champresult=pg_query($champquery);
    echo($arr_lang["state-update-ok"]);
}
?>
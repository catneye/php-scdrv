<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once($app."lang.php");
include_once($app."connect.php");

if ( ($_SESSION["username"]) && ($_GET["option"]) && ($_GET["option"] == "delete") && ($_GET["item"]) ){
    
    $champquery = "update champing set deldate=now() where id=".$_GET["item"];
    $champresult=pg_query($champquery);
    echo($arr_lang["state-update-ok"]);
}
?>
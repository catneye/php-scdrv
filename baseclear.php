<?php

//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once($app."lang.php");
include_once($app."connect.php");

if ( ($_SESSION["username"]) && ($_GET[option]) && ($_GET[option] == "clear") && ($_GET[item]) ){
    //unlink($medialib.$_GET[item]);
    
    $deletequery = "update base set priority=0 where idchamping=".$_GET[item];
    $deleteresult=pg_query($deletequery);
    echo($arr_lang["delete-ok"]);
}
?>
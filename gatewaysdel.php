<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once($app."lang.php");
include_once($app."connect.php");

if ( ($_SESSION["username"]) && ($_GET[option]) && ($_GET[option] == "delete") && ($_GET[item]) ){
    
    $gwquery = "update gateways set deldate=now() where id=".$_GET[item];
    $gwresult=pg_query($gwquery);
    echo($arr_lang["state-update-ok"]);
}
?>
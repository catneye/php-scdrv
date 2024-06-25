<?php

//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once($app . "lang.php");
include_once($app . "connect.php");

if (($_SESSION["username"]) && ($_GET["option"]) && ($_GET["option"] == "recorddelete") && ($_GET["item"])) {
    echo($_GET["item"]);
    unlink($records . $_GET["item"]);
    //$deletequery = "update medialib set deldate=now() where name='".$_GET[item]."' and deldate is null";
    //$deleteresult=pg_query($deletequery);
    echo($arr_lang["delete-ok"]);
}
?>
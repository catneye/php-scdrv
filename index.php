<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko
$app="/var/www/html/scdrv/";

session_start();

include_once( $app."lang.php" );

echo("<html>
<head>
<link rel='SHORTCUT ICON' href='img/icon.ico' type='image/x-icon' />
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<title>".$arr_lang["sitetitle"]."</title>
<link href='./css/main.css' rel='stylesheet' type='text/css' media='all' />
<link href='./css/base/jquery.ui.base.css' rel='stylesheet' type='text/css' media='all' />
<link href='./css/base/jquery.ui.datepicker.css' rel='stylesheet' type='text/css' media='all' />
<link href='./css/smoothness/jquery-ui-1.8.11.custom.css' rel='stylesheet' type='text/css' media='all' />
<script src='./js/jquery-1.4.4.min.js' type='text/javascript'></script>
<script src='./js/jquery-ui-1.8.11.custom.min.js' type='text/javascript'></script>
<script src='./js/jquery.ui.datepicker-ru.js' type='text/javascript'></script>
");
echo("</head>
<body>");

echo("<table class='mtable' border='0'>");

echo("<tr valign='top'><td><div>");
include_once( "./login.php" );
echo("</div></td></tr>");

echo("<tr valign='top'><td>");
if ($_SESSION["username"]!=""){
    include_once( "./menu.php" );
}
echo("</td></tr>");
//-----------content
//if ( ($_SESSION["username"]) && ($_GET[action]) && ($_GET[action] == "champing") ){
if ( ($_SESSION["username"]) && 
(($_GET[action]) && ($_GET[action] == "champing")||(($_POST[action]) && ($_POST[action] == "champing"))) ){
    echo("<tr valign='top'><td>");
    include_once( "./champingmenu.php" );
    echo("</td></tr>");
    if ($_GET[option] == "macros"){
        echo("<tr valign='top'><td>");
        include_once( "./champingmacros.php" );
        echo("</td></tr>");
    }
    if ($_GET[option] == "list"){
        echo("<tr valign='top'><td>");
        include_once( "./champing.php" );
        echo("</td></tr>");
    }
    /*if ($_GET[option] == "panel"){
        echo("<tr valign='top'><td>");
        include_once( "./panel.php" );
        echo("</td></tr>");
    }*/
    if ($_GET[option] == "add"){
        echo("<tr valign='top'><td>");
        include_once( "./champingadd.php" );
        echo("</td></tr>");
    }
    if ($_GET[option] == "import"){
        echo("<tr valign='top'><td>");
        include_once( "./baseadd.php" );
        echo("</td></tr>");
    }
    if ($_GET[option] == "clear"){
        echo("<tr valign='top'><td>");
        include_once( "./baseclear.php" );
        echo("</td></tr>");
    }
    if ($_GET[option] == "start"){
        echo("<tr valign='top'><td>");
        include_once( "./champingstart.php" );
        echo("</td></tr>");
    }
    if ($_GET[option] == "stop"){
        echo("<tr valign='top'><td>");
        include_once( "./champingstart.php" );
        echo("</td></tr>");
    }
    if ($_GET[option] == "delete"){
        echo("<tr valign='top'><td>");
        include_once( "./champingdel.php" );
        echo("</td></tr>");
    }
    if ($_POST[option] == "add"){
        echo("<tr valign='top'><td>");
        include_once( "./champingupload.php" );
        echo("</td></tr>");
    }
    if ($_POST[option] == "import"){
        echo("<tr valign='top'><td>");
        include_once( "./baseupload.php" );
        echo("</td></tr>");
    }
}
if ( ($_SESSION["username"]) && ($_GET[action]) && ($_GET[action] == "activity") ){
    echo("<tr valign='top'><td>");
    include_once( "./activity.php" );
    echo("</td></tr>");
}
if ( ($_SESSION["username"]) && ($_GET[action]) && ($_GET[action] == "panel") ){
    echo("<tr valign='top'><td>");
    //include_once( "./panelmenu.php" );
    include_once( "./panel.php" );
    echo("</td></tr>");
    if ($_GET[option] == "login"){
        echo("<tr valign='top'><td>");
        include_once( "./panellogin.php" );
        echo("123");
        echo("</td></tr>");
    }
}
/*if ( ($_SESSION["username"]) && ($_GET[action]) && ($_GET[action] == "addpac1") ){
    echo("<tr valign='top'><td>");
    include_once( "./addpac1.php" );
    echo("</td></tr>");
}*/
if ( ($_SESSION["username"]) && ($_GET[action]) && ($_GET[action] == "scenarios") ){
    echo("<tr valign='top'><td>");
    include_once( "./scenarios.php" );
    echo("</td></tr>");
}
if ( ($_SESSION["username"]) && ($_GET[action]) && ($_GET[action] == "reports") ){
    echo("<tr valign='top'><td>");
    include_once( "./reportsmenu.php" );
    echo("</td></tr>");
    
    if ($_GET[option] == "provider"){
        echo("<tr valign='top'><td>");
        include_once( "./filter.php" );
        echo("</td></tr>");
        
        echo("<tr valign='top'><td>");
        include_once( "./reportprovider.php" );
        echo("</td></tr>");
    }
    if ($_GET[option] == "operator"){
        echo("<tr valign='top'><td>");
        include_once( "./filter.php" );
        echo("</td></tr>");
        
        echo("<tr valign='top'><td>");
        include_once( "./reportoperator.php" );
        echo("</td></tr>");
    }
    if ( $_GET[option] == "list"){
        echo("<tr valign='top'><td>");
        include_once( "./filter.php" );
        echo("</td></tr>");
        
        echo("<tr valign='top'><td>");
        include_once( "./list.php" );
        echo("</td></tr>");
    }
    if ( $_GET[option] == "record"){
        echo("<tr valign='top'><td>");
        include_once( "./record.php" );
        echo("</td></tr>");
    }
    if ( $_GET[option] == "recorddelete"){
        echo("<tr valign='top'><td>");
        include_once( "./recorddelete.php" );
        echo("</td></tr>");
    }
}

if ( ($_SESSION["username"]) && 
(($_GET[action]) && ($_GET[action] == "medialib")||(($_POST[action]) && ($_POST[action] == "medialib"))) ){
    echo("<tr valign='top'><td>");
    include_once( "./medialibmenu.php" );
    echo("</td></tr>");
    if ($_GET[option] == "list"){
        echo("<tr valign='top'><td>");
        include_once( "./medialib.php" );
        echo("</td></tr>");
    }
    if ($_GET[option] == "add"){
        echo("<tr valign='top'><td>");
        include_once( "./medialibadd.php" );
        echo("</td></tr>");
    }
    if ($_GET[option] == "delete"){
        echo("<tr valign='top'><td>");
        include_once( "./medialibdelete.php" );
        echo("</td></tr>");
    }
    if ($_POST[option] == "add"){
        echo("<tr valign='top'><td>");
        include_once( "./medialibupload.php" );
        echo("</td></tr>");
    }
}

if ( ($_SESSION["username"]) && 
(($_GET[action]) && ($_GET[action] == "gateways")||(($_POST[action]) && ($_POST[action] == "gateways"))) ){
    echo("<tr valign='top'><td>");
    include_once( "./gatewaysmenu.php" );
    echo("</td></tr>");
    if ($_GET[option] == "list"){
        echo("<tr valign='top'><td>");
        include_once( "./gateways.php" );
        echo("</td></tr>");
    }
    if ($_GET[option] == "add"){
        echo("<tr valign='top'><td>");
        include_once( "./gatewaysadd.php" );
        echo("</td></tr>");
    }
    if ($_GET[option] == "delete"){
        echo("<tr valign='top'><td>");
        include_once( "./gatewaysdel.php" );
        echo("</td></tr>");
    }
    if ($_POST[option] == "add"){
        echo("<tr valign='top'><td>");
        include_once( "./gatewaysupload.php" );
        echo("</td></tr>");
    }
    if ($_GET[option] == "sms"){
        echo("<tr valign='top'><td>");
        include_once( "./gatewayssms.php" );
        echo("</td></tr>");
    }
    if ($_POST[option] == "sms"){
        echo("<tr valign='top'><td>");
        include_once( "./gatewayssendsms.php" );
        echo("</td></tr>");
    }
    if ($_GET[option] == "ussd"){
        echo("<tr valign='top'><td>");
        include_once( "./gatewaysussd.php" );
        echo("</td></tr>");
    }
    if ($_POST[option] == "ussd"){
        echo("<tr valign='top'><td>");
        include_once( "./gatewayssendussd.php" );
        echo("</td></tr>");
    }
}

//-----------content
echo("<tr valign='top'><td><div></div>");
echo("</td></tr>");

echo("</table>");
echo("</body></html>");
?>
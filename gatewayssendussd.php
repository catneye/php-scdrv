<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once("./lang.php");
include_once("./connect.php");
$allfields=false;
if (($_POST["gateway"])&&($_POST["gateway"]!="")&&
    ($_POST["port"])&&($_POST["port"]!="")&&
    ($_POST["ussdtext"])&&($_POST["ussdtext"]!="")
){
    $allfields=true;
}
if ($allfields){
    $gwquery="select address, user, password from gateways
    where id=".$_POST["gateway"];
    //echo($gwquery);
    $gwresult=pg_query($gwquery);
if ($gwresult){
    $gwrow=pg_fetch_row($gwresult);

    $host=$gwrow[0];
    $user=$gwrow[1];
    $password=$gwrow[2];
    $port=$_POST["port"];
    $ussdtext=$_POST["ussdtext"];
    echo("<p>".$arr_lang["ussdtext-transform"].$ussdtext."</p>");
    echo("<p style='visibility:hidden;'>");
    ini_set("expect.timeout", 60);
    ini_set('expect.logfile', 'php://output');
    ob_start();
    $stream = fopen("expect://telnet $host", "r");
    $cases = array (
    array (0 => "Login:", 1 => "LOGIN"),
    array (0 => "Password:", 1 => "PASSWORD"),
    array (0 => "GS1004>", 1 => "ENABLE"),
    array (0 => "+CUSD", 1 => "END")
    );
    while (true) {
        switch (expect_expectl($stream, $cases)) {
            case "LOGIN":
                fwrite($stream, "$user\r");
                break;
            case "PASSWORD":
                fwrite($stream, "$password\r");
                break;
            case "ENABLE":
                fwrite($stream, "enable\rterminal monitor\rdebug gsm $port event\rgsm $port ussd send $ussdtext\r");
                break;
            case "END":
                fwrite($stream, "terminal no monitor\rexit\rexit\r");
                break;
            case EXP_TIMEOUT:
                echo ($arr_lang["timeout"]);
            case EXP_EOF:
                echo ("eof");
                break 2;
            default:
                echo("default");
                break 2;
            }
    }
    $out=ob_get_contents();
    ob_end_clean();
    fclose ($stream);
    //echo($out);
    echo("</p>");
    $out1=trim(preg_replace("~[\s]+~","",$out));
    //echo($out1."\r\n");
    $reply=split('"',$out1);
    $utf16=$reply[1];
    $i=0;
    $utf16c='';
    while ($i<strlen($utf16)) {
        $s_utf16=substr($utf16,$i,2);
        $i+=2;
        //echo(chr("0x".$s_utf16))."\r\n";
        $utf16c.=chr('0x'.$s_utf16);
    }
    echo(mb_convert_encoding($utf16c,"UTF-8","UTF-16"));

    }else{
        echo($arr_lang["form-not-field"]);
    }
}
?>
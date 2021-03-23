<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once("./lang.php");
include_once("./connect.php");
    //echo($_POST[gateway]);
    //echo($_POST[port]);
    //echo($_POST[numbers]);
    //echo($_POST[smstext]);
$allfields=false;
if (($_POST[gateway])&&($_POST[gateway]!="")&&
    ($_POST[port])&&($_POST[port]!="")&&
    ($_POST[numbers])&&($_POST[numbers]!="")&&
    ($_POST[smstext])&&($_POST[smstext]!="")
){
    $allfields=true;
}

if ($allfields){
    $gwquery="select address, user, password from gateways
    where id=".$_POST[gateway];
    //echo($gwquery);
    $gwresult=pg_query($gwquery);
if ($gwresult){
    $gwrow=pg_fetch_row($gwresult);

    $host=$gwrow[0];
    $user=$gwrow[1];
    $password=$gwrow[2];
    $port=$_POST[port];
    $smstext=$_POST[smstext];
    $numbers=preg_replace("/[^0-9\\;]/u","",$_POST[numbers]);
    $smstext=preg_replace("~[\s]+~"," ",$_POST[smstext]);
    $smstext=preg_replace("/[\\Н]/u","H",$smstext);

    echo("<p>".$arr_lang["numbers-transform"].$numbers."</p>");
    echo("<p>".$arr_lang["smstext-transform"].$smstext."</p>");
    $arrnum=split(";",$numbers);
    for ($i=0;$i<count($arrnum);$i++){
        $number=$arrnum[$i];
        //echo("$host' '$user' '$password' '$port' '$number' '$smstext'");
        //passthru("./sendsms.expect '$host' '$user' '$password' '$port' '$number' '$smstext'");
        //shell_exec("./sendsms.expect '$host' '$user' '$password' '$port' '$number' '$smstext'");
        echo("<p>".$arr_lang["sendingsms"]."</p></p> $number; ".$arr_lang["smstext"].": $smstext</p>");
        echo("<p>".$arr_lang["result"].": ");
        ini_set("expect.timeout", 60);
        $stream = fopen("expect://telnet $host", "r");
        $cases = array (
            array (0 => "Login:", 1 => "LOGIN"),
            array (0 => "Password:", 1 => "PASSWORD"),
            array (0 => "GS1004>", 1 => "ENABLE"),
            array (0 => "GS1004#", 1 => "BSENDSMS")
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
                fwrite($stream, "enable\rgsm $port smsd message send 8$number $smstext\r");
                break;
            case "BSENDSMS":
                fwrite($stream, "exit\rexit\r");
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
        while ($line = fgets($stream)) {
            echo $line;
        }
        echo("</p>");
        fclose($stream);
    }
}
}else{
echo($arr_lang["form-not-field"]);
}

?>
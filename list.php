<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

session_start();
if ( !$_SESSION["username"] ) exit;

include_once("./connect.php");
include_once("./lang.php");

$timestamp=time();
$bdate=date("Y-m-d 0:0:0", $timestamp);
$edate=date("Y-m-d 23:59:59", $timestamp);
$src="";
$dst="";
$filters="";

$listquery = "select calldate, clid, src, dst, dcontext,
channel, dstchannel, lastapp, lastdata, duration, 
billsec, disposition, amaflags, accountcode, uniqueid, 
userfield 
from cdr
where 1=1";

echo("<div class='usedfilters'><B>".$arr_lang["usedfilters"].":</B> ");

if ( !$_GET["alldate"] ) {
    if ( $_GET["bdate"] ) {
        $bdate=$_GET["bdate"]." 0:0:0";
        $edate=$_GET["bdate"]." 23:59:59";
    }
    echo($arr_lang["begindate"]." - ".$bdate."; ");
    if ( $_GET["edate"] ) {
        $edate=$_GET["edate"]." 23:59:59";
    }
    echo($arr_lang["enddate"]." - ".$edate."; ");

    $listquery = $listquery." and calldate >= '".$bdate."' and calldate<= '".$edate."'";
}else{
    echo($arr_lang["alldate"]."; ");
}

if ( $_GET["src"] ) {
    $src=$_GET["src"];
    $listquery = $listquery." and src like '".$src."'";
    echo($arr_lang["src"]." - ".$src."; ");
}

if ( $_GET["dst"] ) {
    $dst=$_GET["dst"];
    $listquery = $listquery." and dst like '".$dst."'";
    echo($arr_lang["dst"]." - ".$dst."; ");
}
//echo($listquery);
$listresult=pg_query($listquery);

if ($listresult){
    echo("<table class='btable'><tr>");
    echo("<tr>");
    echo("<th class='btableth'>".$arr_lang["calldate"]."</th>");
    echo("<th class='btableth'>".$arr_lang["src"]."</th>");
    echo("<th class='btableth'>".$arr_lang["dst"]."</th>");
    echo("<th class='btableth'>".$arr_lang["providername"]."</th>");
    echo("<th class='btableth'>".$arr_lang["duration"]."</th>");
    echo("<th class='btableth'>".$arr_lang["billsec"]."</th>");
    echo("<th class='btableth'>".$arr_lang["disposition"]."</th>");
    echo("<th class='btableth'>".$arr_lang["account"]."</th>");
    echo("<th class='btableth'>".$arr_lang["record"]."</th>");
    echo("<th class='btableth'>".$arr_lang["userfield"]."</th></tr>");
    while ($listrow=pg_fetch_row($listresult)){
        echo("<tr>");
        echo("<td class='btabletd'>"."<a class='ttip' href='#'>".$listrow[0].
        "<span>".$arr_lang["clid"].":".$listrow[1]."<br />".
        $arr_lang["context"].":".$listrow[4]."<br />".
        $arr_lang["srcchannel"].":".$listrow[5]."<br />".
        $arr_lang["dstchannel"].":".$listrow[6]."<br />".
        $arr_lang["lastapp"].":".$listrow[7]."<br />".
        $arr_lang["lastappdata"].":".$listrow[8]."<br />".
        "</span>".
        "</a>"."</td>");
        echo("<td class='btabletd'>".$listrow[2]."</td>");
        echo("<td class='btabletd'>".$listrow[3]."</td>");
        
        //$provquery="select provider.name, provider.description
        //from def, provider
        //where concat(def.name, def.adddigits) = substring('".$listrow[3]."', 2, 6)
        //and provider.id=def.idprovider";
        if (strlen($listrow[2])>=11){
            $cleanphone=preg_replace("/[^0-9]/", "",$listrow[2]);
        }else{
            $cleanphone=preg_replace("/[^0-9]/", "",$listrow[3]);
        }
        if (strlen($cleanphone)>=11){
            $provquery="select provider.name, provider.description
            from def, provider
            where def.name='".substr($cleanphone, 1, 3)."'
            and def.digfrom <= ".substr($cleanphone, 4, 7)."
            and def.digto >= ".substr($cleanphone, 4, 7)."
            and provider.id = def.idprovider";
            //echo($provquery);
            $provresult=pg_query($provquery);
            if ($provresult)
                $provrow=pg_fetch_row($provresult);

            if ($provrow){
                echo("<td class='btabletd'>".$provrow[0]." - ".$provrow[1]."</td>");
            }else{
                echo("<td class='btabletd'>".$arr_lang["unknown"]."</td>");
            }
        }else{
            echo("<td class='btabletd'>".$arr_lang["unknown"]."</td>");
        }
        //}
        echo("<td class='btabletd'>".$listrow[9]."</td>");
        echo("<td class='btabletd'>".$listrow[10]."</td>");
        echo("<td class='btabletd'>".$arr_lang[$listrow[11]]."</td>");
        echo("<td class='btabletd'>".$listrow[13]."</td>");
        echo("<td class='btabletd'>");
//echo($_SESSION["userrole"]);
        if ( ($_SESSION["userrole"]=="admin" ) || ($_SESSION["userrole"]=="super" ) ){
            if (file_exists("./monitor/".$listrow[14].".wav")){
                echo("<a href='./monitor/".$listrow[14].".wav'>".$listrow[14]."</a>");
            }else if (file_exists("./monitor/".$listrow[14].".WAV")){
                echo("<a href='./monitor/".$listrow[14].".WAV'>".$listrow[14]."</a>");
            }else{
                echo($listrow[14]);
            }
        }

        if ( ($_SESSION["userrole"]=="user" ) && ( ($listrow[2]==$_SESSION["clid"]) || ($listrow[3]==$_SESSION["clid"]) ) ){
            if (file_exists("./monitor/".$listrow[14].".wav")){
                echo("<a href='./monitor/".$listrow[14].".wav'>".$listrow[14]."</a>");
            }else{
                echo($listrow[14]);
            }
        }

        echo("</td>");

echo("<td class='btabletd'>");
echo($listrow[15]."-");
switch ($listrow[15]) {
case 1:
echo 'UNALLOCATED';
break;
case 2:
echo 'NO_ROUTE_TRANSIT_NET';
break;
case 3:
echo 'NO_ROUTE_DESTINATION';
break;
case 6:
echo 'CHANNEL_UNACCEPTABLE';
break;
case 7:
echo 'CALL_AWARDED_DELIVERED';
break;
case 16:
echo 'NORMAL_CLEARING';
break;
case 17:
echo 'USER_BUSY';
break;
case 18:
echo 'NO_USER_RESPONSE';
break;
case 19:
echo 'NO_ANSWER';
break;
case 21:
echo 'CALL_REJECTED';
break;
case 22:
echo 'NUMBER_CHANGED';
break;
case 27:
echo 'DESTINATION_OUT_OF_ORDER';
break;
case 28:
echo 'INVALID_NUMBER_FORMAT';
break;
case 29:
echo 'FACILITY_REJECTED';
break;
case 30:
echo 'RESPONSE_TO_STATUS_ENQUIRY';
break;
case 31:
echo 'NORMAL_UNSPECIFIED';
break;
case 34:
echo 'NORMAL_CIRCUIT_CONGESTION';
break;
case 38:
echo 'NETWORK_OUT_OF_ORDER';
break;
case 41:
echo 'NORMAL_TEMPORARY_FAILURE';
break;
case 42:
echo 'SWITCH_CONGESTION';
break;
case 43:
echo 'ACCESS_INFO_DISCARDED';
break;
case 44:
echo 'REQUESTED_CHAN_UNAVAIL';
break;
case 45:
echo 'PRE_EMPTED';
break;
case 50:
echo 'FACILITY_NOT_SUBSCRIBED';
break;
case 52:
echo 'OUTGOING_CALL_BARRED';
break;
case 54:
echo 'INCOMING_CALL_BARRED';
break;
case 57:
echo 'BEARERCAPABILITY_NOTAUTH';
break;
case 58:
echo 'BEARERCAPABILITY_NOTAVAIL';
break;
case 65:
echo 'BEARERCAPABILITY_NOTIMPL';
break;
case 66:
echo 'CHAN_NOT_IMPLEMENTED';
break;
case 69:
echo 'FACILITY_NOT_IMPLEMENTED';
break;
case 81:
echo 'INVALID_CALL_REFERENCE';
break;
case 88:
echo 'INCOMPATIBLE_DESTINATION';
break;
case 95:
echo 'INVALID_MSG_UNSPECIFIED';
break;
case 96:
echo 'MANDATORY_IE_MISSING';
break;
case 97:
echo 'MESSAGE_TYPE_NONEXIST';
break;
case 98:
echo 'WRONG_MESSAGE';
break;
case 99:
echo 'IE_NONEXIST';
break;
case 100:
echo 'INVALID_IE_CONTENTS';
break;
case 101:
echo 'WRONG_CALL_STATE';
break;
case 102:
echo 'RECOVERY_ON_TIMER_EXPIRE';
break;
case 103:
echo 'MANDATORY_IE_LENGTH_ERROR';
break;
case 111:
echo 'PROTOCOL_ERROR';
break;
case 127:
echo 'INTERWORKING';
break;
}
echo("</td>");
        echo("</tr>");
    }
    echo("</table>");
}

?>
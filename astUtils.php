<?
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko


/*
function getAgentCalls($agentid){

include("/var/www/scdrv/etc/setup.php");
    $ret=array();
    $gaci=0;
    $oSocket = @fsockopen($astHost, 5038, $errnum, $errdesc)
        or die("Connection to host failed");
    fputs($oSocket, "Action: login".$crlf);
    fputs($oSocket, "Events: off".$crlf);
    fputs($oSocket, "Username: ".$astUser.$crlf);
    fputs($oSocket, "Secret: ".$astSecret.$crlf.$crlf);
    fputs($oSocket, "Action: Status".$crlf.$crlf);

    fputs($oSocket, "Action: Logoff".$crlf.$crlf);

    while (!feof($oSocket)) {
        $wrets.= fread($oSocket, 8192);
    }
    fclose($oSocket);

    $arr=preg_split("/\r\n\r\n/",$wrets);
    foreach ($arr as $value){
        $params=array();
        $arr1=preg_split("/\r\n/",$value);
        foreach($arr1 as $value1) {
        if ($value1 != null ){
                $param=preg_split("/:/",$value1);
                if ( sizeof($param)>1 ){
                    $pn=trim($param[0]);
                    //echo("-$pn-$param[1]\n");
                    $params[$pn]=trim($param[1]);
                }
            }
            //echo($params[$param[0]]."\n");
        }
        if ( array_key_exists("Event", $params) && $params["Event"]=="Status"){
            //echo("Event - ".$params["Event"]."\n");
            if ( $params["Channel"]=="Agent/".$agentid ){
                //echo($params["Channel"]);
                $ret[$gaci]=$params;
                $gaci++;
                //echo(getVariable("CALLFILENAME", $params["Channel"])."\n");
            }
        }
    }
    return $ret;
}
*/
function getAgentCalls($agentid){

include("/var/www/scdrv/etc/setup.php");
    $ret=array();
    $gaci=0;
    $oSocket = @fsockopen($astHost, 5038, $errnum, $errdesc)
        or die("Connection to host failed");
    fputs($oSocket, "Action: login".$crlf);
    fputs($oSocket, "Events: off".$crlf);
    fputs($oSocket, "Username: ".$astUser.$crlf);
    fputs($oSocket, "Secret: ".$astSecret.$crlf.$crlf);
    fputs($oSocket, "Action: CoreShowChannels".$crlf.$crlf);

    fputs($oSocket, "Action: Logoff".$crlf.$crlf);

    while (!feof($oSocket)) {
        $wrets.= fread($oSocket, 8192);
    }
    fclose($oSocket);

    $arr=preg_split("/\r\n\r\n/",$wrets);
    foreach ($arr as $value){
        $params=array();
        $arr1=preg_split("/\r\n/",$value);
        foreach($arr1 as $value1) {
        if ($value1 != null ){
                $param=preg_split("/:/",$value1);
                if ( sizeof($param)>1 ){
                    $pn=trim($param[0]);
                    $params[$pn]=trim($param[1]);
                }
            }
        }
        if ( array_key_exists("Event", $params) && $params["Event"]=="CoreShowChannel"){
            if ( $params["Channel"]=="Agent/".$agentid ){
                $ret[$gaci]=$params;
                $gaci++;
            }
        }
    }
    return $ret;
}

function getCallInfo($calluid){

include("/var/www/scdrv/etc/setup.php");
    $ret=array();
    $gaci=0;
    $oSocket = @fsockopen($astHost, 5038, $errnum, $errdesc)
        or die("Connection to host failed");
    fputs($oSocket, "Action: login".$crlf);
    fputs($oSocket, "Events: off".$crlf);
    fputs($oSocket, "Username: ".$astUser.$crlf);
    fputs($oSocket, "Secret: ".$astSecret.$crlf.$crlf);
    fputs($oSocket, "Action: CoreShowChannels".$crlf.$crlf);

    fputs($oSocket, "Action: Logoff".$crlf.$crlf);

    while (!feof($oSocket)) {
        $wrets.= fread($oSocket, 8192);
    }
    fclose($oSocket);

    $arr=preg_split("/\r\n\r\n/",$wrets);
    foreach ($arr as $value){
        $params=array();
        $arr1=preg_split("/\r\n/",$value);
        foreach($arr1 as $value1) {
        if ($value1 != null ){
                $param=preg_split("/:/",$value1);
                if ( sizeof($param)>1 ){
                    $pn=trim($param[0]);
                    $params[$pn]=trim($param[1]);
                }
            }
        }
        if ( array_key_exists("Event", $params) && $params["Event"]=="CoreShowChannel"){
            if ( ($params["UniqueID"]==$calluid) ){
                $ret[$gaci]=$params;
                $gaci++;
            }
        }
    }
    return $ret;
}

function getActiveQueueAgents($queuename){

include("/var/www/scdrv/etc/setup.php");
    $ret=0;//array();
    $oSocket = fsockopen($astHost, 5038, $errnum, $errdesc)
        or die("Connection to host failed");
    fputs($oSocket, "Action: Login".$crlf);
    fputs($oSocket, "Events: off".$crlf);
    fputs($oSocket, "Username: ".$astUser.$crlf);
    fputs($oSocket, "Secret: ".$astSecret.$crlf.$crlf);
    fputs($oSocket, "Action: QueueStatus".$crlf.$crlf);
    fputs($oSocket, "Action: Logoff".$crlf.$crlf);

    while (!feof($oSocket)) {
        $wrets.= fread($oSocket, 8192);
    }
    fclose($oSocket);
    
    //$handle = fopen("/var/log/asterisk/cron1.log", "w");
    //fwrite($handle, $wrets);
    //fclose($handle);
    //echo($wrets);
    
    $arr=preg_split("/\r\n\r\n/",$wrets);
    foreach ($arr as $value){
        $params=array();
        $arr1=preg_split("/\r\n/",$value);
        foreach($arr1 as $value1) {
        if ($value1 != null ){
                $param=preg_split("/:/",$value1);
                if ( sizeof($param)>1 ){
                    $pn=trim($param[0]);
                    $params[$pn]=trim($param[1]);
                }
            }
        }
        if ( array_key_exists("Event", $params) && $params["Event"]=="QueueMember"){
            if ( ($params["Status"]=="1")&&($params["Queue"]==$queuename) ){
                $ret+=1;
            }
        }
    }
    return $ret;
}
//$arr=getAgentCalls("100");
//$param=$arr[0];
//echo($param["BridgedUniqueid"]);
//echo(getCallInfo($param["BridgedUniqueid"]));
//echo(getActiveQueueAgents("in-1"));

function agentLogin($cid){
include("/var/www/scdrv/etc/setup.php");
//echo($cid);
    $tmpname=uniqid("s-", true) . '.call';
    $cname=$gencalldir.$tmpname;
    $cfile = fopen($cname, 'w');
    //fputs($cfile,'Channel: Zap/g1/'.$phone.$cr);
    //fputs($cfile,'Channel: Local/'.$phone.'@out-gal'.$cr);
    fputs($cfile,'Channel: Local/'.$cid.$cr);
    fputs($cfile,'MaxRetries: 1'.$cr);
    fputs($cfile,'RetryTime: 300'.$cr);
    fputs($cfile,'WaitTime: 30'.$cr);
    fputs($cfile,'Priority: 1'.$cr);
    fputs($cfile,'Archive: yes'.$cr);
    fputs($cfile,'Account: AgentLogin'.$cr);
    fputs($cfile,'Application: macro'.$cr);
    fputs($cfile,'Data: agent-login,1001234'.$cr);
    fclose($cfile);
    chmod($cname,0777);
    chown($cname, 'asterisk');
    rename($cname, $calldir.$tmpname);
}


function originateCall($phone, $macro, $macrodata){
include("/var/www/scdrv/etc/setup.php");
//echo($cid);
    $tmpname=uniqid("s-", true) . '.call';
    $cname=$gencalldir.$tmpname;
    $cfile = fopen($cname, 'w');
    fputs($cfile,'Channel: Local/'.$phone.$cr);
    fputs($cfile,'MaxRetries: 1'.$cr);
    fputs($cfile,'RetryTime: 5'.$cr);
    fputs($cfile,'WaitTime: 30'.$cr);
    fputs($cfile,'Priority: 1'.$cr);
    fputs($cfile,'Archive: yes'.$cr);
    fputs($cfile,'Account: OriginateCall'.$cr);
    fputs($cfile,'Application: macro'.$cr);
    fputs($cfile,'Data: '.$macro.','.$macrodata.''.$cr);
    fclose($cfile);
    //chmod($cname,0777);
    //chown($cname, 'asterisk');
    //rename($cname, $calldir.$tmpname);
}
?>
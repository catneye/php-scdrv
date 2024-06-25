<?php

//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once($app."lang.php");
include_once($app."connect.php");
include_once($app."astUtils.php");

if ($_GET["func"] && ($_GET["func"]=="fillmacro")){
    $ret="";
    $paramquery = "select params from macros where name='".$_GET["param"]."'";

    $paramresult=pg_query($paramquery);
    if ($paramresult){
        while ($paramrow=pg_fetch_row($paramresult)){
            $paramlist=preg_split("/\;/", $paramrow[0]);
            foreach ($paramlist as $param) {
                if ($param=="mediafile"){
                $ret.="select:";
                    $mediaquery = "select shortname from medialib where deldate is null";
                    $mediaresult=pg_query($mediaquery);
                    if ($mediaresult){
                        while ($mediarow=pg_fetch_row($mediaresult)){
                            if ($ret!="select:") {
                                $ret.=";";
                            }
                            $ret.=$mediarow[0];
                        }
                    }
                }else if ($param=="string"){
                    $ret.="input:text";
                }
                $ret.=",";
            }
        }
    }
    echo($ret);
}

if ($_GET["func"] && ($_GET["func"]=="checkchampingname")){
    $count=0;
    $paramquery = "select count(id) from champing where name='".$_GET["param"]."'";

    $paramresult=pg_query($paramquery);
    if ($paramresult){
        $paramrow=pg_fetch_row($paramresult);
        $count=$paramrow[0];
    }
    if ($count==0){
        echo($arr_lang["allow"]);
    }else{
        echo($arr_lang["deny"]);
    }
}

if ($_GET["func"] && ($_GET["func"]=="checkgatename")){
    $count=0;
    $paramquery = "select count(id) from gateways where name='".$_GET["param"]."'";

    $paramresult=pg_query($paramquery);
    if ($paramresult){
        $paramrow=pg_fetch_row($paramresult);
        $count=$paramrow[0];
    }
    if ($count==0){
        echo($arr_lang["allow"]);
    }else{
        echo($arr_lang["deny"]);
    }
}

if ($_GET["func"] && ($_GET["func"]=="champingstate")){
    //echo($_GET[param]);
    $paramsql = "select status from champing where id=".$_GET["param"];
    //echo($paramsql);
    $paramresult=pg_query($paramsql);
    if ($paramresult){
        $paramrow=pg_fetch_row($paramresult);
        echo($paramrow[0]);
    }
}

if ($_GET["func"] && ($_GET["func"]=="getagenturl")){
    session_start();
    $ret="";
    if ($_SESSION["clid"]!=null){
        $agentcalls=getAgentCalls($_SESSION["clid"]);
        //echo(array_keys($agentcalls));
        //echo(print_r($agentcalls))."</br>";
        foreach ($agentcalls as $agentcall){
            $agentsql = "select count(id) from agentcalls where uid='".$agentcall["UniqueID"]."'";
            $agentresult=pg_query($agentsql);
            $agentrow=pg_fetch_row($agentresult);
            if ($agentrow[0]==0){
                $bridgeds=getCallInfo($agentcall["BridgedUniqueID"]);
                foreach ($bridgeds as $bridged){
                //echo(print_r($agentcall)).$crlf;
                //echo(print_r($bridgeds))."</br>";
                //echo(print_r(getCallInfo($bridgeds["BridgedUniqueid"]))).$crlf;
                //$bridgeds1=getCallInfo($$bridgeds["BridgedUniqueid"]);
                //echo(print_r($bridgeds1))."</br>";

                $qname=split(",",$bridged["ApplicationData"]);
                    $urlsql = "select url from scenario where queuename='".$qname[0]."'";
                    $urlresult=pg_query($urlsql);
                    //echo($urlsql);
                    if ($urlresult){
                        $urlrow=pg_fetch_row($urlresult);
                        $url=$urlrow[0];
                        $url=str_replace("_myid",$_SESSION["clid"],$url);
                        $url=str_replace("_user",$_SESSION["username"],$url);
                        $url=str_replace("_cid",substr($agentcall["Extension"],-10),$url);
                        if (strlen($ret)>0){
                            $ret.=";";
                        }
                        $ret.=$url;

                        $callsql="insert into agentcalls (uid, adddate, channel, cid) values (
                        '".$agentcall["UniqueID"]."',now(),'".$agentcall["Channel"]."','".$agentcall["Extension"]."')";
                        //echo ($callsql);
                        $callresult=pg_query($callsql);
                    }
                }
            }
        }
    }
    echo($ret);
}

?>
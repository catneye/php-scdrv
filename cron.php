<?
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once("/var/www/scdrv/lang.php");
include_once("/var/www/scdrv/connect.php");
include_once("/var/www/scdrv/translate.php");
include_once("/var/www/scdrv/astUtils.php");

$handle = fopen("/var/log/asterisk/cron.log", "a");
fwrite($handle, date("Y-m-d H:i:s").$crlf);

// check champing for correct job time
$stopsql="select id, stoptime from champing where status='start' and stoptime <= ".date("H:i:s");
$stopresult=pg_query($stopsql);
if ($stopresult){
    while ($stoprow=pg_fetch_row($stopresult)){
        $upstopsql="update champing set status='stop' where id=".$stoprow[0];
        $upstopresult=pg_query($upstopsql);
        fwrite($handle, "stoped champing id=$stoprow[0]".$crlf);
    }
}
//enum all champings
$champsql="select id, limitcnt, macro, macrodata, defaultchannel, callerid, waitmsec, name
from champing where status='start' and deldate is null";
fwrite($handle,$champsql.$crlf);
$champresult=pg_query($champsql);
if ($champresult){
    while ($champrow=pg_fetch_row($champresult)){
        $champid=$champrow[0];
        $limitcnt=$champrow[1];
        $macro=$champrow[2];
        $macrodata=$champrow[3];
        $defaultchannel=$champrow[4];
        $callerid=$champrow[5];
        $waitmsec=$champrow[6];
        $champname=$champrow[7];

        fwrite($handle,"Champing $champid is $macro".$crlf);
        fwrite($handle,"arguments: $macrodata".$crlf);
        if ($macro=="queue"){
            $aq=getActiveQueueAgents($macrodata);
            fwrite($handle,"getActiveQueueAgents: $aq\n");
            $limitcnt=floor($aq*1.5);
        }
        fwrite($handle,"limitcnt: $limitcnt\n");
        $basesql="select id, name, priority from base 
            where idchamping=".$champid." and priority > 0
            order by priority desc limit ".$limitcnt;
        $baseresult=pg_query($basesql);
        if($baseresult){
            while ($baserow=pg_fetch_row($baseresult)){
                $baseid=$baserow[0];
                $basename=$baserow[1];
                $priority=$baserow[2];
                fwrite($handle,"Base: $basename, $baseid".$crlf);
                if (strlen($basename) > 0){
                    originateCall($basename, $macro, $macrodata);
                    fwrite($handle,"Originated: $basename, $macro, $macrodata".$crlf);
                }
                $priority=0;
                $resultsql="update base set lastoriginatedate=now(), priority=".($priority).
                    " where id=".$baseid;
                //echo($resultsql.$crlf);
                $resultresult=pg_query($resultsql);
                usleep(4000);
            }
        }
    }
}
fclose($handle);
?>
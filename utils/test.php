<?
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

    $champname="manual";
    $limitcnt="1";
    $macro="queue";
    $macrodata="in-1";
    $defaultchannel="Local/";
    $callerid="79094027854";
    $basename="79094027854";
    $priority="1";
    $crlf="\r\n";

                $oSocket = @fsockopen("localhost", 5038, $errnum, $errdesc)
                or die("Connection to host failed");
                fputs($oSocket, "Action: login".$crlf);
                fputs($oSocket, "Events: off".$crlf);
                fputs($oSocket, "Username: scdrv".$crlf);
                fputs($oSocket, "Secret: scdrv".$crlf.$crlf);
    
                fputs($oSocket, "Action: Status".$crlf.$crlf);
                
                fputs($oSocket, "Action: CoreChannelsStatus".$crlf.$crlf);
                
                

                //fputs($oSocket, "Action: Agents".$crlf.$crlf);
                
                //fputs($oSocket, "Variable: Medialib".$crlf);
                //fputs($oSocket, "Action: Status".$crlf.$crlf);
                
                //fputs($oSocket, "Action: QueueStatus".$crlf.$crlf);

                //fputs($oSocket, "Action: originate".$crlf);
                //echo($defaultchannel.$basename.$crlf);
                //fputs($oSocket, "Channel: ".$defaultchannel.$basename.$crlf);
                //fputs($oSocket, "CallerID: ".$callerid.$crlf);
                //fputs($oSocket, "Application: Macro".$crlf);
                //fputs($oSocket, "Data: ".$macro.",".$macrodata.$crlf);
                //fputs($oSocket, "Account: ".$champname.$crlf);
                //fputs($oSocket, "Priority: 1".$crlf.$crlf);

                fputs($oSocket, "Action: Logoff".$crlf.$crlf);
                while (!feof($oSocket)) {
                $wrets = fread($oSocket, 8192);
                }
                fclose($oSocket);
                
                $arr=preg_split("/\r\n\r\n/",$wrets);
                foreach ($arr as $value){
                    $arr1=preg_split("/\r\n/",$value);
                    foreach ($arr1 as $value1){
                    echo ($value1."---".$crlf);
                    }
                    echo ($crlf);
                }
?>
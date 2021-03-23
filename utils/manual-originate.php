<?
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

    $champname="manual";
    $limitcnt="1";
    $macro="dial";
    $macrodata="79094027854";
    //$macrodata="79061840312";
    $defaultchannel="Local/";
    //$callerid="79094027854";
    $basename="78632245367";
    //$basename="79034892902";
    $priority="1";
    $crlf="\r\n";

                $oSocket = @fsockopen("localhost", 5038, $errnum, $errdesc)
                or die("Connection to host failed");
                fputs($oSocket, "Action: login".$crlf);
                fputs($oSocket, "Events: off".$crlf);
                fputs($oSocket, "Username: scdrv".$crlf);
                fputs($oSocket, "Secret: scdrv".$crlf.$crlf);

                //fputs($oSocket, "Action: SetVar".$crlf);
                //fputs($oSocket, "Variable: Medialib".$crlf);
                //fputs($oSocket, "Value: ".$astMedialib.$crlf.$crlf);

                fputs($oSocket, "Action: originate".$crlf);
                echo($defaultchannel.$basename.$crlf);
                fputs($oSocket, "Channel: ".$defaultchannel.$basename.$crlf);
                fputs($oSocket, "CallerID: ".$callerid.$crlf);
                fputs($oSocket, "Application: Macro".$crlf);
                fputs($oSocket, "Data: ".$macro.",".$macrodata.$crlf);
                fputs($oSocket, "Account: ".$champname.$crlf);
                fputs($oSocket, "Priority: 1".$crlf.$crlf);

                fputs($oSocket, "Action: Logoff".$crlf.$crlf);
                while (!feof($oSocket)) {
                $wrets = fread($oSocket, 8192);
                }
                fclose($oSocket);
                if (stripos($wrets, 'Originate successfully queued')) {
                    echo "Call completed ".$crlf;
                } else {
                    echo "No accept call ".$crlf;
                }
?>
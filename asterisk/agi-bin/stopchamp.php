#!/usr/bin/php
<?
$crlf="\r\n";
//require '/var/lib/asterisk/agi-bin/stuff/phpagi.php';
//$agi = new AGI();

//$no=$agi->get_variable("pin");

$db = 'scdrv';
$dbuser = 'root';
$dbpass = 'root152';
$dbhost = 'localhost';
$account="0";

pg_connect($dbhost,$dbuser,$dbpass);
pg_select_db("$db");
$query="update champing set status='stop';";
$res=pg_query($query);
$query="delete from base;";
$res=pg_query($query);


//$agi->exec("NoOp",$row);
//if (pg_num_rows($res)>0){
//    $row=pg_fetch_row($res);
//    $account = $row[0];
//}
//$agi->set_variable("acc", $account);
?>
#!/usr/bin/php -q

<?
$crlf="\r\n";
include_once("/var/www/scdrv/etc/setup.php");

if (!defined('STDIN'))
    define('STDIN', fopen('php://stdin', 'r'));
if (!defined('STDOUT'))
    define('STDOUT', fopen('php://stdout', 'w'));
if (!defined('STDERR'))
    define('STDERR', fopen('php://stderr', 'w'));
$flog = fopen('/var/log/asterisk/my_agi.log', 'w');

while (!feof(STDIN)) {
    $temp = trim(fgets(STDIN,4096));
    if (($temp == "") || ($temp == "\n")) {
    break;
}
$s = split(":",$temp);
$name = str_replace("agi_","",$s[0]);
$agi[$name] = trim($s[1]);
}

foreach($agi as $key=>$value) {
    fwrite($flog,"$key -- $value\n");
}
$tmpname="";
for ($i=0;$i<10;$i++){
    $tmpname.=mt_rand(0,100);
}
fwrite($flog,$agi["arg_1"].".wav\n");
fwrite($flog,$tmpname.".gsm\n");

$sysret="";
$cmd="sox ".$agi["arg_1"].".wav -r 8000 -c 1 ".$medialib.$tmpname.".gsm";
fwrite($flog,$cmd."\n");
system($cmd,$sysret);
fwrite($flog,$sysret."\n");

if( filesize($medialib.$tmpname.".gsm")>0){
    pg_connect($dbhost,$dbuser,$dbpass);
    pg_select_db($dbname);
    $query="insert into medialib (name, description, shortname) values
    ('".$tmpname.".gsm','Asterisk Record - ".$tmpname."','".$tmpname."')";
    fwrite($flog,$query."\n");
    $res=pg_query($query);
}
fclose($flog);
?>
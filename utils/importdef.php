<?php
include_once("../connect.php");

mysql_query('delete from def'); 
mysql_query('delete from provider'); 
mysql_query('ALTER TABLE provider AUTO_INCREMENT = 0'); 
mysql_query('ALTER TABLE def AUTO_INCREMENT = 0'); 

$filename="ABC_.csv";
$file=fopen($filename,'r');
if ($file){
    while( ($line=fgets($file,4096)) !== false){
        $arr=preg_split("/\;/", $line);
        //def;from;to;count;operator;region
        //provider
        mysql_query('SET AUTOCOMMIT=0'); 
        mysql_query('START TRANSACTION'); 
        
        $idprovider=0;
        $provsql="select id from provider where name='".$arr[4]."' and description = '".trim($arr[5])."'";
        echo("select provider: ".$provsql.$crlf);
        $provres=mysql_query($provsql);
        if (mysql_num_rows($provres)==0){
            $newprovsql="insert into provider (name, description) values ('".$arr[4]."', '".trim($arr[5])."')";
            echo("insert provider: ".$newprovsql.$crlf);
            $provres=mysql_query($newprovsql);
            $idprovider=mysql_insert_id();
        }else{
            $provrow=mysql_fetch_row($provres);
            $idprovider=$provrow[0];
        }
        $defsql="insert into def (name, digfrom, digto,idprovider, amount)
        values('".$arr[0]."',$arr[1],$arr[2],$idprovider,$arr[3])";
        echo("insert def: ".$defsql.$crlf);
        $defres=mysql_query($defsql);
        if ( !$defres ){
            die("error".$crlf);
        }
        mysql_query('COMMIT'); 
    }
fclose($file);
}
?>

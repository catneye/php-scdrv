<?php

//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once($app."lang.php");
include_once($app."connect.php");

//echo($_FILES["media"]["type"]);

$mime=$_FILES["media"]["type"];
if (  ($mime== "text/comma-separated-values")||($mime=="text/csv")){
    if ($_FILES["media"]["error"] > 0){
        echo $arr_lang["upload-error"].": " . $_FILES["media"]["error"] . "<br />";
    }else{
         echo $arr_lang["filename"].": " . $_FILES["media"]["name"] . "<br />";
         echo $arr_lang["filetype"].": " . $_FILES["media"]["type"] . "<br />";
         echo $arr_lang["filesize"].": " . ($_FILES["media"]["size"] / 1024) . " Kb<br />";
         if ($_POST["limit"] && ($_POST["limit"]>0) && $_POST["item"] ){
             $tmpname=$uploaddir;
             for ($i=0;$i<10;$i++){
                 $tmpname.=mt_rand(0,100);
             }
             move_uploaded_file($_FILES["media"]["tmp_name"],$tmpname);
             echo $arr_lang["upload-stored"].": " .$tmpname;

             $tmpfile=fopen($tmpname,'r');
             if ($tmpfile){
                 while(($line=fgets($tmpfile,256))!== false){
                     $cleanline=preg_replace("/[^0-9]/","", $line);
                     $basequery="insert into base (name, adddate, idchamping, priority)
                     values ('".$cleanline."',now(),".$_POST["item"].",".$_POST["limit"].")";
                     //echo($basequery);
                     $baseresult=pg_query($basequery);
                 }
                 fclose($tmpfile);
             }
         } else {
             echo $arr_lang["form-not-field"];
         }
    }
}else{
    echo $arr_lang["upload-invalid-type"].": ".$_FILES["media"]["type"];
}
?>

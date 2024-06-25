<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once($app."lang.php");
include_once($app."connect.php");

if ($_POST["description"]&&(trim($_POST["description"])!="")){
    echo $arr_lang["filename"].": " . $_FILES["media"]["name"] . "<br />";
    echo $arr_lang["filetype"].": " . $_FILES["media"]["type"] . "<br />";
    echo $arr_lang["filesize"].": " . ($_FILES["media"]["size"] / 1024) . " Kb<br />";

    $mime=$_FILES["media"]["type"];
    $tmpname="";
    $resname="";
    for ($i=0;$i<10;$i++){
        $tmpname.=mt_rand(0,100);
    }

    if ($_FILES["media"]["error"] == 0){
        $uploadname=$uploaddir.$_FILES["media"]["name"];
        move_uploaded_file($_FILES["media"]["tmp_name"],$uploadname);
        echo $arr_lang["upload-stored"].": " .$uploadname."<br />";

        if ($mime == "application/octet-stream"){
            $resname=$medialib.$tmpname.".gsm";
            rename($uploadname,$resname);
        }else if ($mime=="audio/mpeg"){
            echo $arr_lang["upload-encoding"]."<br />";
            $sysret="";
            $cmd="sox ".$uploadname." -r 8000 -c 1 ".$uploaddir.$tmpname.".gsm";
            echo($cmd)."<br />";
            system($cmd,$sysret);
            if( ($sysret!="")&&(filesize($uploaddir.$tmpname.".gsm")==0)){
                echo $arr_lang["upload-encoding-fail"].": " .$sysret."<br />";
            }else{
                $resname=$medialib.$tmpname.".gsm";
                rename($uploaddir.$tmpname.".gsm",$resname);
            }
        }else if ($mime=="audio/wav"){
            echo $arr_lang["upload-encoding"]."<br />";
            $sysret="";
            $cmd="sox ".$uploadname." -r 8000 -c 1 ".$uploaddir.$tmpname.".gsm";
            echo($cmd."<br />");
            system($cmd,$sysret);
            if( ($sysret!="")&&(filesize($uploaddir.$tmpname.".gsm")==0)){
                echo $arr_lang["upload-encoding-fail"].": " .$sysret."<br />";
            }else{
                $resname=$medialib.$tmpname.".gsm";
                rename($uploaddir.$tmpname.".gsm",$resname);
            }
        }else{
            echo $arr_lang["upload-invalid-type"].": ".$mime."<br />";
            echo $arr_lang["upload-encoding"]."<br />";
            $sysret="";
            $cmd="sox ".$uploadname." -r 8000 -c 1 ".$uploaddir.$tmpname.".gsm";
            echo($cmd."<br />");
            system($cmd,$sysret);
            if( ($sysret!="")&&(filesize($uploaddir.$tmpname.".gsm")==0)){
                echo $arr_lang["upload-encoding-fail"].": " .$sysret."<br />";
            }else{
                $resname=$medialib.$tmpname.".gsm";
                rename($uploaddir.$tmpname.".gsm",$resname);
            }
        }
    }else{
        echo $arr_lang["upload-error"].": " . $_FILES["media"]["error"] . "<br />";
    }
    if ($resname!=""){
        echo $arr_lang["upload-stored"].": " .$resname."<br />";
         $uploadquery = "insert into medialib (name, description, shortname) values".
         "('".$tmpname.".gsm', '".$_POST["description"]."', '".$tmpname."')";
         //echo($uploadquery);
         $uploadresult=pg_query($uploadquery);
    }
}else{
    echo($arr_lang["form-not-field"]."<br />");
}
?>

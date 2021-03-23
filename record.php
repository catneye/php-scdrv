<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once($app."lang.php");
include_once($app."connect.php");

$dir=$records;

echo("<table class='btable'><tr>");
echo("<tr>");
echo("<th class='btableth'>".$arr_lang["filename"]."</th>");
echo("<th class='btableth'>".$arr_lang["filetype"]."</th>");
echo("<th class='btableth'>".$arr_lang["calldate"]."</th>");
echo("<th class='btableth'>".$arr_lang["src"]."</th>");
echo("<th class='btableth'>".$arr_lang["dst"]."</th>");
echo("<th class='btableth'>".$arr_lang["action"]."</th>");
echo("</tr>");

if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            //echo "filename: $file : filetype: " . filetype($dir . $file) . "\n";
            //$finfo=finfo_open(FILEINFO_MIME_TYPE);
            //echo(finfo_file($finfo,$dir.$file));
            //finfo_close($finfo);
            if (filetype($dir . $file)=='file'){
                echo("<tr>");
                echo("<td class='btabletd'>".$file."</td>");
                echo("<td class='btabletd'>".mime_content_type($dir.$file)."</td>");
                $uid=substr($file,0,-4);

                $listquery = "select calldate, src, dst from cdr where uniqueid = '".$uid."' order by calldate";
                //echo($listquery);
                $listresult=pg_query($listquery);
                if ($listresult){
                    $listrow=pg_fetch_row($listresult);
                    $calldate=$listrow[0];
                    $src=$listrow[1];
                    $dst=$listrow[2];
                    echo("<td class='btabletd'>".$calldate."</td>");
                    echo("<td class='btabletd'>".$src."</td>");
                    echo("<td class='btabletd'>".$dst."</td>");
                }else{
                    echo("<td class='btabletd'></td>");
                    echo("<td class='btabletd'></td>");
                    echo("<td class='btabletd'></td>");
                }
                echo($cr);
                echo("<td class='btabletd'>".
                    "<a href='index.php?action=reports&option=recorddelete&item=".
                    $file."'>". $arr_lang["delete"]."</a>"."&nbsp&nbsp".
                    "<a href='".$dir.$file."'>".$arr_lang["download"]."</a>".
                    "</td>");
                echo("</tr>");
                echo($cr);
            }
        }
    closedir($dh);
    }
echo("</table>");
}
?>
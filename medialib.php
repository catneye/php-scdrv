<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once($app."lang.php");
include_once($app."connect.php");

$dir=$medialib;

echo("<table class='btable'><tr>");
echo("<tr>");
echo("<th class='btableth'>".$arr_lang["filename"]."</th>");
echo("<th class='btableth'>".$arr_lang["filetype"]."</th>");
echo("<th class='btableth'>".$arr_lang["description"]."</th>");
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
                $description=$arr_lang["withoutdescription"];
                $medianame=0;
                $listquery = "select name, description from medialib where name = '".$file."' and deldate is null";
                $listresult=pg_query($listquery);
                if ($listresult){
                    $listrow=pg_fetch_row($listresult);
                    $medianame=$listrow[0];
                    $description=$listrow[1];
                }
                echo("<td class='btabletd'>".$description."</td>");
                if ($medianame && (trim($medianame)!="")){
                echo("<td class='btabletd'>
                    <a href=index.php?action=medialib&option=delete&item=".
                    $medianame.">". $arr_lang["delete"]."</a>".
//                    "<a href=index.php?action=medialib&option=edit&item=".
//                    $medianame.">".$arr_lang["rename"]."</a>".
                    "</td>");
                }
                echo("</tr>");
            }
        }
    closedir($dh);
    }
echo("</table>");
}
?>
<script>
function Add(){
//clean old
var j=1;
var parent = document.getElementById('dmacrodata');
var old = document.getElementById('macrodata'+j);
while (old){
    parent.removeChild(old);
    j++;
    old = document.getElementById('macrodata'+j);
}
//get new
var val = document.getElementById('macro').value;
$.get('./ajax.php?func=fillmacro&param='+val, function(data){
    var i=1;
    var params=data.split(",");
    for (var pidx in params){
        var param=params[pidx];
        var parts=param.split(":");
        var newelem=document.createElement(parts[0]);
        newelem.id='macrodata'+i;
        newelem.onchange=function(){SetMacroData();};

        if (parts[0]=="select"){
            var opts=parts[1].split(";");
            for (var oidx in opts){
                var newopt=document.createElement("option");
                newopt.value=opts[oidx];
                newopt.text=opts[oidx];
                newelem.add(newopt);
            }
        }else if (parts[0]=="input"){
            newelem.value=parts[1];
        }
        parent.appendChild(newelem);
        i++;
    }
    SetMacroData();
});
}

function CheckName(){
var val = document.getElementById('chname').value;
var parent = document.getElementById('chchname');
$.get('./ajax.php?func=checkchampingname&param='+val, function(data){
parent.innerHTML=data;
});
}

function SetMacroData(){
    var j=1;
    var elem = document.getElementById('macrodata'+j);
    var res="";
    while (elem){
        if (res!=""){
            res=res+",";
        }
        res=res+elem.value;
        j++;
        elem = document.getElementById('macrodata'+j);
    }
    var helem = document.getElementById('hmacrodata');
    if ( helem!=null ){
        helem.value=res;
    }
}
</script>

<?php

//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once($app."lang.php");
include_once($app."connect.php");

echo ("<table>");
echo ("<form method='post' action='./index.php'>");
echo ("<tr><td colspan='2'>".$arr_lang["create-champing"]."</td></td>");
echo ("<tr><td>".$arr_lang["name"]."</td><td><input type='text' id='chname' name='chname' style='width: 100%' onchange='CheckName();' value='".$arr_lang["new-champing"]."' /></td></tr>");
echo ("<tr><td>".$arr_lang["checkname"]."</td><td><div id='chchname' name='chchname'></div></td></tr>");
echo ("<tr><td>".$arr_lang["description"]."</td><td><input type='text' name='description' style='width: 100%' value='".$arr_lang["new-champing"]."'/></td></tr>");
echo ("<tr><td>".$arr_lang["limitcnt"]."</td><td><input type='text' name='limitcnt' style='width: 100%' value='1' /></td></tr>");

echo ("<tr><td>".$arr_lang["macro"]."</td><td><select id='macro' name='macro' size='1' style='width: 100%' onchange='Add();'>");
$listquery = "select name from macros";
$listresult=pg_query($listquery);
if ($listresult){
    while ($listrow=pg_fetch_row($listresult)){
        echo("<option value='".$listrow[0]."'>".$listrow[0]."</option>");
    }
}
echo("</select></td></tr>");

//echo ("<tr><td>".$arr_lang["champing-type"]."</td><td><select id='chtype' name='chtype' size='1' style='width: 100%'>");
//$listquery = "select id, description from champingtype";
//$listresult=pg_query($listquery);
//if ($listresult){
//    while ($listrow=pg_fetch_row($listresult)){
//        echo("<option value='".$listrow[0]."'>".$listrow[1]."</option>");
//    }
//}
echo("</select></td></tr>");

echo ("<tr><td>".$arr_lang["macrodata"]."</td><td><div id='dmacrodata' name='dmacrodata' onchange='SetMacroData();' style='width: 100%'></div></td></tr>");

echo ("<tr><td>".$arr_lang["defaultchannel"]."</td><td><input type='text' name='defaultchannel' style='width: 100%' value='Local/'/></td></tr>");
echo ("<tr><td>".$arr_lang["callerid"]."</td><td><input type='text' name='callerid' style='width: 100%' value='000'/></td></tr>");
echo ("<tr><td>".$arr_lang["waitmsec"]."</td><td><input type='text' name='waitmsec' style='width: 100%' value='50'/></td></tr>");

echo ("<tr><td><input type='submit' name='select' value='".$arr_lang["select"]."'></td>");
echo ("<td><input type='hidden' name='action' value='".$_GET[action]."'>
<input type='hidden' name='option' value='".$_GET[option]."'>
<input type='hidden' id='hmacrodata' name='hmacrodata'>
</td></tr>");
echo ("</form></table>");


?>
<script>
Add();
CheckName();
SetMacroData();
</script>
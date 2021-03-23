<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

include_once($app."lang.php");
if ($_POST[login]!=""){
    include_once("./connect.php");
    $query="select id, name, secret, idrole, human from accounts where name='".$_POST[login]."'";
    //echo $query;
    $result=pg_query($query);
    if ($result){
        session_start();
        $row = pg_fetch_row($result);
        if ( ($row[1]==$_POST["login"])&&($row[2]==$_POST["password"])){
            $_SESSION['username']=$row[1];
            $_SESSION['useridrole']=$row[3];
            $_SESSION['userhuman']=$row[4];
            $rolequery="select id, name, description from role where id=".$row[3];
            $roleresult=pg_query($rolequery);
            $rolerow = pg_fetch_row($roleresult);
            $_SESSION['userrole']=$rolerow[1];
            $_SESSION['userhumanrole']=$rolerow[2];
            $_SESSION['clid']=$_POST["extension"];
            header("Location: index.php");
        }
    }else{
        echo("result error");
        header("Location: index.php?error=1");
    }
}else if ( ($_GET[action]!="")&&($_GET[action]=="exit")){
    session_start();
    unset($_SESSION['username']);
    unset($_SESSION['useridrole']);
    unset($_SESSION['userhuman']);
    unset($_SESSION['userrole']);
    unset($_SESSION['userhumanrole']);
    session_destroy();
    header("Location: index.php");
}else{
    session_start();
    if ($_SESSION['username']==''){
        echo "<table name='login form'>
        <form method='post' action='./login.php'>
        <tr><td rowspan='3'><img src='./img/logo.png' alt='scdrvlogo' /></td><td width='100%'><div></div></td><td><div>".$arr_lang["name"]."</div></td><td><input type='text' name='login'/></td></tr>
        <tr><td></td><td><div>".$arr_lang["password"]."</div></td><td><input type='password' name='password'/></td></tr>
        <tr><td></td><td><div>".$arr_lang["extension"]."</div></td><td><input type='extension' name='extension'/></td></tr>
        <tr><td></td><td></td><td><input type='submit' value='".$arr_lang["enter"]."'/></tr>
        </form></table>";
    }else{
        echo "<table name='login info' border='0'>
        <tr><td rowspan='3' align='left'><img src='./img/logo.png' alt='scdrvlogo' /></td><td width='100%'><div></div></td><td>".$arr_lang["welcome"].", </td><td>".$_SESSION["userhuman"]."</td></tr>
        <tr><td><div></div></td><td>".$arr_lang["yourole"].": </td><td>".$arr_lang[$_SESSION['userrole']]."</td></tr>
        <tr><td><div></div></td><td></td><td></td></tr>
        <tr><td><div></div></td><td><div></div></td><td><a href='login.php?action=exit'>".$arr_lang["exit"]."</a></td></tr>
        </table>";
    }
}
?>
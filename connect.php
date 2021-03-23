<?php
//It's file is part of "Simple CDR View"
//Licensed GPL2 (see LICENSE)
//(c)2010-2012 Oleg Kuchenko

    include_once($app."etc/setup.php");
    
    $host = $dbhost;
    $uname = $dbuser;
    $upassword = $dbpass;
    $name = $dbname;
    $conn = pg_connect("host=".$host." port=5432 user=".$uname." password=".$upassword." dbname=".$name );
    if ( !isset( $conn ) )
    {
    echo( "Error. pg_connect( $host, $uname, ****** )" );
    exit();
    }
?>

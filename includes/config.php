<?php

    ob_start();
    session_start( );
    
    date_default_timezone_set( "Europe/Paris" );
    
    try{
        $con = new PDO( "mysql:dbname=netfilm;host=localhost" , "loun" , "lounloun" );
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    catch( PDOException $e ){
        exit( "Connection failed:" . $e->getMessage() );
    }

?>
<?php
    $db = array(
        "username" => "epalmquist",
        "password" => "onepine1",
        "localhost" => "localhost",
        "dbname" => "info230_SP12_epalmquist"
    );
    
    $mysqli = new mysqli($db['localhost'], $db['username'], $db['password'], $db['dbname']);
    
    if($mysqli->connect_errno) {
        print "Failed to connect to MySQL: " . $mysqli->connect_error;
    }  
?>

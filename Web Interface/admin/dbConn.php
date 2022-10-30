<?php
    $Servername="localhost";
    $Username="id19414514_teamtrolley";
    $password="Password@111";
    $Database="id19414514_trolleyproject";
    $con = new mysqli($Servername,$Username,$password,$Database);
    if($con->connect_errno){
        die();
        echo "Failed to connect to database" .$con->connect_error;
    }
    else{
        // echo "connection successful";
    }
?>
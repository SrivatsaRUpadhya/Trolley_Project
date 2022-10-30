<?php
    if(isset($_POST['submit'])){
        include "dbConn.php";
        $sql = "SELECT * FROM customers";
        $result= $con->query($sql);
        $row = $result->fetch_assoc();
        if($row['Contact_Number'] == $_POST['phone'] and $row['Password'] == $_POST['password']){
            session_start();
            $_SESSION['LoggedIn']=true;
            echo $_SESSION['LoggedIn'];
            header("location:..\Landing Page.html");
            $_SESSION['uploadprd'] = true;
            $_SESSION['viewprd'] = true;
            exit();
        }
        else{
            header("location:..\index.html");
        }
    }
    else{
        header("location:..\index.html");
    }
?>

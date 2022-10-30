<?php
        if(isset($_POST['submit'])){
        include "dbConn.php";
        $phone = $_POST['phone'];
        $sql = "SELECT * FROM customers WHERE Contact_Number = $phone";
        $result= $con->query($sql);
        $row = $result->fetch_assoc();
        if($row == []){
            echo("mc1");//User not found 
        }
        else{
            while($row){
                
                if($row['Contact_Number'] == $_POST['phone'] and $row['Password'] == $_POST['pin']){
                    echo("mc3");//User details incorrect
                    exit();
                }
                else{
                    echo("mc2");//User details correct. so login
                    exit();
                }
        }
        }

    }
?>

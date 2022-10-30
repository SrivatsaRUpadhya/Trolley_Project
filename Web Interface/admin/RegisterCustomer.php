<?php
    include "dbConn.php";
    
    if(isset($_POST['submit'])){
        if($_POST['password'] == $_POST['password_repeat']){
            $Name = $_POST['name'];
            $Phone = $_POST['phone'];
            $Email = $_POST['email'];
            $Password = $_POST['password'];
    

            
            $insert = mysqli_query($con, "INSERT INTO customers (Contact_Number, Customer_Name, Email, Password) VALUES ('$Phone', '$Name', '$Email', '$Password')");
        
            if(!$insert){
                echo (mysqli_error($con));
            }
            else{
                echo '<script>';
                echo '  alert("Records added successfully.");';
                echo '</script>';
            }
            
            $remove_col = mysqli_query($con,"ALTER TABLE customers DROP Sl_No");
            $add_col = mysqli_query($con,"ALTER TABLE customers ADD Sl_No INT(255) NOT NULL AUTO_INCREMENT ,ADD PRIMARY KEY(Sl_No)");
            
            mysqli_close($con); // Close connection
        }
        else{
            echo '<script>';
            echo '  alert("Passwords do not match!");';
            echo '</script>';
        }
    }
        // else{
        //     echo '<script>';
        //         echo '  alert("Could not submit");';
        //         echo '</script>';
        // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\css\Register Customer.css">
    <title>Store name-New User</title>
</head>
<body>
    <div class="form-wrapper">
        <form method="POST" enctype="multipart/form-data">
            <h1>Hi! welcome to store name</h1>
            <ul class="form-elements">
                <h2>Please register yourself</h2>
                <li><label for="name-field">Name</label><input type="text" name="name" id="name-field"></li>
                <li><label for="phone-field">Contact Number</label><input type="tel" name="phone" id="phone-field" maxlength = "10"></li>
                <li><label for="email-field">Email</label><input type="text" name="email" id="email-field"></li>
                <li><label for="password-field">Set Pin</label><input type="number" name="password" id="password-field"></li>
                <li><label for="password-repeat-field">Re-type Pin</label><input type="number" name="password_repeat" id="password-repeat-field"></li>
                <!--<button type="submit" name = "submit">Register</button>-->
                <input type = "submit" name = "submit">
            </ul>
        </form>
    </div>

    <!-- PHP code to register the user to the databse  -->

</body>
</html>
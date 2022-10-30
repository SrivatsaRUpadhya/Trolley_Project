<?php session_start();
    if(isset($_POST['submit'])){
        include "admin/dbConn.php";
        $phone = $_POST['phone'];
        $sql = "SELECT * FROM customers WHERE Contact_Number = $phone";
        $result= $con->query($sql);
        $row = $result->fetch_assoc();
        if($row == []){
            header('location:admin\RegisterCustomer.php');
        }
        else{
            while($row){
                if($row['Contact_Number'] == $_POST['phone'] and $row['Password'] == $_POST['password']){
                header("location:Landing Page.php");
                $_SESSION['LoggedIn']=true;
                $_SESSION['customer_logged_in'] = true;
                $_SESSION['Customer'] = $phone;
                exit();
            }
            else{
                echo '<script>';
                echo '  alert("Invalid credentials!");';
                echo '</script>';
                mysqli_close($con);
                exit();
            }
        }
        }

    }
    
?>
<html lang="en">
<head>
    <meta charset="UTF-8 without BOM">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/LoginPage.css">
    <title>store name</title>
</head>
<body>
    <div class="content-wrapper">
    <h1 id="welcome-msg">Hi!<br>Welcome to store name.</h1>
    <h2 id="ask-login">Please login to continue</h2>
        <form method="post">
            <ul class="form-elements">
                <li><label for="phone-field">Phone Number</label><input type="tel" name="phone" id="phone-field" maxlength = "10" required></li>
                <li><label for="password-field">Pin</label><input type="number" name="password" id="password-field" minlength = ""></li>
                <li><button type="submit" name = "submit">Login</button></li>
                <br><li><a href = "https://smart-trolley-project.000webhostapp.com/admin/RegisterCustomer.php">New Users Register Here</a></li>
            </ul>
        </form>
    </div>
</body>
</html>
    <!-- validation -->

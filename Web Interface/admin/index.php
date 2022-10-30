<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/LoginPage.css">
    <title>store name</title>
</head>
<body>
    <div class="content-wrapper">
    <h1 id="welcome-msg">Store Management</h1>
    <h2 id="ask-login">Please login to continue</h2>
        <form method="post">
            <ul class="form-elements">
                <li><label for="username-field">Username</label><input type="text" name="username" id="username-field"></li>
                <li><label for="password-field">Password</label><input type="text" name="password" id="password-field"></li>
                <li><button type="submit" name = "submit">Login</button></li>
            </ul>
        </form>
    </div>

    <!-- validation -->
    <?php
    if(isset($_POST['submit'])){
        include "dbConn.php";
        $sql = "SELECT * FROM customers";
        $result= $con->query($sql);
        $row = $result->fetch_assoc();
        if($_POST['username'] == "storeadmin" and $_POST['password'] == "storeadmin"){
            session_start();
            $_SESSION['LoggedIn']=true;
            echo $_SESSION['LoggedIn'];
            header("location:Manage Products.php");
            $_SESSION['manageprd'] = true;
            $_SESSION['viewprd'] = true;
            exit();
        }
        else{
            echo '<script>';
            echo '  alert("Invalid credentials!");';
            echo '</script>';
            mysqli_close($con);
        }
    }
?>

</body>
</html>
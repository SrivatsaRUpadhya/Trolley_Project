<?php
        session_start();
        if($_SESSION['customer_logged_in']){
            // unset($_SESSION['manageprd']);
        }
        else{
            header("location:index.php");
        }

    if(isset($_POST['logout'])){
                $_SESSION['Customer'] = "";
                session_destroy();
                // $_SESSION['manageprd'];
                // unset($_SESSION['manageprd']);
                // header("location:index.php");
                echo "<script>
                    window.location.href = 'index.php';
                </script>";
                }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\Landing Page.css">
    <title>Landing Page</title>
</head>
<body>
    <div class="wrapper">
        <div class="nav-wrapper">
            <h2 class="nav-heading">Hello! <br> What would you like to do?</h2>
            <ul class="nav-list">
                <li class="nav-listitems"><a href="Bill Page.php" class="navlinks">Start Shopping</a></li>
                <li class="nav-listitems"><a href="Previous Bills.php" class="navlinks">View Previous Bills</a></li>
                <li class="nav-listitems"><form method="post"><input type="submit" value="Logout" name = "logout"></form></li>
            </ul>
        </div>
    </div>
</body>
</html>
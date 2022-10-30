<?php
//Creates new record as per request
    //Connect to database
    $servername = "localhost";
    $username = "id19414514_srivatsa";
    $password = "Password@111";
    $dbname = "id19414514_espdemo";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }
    else{
        echo "Connection successful";
    }

    //Get current date and time
    date_default_timezone_set('Asia/Kolkata');
    $d = date("Y-m-d");
    //echo " Date:".$d."<BR>";
    $t = date("H:i:s");

    if($_POST['phone'] != "")
    {
    	$phone = $_POST['phone'];
    // 	$station = $_POST['station'];

	    $sql = "INSERT INTO logs (phone)
		
		VALUES ('$phone')";

		if ($conn->query($sql) === TRUE) {
		    echo "OK";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
  		// $sql = "INSERT INTO logs (station, status) VALUES ('5645', 'AA')";
		// $conn->query($sql);


	$conn->close();
?>
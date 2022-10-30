<?php
        include "admin/dbConn.php";
        if(isset($_POST['add_prd']) && $_POST['prd-id'] != ""){   
            // echo ($customer);
            $customer = $_POST['customer'];
            $add_prd_ID = $_POST['prd-id'];
            $get_present_qty = mysqli_query($con, "SELECT Quantity FROM all_bills WHERE Product_ID = $add_prd_ID AND Customer = $customer AND Bill_Date = CURRENT_DATE()");
            $present_qty = mysqli_fetch_array($get_present_qty);

            if($present_qty == []){
                $get_data = mysqli_query($con, "SELECT * FROM all_products WHERE Product_ID = $add_prd_ID");
                $data_arr = mysqli_fetch_assoc($get_data);
                $cost = $data_arr['Cost'];
                $amount = $cost;
                $insert_item = mysqli_query($con, "INSERT INTO `all_bills`(`Customer`, `Bill_Date`, `Product_ID`, `Product_Name`, `Cost`, `Amount`) VALUES ('$customer',CURRENT_DATE(),'$data_arr[Product_ID]', '$data_arr[Product_Name]', '$data_arr[Cost]', '$amount')");
                if(!$insert_item){
                    echo mysqli_error($con);
                }
                else{
                    echo '<script>';
                    // echo '  alert("Records added successfully.");';
                    echo ($cost);
                    echo '</script>';
                    mysqli_close($con); // Close connection
                }
            }
            else{
                $get_data = mysqli_query($con, "SELECT * FROM all_products WHERE Product_ID = $add_prd_ID");
                $data_arr = mysqli_fetch_assoc($get_data);
                $cost = $data_arr['Cost'];
                $amount = $cost;
                $new_qty = $present_qty[0] + 1;
                $new_amt = ($new_qty) * $cost;
                $change_qty = mysqli_query($con, "UPDATE all_bills SET Quantity = '$new_qty', Amount = '$new_amt' WHERE Product_ID = $add_prd_ID AND Customer = $customer AND Bill_Date = CURRENT_DATE()");
            }
    }
    ?>
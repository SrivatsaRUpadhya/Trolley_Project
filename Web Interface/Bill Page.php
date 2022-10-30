<?php
session_start();
if($_SESSION['customer_logged_in']){
    // unset($_SESSION['manageprd']);
    
}
else{
    header("location:index.php");
}
    $customer = $_SESSION['Customer'];
    include_once("gridphp/config.php");

// include and create object
include("gridphp/lib/inc/jqgrid_dist.php");

$db_conf = array(
                    "type"      => PHPGRID_DBTYPE,
                    "server"    => PHPGRID_DBHOST,
                    "user"      => PHPGRID_DBUSER,
                    "password"  => PHPGRID_DBPASS,
                    "database"  => PHPGRID_DBNAME
                );

$g = new jqgrid($db_conf);

$g->set_actions(array(	
    "showhidecolumns"=>true,
    "export_pdf"=>true
)
);

// set few params
$opt["caption"] = "Cart";
$opt["rownumbers"] = true;
$opt["forceFit"] = true;
$opt["autowidth"] = true;
$opt["loadtext"] = "Loading...";
$opt["responsive"] = false;
$opt["showhidecolumns"] = true;
$opt["autoresize"] = true;
$opt["footerrow"] = true;
$opt["reloadedit"] = true;
$opt["loadComplete"] = "function(){ grid_onload(); }";
$g->set_options($opt);

// $grid["add_options"]["afterSubmit"] = "function(){ window.location.reload(); return [true, ''];}";
// $g->set_options($grid);
// set database table for CRUD operations
$today = date('Y-m-d');
// echo($today);
$g->select_command = "SELECT * FROM all_bills WHERE Bill_Date = '$today' AND Customer = $customer";
$g -> table = "all_bills";

$col = array();
$col["title"] = "Customer";
$col["name"] = "Customer";
$col["hidden"] = true;
$col["hidedlg"] = true;
$col["hidedlg"] = true;
$cols[] = $col;

$col = array();
$col["title"] = "Product ID";
$col["name"] = "Product_ID";
$col["hidden"] = true;
$col["hidedlg"] = true;
$cols[] = $col;

$col = array();
$col["title"] = "Product Name";
$col["name"] = "Product_Name";
$col["width"] = 100;
$col["editable"] = false;
$cols[] = $col;

$col = array();
$col["title"] = "Sl_No";
$col["name"] = "Sl_No";
$col["hidden"] = true;
$col["hidedlg"] = true;
$cols[] = $col;

$col = array();
$col["title"] = "Amount";
$col["name"] = "Amount";
$col["hidden"] = true;
$col["editable"] = false;
$cols[] = $col;

$col = array();
$col["title"] = "Cost";
$col["name"] = "Cost";
$col["editable"] = false;
$cols[] = $col;

$col = array();
$col["title"] = "Bill_Date";
$col["name"] = "Bill_Date";
$col["hidden"] = true;
$col["hidedlg"] = true;
$cols[] = $col;

$g -> set_columns($cols, true);
// render grid and get html/js output
$out = $g->render("list1");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="refresh" content="5">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" media="screen" href="gridphp/lib/js/themes/flick/jquery-ui.custom.css">
	<link rel="stylesheet" type="text/css" media="screen" href="gridphp/lib/js/jqgrid/css/ui.jqgrid.css">
    <link rel="stylesheet" href="css\Bill Page.css">
    <script src="https://kit.fontawesome.com/34a6ca24a7.js" crossorigin="anonymous"></script>
	<script src="gridphp/lib/js/jquery.min.js" type="text/javascript"></script>
	<script src="gridphp/lib/js/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
	<script src="gridphp/lib/js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>	
	<script src="gridphp/lib/js/themes/jquery-ui.custom.min.js" type="text/javascript"></script>
    <title>Onine billing page</title>
</head>
<body>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }   
    </script>
    <div class="wrapper">
    
        <div class="form-wrapper">
            <form method="post">
                <a href = "../Landing Page.php">Back to Dashboard</a>
                <label for="prd-id-field">Scan or Enter Product ID</label><input type="text" name="prd-id" id="prd-id-field" autofocus>
                <!--<button type="submit" name = "add-prd" id = "submit_btn"><i class="fa-solid fa-plus"></i>&nbsp Add</button>-->
                 <input type="submit" name = "add_prd" value="Add To Cart"> 
            </form>
            <div class="grid">
                <script>
                    function grid_onload() 
                    {
                        var grid = $("#list1");

                        sum = grid.jqGrid('getCol', 'Amount', false, 'sum'); // 'sum, 'avg', 'count' (use count-1 as it count footer row).


                        // record count

                        sum = Number(sum).toLocaleString('en-US', { style: 'currency', currency: 'INR' });
                        grid.jqGrid('footerData','set', {Product_Name: 'Total: ' + sum}, false);
                    };
	
                    
                </script>

                <?php
                    echo $out;
                ?>
            </div>
        </div>
    </div>
    <div class = "portrait-warning">
        <h1>Please hold your device in landscape mode only!</h1>
    </div>

    <!-- Add products to bill and display as a table -->
    <?php
        include "admin/dbConn.php";
        if(isset($_POST['add_prd']) && $_POST['prd-id'] != ""){   
            // echo ($customer);
            $add_prd_ID = $_POST['prd-id'];
            $get_present_qty = mysqli_query($con, "SELECT Quantity FROM all_bills WHERE Product_ID = $add_prd_ID AND Customer = $customer AND Bill_Date = CURRENT_DATE()");
            $present_qty = mysqli_fetch_array($get_present_qty);

            if($present_qty == []){
                $get_data = mysqli_query($con, "SELECT * FROM all_products WHERE Product_ID = $add_prd_ID");
                $data_arr = mysqli_fetch_assoc($get_data);
                $cost = $data_arr[Cost];
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
                $cost = $data_arr[Cost];
                $amount = $cost;
                $new_qty = $present_qty[0] + 1;
                $new_amt = ($new_qty) * $cost;
                $change_qty = mysqli_query($con, "UPDATE all_bills SET Quantity = '$new_qty', Amount = '$new_amt' WHERE Product_ID = $add_prd_ID AND Customer = $customer AND Bill_Date = CURRENT_DATE()");
            }
    }
    ?>

<!-- <div id = "search-table">
            <table id="all-products">
                <th>Sl.No</th><th>Product ID</th><th>Product Name</th><th>Quantity</th><th>Cost</th><th>Amount</th> -->

                <?php 
                    // include "admin\dbConn.php"; // Using database connection file here
                    // $sql = "SELECT * FROM all_bills WHERE Bill_Date = CURRENT_DATE()";
                    // $result = $con->query($sql);
                    // while($row = $result->fetch_assoc()){
                    // echo "<tr>";
                    // echo("<td> $row[Sl_No]</td>");
                    // echo("<td> $row[Product_ID]</td>");
                    // echo("<td> $row[Product_Name]</td>");
                    // echo("<td> $row[Quantity]</td>");
                    // echo("<td> $row[Cost]</td>");
                    // echo("<td> $row[Amount]</td>");
                    // echo "</tr>";
                    // }

                    // require_once("admin/phpGrid_Lite/conf.php");
                    // $today = date('Y-m-d');
                    // $dg = new C_DataGrid("SELECT * FROM all_bills", "Sl_No", "all_bills");
                    // $dg -> set_query_filter("Bill_Date = '$today' AND Customer = '$customer'");
                    // $dg -> set_col_hidden('Bill_Date, Customer', false);
                    // $dg -> enable_edit('INLINE', 'UD');
                    // $dg -> display();
                ?>
</body>
</html>
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


    include_once("gridphp/config.php");

    // include and create object
    include(PHPGRID_LIBPATH."inc/jqgrid_dist.php");
    
    $db_conf = array(
                        "type"      => PHPGRID_DBTYPE,
                        "server"    => PHPGRID_DBHOST,
                        "user"      => PHPGRID_DBUSER,
                        "password"  => PHPGRID_DBPASS,
                        "database"  => PHPGRID_DBNAME
                    );
    
    $g = new jqgrid($db_conf);
    
    // set few params
    $opt["caption"] = "All Bills";
    $opt["reloadedit"] = true; // auto reload after editing
    $opt["footerrow"] = true; // Show footer row
    $opt["loadtext"] = "Loading...";
    $opt["grouping"] = true;
    $opt["groupingView"] = array();
    $opt["groupingView"]["groupField"] = array("Bill_Date"); //Specifying column used for grouping
    $opt["groupingView"]["groupColumnShow"] = array(false) ; //Specify whether to display the grouping column
    $opt["groupingView"]["groupText"] = array("<b>{0} - {1}Item(s)</b>"); //Text for each group (Group Heading)
    $opt["groupingView"]["groupOrder"] = array("dec"); //Displaying in decending order 
    $opt["groupingView"]["groupDataSorted"] = array(true); //Displaying sorted data
    $opt["groupingView"]["groupSummary"] = array(true);
    $opt["groupingView"]["showSummaryOnHide"] = true;
    $g->set_options($opt);
    
    $g->set_actions(array(	
        "add"=>false, // allow/disallow add
        "edit"=>false, // allow/disallow edit
        "delete"=>false, // allow/disallow delete
        "rowactions"=>false, // show/hide row wise edit/del/save option
        "export"=>true, // show/hide export to excel option
        "autofilter" => true, // show/hide autofilter for search
        "search" => "advance" // show single/multi field search condition (e.g. simple or advance)
    ) 
);
    // set database table for CRUD operations
    $g->select_command = "SELECT * FROM all_bills WHERE Customer = $customer";

$col = array();
$col["align"] = "center";
$col["title"] = "Amount";
$col["name"] = "Amount";
$col["width"] = "80";
$col["editable"] = false;
$col["summaryType"] = "sum"; // available grouping fx: sum, count, min, max, avg
$col["summaryRound"] = 2; // decimal places
$col["summaryRoundType"] = 'fixed'; // round or fixed
$col["summaryTpl"] = 'Total {0}'; // display html for summary row - work when "groupSummary" is set true. search below
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "₹",
                                "thousandsSeparator" => ",",
                                "decimalSeparator" => ".",
                                "decimalPlaces" => 2);
$cols[] = $col;

$col = array();
$col["title"] = "Sl No";
$col["name"] = "Sl_No";
$col["hidden"] = true;
$cols[] = $col;

$col = array();
$col["title"] = "Product ID";
$col["name"] = "Product_ID";
$col["width"] = 200;
$cols[] = $col;

$col = array();
$col["title"] = "Quantity";
$col["name"] = "Quantity";
$col["width"] = 70;
$cols[] = $col;

$col = array();
$col["title"] = "Product Name";
$col["name"] = "Product_Name";
$col["width"] = 100;
$col["editable"] = false;
$cols[] = $col;

$col = array();
$col["title"] = "Product ID";
$col["name"] = "Product_ID";
$col["width"] = 100;
$col["editable"] = false;
$cols[] = $col;

$col = array();
$col["title"] = "Sl_No";
$col["name"] = "Sl_No";
$col["viewable"] = false;
$cols[] = $col;

$col = array();
$col["title"] = "Amount";
$col["name"] = "Amount";
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
$col["viewable"] = false;
$cols[] = $col;

$col = array();
$col["title"] = "Customer";
$col["name"] = "Customer";
$col["viewable"] = false;
$cols[] = $col;
$g->set_columns($cols,true);
    
    // render grid and get html/js output
    $out = $g->render("list1");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- these css and js files are required by php grid -->
    <link rel="stylesheet" type="text/css" media="screen" href="gridphp/lib/js/themes/Base/jquery-ui.custom.css">
	<link rel="stylesheet" type="text/css" media="screen" href="gridphp/lib/js/jqgrid/css/ui.jqgrid.css">
	<script src="gridphp/lib/js/jquery.min.js" type="text/javascript"></script>
	<script src="gridphp/lib/js/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
	<script src="gridphp/lib/js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>	
	<script src="gridphp/lib/js/themes/jquery-ui.custom.min.js" type="text/javascript"></script>
    <style>
        #d_tg{
            display: none;
        }
        .ui-jqgrid .ui-jqgrid-htable th div {
            text-align: center;
            padding-right: 20px;
        }
        #list1{
            text-align: center !important;
        }
        .ui-row-ltr>td{
            text-align: center !important; 
        }
    </style>
    <!-- these css and js files are required by php grid -->

    <title>Previous Bills</title>
</head>
<body>
    <div class="wrapper">
        <h1 class="page-title">View Your Previous Shopping Bills</h1>
        <button id="toggleGroup">Toggle Grouping</button>
        <script>
            jQuery(window).load(function()
	{
		// show dropdown in toolbar
		jQuery('.navtable tr:first').append('<td><div style="padding-left: 5px; padding-top:0px; float:left"><select style="height:24px" class="chngroup"><option value="clear" >-Group-</option><?php foreach($g->options["colModel"] as $c) { if($c["title"] !='Action'){?><option value="<?php echo $c["name"] ?>" <?php echo ($c["name"]=="role")?"selected":"" ?>><?php echo $c["title"] ?></option><?php }} ?></select></div></td>');

		var grid_id = '<?php echo $g->id ?>';
		
		jQuery(".chngroup").change(function()
		{
			var vl = jQuery(this).val(); 
			if(vl) 
			{ 
				if(vl == "clear") 
					jQuery("#"+grid_id).jqGrid('groupingRemove',true); 
				else 
					jQuery("#"+grid_id).jqGrid('groupingGroupBy',vl); 
			} 
		});

            jQuery("#toggleGroup").click(function()
		{
			jQuery("."+grid_id+"ghead_0").each(function(){
				jQuery("#"+grid_id).jqGrid('groupingToggle',jQuery(this).attr('id')); 
			});
		});
	});
        </script>
        <?php echo $out?>
        
    </div>
</body>
</html>
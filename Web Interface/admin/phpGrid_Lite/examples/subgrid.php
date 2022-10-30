<?php
//use phpGrid\C_DataGrid;

require_once("../conf.php");      
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subgrid</title>
</head>
<body> 

<?php
$dg = new C_DataGrid("SELECT * FROM orders", "orderNumber", "orders");

// enable edit
$dg->enable_edit("FORM", "CRUD");
$dg->enable_autoheight(true);
//$dg->set_col_wysiwyg('comments');



// second grid as detail grid. Notice it is just another regular phpGrid with properites.
$sdg = new C_DataGrid("SELECT * FROM orderdetails", array("orderLineNumber", "productCode"), "orderdetails");

$sdg->enable_edit("FORM", "CRUD");
$sdg->set_col_readonly('quantityOrdered');



// second grid as detail grid. Notice it is just another regular phpGrid with properites.
$sdg2 = new C_DataGrid("SELECT * FROM products", array("productCode"), "products");

$sdg2->enable_edit("FORM", "CRUD");
$sdg2->set_col_readonly('quantityInStock');



// define master detail relationship by passing the detail grid object as the first parameter, then the foriegn key name.
$sdg->set_subgrid($sdg2, 'productCode');
$dg->set_subgrid($sdg, 'orderNumber');


$dg -> set_dimension(1000, 600); 


$dg->display();
?>

</body>
</html>
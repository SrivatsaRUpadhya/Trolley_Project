<?php
    session_start();
    if($_SESSION['customer_logged_in']){
        // unset($_SESSION['manageprd']);
    }
    else{
        header("location:index.php");
    }
    
    $customer = $_SESSION['Customer'];
    if(isset($_POST['checkout_btn'])){

    //include connection file
    include_once("connection.php");
    include_once('libs\fpdf.php');
    
    class PDF extends FPDF
    {
    // Page header
    function Header()
    {
        // Logo
        // $this->Image('logo.png',10,-1,70);
        $this->SetFont('Arial','B',13);
        // Move to the right
        // Title
        $this->Cell(0,10,'Invoice',0,0,'C');
        // Line break
        $this->Ln(10);
        $today = date('d-m-Y');
        $this->Cell(0,10,$today,0,0,'C');
        // Line break
        $this->Ln(20);
    }
    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    }
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    $display_heading = array('Product_ID'=>'Barcode', 'Product_Name'=> 'Product Name', 'Cost'=> 'Cost','Quantity'=> 'Quantity', 'Amount'=> 'Amount');
    
    $result = mysqli_query($connString, "SELECT Product_ID, Product_Name, Quantity, Cost, Amount FROM all_bills WHERE Customer = $customer AND Bill_Date = CURDATE()") or die("database error:". mysqli_error($connString));
    // $header_query = mysqli_query($connString, "SELECT Product_ID, Product_Name, Quantity, Cost, Amount FROM all_bills");
    $header = array("Product_ID", "Product_Name", "Quantity", "Cost", "Amount");
    $pdf = new PDF();
    //header
    $pdf->AddPage();
    //foter page
    $pdf->AliasNbPages();
    $pdf->SetFont('Arial','B',12);
    foreach($header as $heading) {
    $pdf->Cell(38,12,$display_heading[$heading],1);
    }
    foreach($result as $row) {
    $pdf->Ln();
    foreach($row as $column)
    $pdf->Cell(38,12,$column,1);
    }
    $pdf->Output();
}
?>
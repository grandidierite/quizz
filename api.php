<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'test';

$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die("Database connection failed");

function startQuiz($conn)
{
	$quesList = array();
	$quesListQuery = mysqli_query($conn,"SELECT * FROM quiz ORDER BY RAND() LIMIT 10");
	while($quesListQueryFetch = mysqli_fetch_assoc($quesListQuery))
	{
		$quesList[] = $quesListQueryFetch;
	}
	return $quesList;
}

function getAnswerById($conn, $id)
{
	$result = mysqli_query($conn,"SELECT answer FROM quiz WHERE id=$id");
	$answer = $result->fetch_row()[0];
	return $answer;
}

function getImagePathById($conn, $id)
{
	$result = mysqli_query($conn,"SELECT image_path FROM quiz WHERE id=$id");
	$answer = $result->fetch_row()[0];
	return $answer;
}


/*
function companyList()
{
	$itemList = array();
	$itemListQuery = mysqli_query(conn(),"SELECT * FROM company");
	while($itemListQueryFetch = mysqli_fetch_assoc($itemListQuery))
	{
		$itemList[] = $itemListQueryFetch;
	}
	return $itemList;
}


function invoiceList()
{
	$invoiceList = array();
	$invoiceListQuery = mysqli_query(conn(),"SELECT * FROM invoice");
	while($invoiceListQueryFetch = mysqli_fetch_assoc($invoiceListQuery))
	{
		$invoiceList[] = $invoiceListQueryFetch;
	}
	return $invoiceList;
}

function getInvoiceId() {
	$idinvoiceQuery = mysqli_query(conn(),"SELECT id FROM invoice ORDER BY id DESC LIMIT 1");
	$idinvoice = mysqli_fetch_assoc($idinvoiceQuery);
	return $idinvoice['id'];
	
}

function generateInvoiceId() {
	$idinvoiceQuery = mysqli_query(conn(),"SELECT IF(MAX(id) IS NULL, 1, MAX(id)+1) as id FROM invoice");
	$idinvoice = mysqli_fetch_assoc($idinvoiceQuery);
	return $idinvoice['id'];
	
}

function generateNoInvoice() {
	$noinvoiceQuery = mysqli_query(conn(),"SELECT LPAD((SELECT IF(MAX(no) IS NULL, 1, MAX(no)+1) FROM invoice), 5, '0') as noinvoice");
	$noinvoice = mysqli_fetch_assoc($noinvoiceQuery);
	return $noinvoice['noinvoice'];
	
}

function checkInvoiceId($id) {
	$invoiceQuery = mysqli_query(conn(),"SELECT * FROM invoice WHERE id=$id");
	$invoice = mysqli_fetch_assoc($invoiceQuery);


	return $invoice['id'] ? true : false;
	
}

function deleteInvoice($id) {
	if(!empty($id)) {
		$conn = conn();
		mysqli_query($conn,"DELETE FROM invoice WHERE id = '".$id."'");
		mysqli_query($conn,"DELETE FROM invoice_details WHERE invoice_id = '".$id."'");
	}
}
function invoiceInsert($data = "")
{
	
	$company_id = "";
$invoice_id = "";
$item_id = "";
$description = "";
$qty = "";
$price = "";
$subtotal = "";
$grandtotal = "";
$tax_percent = "";
$tax = "";
$total = "";
$subject = "";
$no_invoice = "";
$duedate = "";
$issuedate = "";

	
	if(array_key_exists('company_id', $data))
		$company_id = $data['company_id'];
	
	if(array_key_exists('invoice_id', $data))
		$invoice_id = $data['invoice_id'];
	
	if(array_key_exists('item_id', $data))
		$item_id = $data['item_id'];
	
	if(array_key_exists('qty', $data))
		$qty = $data['qty'];
	
	if(array_key_exists('price', $data))
		$price = $data['price'];
	
	if(array_key_exists('subtotal', $data))
		$subtotal = $data['subtotal'];
	
	
	if(array_key_exists('grandtotal', $data))
		$grandtotal = $data['grandtotal'];
	
	if(array_key_exists('tax_percent', $data))
		$tax_percent = $data['tax_percent'];
	
	if(array_key_exists('tax', $data))
		$tax = $data['tax'];
	
	if(array_key_exists('total', $data))
		$total = $data['total'];

	if(array_key_exists('subject', $data))
		$subject = $data['subject'];

	if(array_key_exists('no_invoice', $data))
		$no_invoice = $data['no_invoice'];

	if(array_key_exists('issuedate', $data))
		$issuedate = $data['issuedate'];

	if(array_key_exists('duedate', $data))
		$duedate = $data['duedate'];


	if(isset($company_id) && isset($invoice_id) && isset($subject)
		&& isset($no_invoice) && isset($duedate) && isset($issuedate)
		&& isset($item_id) && isset($grandtotal) && isset($tax) && isset($total)) {

        $conn = conn();
		
		if(checkInvoiceId($invoice_id)) {
			
			if(mysqli_query($conn,"UPDATE invoice
												SET
													no = '".$no_invoice."',
													subject = '".$subject."',
													issuedate = '".$issuedate."',
													duedate = '".$duedate."',
													grandtotal = '".$grandtotal."',
													tax = '".$tax."',
													total = '".$total."',
													company_id = '".$company_id."' 
													WHERE id = '".$invoice_id."'")) {

				if(mysqli_query($conn,"DELETE FROM invoice_details WHERE invoice_id =
													'".$invoice_id."'")) {

					foreach ($item_id as $key => $value) {
					
					    if(mysqli_query($conn,"INSERT INTO invoice_details
														SET
															id = null,
															invoice_id = '".$invoice_id."',
															item_id = '".$item_id[$key]."',
															qty = '".$qty[$key]."',
															price = '".$price[$key]."',
															amount = '".$subtotal[$key]."'")) {

					    } else {
					    	 die(mysqli_error($conn));
					    }
					}
				} else {
					 die(mysqli_error($conn));
				}

				

			} else {
				 die(mysqli_error($conn));
			}
		} else {
			if(mysqli_query($conn,"INSERT INTO invoice
												SET
													id = null,
													no = '".$no_invoice."',
													subject = '".$subject."',
													issuedate = '".$issuedate."',
													duedate = '".$duedate."',
													grandtotal = '".$grandtotal."',
													tax = '".$tax."',
													total = '".$total."',
													company_id = '".$company_id."'")) {


				foreach ($item_id as $key => $value) {
					
				    if(mysqli_query($conn,"INSERT INTO invoice_details
													SET
														id = null,
														invoice_id = '".$invoice_id."',
														item_id = '".$item_id[$key]."',
														qty = '".$qty[$key]."',
														price = '".$price[$key]."',
														amount = '".$subtotal[$key]."'")) {

				    } else {
				    	echo mysqli_error($conn);
				    }
				}

			} else {
				echo mysqli_error($conn);
			}
		}
		

		
	}	
	
}

function getInvoice($id) {
	$invoiceQuery = mysqli_query(conn(),"SELECT * FROM invoice WHERE id=$id");
	$invoice = mysqli_fetch_assoc($invoiceQuery);
	return $invoice;
	
}

function getInvoiceDetails($id) {
	$invoiceDetailsQuery = mysqli_query(conn(),"SELECT * FROM invoice_details WHERE invoice_id=$id");
	$invoiceDetails = array();
	while ( $item = mysqli_fetch_assoc($invoiceDetailsQuery) )
	{
	    $invoiceDetails[] = $item;
	} 
	return $invoiceDetails;
	
}

function getCompany($id) {
	$companyQuery = mysqli_query(conn(),"SELECT * FROM company WHERE id=$id");
	$company = mysqli_fetch_assoc($companyQuery);
	return $company;
	
}

function getItemName($id) {
	$itemQuery = mysqli_query(conn(),"SELECT name FROM item WHERE id=$id");
	$name = mysqli_fetch_assoc($itemQuery);
	return $name;
	
}

function getItemPrice($id) {
	$itemQuery = mysqli_query(conn(),"SELECT price FROM item WHERE id=$id");
	$price = mysqli_fetch_assoc($itemQuery);
	return $price;
	
}

function getItemDescription($id) {
	$itemQuery = mysqli_query(conn(),"SELECT description FROM item WHERE id=$id");
	$desc = mysqli_fetch_assoc($itemQuery);
	return $desc;
	
}*/
<?php

include 'api.php';

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	echo call_user_func($_REQUEST['func'], $conn, $_REQUEST['id']);
	//echo getAnswerById($conn, $_REQUEST['id']);
	//deleteInvoice($_REQUEST['id']);
}

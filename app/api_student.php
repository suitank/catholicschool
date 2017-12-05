<?php

include_once 'utility_functions.php';
include_once 'model_functions.php';

$proc = $_REQUEST['proc'];
$status = true;
$response = array();

if(!isset($_SESSION)){
	session_start();
}

if ($proc == 'addStudent') {
	$data = array();
	$data['email'] = test_input($_POST['email']);
	$data['Account_Id'] = test_input($_SESSION['account_id']);
	$data['First_Name'] = test_input($_POST['studentFirstName']);
	$data['Middle_Name'] = test_input($_POST['studentMiddleName']);
	$data['Last_Name'] = test_input($_POST['studentLastName']);
	$data['Grade_Id'] = test_input($_POST['studentGradeId']);
	$data['Birth_Date'] = test_input($_POST['studentBirthDate']);
	$data['DiplomaType_Id'] = test_input($_POST['studentDiplomaTypeId']);

	$status = insertStudent($data);
} else if ($proc == 'updateStudent') {
	$data = array();
	$data['Student_Id'] = test_input($_POST['studentId']);
	$data['First_Name'] = test_input($_POST['studentFirstName']);
	$data['Middle_Name'] = test_input($_POST['studentMiddleName']);
	$data['Last_Name'] = test_input($_POST['studentLastName']);
	$data['Grade_Id'] = test_input($_POST['studentGradeId']);
	$data['Birth_Date'] = test_input($_POST['studentBirthDate']);
	$data['DiplomaType_Id'] = test_input($_POST['studentDiplomaTypeId']);

	$status = updateStudent($data);
} else if ($proc == 'removeStudent') {
	$id = test_input($_POST['studentId']);
	
	$status = removeStudent($id);
} else if ($proc == 'revertStudent') {
	$ids = test_input($_POST['studentIds']);

	$status = revertStudent($ids);
} else if ($proc == 'deleteStudent') {
	$id = test_input($_POST['studentId']);
	
	$status = deleteStudent($id);
} else if ($proc == 'getNotEnrolledStudent') {
	$email = test_input($_POST['email']);

	$stmt = getStudent(test_input($_SESSION['account_id']), false);
	if ($stmt->rowCount()) {
		$response['statusCode'] = http_response_code();
		$response['message'] = 'Success';
		$response['datas'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} else {
		$response['statusCode'] = http_response_code();
		$response['message'] = 'Failed';
	}
	exit(json_encode($response));
} else if ($proc == 'diplomaType') {
	$rows = getDiplomaType();

	if (count($rows)) {
		$response['statusCode'] = http_response_code();
		$response['message'] = 'Success';
		$response['datas'] = $rows;
	} else {
		$response['statusCode'] = http_response_code();
		$response['message'] = 'Failed';
	}
} else {
	$response['statusCode'] = http_response_code();
	$response['message'] = 'This action is not registered.';
}

if ($status) {
	$response['statusCode'] = http_response_code();
	$response['message'] = 'Success';
} else {
	$response['statusCode'] = http_response_code();
	$response['message'] = 'Failed';
}
exit(json_encode($response));

?>

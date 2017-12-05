<?php

include_once 'utility_functions.php';
include_once 'model_functions.php';

$email = test_input($_POST['email']);
$password = test_input($_POST['password']);

$stmt = loginCheck($email, $password);

if ($stmt->rowCount()) {
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$response['statusCode'] = http_response_code();
	$response['message'] = 'Success';
	$response['Account_Id'] = $rows[0]['Account_Id'];
	$response['email'] = $email;
} else {
	$response['statusCode'] = http_response_code();
	$response['message'] = 'Failed';
}
exit(json_encode($response));

?>
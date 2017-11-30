<?php

include 'model_functions.php';

$email = $_POST['email'];
$password = $_POST['password'];

$data = signup($email, $password);
// $response['double'] = $data['double'];


$response['status'] = '';
$response['message'] = '';
if (isset($data['status'])) {
	$response['status'] = $data['status'];
}
if (isset($data['message'])) {
	$response['message'] = $data['message'];
}

if ($data['status']) {
	$stmt = loginCheck($email, $password);
	if ($stmt->rowCount()) {
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$response['Account_Id'] = $rows[0]['Account_Id'];
	} else {
		$response['status'] = 102;
	}
}

exit(json_encode($response));

?>
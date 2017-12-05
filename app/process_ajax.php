<?php
include_once 'utility_functions.php';
include_once 'db_functions.php';

//receiving the parameters by query string

$fatherName = test_input($_GET['fatherName']);
$fatherFamilyName = test_input($_GET['fatherFamilyName']);
$fatherResidesAtHome = test_input($_GET['fatherResidesAtHome']);
$fatherDeceased = test_input($_GET['fatherDeceased']);
$motherName = test_input($_GET['motherName']);
$motherFamilyName = test_input($_GET['motherFamilyName']);
$motherResidesAtHome = test_input($_GET['motherResidesAtHome']);
$motherDeceased = test_input($_GET['motherDeceased']);
$email = test_input($_GET['email']);

$resultUpdateUser = FALSE;
$resultUpdateUser = updateUser($email, $fatherName, $fatherFamilyName, $motherName, $motherFamilyName, $fatherResidesAtHome, $fatherDeceased, $motherResidesAtHome, $motherDeceased);

//Checking the results
if ($resultUpdateUser === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating user record";
}

?>

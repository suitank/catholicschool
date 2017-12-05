<?php

// get login status
function loginCheck($email, $password) {
	require("db_connection.php");

  $stmt = $db->prepare("SELECT * FROM account AS a
    LEFT JOIN wp2233618536db_32463.wp_users AS w ON a.Account_Id=w.ID
    WHERE w.user_email=? AND w.user_pass=?");
  $stmt->execute(array($email, $password));

  $db = null;
  return $stmt;
}

// insert account
function signup($email, $password) {
	require("db_connection.php");

	$data = array();
	// $data['double'] = false;
	$data['status'] = 0;

  $stmt = $db->prepare("SELECT * FROM wp2233618536db_32463.wp_users WHERE user_email=?");
  $stmt->execute(array($email));
  $row_count = $stmt->rowCount();
  $stmt->closeCursor();

  if ($stmt->rowCount()) {
  	$data['status'] = 101;
  } else {
    $st1 = $db->prepare("INSERT INTO wp2233618536db_32463.wp_users SET user_email=:email, user_pass=:password, user_status='1'");
    try { 
      $st1->execute(array(':email' => $email, ':password' => $password));
      $insert_wp_users_ID = $db->lastInsertId();
      $st1->closeCursor();

      $st2 = $db->prepare("INSERT INTO contactperson SET Email1=?");
      try { 
        $st2->execute(array($email));
        $st2->closeCursor();

        $data['message'] = $insert_wp_users_ID;
        
        $st3 = $db->prepare("INSERT INTO account SET Account_Id=:wp_users_ID");
        
        try { 
          $st3->execute(array(':wp_users_ID' => $insert_wp_users_ID));
          $data['status'] = 200;
          $data['message'] = 'Success without an error';
        } catch(PDOExecption $e) { 
          $data['status'] = 500;
          $data['message'] = 'Error in adding user in account table';
          print "Error!: " . $e->getMessage(); 
        }
      } catch(PDOExecption $e) { 
        $data['status'] = 500;
        $data['message'] = 'Error in adding email into contact table';
        print "Error!: " . $e->getMessage(); 
      }
    } catch(PDOExecption $e) { 
      $data['status'] = 500;
      $data['message'] = 'Error in adding user into users table';
      print "Error!: " . $e->getMessage(); 
    }
  }

  // $db = null;
  return $data;
}

// get household data
function getContactPerson($email) {
  require("db_connection.php");

  $stmt = $db->prepare("SELECT * FROM contactperson WHERE Email1=:email");
  $stmt->bindValue(':email', $email, PDO::PARAM_STR);
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  $db = null;
  return $rows;
}

// set(insert, update) household data
function setHousehold($params) {
  require("db_connection.php");

  $stmt = $db->prepare("SELECT * FROM contactperson WHERE Email1=?");
  $stmt->execute(array($params['Email1']));
  $row_count = $stmt->rowCount();

  if ($row_count) {
    $st = $db->prepare("UPDATE contactperson SET 
      First_Name=:First_Name,
      Last_Name=:Last_Name,
      Address_1=:Address_1, 
      Address_2=:Address_2,
      City=:City,
      State=:State,
      Zip=:Zip,
      Country=:Country,
      Phone1=:Phone1,
      Phone2=:Phone2,
      Email2=:Email2
      WHERE Email1=:Email1
    ");
  } else {
    $st = $db->prepare("INSERT INTO contactperson SET 
      First_Name=:First_Name, 
      Last_Name=:Last_Name, 
      Address_1=:Address_1, 
      Address_2=:Address_2,
      City=:City,
      State=:State,
      Zip=:Zip,
      Country=:Country,
      Phone1=:Phone1,
      Phone2=:Phone2,
      Email1=:Email1,
      Email2=:Email2
    ");
  }
  
  try { 
    $st->execute(array(
      ':First_Name' => $params['First_Name'],
      ':Last_Name' => $params['Last_Name'],
      ':Address_1' => $params['Address_1'],
      ':Address_2' => $params['Address_2'],
      ':City' => $params['City'],
      ':State' => $params['State'],
      ':Zip' => $params['Zip'],
      ':Country' => $params['Country'],
      ':Phone1' => $params['Phone1'],
      ':Phone2' => $params['Phone2'],
      ':Email1' => $params['Email1'],
      ':Email2' => $params['Email2']
    ));
  } catch(PDOExecption $e) { 
    print "Error!: " . $e->getMessage(); 
  }

  $db = null;
  return;
}

// get student data (enrolled: Status='1', not enrolled: Status='0')
function getStudent($account_id, $enrollStatus) {
  require("db_connection.php");

  $stmt = $db->prepare("SELECT s.*, g.Description AS Grade, d.Name AS DiplomaType FROM student AS s 
    LEFT JOIN grade AS g ON s.Grade_Id=g.Grade_Id
    LEFT JOIN diplomatype AS d ON s.DiplomaType_Id=d.DiplomaType_Id
    WHERE s.Account_Id=? AND s.Status=?
  ");
  if ($enrollStatus)
    $stmt->execute(array($account_id, 1));
  else
    $stmt->execute(array($account_id, 0));

  $db = null;
  return $stmt;
}

function getDiplomaType() {
  require("db_connection.php");

  $stmt = $db->prepare("SELECT * FROM diplomatype ORDER BY Display_Order");
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  $db = null;
  return $rows;
}

// insert student data
function insertStudent($data) {
  require("db_connection.php");

  $rows = getContactPerson($data['email']);
  $ParentOrGuardian_1_Id = $rows[0]['ContactPerson_Id'];
  $ParentOrGuardian_2_Id = $rows[0]['ContactPerson_Id'];
  // var_dump($row);

  $stmt = $db->prepare("INSERT INTO student SET
            Account_Id = :Account_Id,
            First_Name = :First_Name,
            Middle_Name = :Middle_Name,
            Last_Name = :Last_Name,
            Grade_Id = :Grade_Id,
            Birth_Date = :Birth_Date,
            DiplomaType_Id = :DiplomaType_Id,
            Status = '1',
            ParentOrGuardian_1_Id = :ParentOrGuardian_1_Id,
            ParentOrGuardian_2_Id = :ParentOrGuardian_2_Id,
            Parent_or_Guardian_1_GuardianToStudentRelation_Id = '10',
            Parent_or_Guardian_2_GuardianToStudentRelation_Id = '20'
  ");

  try { 
    $stmt->execute(array(':Account_Id' => $data['Account_Id'], ':First_Name' => $data['First_Name'], ':Middle_Name' => $data['Middle_Name'], ':Last_Name' => $data['Last_Name'], ':Grade_Id' => $data['Grade_Id'], ':Birth_Date' => $data['Birth_Date'], ':DiplomaType_Id' => $data['DiplomaType_Id'], ':ParentOrGuardian_1_Id' => $ParentOrGuardian_1_Id, ':ParentOrGuardian_2_Id' => $ParentOrGuardian_2_Id));
  } catch(PDOExecption $e) { 
    print "Error!: " . $e->getMessage(); 
  }

  $db = null;
  return $stmt;
}

// update student data
function updateStudent($data) {
  require("db_connection.php");

  $stmt = $db->prepare("UPDATE student SET
            First_Name = :First_Name,
            Middle_Name = :Middle_Name,
            Last_Name = :Last_Name,
            Grade_Id = :Grade_Id,
            Birth_Date = :Birth_Date,
            DiplomaType_Id = :DiplomaType_Id
          WHERE Student_Id=:Student_Id
  ");

  try { 
    $stmt->execute(array(':Student_Id' => $data['Student_Id'], ':First_Name' => $data['First_Name'], ':Middle_Name' => $data['Middle_Name'], ':Last_Name' => $data['Last_Name'], ':Grade_Id' => $data['Grade_Id'], ':Birth_Date' => $data['Birth_Date'], ':DiplomaType_Id' => $data['DiplomaType_Id']));
  } catch(PDOExecption $e) { 
    print "Error!: " . $e->getMessage(); 
  }

  $db = null;
  return $stmt;
}

// remove student data, set Status='0'
function removeStudent($Student_Id) {
  require("db_connection.php");

  $stmt = $db->prepare("UPDATE student SET Status='0' WHERE Student_Id=:Student_Id");

  try { 
    $stmt->execute(array(':Student_Id' => $Student_Id));
  } catch(PDOExecption $e) { 
    print "Error!: " . $e->getMessage(); 
  }

  $db = null;
  return true;
}

// revert student data, set Status='1'
function revertStudent($Student_Ids) {
  require("db_connection.php");
  
  $stmt = $db->prepare("UPDATE student SET Status='1' WHERE Student_Id=?");

  try {
    foreach (explode(',', $Student_Ids) as $Student_Id) {
      $stmt->execute(array($Student_Id));  
    }
  } catch(PDOExecption $e) { 
    print "Error!: " . $e->getMessage(); 
  }

  $db = null;
  return true;
}

// delete student data
function deleteStudent($Student_Id) {
  require("db_connection.php");

  $stmt = $db->prepare("DELETE FROM student WHERE Student_Id=? AND Status='0'");

  try {
    $stmt->execute(array($Student_Id));
  } catch(PDOExecption $e) { 
    print "Error!: " . $e->getMessage(); 
  }

  $db = null;
  return true;
}
?>
<?php
include_once '../app/utility_functions.php';

  //check session
  if(!isset($_SESSION)){
    session_start();
  }
  if (!isset($_SESSION["email"])) {
    header( 'Location: /views/login.php' ) ;
  }

  include_once '../app/model_functions.php';

  error_reporting( E_ALL | E_STRICT );
  if(!isset($_SESSION)){
    session_start();
  }

  // get the email parameter and query the dabatase. If does not exist, a new application will be created.
  $Email1 = test_input($_POST["email"]);

  // Contact Person
  $rows = getContactPerson($Email1);
  $ContactPerson_Id = $rows ? $rows[0]["ContactPerson_Id"] : '';
  $First_Name = $rows ? $rows[0]["First_Name"] : '';
  $Last_Name = $rows ? $rows[0]["Last_Name"] : '';
  $Address_1 = $rows ? $rows[0]["Address_1"] : '';
  $Address_2 = $rows ? $rows[0]["Address_2"] : '';
  $City = $rows ? $rows[0]["City"] : '';
  $State = $rows ? $rows[0]["State"] : '';
  $Zip= $rows ? $rows[0]["Zip"] : '';
  $Country = $rows ? $rows[0]["Country"] : '';
  $Phone1 = $rows ? $rows[0]["Phone1"] : '';
  $Phone2 = $rows ? $rows[0]["Phone2"] : '';
  $Email2 = $rows ? $rows[0]["Email2"] : '';
  $Account_Id = $_SESSION["account_id"];
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="author" content="david" />
  <meta name="description" content="Catholic School">
  <link rel="icon" href="images/favicon.ico">
  <title>Catholic School</title>

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/daterangepicker.css" />
  <link rel="stylesheet" href="../css/app.css">

  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/moment.min.js"></script>
  <script src="../js/daterangepicker.js"></script>
  <script>
    let alertMessage = 'Sorry, some unknown error occurred! Please contact us at <strong>support@ada.school</strong> to resolve this problem.';
    let Account_Id = "<?php echo test_input($_POST['Account_Id']);?>";
    //This script handle the tab's navigation
    $(document).ready(function() {
      $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        let index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
      });
    });

    function logout() {
      destroy_session();
    }

    function destroy_session(){
      $.ajax({
        type: "post",
        url: "../app/api_session.php",
        data: {
          type: "remove"
        },
        dataType: "json",
        success: function(response) {
          console.log("DESTROY SUCCESS");
          window.location = "/views/login.php";
        },
        error: function(xhr, status, error) {
          var err = xhr.responseText;
          alert(err);
          $('.alert-danger').slideDown("slow");
        }
      })
    }
  </script>
</head>
<body>
  <header>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h3>Home Study Catholic School</h3>
        </div>  
      </div>
    </div>
  </header>

  <input type="hidden" id="email" value="<?php echo test_input($_POST['email']);?>">
  <input type="hidden" id="account_id" value="<?php echo $Account_Id;?>">
  
  <section>
    <div class="container">
      <div class="row">
        <div class="col-sm-4 col-md-4 col-lg-3 bhoechie-tab-menu">
          <div class="list-group">
            <a href="#" class="list-group-item active text-left">
              <h4 class="glyphicon glyphicon-info-sign"></h4> <span>Introduction</span>
            </a>
            <a href="#" class="list-group-item text-left">
              <h4 class="glyphicon glyphicon-home"></h4> <span>Household Information</span>
            </a>
            <a href="#" class="list-group-item text-left">
              <h4 class="glyphicon glyphicon-user"></h4> <span>Student Information</span>
            </a>
            <a id="course_tab" href="#" class="list-group-item text-left">
              <h4 class="glyphicon glyphicon-book"></h4> <span>Courses Credits</span>
            </a>
            <a href="#" class="list-group-item text-left">
              <h4 class="glyphicon glyphicon-scissors"></h4> <span>Supplements</span>
            </a>
            <a href="#" class="list-group-item text-left">
              <h4 class="glyphicon glyphicon-duplicate"></h4> <span>Summary</span>
            </a>
            <a href="#" class="list-group-item text-left">
              <h4 class="glyphicon glyphicon-credit-card"></h4> <span>Submission & Payments</span>
            </a>
            <a href="#" onclick="logout()" class="list-group-item text-left">
              <h4 class="glyphicon glyphicon-log-out"></h4> <span>Log out</span>
            </a>
          </div>
        </div>
        <div class="col-sm-8 col-md-8 col-lg-7 bhoechie-tab">
            <!-- Introduction section -->
            <div class="bhoechie-tab-content active">
              <?php include_once 'introduction.php'; ?>
            </div>

            <!-- Household Information section -->
            <div class="bhoechie-tab-content">
              <?php include_once 'household.php'; ?>
            </div>

            <!-- Student section -->
            <div class="bhoechie-tab-content">
              <?php include_once 'student.php'; ?>
            </div>

            <!-- Courses Credits section -->
            <div class="bhoechie-tab-content">
              <?php include_once 'course.php'; ?>
            </div>

            <!-- Supplements section -->
            <div class="bhoechie-tab-content">
              <?php include_once 'supplement.php'; ?>
            </div>

            <!-- Summary section -->
            <div class="bhoechie-tab-content">
              <?php include_once 'summary.php'; ?>
            </div>

            <!-- Submission & Payments section -->
            <div class="bhoechie-tab-content">
              <?php include_once 'submission.php'; ?>
            </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
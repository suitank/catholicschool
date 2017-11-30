<div class="course_page">
  <h3>Courses Credits</h3>

  <div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <span class="message"></span>
  </div>
  <div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <span class="message"></span>
  </div>

  <p>This section shows each student who is being enrolled and allows you to select the courses they will enroll in and take credits for any required books that you may already have.</p>
  <p>Course selection and book credits are done on a per-student basis. Use the tabs below to select a student to work with.</p>

  <div>
  	<div class="credit-ticker total-credits">
  		<span>Total Credits:</span> <span id="total_credits">$23.22</span>
  	</div>
  	<div id="courseTabsPlaceHolder"></div>
  </div>
</div>

<script type="text/javascript">
	'use strict';

	$(document).ready(function() {
		$('#course_tab').on('click', function() {
			displayCourse();
		});
	});

	function displayCourse() {
		let email = $('#email').val();
    if (email == "") {
      $("#courseTabsPlaceHolder").html("");
      return;
    }
    
    $.ajax({
      type: "post",
      url: "courseTabs.php",
      data: {
        email: email
      },
      success: function(response) {
        let nth = $('#courseNavTab li.active').index()+1;
        $("#courseTabsPlaceHolder").html(response);
        $('#courseNavTab li:nth-child('+nth+') a').trigger('click');
      }, 
      error: function() {
        $('#courseTabsPlaceHolder').html('<p>An error has occurred</p>');
      },
    });
	}

	// Insert Grade Select Element
  function insertCurriculumSelectElement(selector) {
    let gradeStr = "<option value='0'>Change Curriculum</option>";
    for (let i = 1; i <= 12; i++) {
      gradeStr += "<option value='" + i + "'>" + gradeAry[i] +"</option>";
    }
    $(selector).html(gradeStr);
  }
</script>
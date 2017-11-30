<?php

include '../app/model_functions.php';

$studentEmail = $_POST['email'];
$stmt = getStudent($studentEmail, true);

$res = "<ul id='courseNavTab' class='nav nav-tabs'>";
$tabContent = "";

$i = 0;
if ($stmt->rowCount() > 0) {
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($rows as $row) {
		$res .= "<li class='". ($i ? "" : "active") ."'><a data-toggle='tab' href='#student{$row['Student_Id']}'>{$row['First_Name']} {$row['Middle_Name']} {$row['Last_Name']}</a></li>";

		$tabContent .= "<div id='student{$row['Student_Id']}' class='". ($i ? "tab-pane" : "tab-pane fade active in") ."'>";
		$tabContent .= "<div class='form-group'>
			<div class='credit-ticker student-credits'>
	  		<span>Student Credits:</span> <span id='student_credits'>$23.22</span>
	  	</div>
			<div class='intro'>
				<p>Below is the list of courses for <strong>{$row['First_Name']}</strong>. You may add and remove courses to customize the curriculum or change the curriculum enirely to that of a different grade level. Some courses may have alternatives that you may choose from. For example, elementary Math courses use Saxon text books, but Seton offers alternative courses that use the MCP text books instead. Likewise some courses may be available in multiple revisions, useful if an older sibling took the course using older materials, and you have and want to re-use those materials.</p>
				<p>You can take book credits for any books that you already own. The total of credits taken is shown above to the right. You may not take \"credit\" for books that normally incur additional fees. However, if you already have the book, you can avoid the fee by checking the \"Not Needed\" box.</p>
			</div>
			<div class='control'>
				<button class='btn btn-primary'><span class='glyphicon glyphicon-plus'></span> Add Course</button>
				<select id='selectGrade' class='form-control'></select>
				<button class='btn btn-primary'><span class='glyphicon glyphicon-repeat'></span> Reset Curriculum</button>
				<button class='btn btn-primary'><span class='glyphicon glyphicon-remove'></span> Remove All Courses</button>
			</div>
		</div>";
		$tabContent .= "</div>";

		$i++;
	}
}
$res .= "</ul>";

$res .= "<div class='tab-content'>";
$res .= $tabContent;
// Modal
$res .= "<div class='modal fade' id='deleteStudentModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
	<div class='modal-dialog' role='document'>
		<div class='modal-content'>
			<div class='modal-header' style='background-color:#fab402; border-radius:5px 5px 0 0; margin:1px;'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span> </button>
				<h4 class='modal-title' id='myModalLabel'>Delete Student?</h4>
			</div>
			<div class='modal-body'>
				<p>Please confirm that you wish to Delete the student record and course selections for <span id='deleteStudentName'></span>?</p>
				<p>This action cannot be undone and will remove all course selections, etc. associated with this student in this application.  As an alternative you may wish to simply mark <span id='deleteStudentName'></span> as not enrolling.</p>
			</div>
			<div class='modal-footer'>
				<button class='btn btn-default' data-dismiss='modal'>Cancel</button>
				<button id='btnDeleteStudent' class='btn btn-primary'>Delete</button>
			</div>
		</div>
	</div>
	<input id='deleteStudentId' type='hidden' value='' />
</div>";
$res .= "</div>";

echo $res;
?>

<script type="text/javascript">
'use strict';

$(document).ready(function() {
	insertCurriculumSelectElement('.course_page #selectGrade');
});
</script>
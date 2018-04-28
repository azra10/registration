<div class="container">
  <?php
		
	$issclasslist = iss_class_list();				
	$regschclasslist = iss_regular_school_class_list();
				
	if (strpos ( $isstabname, "student", 0 ) === 0) {
		$activetab = $isstabname;
	} else if (! is_null ( $issstudents ) && (count ( $issstudents ) > 0)) {
		$activetab = 'student' . $issstudents [0] ['StudentID'];
	} else {
		$activetab = 'studentnew';
	}
	?>

      <!-- student tabs -->
	<div class="row">
		<ul id="studentnav" class="nav nav-pills nav-stacked col-md-3">
          <?php $i=0; if (!is_null($issstudents)) {  $i=1; foreach ($issstudents as $student) { ?>
            <li
				class="<?php echo ($activetab == 'student' . $student['StudentID'])? 'active':'' ?>">
				<a href="#student<?php echo $i; ?>" data-toggle="tab">
                <?php echo $student['StudentFirstName'] . ' - Grade ' . $student['ISSGrade']?>
				<?php echo ($student['StudentNew'] == 'Yes')? '(New)': '';?>
              </a>
			</li>
            <?php $i++; } } ?>
              <?php if ($edit) {?>
              <li
				class="<?php echo ($activetab == 'studentnew')? 'active':'' ?>"><a
				href="#new" data-toggle="tab">Add Student</a></li>
              <?php } // if edit  ?>
        </ul>
		<div class="tab-content col-md-6">

          <?php if (!is_null($issstudents)) {  $i=1; foreach ($issstudents as $student) { ?>

            <div
				class="tab-pane <?php echo ($activetab == 'student' . $student['StudentID'])? 'active':'' ?>"
				id="student<?php echo $i; ?>" style="padding-top: 10px;">
				<form class="form-horizontal" method="post"
					action="<?php echo $issformposturl;?>"
					enctype="multipart/form-data">
                <?php wp_nonce_field('iss-edit-parents-form-page', '_wpnonce-iss-edit-parents-form-page') ?>
                  <input type="hidden" id="RegistrationYear"
						name="RegistrationYear" value="<?php echo $regyear; ?>" /> <input
						type="hidden" id="ParentID" name="ParentID"
						value="<?php echo $parentid; ?>" /> <input type="hidden"
						id="tabname" name="tabname"
						value="student<?php echo $student['StudentID']; ?>" /> <input
						type="hidden" id="StudentID" name="StudentID"
						value="<?php echo $student['StudentID']; ?>">
                  
                  <?php   include(ISS_PATH . "/includes/student.php"); ?>
              </form>
			</div>
            <?php $i++; } }?>

              <?php if ($edit) {?>
                <div
				class="tab-pane <?php echo (($i==0) || ($activetab == 'studentnew'))?'active':'' ?> "
				id="new" style="padding-top: 10px;">
                  <?php $student = $studentnew; ?>
                    <form class="form-horizontal" method="post"
					action="<?php echo $issformposturl;?>"
					enctype="multipart/form-data">
                      <?php wp_nonce_field('iss-edit-parents-form-page', '_wpnonce-iss-edit-parents-form-page') ?>
                        <input type="hidden" id="RegistrationYear"
						name="RegistrationYear" value="<?php echo $regyear; ?>" /> <input
						type="hidden" id="ParentID" name="ParentID"
						value="<?php echo $parentid; ?>" /> <input type="hidden"
						id="tabname" name="tabname" value="studentnew" /> <input
						type="hidden" id="StudentID" name="StudentID" value="new">
                        <input type="hidden" id="StudentNew" name="StudentNew" value="Yes">
                        <?php   include(ISS_PATH . "/includes/studentnew.php"); ?>

                    </form>
			</div>
			<!-- tab end -->
                <?php } // if edit  ?>
        </div>

		<!-- /student tabs -->
	</div>
	<div class="row">
		<div class="col-md-offset-1 col-md-4 "></div>
		<div class="col-md-5">
			<ul class="list-inline pull-right">
				<li><button type="button" class="btn btn-primary prev-step"
						data-toggle="tooltip" data-placement="top"
						title="Leave without saving changes.">Previous</button></li>
				<li><button type="button" class="btn btn-primary next-step"
						data-toggle="tooltip" data-placement="top"
						title="Leave without saving changes.">Next</button>
				
				<li>
			
			</ul>
		</div>
	</div>
</div>
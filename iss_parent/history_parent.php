<?php
if (! isset ( $_GET ['id'] ) || empty ( $_GET ['id'] ) || (intval ( $_GET ['id'] ) == 0)) {
	echo '<div class="text-danger"><p><strong>Unknown Parent.</strong></p></div>';
	return;
}

$id = iss_sanitize_input ( $_GET ['id'] );

// IF PARENT EXIST, PULL PARENT
$issparent = iss_get_parent_and_payment_by_id ( $id );

if ($issparent == NULL) {
	echo '<p>' . 'No users found.' . '</p>';
} else {
    echo '<h3> Family Change History</h3>';
	
	$parentid = $issparent ['ParentID'];
	
    iss_write_changelog_vertical ( 'parent', $parentid, NULL );
  //  iss_write_changelog_vertical ( 'payment', $parentid, NULL );

    // IF PARENT EXISTS, PULL STUDENTS
	$issstudents = iss_get_students_by_parentid ( $issparent ['ParentID'], $issparent ['RegistrationYear'] );

    foreach($issstudents as $student) {
        $studentid = $student['StudentID'];
    iss_write_changelog_vertical ( 'student', $parentid, $studentid );
	//iss_write_changelog_vertical ( 'registration', $parentid, $studentid );
    }
}
?>
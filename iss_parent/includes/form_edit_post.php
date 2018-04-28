<?php
iss_write_log ( $_POST );

// REQUIRED FIELDS
if (! isset ( $_POST ['tabname'] ) || empty ( $_POST ['tabname'] ) || ! iss_valid_tabname ( $_POST ['tabname'] ) || ! isset ( $_POST ['RegistrationYear'] ) || empty ( $_POST ['RegistrationYear'] ) || ! iss_field_valid ( 'RegistrationYear', $_POST ['RegistrationYear'], $errors, '' ) || ! isset ( $_POST ['ParentID'] ) || empty ( $_POST ['ParentID'] ) || (intval ( $_POST ['ParentID'] ) == 0)) {
	echo '<div class="text-danger"><p><strong>Unknown User.</strong></p></div>';
	return;
}
// OPTIONAL FIELD
if (isset ( $_POST ['StudentID'] ) && ! empty ( $_POST ['StudentID'] )) {
	$studentid = iss_sanitize_input ( $_POST ['StudentID'] );
} else {
	$studentid = '';
}

$isstabname = iss_sanitize_input ( $_POST ['tabname'] );
$regyear = iss_sanitize_input ( $_POST ['RegistrationYear'] );
$parentid = iss_sanitize_input ( $_POST ['ParentID'] );
$issparent = iss_get_parent_by_parentid ( $parentid, $regyear );
if ($issparent == NULL) {
	echo '<div class="text-danger"><p><strong>Unknown Parent.</strong></p></div>';
	return;
}
$issstudents = iss_get_students_by_parentid ( $parentid, $regyear );
if ((intval ( $studentid ) != 0)) {
	$isstabname = "student{$studentid}";
	foreach ( $issstudents as &$row ) {
		if ($row['StudentID'] == $studentid) {
			$studentrow = $row;
			break;
		}
	}
}

iss_write_log ( "POSTED: {$isstabname} parentid={$parentid} regyear={$regyear} studentid={$studentid}" ); // ISS TEST

$studentnew = array ();

if ($isstabname === 'studentnew') {
	$result = iss_process_newstudentrequest ( $_POST, $studentnew, $errors );
	if (0 < $result) {
		$isstabname = 'student' . $result;
		$issstudents = iss_get_students_by_parentid ( $parentid, $regyear );
		$successstring = 'Student added.';
	} else {
		$errorstring = '* Could not save changes, please try again. ';
	}
} else if (strpos ( $isstabname, "student", 0 ) === 0) {
	$result = iss_process_updatestudentrequest ( $studentrow, $_POST, $errors );
	if ($result === 1) {
		$issstudents = iss_get_students_by_parentid ( $parentid, $regyear );
		$successstring = 'Changes added.';
	} else {
		$errorstring = '* Could not save changes, please try again. ';
	}
} else {
	$result = iss_process_updateparentrequest ( $isstabname, $issparent, $_POST, $errors );
	if ($result === 1) {
		$isstabname = iss_get_next_tab ( $isstabname );
	} else {
		$errorstring = '* Could not save changes, please try again. ';
	}
}

if (! empty ( $errors )) {
	$errorstring = '* Please correct the values and submit again. ';
}

if ($isstabname === 'complete') {
}
?>
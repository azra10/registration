<?php
// INITIALIZE
$isstabname = 'parent';
$errorstring = '';
$errors = array ();
$issformposturl = '';

// / IF FORM POST REQUEST
if (isset ( $_POST ['_wpnonce-iss-edit-parents-form-page'] )) {
	check_admin_referer ( 'iss-edit-parents-form-page', '_wpnonce-iss-edit-parents-form-page' );
	include (ISS_PATH . "/includes/form_edit_post.php");
	if ($isstabname == 'view') {
		$edit = false;
		$isstabname = 'parent';
		//include (ISS_PATH . "/includes/form_view.php");
		include (ISS_PATH . "/includes/form_print.php");
	} else {
		$edit = true;
		include (ISS_PATH . "/includes/form_edit.php");
	}
} else {
	iss_write_log ( $_GET );
	// REQUIRED FIELDS
	if (! isset ( $_GET ['regyear'] ) || empty ( $_GET ['regyear'] ) || ! iss_field_valid ( 'RegistrationYear', $_GET ['regyear'], $errors, '' ) || ! isset ( $_GET ['pid'] ) || empty ( $_GET ['pid'] ) || (intval ( $_GET ['pid'] ) == 0)) {
		echo '<div class="text-danger"><p><strong>Unknown User.</strong></p></div>';
		return;
	}
	
	// OPTIONAL FIELD
	if (isset ( $_GET ['sid'] ) && ! empty ( $_GET ['sid'] )) {
		$studentid = iss_sanitize_input ( $_GET ['sid'] );
	} else {
		$studentid = '';
	}
	
	$regyear = iss_sanitize_input ( $_GET ['regyear'] );
	$parentid = iss_sanitize_input ( $_GET ['pid'] );
	$issparent = iss_get_parent_by_parentid ( $parentid, $regyear );
	if ($issparent == NULL) {
		echo '<div class="text-danger"><p><strong>Unknown User.</strong></p></div>';
		return;
	}
	$issstudents = iss_get_students_by_parentid ( $parentid, $regyear );
	if ((intval ( $studentid ) != 0)) {
		$isstabname = "student{$studentid}";
		foreach ( $issstudents as &$row ) {
			if ($row ['StudentID'] == $studentid) {
				$studentrow = $row;
				break;
			}
		}
	}
	$studentnew = array ();
	$edit = true;
	include (ISS_PATH . "/includes/form_edit.php");
}
if (isset ( $_GET ['error'] )) {
	echo '<div class="text-danger"><p><strong>Unknown Error!.</strong></p></div>';
}
?>
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
	
	$parentid = $issparent ['ParentID'];
	$regyear = $issparent ['RegistrationYear'];
	$isstabname = 'parent';
	$errorstring = '';
	$issstudents = NULL;
	$studentid = NULL;
	$issformposturl = '';
	
	// IF PARENT EXISTS, PULL STUDENTS
	$issstudents = iss_get_students_by_parentid ( $issparent ['ParentID'], $issparent ['RegistrationYear'] );
	$edit = false;
	
	include (ISS_PATH . "/includes/form_view.php");
}
?>

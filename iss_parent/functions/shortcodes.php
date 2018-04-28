<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function view_parent_function() {
	iss_write_log ( "view parent shortcode" );
	
	// retrieve regyear
	if (! isset ( $_GET ['regyear'] ) || empty ( $_GET ['regyear'] )) {
		echo '<div class="text-danger"><p><strong>Unknown registration year.</strong></p></div>';
		return;
	}
	
	if (! isset ( $_GET ['parentid'] ) || empty ( $_GET ['parentid'] ) || (intval ( $_GET ['parentid'] ) == 0)) {
		echo '<div class="text-danger"><p><strong>Unknown Parent.</strong></p></div>';
		return;
	}
	
	$regyear = iss_sanitize_input ( $_GET ['regyear'] );
	$parentid = iss_sanitize_input ( $_GET ['parentid'] );
	
	echo "parentid={$parentid} regyear={$regyear} "; // ISS TEST
	                                                 
	// IF PARENT EXIST, PULL PARENT
	$issparent = iss_get_parent_by_parentid ( $parentid, $regyear );
	// / IF PARENT EXISTS, PULL STUDENTS
	if ($issparent != NULL) {
		$issstudents = iss_get_students_by_parentid ( $parentid, $regyear );
		$edit = false;
		include (ISS_PATH . "/includes/form_view.php");
	} else {
		echo '<p>' . 'No users found.' . '</p>';
	}
	$return_string = "parentid:{$parentid}";
	return "$return_string";
}
function edit_parent_function() {
	iss_write_log ( "edit parent shortcode" );
	iss_write_log ( $_GET );
	// INITIALIZE
	$isstabname = 'parent';
	$regyear = '';
	$errorstring = '';
	$issstudents = NULL;
	$issparent = NULL;
	$studentid = NULL;
	
	if (! isset ( $_GET ['code'] ) || empty ( $_GET ['code'] )) {
		echo '<div class="text-danger"><p><strong>Unknown code.</strong></p></div>';
		return;
	}
	
	$code = iss_sanitize_input ( $_GET ['code'] );
	
	$issformposturl = "";
	
	// / IF FORM POST REQUEST
	if (isset ( $_POST ['_wpnonce-iss-edit-parents-form-page'] )) {
		check_admin_referer ( 'iss-edit-parents-form-page', '_wpnonce-iss-edit-parents-form-page' );
		include (ISS_PATH . "/includes/form_edit_post.php");
		
		if ($isstabname == 'view') {
			$edit = false;
			//include (ISS_PATH . "/includes/form_view.php");
			include (ISS_PATH . "/includes/form_print.php");
		} else {
			$edit = true;
			include (ISS_PATH . "/includes/form_edit.php");
		}
	}  // form post request
else {
		$issparent = iss_get_parent_by_code ( $code );
		
		// IF PARENT EXISTS, PULL STUDENTS
		if ($issparent != NULL) {
			$parentid = $issparent ['ParentID'];
			$regyear = $issparent ['RegistrationYear'];
			$issstudents = iss_get_students_by_parentid ( $issparent ['ParentID'], $issparent ['RegistrationYear'] );
			$studentnew = array ();
			$edit = true;
			include (ISS_PATH . "/includes/form_edit.php");
		} else {
			echo '<div class="text-danger"><p><strong>Registration code expired, please contact the school administrator. </strong></p></div>';
		}
	}
	
	if (isset ( $_GET ['error'] )) {
		echo '<div class="text-danger"><p><strong>Unknown error, please contact school administrator.</strong></p></div>';
	}
}
?>
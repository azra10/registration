<?php
iss_write_log ( $_POST );

// GET PARENTID
if (isset ( $_POST ['ParentID'] )) {
	$parentid = iss_sanitize_input ( $_POST ['ParentID'] );
}

// GET RegistrationYear
if (isset ( $_POST ['RegistrationYear'] )) {
	$regyear = iss_sanitize_input ( $_POST ['RegistrationYear'] );
}

iss_write_log ( "POSTED: parentid={$parentid} regyear={$regyear}" ); // ISS TEST

if (empty ( $regyear )) {
	echo '<div class="text-danger"><p><strong>Unknown registraion year.</strong></p></div>';
	return;
}
if (intval ( $parentid ) == 0) {
	echo '<div class="text-danger"><p><strong>Unknown Parent.</strong></p></div>';
	return;
}

$issparent = iss_get_parent_by_parentid ( $parentid, $regyear );
if ($issparent != NULL) {
	$issstudents = iss_get_students_by_parentid ( $parentid, $regyear );
}

$paymentchanged = false;
$errors = array ();
$changedfields = array ();
$tab_fields = iss_payment_tabfields ();

foreach ( $tab_fields as $fieldname ) {
	$inputval = '';
	if (isset ( $_POST [$fieldname] )) {
		$inputval = iss_sanitize_input ( $_POST [$fieldname] );
		
		// / VALIDATION ERRORS
		if (strcmp ( $inputval, $issparent [$fieldname] ) != 0) {
			// Modify parent record and record changed fields
			if (iss_field_valid ( $fieldname, $inputval, $errors, '' )) {
				iss_write_log ( "parent changed: {$parentid} {$fieldname}   input: {$inputval}" ); // ISS TEST
				$paymentchanged = true;
				$changedfields [] = $fieldname;
			}
			$issparent [$fieldname] = $inputval;
		}
	}
} // for tab fields
  // / VALIDATE INPUT - end
  
// / UPDATE DB start
if ($paymentchanged) {
	$errorstring = (iss_parent_update ( $changedfields, $issparent ) === 1) ? "Saved successfully." : "Unable to save.";
}
// / UPDATE DB end

// / CONSOLIDATE ERRORS
if (! empty ( $errors )) {
	$errorstring = '* Please correct the values and submit again. ';
	foreach ( $errors as $field => $error )
		$errorstring = $errorstring . '<br/>* ' . $error; // REMOVE LATER
}
?>
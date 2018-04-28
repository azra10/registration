<?php

function iss_get_new_parentid() {
	try {
		iss_write_log ( "iss_get_new_parentid" );
		$parentid = NULL;
		$table = iss_get_table_name ( "parent" );
		global $wpdb;
		$query = "SELECT MAX(ParentID)+1 AS ParentID FROM {$table} LIMIT 1";
		$result_set = $wpdb->get_row ( $query, ARRAY_A );
		
		if ($result_set != NULL) {
			$parentid = $result_set ['ParentID'];
		}
		if ($parentid == NULL)
			$parentid = 1;
		return $parentid;
	} catch ( Exception $ex ) {
		iss_write_log ( "Error" . $ex . getMessage () );
	}
	return 1;
}
/**
 * Function iss_parent_insert
 * Insert parent record
 * 
 * @param
 *        	with minimum required fields (RegistrationYear, FatherLastName, FatherFirstName)
 * @return parentid  / 0 indicating error
 *        
 */
function iss_parent_insert($sdata) {
	try {
		iss_write_log ( "iss_parent_insert" );
		
		if (! isset ( $sdata ['RegistrationYear'] ) || empty ( $sdata ['RegistrationYear'] ) || ! isset ( $sdata ['FatherLastName'] ) || empty ( $sdata ['FatherLastName'] ) || ! isset ( $sdata ['FatherFirstName'] ) || empty ( $sdata ['FatherFirstName'] )) {
			iss_write_log ( "Cannot insert parent due to minimum required fields (RegistrationYear,FatherLastName,FatherFirstName)" );
			return 0;
		}
		
		$table = iss_get_table_name ( "parent" );
		global $wpdb;
		if (! isset ( $sdata ['ParentID'] ) || empty ( $sdata ['ParentID'] ) || ($sdata ['ParentID'] == 'new')) {
			$sdata ['ParentID'] = iss_get_new_parentid ();
		}
		$sdata ['ParentStatus'] = 'active';
		
		$dsarray = array ();
		$typearray = array ();
		$changelog = array ();
		foreach ( iss_parent_table_fields () as $field ) {
			if ($field == 'RegistrationYear')
				continue;
			if (isset ( $sdata [$field] )) {
				$dsarray [$field] = $sdata [$field];
				$typearray [] = iss_field_type ( $field );
				$changelog [] = iss_create_changelog ( $sdata ['ParentID'], NULL, $field, $sdata [$field] );
			}
		}
		$dsarray ['created'] = current_time ( 'mysql' ); // date('d-m-Y H:i:s');
		$typearray [] = iss_field_type ( 'created' );
		
		// check again
		$query = "SELECT * FROM {$table} WHERE ParentID = {$sdata['ParentID']} LIMIT 1";
		$row = $wpdb->get_row ( $query, ARRAY_A );
		
		if ($row != NULL) {
			iss_write_log ( 'iss_parent_insert skipped' );
			if (iss_payment_insert ( $sdata ) == 1)
				return $sdata ['ParentID'];
		}
		
		iss_write_log ( $dsarray );
		$result = $wpdb->insert ( $table, $dsarray, $typearray );
		if ($result == 1) {
			iss_changelog_insert ( $table, $changelog );
			if (iss_payment_insert ( $sdata ) == 1)
				return $sdata ['ParentID'];
		}
	} catch ( Exception $ex ) {
		iss_write_log ( "Error" . $ex . getMessage () );
	}
	return 0;
}
/**
 * Function iss_payment_insert
 * Insert payment record
 * 
 * @param
 *        	with minimum required fields (RegistrationYear, ParentID)
 * @return 1 for success and 0 for no insert
 *        
 */
 function iss_payment_insert($sdata) {
	try {
		iss_write_log ( "iss_payment_insert" );
		$table = iss_get_table_name ( "payment" );
		global $wpdb;
		
		$dsarray = array ();
		$typearray = array ();
		$changelog = array ();
		foreach ( iss_payment_table_fields () as $field ) {
			if (isset ( $sdata [$field] )) {
				$typearray [] = iss_field_type ( $field );
				if (($field == 'PaymentInstallment1')  || ($field == 'PaymentInstallment2') || 
					($field == 'PaymentInstallment3') || ($field == 'PaymentInstallment4'))
				{ $dsarray [$field] = floatval($sdata [$field]); }
				else {$dsarray [$field] = $sdata [$field];}
				$changelog [] = iss_create_changelog ( $sdata ['ParentID'], NULL, $field, $sdata [$field] );
			}
		}
		$dsarray ['created'] = current_time ( 'mysql' ); // date('d-m-Y H:i:s');
		$typearray [] = iss_field_type ( 'created' );
		
		iss_write_log ( $dsarray );
		
		// check again
		$query = "SELECT * FROM {$table} WHERE ParentID = {$sdata['ParentID']}
        and RegistrationYear = '{$sdata['RegistrationYear']}' LIMIT 1";
		$row = $wpdb->get_row ( $query, ARRAY_A );
		
		if (NULL != $row) {
			iss_write_log ( 'iss_payment_insert skipped' );
			return 1;
		}
		
		$result = $wpdb->insert ( $table, $dsarray, $typearray );
		if (1 === $result)
			iss_changelog_insert ( $table, $changelog );
		return $result;
	} catch ( Exception $ex ) {
		iss_write_log ( "iss_payment_insert:Error" . $ex . getMessage () );
	}
	return 0;
}
/**
 * Function iss_parent_update
 * Update parent record
 * 
 * @param $sdata with
 *        	key required fields (RegistrationYear, ParentID)
 *        	$changed fields to update and record the change in log
 * @return 1 for success and 0 for no update
 *        
 */
function iss_parent_update($changedfields, $sdata) {
	try {
		if (! isset ( $sdata ['RegistrationYear'] ) || empty ( $sdata ['RegistrationYear'] ) || ! isset ( $sdata ['ParentID'] ) || empty ( $sdata ['ParentID'] )) {
			iss_write_log ( "Cannot update parent due to minimum required fields" );
			return 0;
		}
		
		iss_write_log ( "iss_parent_update" );
		
		$update = false;
		$changelog = array ();
		$dsarray = array ();
		$typearray = array ();
		$result = 0;
		foreach ( iss_parent_table_fields () as $field ) {
			if (in_array ( $field, $changedfields )) {
				$update = true;
				$dsarray [$field] = $sdata [$field];
				$typearray [] = iss_field_type ( $field );
				$changelog [] = iss_create_changelog ( $sdata ['ParentID'], NULL, $field, $sdata [$field] );
			}
		}
		if ($update) {
			iss_write_log ( "paernt table update" );
			iss_write_log ( $dsarray );
			$table = iss_get_table_name ( "parent" );
			global $wpdb;
			$result = $wpdb->update ( $table, $dsarray, array (
					'ParentID' => $sdata ['ParentID'] 
			), $typearray, array (
					'%d' 
			) );
			if (1 === $result) {
				iss_changelog_insert ( $table, $changelog );
			}
		}
		$result |= iss_payment_update ( $changedfields, $sdata );
		return $result;
	} catch ( Exception $ex ) {
		iss_write_log ( "Error" . $ex . getMessage () );
	}
	return 0;
}
/**
 * Function iss_payment_update
 * Update parent record
 * 
 * @param $sdata with
 *        	key required fields (RegistrationYear, ParentID)
 *        	$changed fields to update and record the change in log
 * @return 1 for success and 0 for no update
 *        
 */
function iss_payment_update($changedfields, $sdata) {
	if (! isset ( $sdata ['RegistrationYear'] ) || empty ( $sdata ['RegistrationYear'] ) || ! isset ( $sdata ['ParentID'] ) || empty ( $sdata ['ParentID'] )) {
		iss_write_log ( "Cannot update payment due to minimum required fields" );
		return 0;
	}
	
	iss_write_log ( "iss_payment_update" );
	$update = false;
	$changelog = array ();
	$dsarray = array ();
	$typearray = array ();
	foreach (  iss_payment_table_fields() as $field ) {
		if (in_array ( $field, $changedfields )) {
			$result = - 1;
			$update = true;
			$typearray [] = iss_field_type ( $field );
			if (($field == 'PaymentInstallment1')  || ($field == 'PaymentInstallment2') || 
				($field == 'PaymentInstallment3') || ($field == 'PaymentInstallment4'))
			{ $dsarray [$field] = floatval($sdata [$field]); }
			else 
			{$dsarray [$field] = $sdata [$field];}
			$changelog [] = iss_create_changelog ( $sdata ['ParentID'], NULL, $field, $sdata [$field] );
		}
	}
	if ($update) {
		iss_write_log ( "payment table update" );
		$table = iss_get_table_name ( "payment" );
		global $wpdb;
		iss_write_log ( $dsarray );
		$result = $wpdb->update ( $table, $dsarray, array (
				'ParentID' => $sdata ['ParentID'],
				'RegistrationYear' => $sdata ['RegistrationYear'] 
		), $typearray, array (
				'%d',
				'%s' 
		) );
		if (1 === $result)
			iss_changelog_insert ( $table, $changelog );
		return $result;
	}
	return 0;
}
/**
 * FUNCTION iss_process_newparentrequest
 *
 * @param
 *        	registration year, post:input from client, issparent: fill in input, errors: processing errors
 * @return 1 for update success, 0 for update failure
 *        
 */
function iss_process_newparentrequest(&$post, &$issparent, &$errors) {
	iss_write_log('iss_process_newparentrequest');
	$required_fields = iss_parent_required_tabfields ();
	$tab_fields = iss_parent_tabfields ();
	$displaynames = iss_field_displaynames ();
	foreach ( $required_fields as $rf ) {
		if (! isset ( $post [$rf] ))
			$errors [$rf] = $displaynames [$rf] . " is required.";
	}
	
	foreach ( $tab_fields as $fieldname ) {
		if (isset ( $post [$fieldname] )) {
			$inputval = iss_sanitize_input ( $post [$fieldname] );
			$issparent [$fieldname] = $inputval;
			iss_field_valid ( $fieldname, $inputval, $errors, '' );
		}
	} // for tab fields
	
	iss_required_emails_valid($post, $errors);
	
	if (empty ( $errors )) {
		$parentid = iss_parent_insert ( $issparent );
		if (0 < $parentid) {
			return $parentid;
		}
	}
	return "new";
}
/**
 * FUNCTION iss_process_updateparentrequest
 *
 * @param
 *        	tab name, parentid, issparent:existing parent record where change applied, post:input from client, errors: processing errors
 * @return 1 for update success, 0 for update failure
 *        
 */
function iss_process_updateparentrequest($tabname, &$issparent, &$post, &$errors) {
	$required_fields = iss_get_requiredfields_by_tabname ( $tabname );
	$tab_fields = iss_get_tabfields_by_tabname ( $tabname );
	$displaynames = iss_field_displaynames ();
	foreach ( $required_fields as $rf ) {
		if (! isset ( $post [$rf] ))
			$errors [$rf] = $displaynames [$rf] . " is required.";
	}
	
	$changedfields = array ();
	foreach ( $tab_fields as $fieldname ) {
		if (isset ( $post [$fieldname] )) {
			$inputval = iss_sanitize_input ( $post [$fieldname] );
			if ((strcmp ( $inputval, $issparent [$fieldname] ) != 0) && iss_field_valid ( $fieldname, $inputval, $errors, '' )) {
				iss_write_log ( "parentchanged: PID:{$post['ParentID']} FLD:{$fieldname} OLD:{$issparent[$fieldname]}  NEW:{$inputval}" );
				$changedfields [] = $fieldname; // record changed fields
			}
			$issparent [$fieldname] = $inputval; // modify parent record
		}
	} // for tab fields
	
	if ($tabname == 'parent')
	{iss_required_emails_valid($post, $errors);}

	if (empty ( $errors )) {
		if (! empty ( $changedfields )) {
			return iss_parent_update ( $changedfields, $issparent ); // PARENT UPDATE
		} else {
			return 1; /* No changes to save */
		}
	}
	return 0;
}
function iss_required_emails_valid($post, &$errors) {
  if ((!isset($post['FatherEmail']) || empty($post['FatherEmail'])) && 
  	  (!isset($post['MotherEmail']) || empty($post['MotherEmail']))) {
	$errors['FatherEmail'] =  'Father or Mother email is required.';
	$errors['MotherEmail'] =  'Father or Mother email is required.';	
  }
  if ((!isset($post['FatherEmail']) || empty($post['FatherEmail']))  && 
  		($post['SchoolEmail']=='Father' )) {
	$errors['FatherEmail'] = 'Chosen as School email, cannot be empty.';
  }
  if ((!isset($post['MotherEmail']) || empty($post['MotherEmail'])) && ($post['SchoolEmail']=='Mother' )) {
	$errors['MotherEmail'] = 'Chosen as School email, cannot be empty.';
  }
  iss_write_log ( "iss_required_emails_valid" );
  iss_write_log ( $errors );
	
}

/*  STUDENT */

function iss_get_new_studentid() {
	iss_write_log ( "iss_get_new_studentid" );
	$studentid = NULL;
	$table = iss_get_table_name ( "student" );
	global $wpdb;
	$query = "SELECT MAX(StudentID)+1 AS StudentID FROM {$table} LIMIT 1";
	$result_set = $wpdb->get_row ( $query, ARRAY_A );
	
	if ($result_set != NULL) {
		$studentid = $result_set ['StudentID'];
	}
	if ($studentid == NULL)
		$studentid = 1;
	return $studentid;
}
/**
 * Function iss_student_insert
 * Insert parent record
 * 
 * @param
 *        	with minimum required fields (ParentID, RegistrationYear, StudentLastName, StudentFirstName)
 * @return studentid
 *        
 */
function iss_student_insert($sdata) {
	try {
		if (! isset ( $sdata ['ParentID'] ) || empty ( $sdata ['ParentID'] ) || ($sdata ['ParentID'] == 'new') || ! isset ( $sdata ['RegistrationYear'] ) || empty ( $sdata ['RegistrationYear'] ) || ! isset ( $sdata ['StudentLastName'] ) || empty ( $sdata ['StudentLastName'] ) || ! isset ( $sdata ['StudentFirstName'] ) || empty ( $sdata ['StudentFirstName'] )) {
			iss_write_log ( "Cannot insert student due to minimum required fields" );
			return 0;
		}
		
		iss_write_log ( "iss_student_insert" );
		$table = iss_get_table_name ( "student" );
		global $wpdb;
		
		if (! isset ( $sdata ['StudentID'] ) || empty ( $sdata ['StudentID'] ) || ($sdata ['StudentID'] == 'new')) {
			$sdata ['StudentID'] = iss_get_new_studentid ();
		}
		$sdata ['StudentStatus'] = 'active';
		
		$dsarray = array ();
		$typearray = array ();
		$changelog = array ();
		foreach ( iss_student_table_fields () as $field ) {
			if (isset ( $sdata [$field] )) {
				$dsarray [$field] = $sdata [$field];
				$typearray [] = iss_field_type ( $field );
				$changelog [] = iss_create_changelog ( $sdata ['ParentID'], $sdata ['StudentID'], $field, $sdata [$field] );
			}
		}
		$dsarray ['created'] = current_time ( 'mysql' ); // date('d-m-Y H:i:s');
		$typearray [] = iss_field_type ( 'created' );
		
		iss_write_log ( $dsarray );
		
		// check again
		$query = "SELECT * FROM {$table} WHERE  StudentID = {$sdata['StudentID']} LIMIT 1";
		$row = $wpdb->get_row ( $query, ARRAY_A );
		if ($row != NULL) {
			iss_write_log ( 'iss_student_insert skipped' );
			if (iss_registration_insert ( $sdata ) === 1)
				return $sdata ['StudentID'];
		}
		
		$result = $wpdb->insert ( $table, $dsarray, $typearray );
		if ($result == 1) {
			iss_changelog_insert ( $table, $changelog );
			if (iss_registration_insert ( $sdata ) === 1)
				return $sdata ['StudentID'];
		}
	} catch ( Exception $ex ) {
		iss_write_log ( "Error" . $ex . getMessage () );
	}
	return 0;
}
function iss_registration_insert($sdata) {
	try {
		if (! isset ( $sdata ['RegistrationYear'] ) || empty ( $sdata ['RegistrationYear'] ) || ! isset ( $sdata ['StudentID'] ) || empty ( $sdata ['StudentID'] )) {
			iss_write_log ( "Cannot insert student registration due to minimum required fields" );
			return 0;
		}
		
		iss_write_log ( "iss_registration_insert" );
		$table = iss_get_table_name ( "registration" );
		global $wpdb;
		
		$dsarray = array ();
		$typearray = array ();
		$changelog = array ();
		foreach ( iss_registration_table_fields () as $field ) {
			if (isset ( $sdata [$field] )) {
				$dsarray [$field] = $sdata [$field];
				$typearray [] = iss_field_type ( $field );
				$changelog [] = iss_create_changelog ( $sdata ['ParentID'], $sdata ['StudentID'], $field, $sdata [$field] );
			}
		}
		$dsarray ['created'] = current_time ( 'mysql' ); // date('d-m-Y H:i:s');
		$typearray [] = iss_field_type ( 'created' );
		
		iss_write_log ( $dsarray );
		
		// check again
		$query = "SELECT * FROM {$table} WHERE StudentID = {$sdata['StudentID']}
        and RegistrationYear = '{$sdata['RegistrationYear']}' LIMIT 1";
		$row = $wpdb->get_row ( $query, ARRAY_A );
		
		if (NULL != $row) {
			iss_write_log ( 'iss_registration_insert skipped' );
			return 1;
		}
		
		$result = $wpdb->insert ( $table, $dsarray, $typearray );
		if (1 === $result) {
			iss_changelog_insert ( $table, $changelog );
			return $result;
		}
	} catch ( Exception $ex ) {
		iss_write_log ( "Error" . $ex . getMessage () );
	}
	return 0;
}
/**
 * Function iss_student_update
 * Update student record
 * 
 * @param $sdata with
 *        	key required fields (RegistrationYear, ParentID, StudentID)
 *        	$changed fields to update and record the change in log
 * @return 1 for success and 0 for no update
 *        
 */
function iss_student_update($changedfields, $sdata) {
	try {
		if (! isset ( $sdata ['ParentID'] ) || empty ( $sdata ['ParentID'] ) || ($sdata ['ParentID'] == 'new') || ! isset ( $sdata ['StudentID'] ) || empty ( $sdata ['StudentID'] ) || ($sdata ['StudentID'] == 'new')) {
			iss_write_log ( "Cannot update student due to minimum required fields" );
			return 0;
		}
		iss_write_log ( 'cool' );
		iss_write_log ( $changedfields );iss_write_log ( $sdata );
		
		$update = false;
		$changelog = array ();
		$dsarray = array ();
		$typearray = array ();
		$result = 0;
		foreach ( iss_student_table_fields () as $field ) {
			if (in_array ( $field, $changedfields )) {
				$update = true;
				$dsarray [$field] = $sdata [$field];
				$typearray [] = iss_field_type ( $field );
				$changelog [] = iss_create_changelog ( $sdata ['ParentID'], $sdata ['StudentID'], $field, $sdata [$field] );
			}
		}
		if ($update) {
			iss_write_log ( "student table update" );
			iss_write_log ( $dsarray );
			$table = iss_get_table_name ( "student" );
			global $wpdb;
			$result = $wpdb->update ( $table, $dsarray, array (
					'StudentID' => $sdata ['StudentID'] 
			), $typearray, array (
					'%d' 
			) );
			if (1 === $result) {
				iss_changelog_insert ( $table, $changelog );
			}
		}
		$result |= iss_registration_update ( $changedfields, $sdata );
		return $result;
	} catch ( Exception $ex ) {
		iss_write_log ( "Error" . $ex . getMessage () );
	}
	return 0;
}
/**
 * Function iss_registration_update
 * Update registration student record
 * 
 * @param $sdata with
 *        	key required fields (RegistrationYear, StudentID)
 *        	$changed fields to update and record the change in log
 * @return 1 for success and 0 for no update
 *        
 */
function iss_registration_update($changedfields, $sdata) {
	if (! isset ( $sdata ['RegistrationYear'] ) || empty ( $sdata ['RegistrationYear'] ) || ! isset ( $sdata ['StudentID'] ) || empty ( $sdata ['StudentID'] ) || ($sdata ['StudentID'] == 'new')) {
		iss_write_log ( "Cannot update student registration due to minimum required fields" );
		return 0;
	}
	
	iss_write_log ( "iss_student_update" );
	$update = false;
	$changelog = array ();
	$dsarray = array ();
	$typearray = array ();
	foreach ( array (
			"ISSGrade",
			"RegularSchoolGrade" 
	) as $field ) {
		if (in_array ( $field, $changedfields )) {
			$update = true;
			$dsarray [$field] = $sdata [$field];
			$typearray [] = iss_field_type ( $field );
			$changelog [] = iss_create_changelog ( $sdata ['ParentID'], $sdata ['StudentID'], $field, $sdata [$field] );
		}
	}
	if ($update) {
		iss_write_log ( "registration table update" );
		$table = iss_get_table_name ( "registration" );
		iss_write_log ( $dsarray );
		global $wpdb;
		$result = $wpdb->update ( $table, $dsarray, array (
				'StudentID' => $sdata ['StudentID'],
				'RegistrationYear' => $sdata ['RegistrationYear'] 
		), $typearray, array (
				'%d',
				'%s' 
		) );
		if (1 === $result) {
			iss_changelog_insert ( $table, $changelog );
			return $result;
		}
	}
	return 0;
}

/**
 * FUNCTION iss_process_newstudentrequest
 *
 * @param
 *        	registration year, post:input from client, studentnew: fill in input, errors: processing errors
 * @return 1 for update success, 0 for update failure
 *        
 */
function iss_process_newstudentrequest(&$post, &$studentnew, &$errors) {
	$tabname = 'student';
	$required_fields = iss_get_requiredfields_by_tabname ( $tabname );
	$tab_fields = iss_get_tabfields_by_tabname ( $tabname );
	$displaynames = iss_field_displaynames ();
	foreach ( $required_fields as $rf ) {
		if (! isset ( $post [$rf] ))
			$errors [$rf] = $displaynames [$rf] . " is required.";
	}
	
	foreach ( $tab_fields as $fieldname ) {
		if (isset ( $post [$fieldname] )) {
			$inputval = iss_sanitize_input ( $post [$fieldname] );
			$studentnew [$fieldname] = $inputval;
			iss_field_valid ( $fieldname, $inputval, $errors, 'new' );
		}
	} // for tab fields
	
	if (empty ( $errors )) {
		;
		$studentid = iss_student_insert ( $studentnew );
		if (0 < $studentid) {
			$studentnew = array ();
			return $studentid;
		}
	}
	return 0;
}
function iss_process_updatestudentrequest(&$studentrow, &$post, &$errors) {
	$tabname = 'student';
	$required_fields = iss_get_requiredfields_by_tabname ( $tabname );
	$tab_fields = iss_get_tabfields_by_tabname ( $tabname );
	$displaynames = iss_field_displaynames ();
	foreach ( $required_fields as $rf ) {
		if (! isset ( $post [$rf] ))
			$errors [$rf] = $displaynames [$rf] . " is required.";
	}
	
	$changedfields = array ();
	foreach ( $tab_fields as $fieldname ) {
		if (isset ( $post [$fieldname] )) {
			$inputval = iss_sanitize_input ( $post [$fieldname] );
			if ((strcmp ( $inputval, $studentrow [$fieldname] ) != 0) && iss_field_valid ( $fieldname, $inputval, $errors, $post ['StudentID'] )) {
				iss_write_log ( "studentchanged: SID:{$post['StudentID']} FLD:{$fieldname} OLD:{$studentrow[$fieldname]}  NEW:{$inputval}" );
				$changedfields [] = $fieldname; // record changed fields
			}
			$studentrow [$fieldname] = $inputval; // modify the student row
		}
	} // for tab fields
	
	if (empty ( $errors )) {
		if (! empty ( $changedfields )) {
			return iss_student_update ( $changedfields, $studentrow ); /* EXISTING STUDENT UPDATE */
		}
		// else { $errorstring = '* No changes to save.'; }
	}
	
	return 0;
}
?>
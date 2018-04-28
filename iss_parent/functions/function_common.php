<?php
if (! function_exists ( 'iss_write_log' )) {
	function iss_write_log($log) {
		if (true === WP_DEBUG) {
			
			if (is_array ( $log ) || is_object ( $log )) {
				error_log ( get_current_user () . ' ' . print_r ( $log, true ) );
			} else {
				error_log ( get_current_user () . ' ' . $log );
			}
		}
	}
}

/** GET Functions */
/**
 * Function iss_get_registrationyear_list
 * Queries registration years in payment table
 * 
 * @param
 *        	none
 * @return array of strings
 *        
 */
function iss_get_registrationyear_list() {
	global $wpdb;
	$parents = iss_get_table_name ( "payment" );
	$query = "SELECT distinct(RegistrationYear)  FROM {$parents} order by  RegistrationYear";
	$result_set = $wpdb->get_results ( $query, ARRAY_A );
	
	return $result_set;
}
/**
 * Function iss_get_export_list
 * Queries parents & studnts in a registration period
 * 
 * @param
 *        	none
 * @return array of strings
 *        
 */
function iss_get_export_list($regyear, $columns='', $orderby='', $parentactive=true, $studentactive = true) {
	global $wpdb;
	
	if ((NULL==$orderby) || (strlen($orderby)===0))
	{ $orderby = 'FatherLastName,FatherFirstName,MotherFirstName,ISSGrade';}
	if ((NULL==$columns) || (strlen($columns)==0)) { $columns = '*';}
	$parentstatus = ($parentactive)? 'active':'inactive';
	$studentstatus = ($studentactive)? 'active':'inactive';
	
	$parents = iss_get_table_name ( "parents" );
	$students = iss_get_table_name ( "students" );
	$query = "SELECT {$columns}  FROM {$parents} AS p INNER JOIN  {$students} AS s ON p.ParentID  = s.ParentID
    WHERE p.RegistrationYear = '{$regyear}' and s.RegistrationYear = '{$regyear}' and  
	s.StudentStatus = '{$studentstatus}' and p.ParentStatus = '{$parentstatus}'  ORDER BY {$orderby}";
	$result_set = $wpdb->get_results ( $query, ARRAY_A );
	
	return $result_set;
}
/**
 * Function iss_get_parents_complete_list
 * Queries parents in a registration period
 * 
 * @param
 *        	none
 * @return array of parent records
 *        
 */
function iss_get_parents_complete_list($regyear) {
	return iss_get_parents_list ( $regyear, '*' );
}

/**
 * Function iss_get_parents_list
 * Queries parents in a registration period
 * 
 * @param
 *        	none
 * @return array of parent records
 *        
 */
function iss_get_parents_list($regyear, $columns) {
	global $wpdb;
	
	$parents = iss_get_table_name ( "parents" );
	$query = "SELECT {$columns}  FROM {$parents} WHERE
    ParentStatus = 'active' and RegistrationYear = '{$regyear}'
    ORDER BY FatherLastName, FatherFirstName";
	$result_set = $wpdb->get_results ( $query, ARRAY_A );
	return $result_set;
}
/**
 * Function iss_get_startwith_parents_list
 * Queries active parents in a registration period starting with given keyword
 * 
 * @param
 *        	none
 * @return array of parent records
 *        
 */
function iss_get_startwith_parents_list($regyear, $columns, $keyword) {
	global $wpdb;
	
	$customers = iss_get_table_name ( "parents" );
	$query = "SELECT {$columns} FROM {$customers}
    WHERE FatherLastName LIKE '{$keyword}%' && RegistrationYear LIKE '{$regyear}%' && ParentStatus = 'active'
    ORDER BY FatherLastName, FatherFirstName";
	
	$result_set = $wpdb->get_results ( $query, ARRAY_A );
	return $result_set;
}
/**
 * Function iss_get_search_parents_list
 * Queries active parents in a registration period searcg with given keyword
 * 
 * @param
 *        	none
 * @return array of parent records
 *        
 */
function iss_get_search_parents_list($regyear, $columns, $keyword) {
	global $wpdb;
	
	$customers = iss_get_table_name ( "parents" );
	// if( strlen($keyword) > 3 )
	// {
	// $query = "
	// SELECT *,
	// MATCH(FatherFirstName, FatherLastName) AGAINST('{$keyword}*' IN BOOLEAN MODE) AS score
	// FROM {$customers}
	// WHERE MATCH(FatherFirstName, FatherLastName) AGAINST('{$keyword}*' IN BOOLEAN MODE)
	// ORDER BY score DESC";
	// }
	// else
	// {
	$query = "SELECT {$columns} FROM {$customers}
    WHERE (FatherFirstName LIKE '%{$keyword}%' OR FatherLastName LIKE '%{$keyword}%')
    && RegistrationYear LIKE '{$regyear}' && ParentStatus = 'active'
    ORDER BY FatherLastName, FatherFirstName";
	
	$result_set = $wpdb->get_results ( $query, ARRAY_A );
	return $result_set;
}
/**
 * Function iss_get_parent_by_parentid
 * Get parent record by ParentID
 * 
 * @param
 *        	ParentID and registration year
 * @return parent record or NULL
 *        
 */
function iss_get_parent_by_parentid($parentid, $regyear) {
	try {
		global $wpdb;
		$parents = iss_get_table_name ( "parents" );
		$query = $wpdb->prepare ( "SELECT * FROM {$parents} WHERE" . " RegistrationYear = '{$regyear}' and ParentStatus = 'active' and ParentID = %d LIMIT 1", $parentid );
		$row = $wpdb->get_row ( $query, ARRAY_A );
		if ($row != NULL) {
			return $row;
		}
	} catch ( Exception $ex ) {
		iss_write_log ( "Error" . $ex . getMessage () );
	}
	return NULL;
}
/**
 * Function iss_get_parent_and_payment_by_id
 * Get parent record by parentviewid
 * 
 * @param
 *        	parentviewid (auto increment column of the table)
 * @return parent record or NULL
 *        
 */
function iss_get_parent_and_payment_by_id($parentviewid) {
	global $wpdb;
	$parents = iss_get_table_name ( "parents" );
	$query = $wpdb->prepare ( "SELECT * FROM {$parents} WHERE ParentViewID = %d LIMIT 1", $parentviewid );
	$row = $wpdb->get_row ( $query, ARRAY_A );
	if ($row != NULL) {
		return $row;
	}
	return NULL;
}
function iss_get_new_parents_list ( $regyear, $columns  )
{
	global $wpdb;
	
	$parents = iss_get_table_name ( "parents" );
	$query = "SELECT {$columns}  FROM {$parents} WHERE
    ParentStatus = 'active' and RegistrationYear = '{$regyear}'
	and ParentNew = 'Yes'
    ORDER BY FatherLastName, FatherFirstName";
	$result_set = $wpdb->get_results ( $query, ARRAY_A );
	return $result_set;
}

function iss_get_new_students_list ( $regyear, $columns )
{
	global $wpdb;
	$table = iss_get_table_name ( "students" );
	$query = "SELECT {$columns}  FROM {$table} WHERE  StudentStatus = 'active'
    and RegistrationYear = '{$regyear}' and StudentNew = 'Yes'
    ORDER BY StudentLastName, StudentFirstName";
	$result_set = $wpdb->get_results ( $query, ARRAY_A );
	return $result_set;
}
/**
 * Function iss_get_students_list
 * Queries active students in a registration period
 * 
 * @param
 *        	none
 * @return array of student records
 *        
 */
function iss_get_students_list($regyear, $columns) {
	global $wpdb;
	$table = iss_get_table_name ( "students" );
	$query = "SELECT {$columns}  FROM {$table} WHERE  StudentStatus = 'active'
    and RegistrationYear = '{$regyear}' ORDER BY StudentLastName, StudentFirstName";
	$result_set = $wpdb->get_results ( $query, ARRAY_A );
	return $result_set;
}
/**
 * Function iss_get_class_students_list
 * Queries students in a class
 * 
 * @param
 *        	none
 * @return array of student records
 *        
 */
function iss_get_class_students_list($regyear, $columns, $class) {
	global $wpdb;
	$table = iss_get_table_name ( "students" );
	$query = "SELECT {$columns}  FROM {$table}
    WHERE  ISSGrade LIKE '{$class}%' and StudentStatus = 'active' and RegistrationYear = '{$regyear}'
    ORDER BY StudentLastName, StudentFirstName";
	$result_set = $wpdb->get_results ( $query, ARRAY_A );
	return $result_set;
}
/**
 * Function iss_get_search_students_list
 * Queries students in a registration period in a class
 * 
 * @param
 *        	none
 * @return array of student records
 *        
 */
function iss_get_search_students_list($regyear, $columns, $keyword) {
	global $wpdb;
	$table = iss_get_table_name ( "students" );
	
	// if( strlen($keyword) > 3 )
	// {
	// $query = "
	// SELECT *,
	// MATCH(StudentFirstName, StudentLastName) AGAINST('{$keyword}*' IN BOOLEAN MODE) AS score
	// FROM {$customers}
	// WHERE MATCH(StudentFirstName, StudentLastName) AGAINST('{$keyword}*' IN BOOLEAN MODE)
	// and RegistrationYear LIKE '{$regyear}' and StudentStatus = 'active'
	// ORDER BY score DESC";
	// } else {
	
	$query = "SELECT {$columns}  FROM {$table}
    WHERE ((StudentFirstName LIKE '%{$keyword}%' OR StudentLastName LIKE '%{$keyword}%'))
    and RegistrationYear LIKE '{$regyear}' and StudentStatus = 'active'
    ORDER BY StudentLastName, StudentFirstName";
	$result_set = $wpdb->get_results ( $query, ARRAY_A );
	return $result_set;
}

/**
 * Function iss_get_student_by_studentid
 * Get Student record by StudentID
 * 
 * @param
 *        	StudentID
 * @return Student record
 *        
 */
function iss_get_student_by_studentid($studentid, $regyear) {
	try {
		// echo "br/> get student {$studentid} , {$regyear}"; // ISS TEST
		global $wpdb;
		$table = iss_get_table_name ( "students" );
		$query = $wpdb->prepare ( "SELECT * FROM {$table} WHERE RegistrationYear = '{$regyear}'  and StudentID = %d LIMIT 1", $studentid );
		$row = $wpdb->get_row ( $query, ARRAY_A );
		if ($row != NULL) {
			return $row;
		}
	} catch ( Exception $ex ) {
		iss_write_log ( "Error" . $ex . getMessage () );
	}
	return NULL;
}

/**
 * Function
 * Get student records
 * 
 * @param
 *        	ParentID & RegistrationYear
 * @return student records array or NULL
 *        
 */
function iss_get_students_by_parentid($parentid, $regyear) {
	global $wpdb;
	$table = iss_get_table_name ( "students" );
	$query = $wpdb->prepare ( "SELECT * FROM {$table} WHERE " . " RegistrationYear = '{$regyear}' and ParentID = %d ORDER BY StudentID", $parentid );
	$result_set = $wpdb->get_results ( $query, ARRAY_A );
	
	if ($result_set != NULL) {
		return $result_set;
	}
	return NULL;
}



/**  HELPER function */
function iss_sanitize_input($data) {
	$data = trim ( $data );
	$data = stripslashes ( $data );
	$data = htmlspecialchars ( $data );
	return $data;
}
/**
 * Function iss_get_table_name
 * Returns the table name
 * 
 * @param
 *        	table alias name
 * @return table name string
 *        
 */
function iss_get_table_name($name) {
	global $wpdb;
	if (empty($name)){
		iss_write_log ( "Empty table name" );
	} elseif ($name == "registration") {
		return $wpdb->prefix . "iss_registration";
	} elseif ($name == "changelog") {
		return $wpdb->prefix . "iss_changelog";
	} elseif ($name == "parents") {
		return $wpdb->prefix . "iss_parents";
	} elseif ($name == "students") {
		return $wpdb->prefix . "iss_students";
	} elseif ($name == "payment") {
		return $wpdb->prefix . "iss_payment";
	} elseif ($name == "parent") {
		return $wpdb->prefix . "iss_parent";
	} elseif ($name == "student") {
		return $wpdb->prefix . "iss_student";
	} else {
		iss_write_log ( "Unknown table name {$name}" );
		return NULL;
	}
}
function iss_quote_all_array($values) {
	foreach ( $values as $key => $value )
		if (is_array ( $value ))
			$values [$key] = iss_quote_all_array ( $value );
		else
			$values [$key] = iss_quote_all ( $value );
	return $values;
}
function iss_quote_all($value) {
	global $wpdb;
	
	if (is_null ( $value ))
		return "NULL";
	
	$value = "\"" .  $value . "\"";
	return $value;
}
function iss_class_list() {
	$issclasslist = array (
				'KG' => 'Kindergarten',
				'1' => 'Grade 1',
				'2' => 'Grade 2',
				'3' => 'Grade 3',
				'4' => 'Grade 4',
				'5' => 'Grade 5',
				'6' => 'Grade 6',
				'7' => 'Grade 7',
				'8' => 'Grade 8',
				'YB' => 'Youth Boys',
				'YG' => 'Youth Girls',
				'XX' => 'Unknown' 
		);
		return $issclasslist;
}
function iss_regular_school_class_list() {
	$regschclasslist = array (
						'KG' => 'Kindergarten',
						'1' => 'Grade 1',
						'2' => 'Grade 2',
						'3' => 'Grade 3',
						'4' => 'Grade 4',
						'5' => 'Grade 5',
						'6' => 'Grade 6',
						'7' => 'Grade 7',
						'8' => 'Grade 8',
						'9' => 'Grade 9',
						'10' => 'Grade 10',
						'11' => 'Grade 11',
						'12' => 'Grade 12',
						'XX' => 'Unknown' 
				);
	return $regschclasslist;
}
?>

<?php
/**
 * Function iss_get_archived_parents_list
 * Queries archived parents in a registration period
 * 
 * @param
 *        	none
 * @return array of parent records
 *        
 */
function iss_get_archived_parents_list($regyear, $columns) {
	global $wpdb;
	
	$table = iss_get_table_name ( "parents" );
	
	$query = "SELECT {$columns} FROM {$table}
    WHERE RegistrationYear = '{$regyear}' && ParentStatus = 'inactive'
    ORDER BY FatherLastName, FatherFirstName";
	
	$result_set = $wpdb->get_results ( $query, ARRAY_A );
	return $result_set;
}
/**
 * Function iss_get_archived_students_list
 * Queries archived parents in a registration period
 * 
 * @param
 *        	none
 * @return array of parent records
 *        
 */
function iss_get_archived_students_list($regyear, $columns ) {
	global $wpdb;
	
	$customers = iss_get_table_name ( "students" );
	
	$query = "SELECT {$columns} FROM {$customers}
    WHERE RegistrationYear = '{$regyear}' && StudentStatus = 'inactive'
    ORDER BY StudentLastName, StudentFirstName";
	
	$result_set = $wpdb->get_results ( $query, ARRAY_A );
	return $result_set;
}
/**
 * Function iss_parent_student_update_new
 * Update parent & students records inactive
 * 
 * @param
 *        	parentViewID (auto increment column of the table)
 * @return 1 for success
 *        
 */function iss_parent_student_update_new($parentid, $text)
{
	global $wpdb;
	$parent = iss_get_table_name ( "parent" );
	$student = iss_get_table_name ( "student" );
	$query = $wpdb->prepare ( "SELECT * FROM {$parent} WHERE ParentID = %d LIMIT 1", $parentid );
	$row = $wpdb->get_row ( $query, ARRAY_A );
	
	if ($row != NULL) {
		$result = $wpdb->update ( $parent, array (
				'ParentNew' => $text 
		), array (
				'ParentID' => $row ['ParentID'] 
		), array (
				'%s' 
		), array (
				'%d' 
		) );
		
		$result = $wpdb->update ( $student, array (
				'StudentNew' => $text
		), array (
				'ParentID' => $row ['ParentID'],
		), array (
				'%s' 
		), array (
				'%d',
		) );
		return $result;
	}
	return 0;
}
/**
 * Function iss_archive_family
 * Update parent & students records inactive
 * 
 * @param
 *        	parentViewID (auto increment column of the table)
 * @return 1 for success
 *        
 */
function iss_archive_family($parentViewID) {
	global $wpdb;
	$parents = iss_get_table_name ( "parents" );
	$students = iss_get_table_name ( "students" );
	$query = $wpdb->prepare ( "SELECT * FROM {$parents} WHERE ParentViewID = %d LIMIT 1", $parentViewID );
	$row = $wpdb->get_row ( $query, ARRAY_A );
	
	if ($row != NULL) {
		$result = $wpdb->update ( $parents, array (
				'ParentStatus' => 'inactive' 
		), array (
				'ParentViewID' => $row ['ParentViewID'] 
		), array (
				'%s' 
		), array (
				'%d' 
		) );
		
		$result = $wpdb->update ( $students, array (
				'StudentStatus' => 'inactive' 
		), array (
				'ParentID' => $row ['ParentID'],
				'RegistrationYear' => $row ['RegistrationYear'] 
		), array (
				'%s' 
		), array (
				'%d',
				'%s' 
		) );
		return $result;
	}
	return 0;
}
/**
 * Function iss_unarchive_family
 * Update parent & students records active
 * 
 * @param
 *        	parentViewID (auto increment column of the table)
 * @return 1 for success
 *        
 */
function iss_unarchive_family($parentViewID) {
	global $wpdb;
	$parents = iss_get_table_name ( "parents" );
	$students = iss_get_table_name ( "students" );
	$query = $wpdb->prepare ( "SELECT * FROM {$parents} WHERE ParentViewID = %d LIMIT 1", $parentViewID );
	$row = $wpdb->get_row ( $query, ARRAY_A );
	
	if ($row != NULL) {
		$result = $wpdb->update ( $parents, array (
				'ParentStatus' => 'active' 
		), array (
				'ParentViewID' => $row ['ParentViewID'] 
		), array (
				'%s' 
		), array (
				'%d' 
		) );
		
		$result = $wpdb->update ( $students, array (
				'StudentStatus' => 'active' 
		), array (
				'ParentID' => $row ['ParentID'],
				'RegistrationYear' => $row ['RegistrationYear'] 
		), array (
				'%s' 
		), array (
				'%d',
				'%s' 
		) );
		return $result;
	}
	return 0;
}
?>
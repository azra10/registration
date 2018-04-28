<?php
/**
 * Function iss_delete_parent_by_id (Testing Only)
 * @param	ParentID 
 * @return 1 success & 0 for failure
 */
function iss_delete_parent_by_parentid($parentid) {
	global $wpdb;
	$table = iss_get_table_name ( "parent" );
	$result = $wpdb->delete ( $table, array ( 'ParentID' => $parentid  ), array ( '%d' ) );
	return $result;
}
/**
 * Function iss_delete_student_by_studentid (Testing Only)
 * @param	StudentID 
 * @return 1 success & 0 for failure
 */
function iss_delete_student_by_studentid($studentid) {
	global $wpdb;
	$table = iss_get_table_name ( "student" );
	$result = $wpdb->delete ( $table, array ( 'StudentID' => $studentid ), array ( '%d'  ) );
	return $result;
}
/**
 * Function iss_delete_students_by_parentid (Testing Only)
 * Delete student records by ParentID
 * 
 * @param PareentID 
 * @return 1 success & 0 for failure
 */
function iss_delete_students_by_parentid($parentid) {
	global $wpdb;
	$table = iss_get_table_name ( "student" );
	$result = $wpdb->delete ( $table, array ('ParentID' => $parentid ), array ('%d' ) );
	return $result;
}
/**
 * Function iss_delete_changelog_by_parentid (Testing Only)
 * Get change record by ParentID
 * 
 * @paramParentID
 *  @return 1 success & 0 for failure
 */
function iss_delete_changelog_by_parentid($parentid) {
	global $wpdb;
	$table = iss_get_table_name ( "changelog" );
	$result = $wpdb->delete ( $table, array ('ParentID' => $parentid ), array ('%d' ) );
	return $result;
}

?>
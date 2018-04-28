<?php
/**
 * Function iss_changelog_list
 * Array of change records
 * 
 * @param
 *        	parentid
 * @return Array of Changelod
 *        
 */
function iss_changelog_list($tablename, $parentid, $studentid) {
	$result = array ();
	global $wpdb;
	// $table = iss_get_table_name("parent");
	// $query = $wpdb->prepare("SELECT * FROM {$table} WHERE ParentID = %d LIMIT 1", $parentid);
	// $row = $wpdb->get_row($query, ARRAY_A);
	// if ($row != NULL) { $result[] = $row; }
	
	$table = iss_get_table_name ( "changelog" );
    $inputtable = iss_get_table_name ( $tablename);
	$paymenttable = iss_get_table_name ( "payment" );
	$regtable = iss_get_table_name ( "registration" );
	$query = '';
    if (($tablename === 'student') && ($studentid != NULL))
    { 
        $query = "SELECT * FROM {$table} 
        WHERE ParentID = {$parentid} and StudentID = {$studentid} and
        (TableName = '{$inputtable}' or TableName = '{$regtable}') 
       order by ChangelogID ASC";
	} else if ($tablename === 'parent')
	{
        $query = "SELECT * FROM {$table} 
        WHERE ParentID = {$parentid} and  
        (TableName = '{$inputtable}' or TableName = '{$paymenttable}') 
        order by ChangelogID ASC";
    } else {
        $query = "SELECT * FROM {$table} 
        WHERE ParentID = {$parentid} and  
        TableName = '{$inputtable}' 
        order by ChangelogID ASC";
    }
    //var_dump($query);
	$result_set = $wpdb->get_results ( $query, ARRAY_A );
	
	$changesetid = NULL;
	$changeset = NULL;
	$modifiedby = NULL;
	foreach ( $result_set as $change ) {
		// echo "<br>"; var_dump($change);
		$modifiedbyt = $change ['ModifiedBy'];
		$changesetidt = substr ( $change ['ChangeSetID'], 0, 19 );
		if (isset ( $changeset [$change ['FieldName']] ) || ($changesetidt != $changesetid) || ($modifiedbyt != $modifiedby)) {
			if ($changeset != NULL) {
				$result [] = $changeset;
			}
			$changeset = array ();
			$changeset ['ModifiedBy'] = $modifiedby = $modifiedbyt;
			$changeset ['ChangeSetID'] = $changesetid = $changesetidt;
		}
		$changeset [$change ['FieldName']] = $change ['FieldValue'];
	}
	if ($changeset != NULL)
		$result [] = $changeset;
	return $result;
}
function iss_create_changelog($parentid, $studentid, $fieldname, $inputval) {
	return array (
			"ParentID" => $parentid,
			'StudentID' => $studentid,
			"FieldName" => $fieldname,
			"FieldValue" => $inputval 
	);
}
function iss_changelogsetid() {
	return date ( 'Y-m-d H:i:s' ) . substr ( microtime (), 1, 9 );
}
/**
 * Function iss_changelog_insert
 * Insert change records
 * 
 * @param
 *        	changelog & tablename
 * @return none
 *
 */
function iss_changelog_insert($tablename, $changelog) {
	try {
		iss_write_log ( "iss_changelog_insert table:{$tablename}" );
		iss_write_log ( $changelog );
		$table = iss_get_table_name ( "changelog" );
		global $wpdb;
		$dsarray = array ();
		$typearray = array ();
		
		$dn = wp_get_current_user ()->display_name;
		$cid = iss_changelogsetid ();
		foreach ( $changelog as $sdata ) {
			if (($sdata ['FieldName'] == 'ParentID') || ($sdata ['FieldName'] == 'StudentID'))
				continue;
			
			$result = $wpdb->insert ( $table, array (
					"TableName" => $tablename,
					"ParentID" => $sdata ['ParentID'],
					"StudentID" => $sdata ['StudentID'],
					"FieldName" => $sdata ['FieldName'],
					"FieldValue" => $sdata ['FieldValue'],
					"ChangeSetID" => $cid,
					"ModifiedBy" => $dn 
			), array (
					"%s",
					"%d",
					"%d",
					"%s",
					"%s",
					"%s" 
			) );
		}
	} catch ( Exception $ex ) {
		iss_write_log ( "Error" . $ex . getMessage () );
	}
}
function iss_write_changelog_vertical($tablename, $parentid, $studentid) {
	$changeset = iss_changelog_list ( $tablename , $parentid, $studentid );
	echo "<br><h3>{$tablename} record,  parentID: {$parentid}";
    if ($studentid != NULL) echo " studentID: {$studentid}";
    echo "</h3><table border=1><tr><th>Change Details</th>";
	$count=1;
	foreach ( $changeset as $changelog ) {
		echo "<td>{$changelog['ChangeSetID']} <br/>By {$changelog['ModifiedBy']} <br/> Change# {$count} </td>";
		$count++;
	}
	echo "</tr>";
	if ($tablename === 'parent') $fields = iss_parent_fields();
    else if ($tablename === 'student') $fields = iss_student_fields();
    else $fields = iss_get_table_fields ( $tablename );
	foreach ( $fields as $field ) {
		echo "<tr><th>{$field}</th>";
		foreach ( $changeset as $changelog ) {
			echo "<td>";
			if ($field == 'ParentID')
				echo $parentid;
			if ($field == 'StudentID')
				echo $studentid;
			foreach ( $changelog as $key => $value ) {
				if ($field == $key) {
					echo $value;
				}
			}
			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
}
/* function iss_write_changelog_horizontal($tablename, $parentid, $studentid) {
	$changeset = iss_changelog_list ( $tablename , $parentid, $studentid );
	echo "<br>Table:{$tablename}<table border=1>";
	echo "<tr>";
    if ($tablename === 'parent') $fields = iss_parent_fields();
    else if ($tablename === 'student') $fields = iss_student_fields();
    else $fields = iss_get_table_fields ( $tablename );
	foreach ( $fields as $field ) {
		echo "<th>{$field}</th>";
	}
	echo "</tr>";
	foreach ( $changeset as $changelog ) {
		echo "<tr>";
		foreach ( iss_parent_table_fields () as $field ) {
			echo "<td>";
			if ($field == 'ParentID')
				echo $parentid;
			if ($field == 'StudentID')
				echo $studentid;
			foreach ( $changelog as $key => $value ) {
				if ($field == $key) {
					echo $value;
				}
			}
			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
}*/
?>
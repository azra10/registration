<?php


/**
 * Function iss_field_type
 * Find field type substitue for wpdb input
 * 
 * @param
 *        	field name
 * @return string type substitute
 *        
 */
function iss_field_type($field) {
	$list = iss_fields_types ();
	if ($list [$field] == 'string')
		return '%s';
	if ($list [$field] == 'int')
		return '%d';
	if ($list [$field] == 'date')
		return '%s';
	if ($list [$field] == 'text')
		return '%s';
	if ($list [$field] == 'float')
		return '%f';
	if ($list [$field] == 'registrationyear')
		return '%s';
}
/**
 * Function iss_field_type
 * VAlidate field value as per its type
 * 
 * @param
 *        	field name, fieldvalue, reference of error array, field prefix for error
 * @return none
 *
 */
function iss_field_valid($field, $inputval, &$errors, $prefix) {
	$errorfield = $prefix . $field;
	if (($inputval == 'new') && (($field == 'ParentID') || ($field == 'StudentID')))
		return true;
	
	$fields_with_lengths = iss_fields_lengths ();
	$fields_with_types = iss_fields_types ();
	$displaynames = iss_field_displaynames ();
	// / REQUIRED FIELD ERRORS
	if (in_array ( $field, iss_required_fields () ) && empty ( $inputval )) {
		$errors [$errorfield] = "{$displaynames[$field]} is required.";
		return false;
	}
		
	// / VALIDATION ERRORS
	if (! empty ( $inputval )) {		
	   if (strlen ( $inputval ) > $fields_with_lengths [$field]) {
			$errors [$errorfield] = "{$displaynames[$field]} is too long ($fields_with_lengths[$field]).";
			return false;
		}
			
		if ($fields_with_types [$field] == 'int') {
			if(!check_int_string($inputval)) {
				$errors [$errorfield] = "{$displaynames[$field]} is not a valid integer.";
				return false;
			}
		}
		if (($fields_with_types [$field] == 'date')  &&
			!check_date_string($inputval)){
				$errors [$errorfield] = "{$displaynames[$field]} is a not valid date (yyyy-mm-dd).";
				return false;
		}
		
		if (($fields_with_types [$field] == 'float')  && 
			!check_double_string ( $inputval )) {
				$errors [$errorfield] = "{$displaynames[$field]} is not a valid amount.";
				return false;
		}

		if (($fields_with_types [$field] == 'registrationyear')  && 
			!check_registrationyear_string($inputval)){
				$errors [$errorfield] = "{$displaynames[$field]} is not a valid.";
				return false;			
		}
		if ($fields_with_types [$field] == 'datetime') {
			return check_datetime_string($inputval);
		}
	}
	return true;
}
function check_date_string($inputval){
	$y = 0;
	$m = 0;
	$d = 0;
	$list = explode ( "-", $inputval );
	$count = count ( $list );
	if ($count > 0)
		$y = intval ( $list [0] );
	if ($count > 1)
		$m = intval ( $list [1] );
	if ($count > 2)
		$d = intval ( $list [2] );
	if (checkdate ( $m, $d, $y )) {
		return true;
	}
	return false;
}
function check_registrationyear_string($inputval){
	$list = explode ( "-", $inputval );
	$count = count ( $list );
	$y1int = 0;
	$y2int = 0;
	if ($count > 0)
		$y1int = intval ( $list [0] );
	if ($count > 1)
		$y2int = intval ( $list [1] );
	$y3int = $y1int + 1;
	if (($y1int === 0) || ($y2int === 0) || ($y3int != $y2int)) {
		return false;
	}
	return true;
}
function check_datetime_string($inputval){
	$format = 'Y-m-d H:i:s';
	$input = trim ( $inputval );
	$time = strtotime ( $input );
	$newdate = date ( $format, $time );
	if ($newdate === $inputval)
		return true;
	return false;
}
function check_int_string($str){
 if (($str === '0') || ($str===0) || (intval($str)>0)) 
 	return true;

	return false;
}
function check_double_string($str){
 if (($str === '0.00') || check_int_string($str) || (floatval($str)>0)) return true;
//  $pairs = explode('.',$str);
//  if ( is_array($pairs) && count($pairs)==2) {
//    return ( is_numeric($pairs[0]) && is_numeric($pairs[1]))? true : false; 
//  }
 return false;
}

?>
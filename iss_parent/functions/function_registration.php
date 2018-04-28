<?php

/** PREPARE NEXT YEAR REGISTRATION */

/**
 * Function iss_last_registration_year
 * Finds the last registration year in payment table
 * 
 * @param
 *        	none
 * @return string last registration year
 *        
 */
function iss_last_registration_year() {
	global $wpdb;
	$parents = iss_get_table_name ( "parents" );
	$query = "SELECT MAX(RegistrationYear) as RegistrationYear FROM {$parents} LIMIT 1";
	$result_set = $wpdb->get_row ( $query, ARRAY_A );
	
	$regyear = NULL;
	if ($result_set != NULL) {
		$regyear = $result_set ['RegistrationYear'];
	}
	return $regyear;
}
/**
 * Function iss_next_registration_year
 * Finds the last registration year in payment table and appends an year
 * 
 * @param
 *        	none
 * @return string next registration year
 *        
 */
function iss_next_registration_year() {
	global $wpdb;
	$parents = iss_get_table_name ( "parents" );
	$query = "SELECT MAX(RegistrationYear) as RegistrationYear FROM {$parents} LIMIT 1";
	$result_set = $wpdb->get_row ( $query, ARRAY_A );
	
	$regyear = NULL;
	if ($result_set != NULL) {
		$regyear = $result_set ['RegistrationYear'];
	}
	if ($regyear == NULL)
		return NULL;
	
	list ( $y1, $y2 ) = explode ( "-", $regyear );
	$y1int = intval ( $y1 );
	$y2int = intval ( $y2 );
	$nextregyear = $y2 . '-' . ($y2int + 1);
	return $nextregyear;
}
function iss_previous_issgrade($issgrade) {
	switch ($issgrade) {
		case '1' :
			return 'KG';
			break;
		case '2' :
			return '1';
			break;
		case '3' :
			return '2';
			break;
		case '4' :
			return '3';
			break;
		case '5' :
			return '4';
			break;
		case '6' :
			return '5';
			break;
		case '7' :
			return '6';
			break;
		case '8' :
			return '7';
			break;
		case 'KG' :
			return '0';
			break;
		case 'YG' :
			return '8';
			break;
		case 'YB' :
			return '8';
			break;
		default :
			return $issgrade;
	}
}
function iss_next_issgrade($issgrade, $gender, $regularschoolgrade) {
	switch ($issgrade) {
		case '1' :
			return '2';
			break;
		case '2' :
			return '3';
			break;
		case '3' :
			return '4';
			break;
		case '4' :
			return '5';
			break;
		case '5' :
			return '6';
			break;
		case '6' :
			return '7';
			break;
		case '7' :
			return '8';
			break;
		case '8' :
			return ($gender == 'F') ? 'YG' : 'YB';
			break;
		case 'KG' :
			return '1';
			break;
		case 'YG' :
			return ($regularschoolgrade == '10') ? 'XX' : 'YG';
			break;
		case 'YB' :
			return ($regularschoolgrade == '10') ? 'XX' : 'YB';
			break;
		default :
			return $issgrade;
	}
}
function iss_next_regularschoolgrade($regularschoolgrade) {
	switch ($regularschoolgrade) {
		case '1' :
			return '2';
			break;
		case '2' :
			return '3';
			break;
		case '3' :
			return '4';
			break;
		case '4' :
			return '5';
			break;
		case '5' :
			return '6';
			break;
		case '6' :
			return '7';
			break;
		case '7' :
			return '8';
			break;
		case '8' :
			return '9';
			break;
		case '9' :
			return '10';
			break;
		case '10' :
			return '11';
			break;
		case 'KG' :
			return '1';
			break;
		default :
			return $regularschoolgrade;
	}
}

/**
 * Function iss_calculate_total_amount_due
 * Returns the total amount due for a given parent
 *
 *  @param parentid
 *  @return dollar amount for fee
*/
function iss_calculate_total_amount_due($parentid){
	global $wpdb;
	
	$table = iss_get_table_name ( "student" );
	$query =  "SELECT COUNT(*) as total FROM {$table}  
    	WHERE StudentStatus='active' and ParentID='{$parentid}'";
	$result = $wpdb->get_results ( $query, ARRAY_A );
	
	$fee = 0.00;
	$count = intval($result[0]['total']);
	if ($count === 1){
		$fee = iss_adminpref_registrationfee_firstchild();
	} else if ($count > 1){
		$fee = iss_adminpref_registrationfee_firstchild() +
		   ($count-1) * iss_adminpref_registrationfee_sibling();		
	}
	iss_write_log('iss_calculate_total_amount_due: parendid:' . $parentid . 'student count'  . $count. ' fee :' . $fee);
			
	return $fee;
}


/**  DIRECT REGISTRATION function */
 /**
 * Function iss_get_parent_by_code
 * Get parent record by registration code
 * 
 * @param
 *        	code
 * @return parent record or NULL
 *        
 */
function iss_get_parent_by_code($code) {
	global $wpdb;
	$date = current_time ( 'mysql' );
	
	$parents = iss_get_table_name ( "parents" );
	$query = $wpdb->prepare ( "SELECT * FROM {$parents} WHERE RegistrationCode = '%s' and
    '{$date}' <= RegistrationExpiration and RegistrationComplete = 'Open' LIMIT 1", $code );
	$row = $wpdb->get_row ( $query, ARRAY_A );
	if ($row != NULL) {
		return $row;
	}
	return NULL;
}
function iss_get_parent_registration_code($parentviewid) {
	global $wpdb;
	$table = iss_get_table_name ( "parents" );
	$code = iss_registration_code ();
	$edate = iss_registration_expirydate ();
	$result = $wpdb->update ( $table, array (
			'RegistrationCode' => $code,
			'RegistrationExpiration' => $edate,
			'RegistrationComplete' => 'Open' 
	), array (
			'ParentViewID' => $parentviewid 
	), array (
			'%s',
			'%s',
			'%s' 
	), array (
			'%d' 
	) );

	if (1 === $result) return $code;
	return NULL;
}
/**
 * Function iss_registration_expirydate
 * Returns an expiry date using the admin preference for open registration days
 * 
 * @param
 *        	none
 * @return expirty date
 *        
 */
function iss_registration_expirydate() {
	$date = current_time ( 'mysql' );
	$delay = ' + ' . iss_adminpref_openregistrationdays () . 'days';
	$cur_dat = date ( 'Y-m-d H:i:s', strtotime ( $date . $delay ) );
	return $cur_dat;
}
function iss_registration_code() {
	return getToken ( 20 );
}
function crypto_rand_secure($min, $max) {
	$range = $max - $min;
	if ($range < 1)
		return $min; // not so random...
	$log = ceil ( log ( $range, 2 ) );
	$bytes = ( int ) ($log / 8) + 1; // length in bytes
	$bits = ( int ) $log + 1; // length in bits
	$filter = ( int ) (1 << $bits) - 1; // set all lower bits to 1
	do {
		$rnd = hexdec ( bin2hex ( openssl_random_pseudo_bytes ( $bytes ) ) );
		$rnd = $rnd & $filter; // discard irrelevant bits
	} while ( $rnd > $range );
	return $min + $rnd;
}
function getToken($length) {
	$token = "";
	$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
	$codeAlphabet .= "0123456789";
	$max = strlen ( $codeAlphabet ); // edited
	
	for($i = 0; $i < $length; $i ++) {
		$token .= $codeAlphabet [crypto_rand_secure ( 0, $max - 1 )];
	}
	
	return $token;
}

/** Miscellaneous */


/**
 * Function iss_registration_period
 * Find user / admin preference or default registration year
 * 
 * @param
 *        	none
 * @return string registration year
 *        
 */
function iss_registration_period() {
	$regyear = iss_userpref_registrationyear ();
	if (NULL == $regyear) {
		$regyear = iss_adminpref_registrationyear ();
	}
	return $regyear;
}
/**
 * Function iss_userpref_registrationyear
 * Find user preference registration year in user meta data
 * 
 * @param
 *        	none
 * @return string registration year
 *        
 */
function iss_userpref_registrationyear() {
	$list = iss_get_user_option_list ();
	if (isset ( $list ['iss_user_registrationyear'] ) && 
		isset ( $list ['iss_user_registrationyear'] [0] ) && 
		! empty ( $list ['iss_user_registrationyear'] [0] ) ) {
		return $list ['iss_user_registrationyear'] [0];
	}
	return NULL;
}

/**
 * Function iss_get_user_option_list
 * Get user preferences array
 * 
 * @param
 *        	none
 * @return array of key/valueArray pairs
 *         Ex: $returnlog['iss_user_registrationyear'][0]
 *        
 */
function iss_get_user_option_list() {
	$user_id = get_current_user_id ();
	return get_user_meta ( $user_id );
}
/**
 * Function iss_set_user_option_list
 * Set User preferences
 * 
 * @param
 *        	changelog array of key/value pairs
 *        	Ex: $changelog = array ('iss_user_registrationyear' => '2010-2011');
 * @return none
 *
 */
function iss_set_user_option_list($option,$inputval) {
	iss_write_log ( "iss_set_user_option_list {$option} {$inputval}" );
	
	$changelog = array ();
	$changelog [$option] = $inputval;
				
	$user_id = get_current_user_id ();
	foreach ( $changelog as $field => $value ) {
		update_user_meta ( $user_id, $field, $value );
	}
}
?>
<?php

function iss_valid_tabname($tabname) {
	switch ($tabname) {
		case 'parent' :
		case 'contact' :
		case 'complete' :
		case 'home' :
		case 'view' :
			return true;
		default :
			if (strpos ( $tabname, "student", 0 ) === 0)
				return true;
	}
	return false;
}
function iss_get_requiredfields_by_tabname($tabname) {
	switch ($tabname) {
		case 'parent' :
			return iss_parent_required_tabfields ();
		case 'home' :
			return iss_home_required_tabfields ();
		case 'contact' :
			return iss_contact_required_tabfields ();
		case 'complete' :
			return array ();
		default :
			if (strpos ( $tabname, "student", 0 ) === 0) {
				return iss_student_required_fields ();
			}
	}
	return array ();
}
function iss_get_tabfields_by_tabname($tabname) {
	switch ($tabname) {
		case 'parent' :
			return iss_parent_tabfields ();
			break;
		case 'home' :
			return iss_home_tabfields ();
			break;
		case 'contact' :
			return iss_contact_tabfields ();
			break;
		case 'complete' :
			return iss_payment_tabfields ();
			break;
		default :
			if (strpos ( $tabname, "student", 0 ) === 0) {
				return iss_student_fields ();
			}
	}
	return array ();
}
/**
 * Function iss_get_next_tab
 * Find next or default tab name to show to user
 * 
 * @param
 *        	current showing tab could be null
 * @return string tab name
 *        
 */
function iss_get_next_tab($current_tab) {
	if ($current_tab == 'parent') {
		return 'home';
	} else if ($current_tab == 'home') {
		return 'contact';
	} else if ($current_tab == 'contact') {
		return 'student';
	} else if ($current_tab == 'student') {
		return 'complete';
	} else if ($current_tab == 'complete') {
		return 'view';
	} else
		return "view";
}
?>
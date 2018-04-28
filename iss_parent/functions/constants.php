<?php
// / TABLE FIELDS BEGIN
function iss_get_table_fields($name) {
	global $wpdb;
	
	if ($name == "registration") {
		return iss_registration_table_fields ();
	} elseif ($name == "payment") {
		return iss_payment_table_fields ();
	} elseif ($name == "parent") {
		return iss_parent_table_fields ();
	} elseif ($name == "student") {
		return iss_student_table_fields ();
	} else {
		iss_write_log ( "iss_get_table_fields: Unknown table name {$name}" );
		return NULL;
	}
}
function iss_parent_table_fields() {
	global $iss_parent_table_fieldnames;
	if ($iss_parent_table_fieldnames == NULL) {
		$iss_parent_table_fieldnames = array_merge ( iss_parent_tabfields (), iss_home_tabfields (), iss_contact_tabfields () );
		unset ( $iss_parent_table_fieldnames ['RegistrationYear'] );
	}
	return $iss_parent_table_fieldnames;
}
function iss_payment_table_fields() {
	global $iss_registration_table_fieldnames;
	if ($iss_registration_table_fieldnames == NULL)
		$iss_registration_table_fieldnames = array_merge ( array (
				"ParentID",
				"RegistrationYear" 
		), iss_payment_tabfields () );
	return $iss_registration_table_fieldnames;
}
function iss_student_table_fields() {
	global $iss_student_table_fieldnames;
	if (NULL == $iss_student_table_fieldnames)
		$iss_student_table_fieldnames = array (
				"StudentFirstName",
				"StudentLastName",
				"StudentBirthDate",
				"StudentGender",
				"StudentStatus",
				"StudentEmail",
				"StudentNew",
				"ParentID",
				"StudentID" 
		);
	return $iss_student_table_fieldnames;
}
function iss_registration_table_fields() {
	return array (
			"StudentID",
			"RegistrationYear",
			"RegularSchoolGrade",
			"ISSGrade" 
	);
}
function iss_changelog_table_fields() {
	return array (
			"ParentID",
			"StudentID",
			"FieldName",
			"FieldValue" 
	);
}
// / TABLE FIELDS END
function iss_required_fields() {
	global $iss_all_required_fieldnames;
	if (NULL == $iss_all_required_fieldnames)
		$iss_all_required_fieldnames = array_merge ( iss_parent_required_tabfields (), iss_home_required_tabfields (), iss_contact_required_tabfields (), iss_student_required_fields () );
	return $iss_all_required_fieldnames;
}
function iss_parent_fields() {
	global $iss_all_parent_fieldnames;
	if ($iss_all_parent_fieldnames == NULL)
		$iss_all_parent_fieldnames = array_merge ( iss_parent_tabfields (), iss_home_tabfields (), iss_contact_tabfields (), iss_payment_tabfields () );
	return $iss_all_parent_fieldnames;
}
function iss_student_fields() {
	global $iss_student_tabfieldnames;
	if (NULL == $iss_student_tabfieldnames)
		$iss_student_tabfieldnames = array_merge ( iss_student_required_fields (), array (
				"StudentEmail", "StudentNew" 
		) );
	return $iss_student_tabfieldnames;
}
function iss_student_required_fields() {
	global $iss_student_required_tabfieldnames;
	if (NULL == $iss_student_required_tabfieldnames)
		$iss_student_required_tabfieldnames = array (
				"StudentFirstName",
				"StudentLastName",
				"RegularSchoolGrade",
				"ISSGrade",
				"StudentBirthDate",
				"StudentGender",
				"StudentStatus",
				"ParentID",
				"StudentID",
				"RegistrationYear" 
		);
	return $iss_student_required_tabfieldnames;
}
function iss_parent_tabfields() {
	return array_merge ( iss_parent_required_tabfields (), array (
			"FatherWorkPhone",
			"FatherEmail",
			"MotherWorkPhone",
			"MotherEmail",
			"MotherCellPhone",
			"FamilySchoolStartYear",
			"ParentNew" 
	) );
}
function iss_parent_required_tabfields() {
	return array (
			"ParentID",
			"ParentStatus",
			"SchoolEmail",
			"RegistrationYear",
			"FatherFirstName",
			"FatherLastName",
			"FatherCellPhone",
			"MotherFirstName",
			"MotherLastName"
	);
}
function iss_home_tabfields() {
	return array_merge ( iss_home_required_tabfields (), array (
			"MotherStreetAddress",
			"MotherCity",
			"MotherZip",
			"MotherHomePhone" 
	) );
}
function iss_home_required_tabfields() {
	return array (
			"HomeStreetAddress",
			"HomeCity",
			"HomeZip",
			"HomePhone",
			"ShareAddress",
			"TakePicture" 
	);
}
function iss_contact_tabfields() {
	return array_merge ( iss_contact_required_tabfields (), array (
			"SpecialNeedNote" 
	) );
}
function iss_contact_required_tabfields() {
	return array (
			"EmergencyContactName1",
			"EmergencyContactPhone1",
			"EmergencyContactName2",
			"EmergencyContactPhone2" 
	);
}
function iss_complete_required_tabfields() {
	return array_merge ( iss_parent_required_tabfields (), iss_home_required_tabfields (), iss_contact_required_tabfields () );
}
function iss_payment_tabfields() {
	return array (
			"RegistrationCode",
			"RegistrationExpiration",
			"RegistrationComplete",
			"PaymentInstallment1",
			"PaymentMethod1",
			"PaymentDate1",
			"PaymentInstallment2",
			"PaymentMethod2",
			"PaymentDate2",
			"TotalAmountDue",
			"FinancialAid",
			"PaidInFull",
			"Comments" 
	);
}
function iss_field_displaynames() {
	global $iss_field_displaynames_;
	if ($iss_field_displaynames_ == NULL)
		$iss_field_displaynames_ = array (
				"ParentID" => "ParentID",
				"ParentStatus" => "Parent Status",
				"ParentNew" => "Parent New",
				"RegistrationYear" => "Registration Period",
				"created" => "Create Date",
				"updated" => "Last Update Date",
				
				"FatherFirstName" => "Father First Name",
				"FatherLastName" => "Father Last Name",
				"FatherEmail" => "Father Email",
				"FatherWorkPhone" => "Father Work Phone",
				"FatherCellPhone" => "Father Cell Phone",
				"SchoolEmail" => "School Email",
				"FamilySchoolStartYear" => "Family School Start Year",
				"MotherFirstName" => "Mother First Name",
				"MotherLastName" => "Mother Last Name",
				"MotherEmail" => "Mother Email",
				"MotherWorkPhone" => "Mother Work Phone",
				"MotherCellPhone" => "Mother Cell Phone",
				
				"HomeStreetAddress" => "Home Street Address",
				"HomeCity" => "Home City",
				"HomeZip" => "Home Zip",
				"HomePhone" => "Home Phone",
				"MotherStreetAddress" => "Mother Street Address",
				"MotherCity" => "Mother City",
				"MotherZip" => "Mother Zip",
				"MotherHomePhone" => "Mother Home Phone",
				"ShareAddress" => "Share Address",
				"TakePicture" => "Take Picture",
				
				"EmergencyContactName1" => "Emergency Contact Name1",
				"EmergencyContactPhone1" => "Emergency Contact Phone 1",
				"EmergencyContactName2" => "Emergency Contact Name 2",
				"EmergencyContactPhone2" => "Emergency Contact Phone 2",
				
				"RegistrationComplete" => "Registration Complete",
				"RegistrationCode" => "Registration Code",
				"RegistrationExpiration" => "Registration Expiration Date",
				"SpecialNeedNote" => "Special Need Note",
				"Comments" => "Comments",
				"PaymentInstallment1" => "Payment Installment 1",
				"PaymentMethod1" => "Payment Method 1",
				"PaymentDate1" => "Payment Date 1",
				"TotalAmountDue" => "Total Amount Due",
				"FinancialAid" => "Financial Aid",
				"PaymentInstallment2" => "Payment Installment 2",
				"PaymentMethod2" => "Payment Method 2",
				"PaymentDate2" => "Payment Date 2",
				"PaidInFull" => "Paid In Full",
				
				"StudentID" => "StudentID",
				"StudentFirstName" => "Student First Name",
				"StudentLastName" => "Student Last Name",
				"RegularSchoolGrade" => "Regular School Grade",
				"ISSGrade" => "Islamic School Grade",
				"StudentStatus" => "Student Status",
				"StudentNew" => "Student New",
				"StudentEmail" => "Student Email",
				"StudentBirthDate" => "Student Birth Date",
				"StudentGender" => "Student Gender",
				"created" => "Create Date",
				"updated" => "Last Update Date" 
		);
	return $iss_field_displaynames_;
}
function iss_fields_lengths() {
	global $iss_field_lengths_;
	if ($iss_field_lengths_ == NULL)
		$iss_field_lengths_ = array (
				"ParentID" => 11,
				"RegistrationYear" => 10,
				"ParentStatus" => 10,
				"ParentNew" => 3,
				"FatherFirstName" => 100,
				"FatherLastName" => 100,
				"FatherEmail" => 100,
				"FatherWorkPhone" => 20,
				"FatherCellPhone" => 20,
				"MotherFirstName" => 100,
				"MotherLastName" => 100,
				"MotherEmail" => 100,
				"MotherWorkPhone" => 20,
				"MotherCellPhone" => 20,
				"SchoolEmail" => 100,
				"FamilySchoolStartYear" => 10,
				
				"created" => 20,
				"updated" => 20,
				"HomeStreetAddress" => 200,
				"HomeCity" => 100,
				"HomeZip" => 5,
				"HomePhone" => 20,
				"MotherStreetAddress" => 200,
				"MotherCity" => 100,
				"MotherZip" => 5,
				"MotherHomePhone" => 20,
				"ShareAddress" => 5,
				"TakePicture" => 5,
				
				"EmergencyContactName1" => 100,
				"EmergencyContactPhone1" => 20,
				"EmergencyContactName2" => 100,
				"EmergencyContactPhone2" => 20,
				
				"RegistrationComplete" => 10,
				"RegistrationCode" => 100,
				"RegistrationExpiration" => 10,
				"PaymentInstallment1" => 10,
				"PaymentMethod1" => 20,
				"PaymentDate1" => 10,
				"PaymentDate2" => 10,
				"TotalAmountDue" => 9,
				"FinancialAid" => 3,
				"PaymentInstallment2" => 10,
				"PaymentMethod2" => 20,
				"PaymentDate2" => 10,
				"Comments" => 300,
				"PaidInFull" => "3",
				"SpecialNeedNote" => 300,
				
				"StudentID" => 11,
				"StudentFirstName" => 100,
				"StudentLastName" => 100,
				"RegularSchoolGrade" => 2,
				"ISSGrade" => 2,
				"StudentEmail" => 100,
				"StudentBirthDate" => 10,
				"StudentGender" => 1,
				"StudentStatus" => 10,
				"StudentNew" => 3				
		);
	return $iss_field_lengths_;
}
function iss_fields_types() {
	global $iss_field_types_;
	if (NULL == $iss_field_types_)
		$iss_field_types_ = array (
				"ParentID" => "int",
				"RegistrationYear" => "registrationyear",
				"created" => "datetime",
				"updated" => "datetime",
				"ParentStatus" => "string",
				"ParentNew" => "string",
				"FatherFirstName" => "string",
				"FatherLastName" => "string",
				"FatherEmail" => "string",
				"FatherWorkPhone" => "string",
				"FatherCellPhone" => "string",
				"MotherFirstName" => "string",
				"MotherLastName" => "string",
				"MotherEmail" => "string",
				"MotherWorkPhone" => "string",
				"MotherCellPhone" => "string",
				"SchoolEmail" => "string",
				
				"HomeStreetAddress" => "string",
				"HomeCity" => "string",
				"HomeZip" => "int",
				"HomePhone" => "string",
				"MotherStreetAddress" => "string",
				"MotherCity" => "string",
				"MotherZip" => "int",
				"MotherHomePhone" => "string",
				"ShareAddress" => "string",
				"TakePicture" => "string",
				
				"EmergencyContactName1" => "string",
				"EmergencyContactPhone1" => "string",
				"EmergencyContactName2" => "string",
				"EmergencyContactPhone2" => "string",
				
				"RegistrationComplete" => "string",
				"RegistrationCode" => "string",
				"RegistrationExpiration" => "date",
				"SpecialNeedNote" => "text",
				"PaymentInstallment1" => "float",
				"PaymentMethod1" => "string",
				"PaymentDate1" => "date",
				"TotalAmountDue" => "float",
				"FinancialAid" => "string",
				"PaymentInstallment2" => "float",
				"PaymentMethod2" => "string",
				"PaymentDate2" => "date",
				"Comments" => "string",
				"FamilySchoolStartYear" => "string",
				"PaidInFull" => "string",
				
				"StudentID" => "int",
				"StudentFirstName" => "string",
				"StudentLastName" => "string",
				"RegularSchoolGrade" => "string",
				"ISSGrade" => "string",
				"StudentEmail" => "string",
				"StudentBirthDate" => "date",
				"StudentGender" => "string",
				"StudentStatus" => "string",
				"StudentNew" => "string",				
				"ChangeSetID" => "string" 
		);
	return $iss_field_types_;
}

?>
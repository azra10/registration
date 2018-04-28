<?php

/*
 * Plugin Name: ISS Registeration For Next Year
 * Description: Prepare all active parents and student for next year registration.
 * Version: 1.0.0
 * Author: Azra Syed
 * Text Domain: iss
 */

/**
 * Main plugin class
 *
 * @since 0.1
 *       
 */
class ISS_Registation {
	private $errorstring;
	private $nextregyear;
	private $prevregyear;
	private $messages;
	/**
	 * Class contructor
	 *
	 * @since 0.1
	 *       
	 */
	public function __construct() {
		add_action ( 'admin_menu', array (
				$this,
				'add_registration_page' 
		) );
		add_action ( 'init', array (
				$this,
				'registration_page_action' 
		) );
		
		$this->prevregyear = iss_last_registration_year ();
		if (NULL == $this->prevregyear)
			$this->errorstring = 'Previous registration year suggestions not available!';
		$this->nextregyear = iss_next_registration_year ();
		if (NULL == $this->nextregyear)
			$this->errorstring = 'Next registration year suggestions not available!';
		$this->messages = array ();
	}
	
	/**
	 * Add administration menus
	 *
	 * @since 0.1
	 *       
	 */
	public function add_registration_page() {
		add_menu_page ( __ ( 'Prepare Next Year', 'iss_registration_text' ), __ ( 'Prepare Next Year', 'iss_registration_text' ), 'iss_admin', 'iss_registration_text', array (
				$this,
				'users_page' 
		), 'dashicons-migrate', 8 );
	}
	
	/**
	 * Process content of CSV file
	 *
	 * @since 0.1
	 *       
	 */
	public function registration_page_action() {
		if (isset ( $_POST ['_wpnonce-iss-registration-page'] )) {
			check_admin_referer ( 'iss-registration-page', '_wpnonce-iss-registration-page' );
			
			if (! isset ( $_POST ['NextRegistrationYear'] ) || empty ( $_POST ['NextRegistrationYear'] )) {
				$this->errorstring = "Aborted: Next Registration Year is required.";
				return;
			}
			
			$this->nextregyear = iss_sanitize_input ( $_POST ['NextRegistrationYear'] );
			$errors = array ();
			if (! iss_field_valid ( 'RegistrationYear', $this->nextregyear, $errors, '' )) {
				$this->errorstring = "Aborted: Next Registration Year is not valid.";
				return;
			}
			if (! isset ( $_POST ['PrevRegistrationYear'] ) || empty ( $_POST ['PrevRegistrationYear'] )) {
				$this->errorstring = "Aborted: Previous Registration Year is required.";
				return;
			}
			
			$this->prevregyear = iss_sanitize_input ( $_POST ['PrevRegistrationYear'] );
			if (! iss_field_valid ( 'RegistrationYear', $this->prevregyear, $errors, '' )) {
				$this->errorstring = "Aborted: Previous Registration Year is not valid.";
				return;
			}
			
			$this->errorstring = "Registration Year:: Previous:{$this->prevregyear}  Next:{$this->nextregyear}";
			iss_write_log ( $this->errorstring );
			$parents = iss_get_parents_complete_list ( $this->prevregyear );
			if ((NULL == $parents) || (count ( $parents ) == 0)) {
				$this->errorstring = "<br>Aborted: Parent records not found in previous registration year.";
				return;
			}			
			foreach ( $parents as $parent ) {
				$registration = array ();
				$registration ['ParentID'] = $parent ['ParentID'];
				$registration ['RegistrationYear'] = $this->nextregyear;
				$registration['TotalAmountDue'] = iss_calculate_total_amount_due($parent['ParentID']);
				$registration['PaidInFull'] = 'No';
				$registration['RegistrationComplete'] = 'Open';
				if (iss_payment_insert ( $registration ) == false)
				{	$this->messages [] = "<br>Parent Skipped PID: {$parent['ParentID']}";}
				else 
				{	iss_parent_student_update_new($parent ['ParentID'], 'No');}
			}

			$students = iss_get_students_list ( $this->prevregyear, "*" );
			if ((NULL == $students) || (count ( $students ) == 0)) {
				$this->errorstring = "<br>Aborted: Student records not found in previous registration year.";
				return;
			}
			foreach ( $students as $student ) {
				$class = array ();
				$class ['ParentID'] = $student ['ParentID'];
				$class ['StudentID'] = $student ['StudentID'];
				$class ['RegistrationYear'] = $this->nextregyear;
				$class ['ISSGrade'] = iss_next_issgrade ( $student ['ISSGrade'], $student ['StudentGender'], $student ['RegularSchoolGrade'] );
				$class ['RegularSchoolGrade'] = iss_next_regularschoolgrade ( $student ['RegularSchoolGrade'] );
				
				if (iss_registration_insert ( $class ) == false)
					$this->messages [] = "Student Skipped PID: {$student['StudentID']}<br>";
			}
			$this->errorstring = "<p><strong>Registration Completed</strong></p>";
			return;
		}
	}
	
	/**
	 * Content of the settings page
	 *
	 * @since 0.1
	 *       
	 */
	public function users_page() {
		if (! iss_current_user_can_admin())
			wp_die ( __ ( 'You do not have sufficient permissions to access this page.', 'iss_registration_text' ) );
		?>

<div class="wrap">
	<h2><?php _e( 'Prepare Registration for Next Year', 'iss_registration_text' ); ?></h2>
    <?php
		if (isset ( $_GET ['error'] )) {
			echo '<div class="updated"><p><strong>' . __ ( 'Error occured.', 'iss_registration_text' ) . '</strong></p></div>';
		}
		
		?>
      <form method="post" action="" enctype="multipart/form-data">
        <?php wp_nonce_field( 'iss-registration-page', '_wpnonce-iss-registration-page' ); ?>
          <table class="form-table">
			<tr valign="top">
				<th scope="row"><label>Prevous Registration Year</label></th>
				<td><input name="PrevRegistrationYear" id="PrevRegistrationYear"
					class="form-control" type="text" title="Previous Registration Year"
					required value="<?php echo $this->prevregyear;?>"></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label>Next Registration Year</label></th>
				<td><input name="NextRegistrationYear" id="NextRegistrationYear"
					class="form-control" type="text" title="Next Registration Year"
					required value="<?php echo $this->nextregyear;?>"></td>
			</tr>

		</table>
		<p class="submit">
			<input type="hidden" name="_wp_http_referer"
				value="<?php echo $_SERVER['REQUEST_URI'] ?>" /> <input
				type="submit" class="button-primary"
				value="<?php _e( 'Create', 'iss_registration_text' ); ?>" />
		</p>
		<div class="updated">
			<strong><?php echo  __($this->errorstring, 'iss_userpref_text' ); ?> </strong>
		</div>

	</form>
	<p>Preparing for the next registration year involves copying all active
		parents and students to the new registration year.</p>
	<p>If the registration was already run ones then it will skip repeating
		the process.</p>
	<p>Run it again if you think the job did not complete.</p>
</div>
<?php
		foreach ( $this->messages as $msg )
			echo "{$msg} <br/>";
	}
}
new ISS_Registation ();
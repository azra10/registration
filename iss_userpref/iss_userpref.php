<?php
/*
 * Plugin Name: ISS User Preferences
 * Description: Save user preferencess.
 * Version: 1.0.0
 * Author: Azra Syed
 * Text Domain: iss_user_pref
 */
class ISS_UserPreferencePlugin {
	private $errorstring;
	
	/**
	 * Start up
	 */
	public function __construct() {
		add_action ( 'admin_menu', array (
				$this,
				'add_plugin_page' 
		) );
		add_action ( 'init', array (
				$this,
				'add_plugin_page_action' 
		) );
	}
	public function add_plugin_page() {
		add_menu_page ( 'iss_userpref', 'User Preference', 'iss_board', 'user_home', array (
				$this,
				'users_page' 
		), 'dashicons-admin-customizer', 6 );
	}
	public function add_plugin_page_action() {		
		// / IF FORM POST REQUEST
		if (isset ( $_POST ['_wpnonce-iss-user-specific-preferences'] )) {
			check_admin_referer ( 'iss-user-specific-preferences', '_wpnonce-iss-user-specific-preferences' );
			if (isset ( $_POST ['iss_user_registrationyear'] )) {
				$inputval = iss_sanitize_input ( $_POST ['iss_user_registrationyear'] );
			}
			
			$error = array ();
			if (strlen($inputval) != 0) // allow removing value
			{iss_field_valid ( 'RegistrationYear', $inputval, $errors, '' );}
						
			// CONSOLIDATE ERRORS
			if (! empty ( $errors )) {
				$this->errorstring = '';
				foreach ( $errors as $field => $error )
					$this->errorstring = $this->errorstring . $error . '<br/>'; // REMOVE LATER
						                                                                                                   // echo $errorstring; //ISS TEST
			} else // / UPDATE DB start
			{
				iss_set_user_option_list ('iss_user_registrationyear', $inputval );
				$this->errorstring = "Changes saved.";
			}
		} // form post request
	}
	public function users_page() {
		if (! iss_current_user_on_board())
			wp_die ( __ ( 'You do not have sufficient permissions to access this page.', 'iss_userpref_text' ) );
		?>

<div class="wrap">
	<h2><?php _e( 'User Specific Preferences', 'iss_userpref_text' ); ?></h2>
   
    <?php
		if (isset ( $_GET ['error'] )) {
			echo '<div class="updated"><p><strong> User not logged in.</strong></p></div>';
		}
		$userregyear = iss_userpref_registrationyear();
		$regyearlist = iss_get_registrationyear_list ();
		?>
      <form class="form" method="post" action=""
		enctype="multipart/form-data">
        <?php wp_nonce_field( 'iss-user-specific-preferences', '_wpnonce-iss-user-specific-preferences' ); ?>
           <table class="form-table">
			<tr valign="top">
				<th scope="row"><label>Registration Year</label></th>
				<td>
				<?php if (sizeof($regyearlist) > 0) { ?>
					<select name="iss_user_registrationyear"
						id="iss_user_registrationyear" class="form-control"
						title="Choose Registration Year" required="">
							<option value="">Select Registration Year</option>
						<?php foreach ($regyearlist as $regyear) { ?>
					<option value="<?php echo $regyear['RegistrationYear'];?>" <?php echo ($regyear[ 'RegistrationYear']==$userregyear)? ' selected' : '';?> >
						<?php echo $regyear['RegistrationYear'];?>
					</option>
					<?php }  if (strlen($userregyear)>0) {?>
					<option value="<?php echo $userregyear;?>" selected><?php echo $userregyear;?></option>
					<?php }?>
					</select>
					<?php } else { ?>
						<input name="iss_user_registrationyear" max-length="9" size="50"
						id="iss_user_registrationyear" class="form-control"
						title="Enter Registration Year"  value="<?php echo $userregyear;?>">
					<?php } ?>
					<br/><span class="text-info">ex: 2016-2017</span>
			 </td>
			</tr>

		</table>

		<p class="submit">
			<input type="hidden" name="_wp_http_referer"
				value="<?php echo $_SERVER['REQUEST_URI'] ?>" /> <input
				type="submit" class="button-primary"
				value="<?php _e( 'Save Changes', 'iss_userpref_text' ); ?>" />
		</p>

		<div class="updated">
			<strong><?php echo  __($this->errorstring, 'iss_userpref_text' ); ?> </strong>
		</div>

	</form>
</div>
<?php
		if (isset ( $_GET ['error'] )) {
			echo '<div class="updated"><p><strong>' . __ ( 'Error Saving!', 'iss_userpref_text' ) . '</strong></p></div>';
		}
	}
}
$my_settings_page = new ISS_UserPreferencePlugin ();
?>
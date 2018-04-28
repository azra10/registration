<?php
/*
 * Plugin Name: ISS Admin Preferences
 * Description: Save admin preferences.
 * Version: 1.0.0
 * Author: Azra Syed
 * Text Domain: iss_adminpref
 */

/**
 * custom option and settings
 */
 /**
 * Function iss_get_school_name
 * Find admin preference or default school name
 * 
 * @param
 *        	none
 * @return string school name
 *        
 */
function iss_get_school_name() {
	$name = iss_adminpref_schoolname ();
	if (NULL == $name)
		$name = "School Name";
	return $name;
}
function iss_adminpref_schoolname() {
	$options = get_option ( 'iss_options' );
	
	if (isset ( $options ['iss_schoolname'] ) &&
		(strlen($options ['iss_schoolname'])>0))
	{	return $options ['iss_schoolname'];}
	return NULL;
}
function iss_adminpref_registrationyear() {
	$options = get_option ( 'iss_options' );
	
	if (isset ( $options ['iss_registrationyear'] ) &&
		(strlen($options ['iss_registrationyear']) > 0))
	{	
		$year = $options ['iss_registrationyear'];
		
		$errors = array ();
		$result = iss_field_valid ( 'RegistrationYear', $year, $errors, '' );
		
		if ($result == true)  { return $year; }
	}
	return NULL;
}
function iss_adminpref_registrationfee_installments() {
	$options = get_option ( 'iss_options' );

	if (isset ( $options ['iss_registrationfee_installments'] ) &&
		(intval($options ['iss_registrationfee_installments'])>0))
	{ return intval($options ['iss_registrationfee_installments']); }

	return 0;
}
function iss_adminpref_registrationfee_firstchild() {
	$options = get_option ( 'iss_options' );

	if (isset ( $options ['iss_registrationfee1'] ) &&
		(intval($options ['iss_registrationfee1'])>0))
	{ return intval($options ['iss_registrationfee1']); }

	return 0;
}
function iss_adminpref_registrationfee_firstchild_installment() {
	$options = get_option ( 'iss_options' );
	$installmetns = 1; 	$fee = 0;
	
	if (isset ( $options ['iss_registrationfee_installments'] ) &&
		(intval($options ['iss_registrationfee_installments'])>0))
	{ $installmetns = $options ['iss_registrationfee_installments'];}
      
	if (isset ( $options ['iss_registrationfee1'] ) &&
		(intval($options ['iss_registrationfee1'])>0))
	{ $fee = $options ['iss_registrationfee1'];}
	
	if ((intval($fee) >0) && (intval($installmetns)>0))
	 { return intval($fee / $installmetns);}

	return 0;
}
function iss_adminpref_registrationfee_sibling() {
	$options = get_option ( 'iss_options' );	
	      
	if (isset ( $options ['iss_registrationfee2'] ) &&
		(intval($options ['iss_registrationfee2'])>0))
	{ return intval($options ['iss_registrationfee2']); }
	
	return 0;
}
function iss_adminpref_registrationfee_sibling_installment() {
	$options = get_option ( 'iss_options' );	
	$installmetns = 1; 	$fee = 0;
	
	if (isset ( $options ['iss_registrationfee_installments'] ) &&
		(intval($options ['iss_registrationfee_installments'])>0))
	{ $installmetns = $options ['iss_registrationfee_installments'];}
      
	if (isset ( $options ['iss_registrationfee2'] ) &&
		(intval($options ['iss_registrationfee2'])>0))
	{ $fee = $options ['iss_registrationfee2'];}
	
	if ((intval($fee) >0) && (intval($installmetns)>0))
	 { return intval($fee / $installmetns);}

	return 0;
}
function iss_adminpref_openregistrationdays() {
	$options = get_option ( 'iss_options' );
	      
	if (isset ( $options ['iss_openregistrationperiod_days'] ) &&
		(intval($options ['iss_openregistrationperiod_days'])>0))
	{ return intval($options ['iss_openregistrationperiod_days']); }
	
	return 0;
}
function iss_settings_init() {
	// register a new setting for "adminpref" page
	register_setting ( 'adminpref', 'iss_options' );
	
	// register a new section in the "adminpref" page
	add_settings_section ( 'iss_registrationyear_section', __ ( '', 'adminpref' ), 'iss_registrationyear_section_cb', 'adminpref' );
	
	// register a new field in the "iss_registrationyear_section" section, inside the "adminpref" page
	add_settings_field ( 'iss_field0', __ ( 'School Name', 'adminpref' ), 'iss_textinput_field_cb', 'adminpref', 'iss_registrationyear_section', [ 
			'label_for' => 'iss_schoolname',
			'class' => 'iss_row',
			'iss_custom_data' => 'ex: Islamic School of Silicon Valley' 
	] );
	add_settings_field ( 'iss_field', // as of WP 4.6 this value is used only internally
	             // use $args' label_for to populate the id inside the callback
	__ ( 'Registration Year', 'adminpref' ), 'iss_registrationyear_field_cb', 'adminpref', 'iss_registrationyear_section', [ 
			'label_for' => 'iss_registrationyear',
			'class' => 'iss_row',
			'iss_custom_data' => 'ex: 2016-2017' 
	] );
	add_settings_field ( 'iss_field6', __ ( 'Installments', 'adminpref' ), 'iss_textinput_field_cb', 'adminpref', 'iss_registrationyear_section', [ 
			'label_for' => 'iss_registrationfee_installments',
			'class' => 'iss_row',
			'iss_custom_data' => 'ex: 2' 
	] );
	add_settings_field ( 'iss_field1', __ ( 'Registration Fee (first child)', 'adminpref' ), 'iss_textinput_field_cb', 'adminpref', 'iss_registrationyear_section', [ 
			'label_for' => 'iss_registrationfee1',
			'class' => 'iss_row',
			'iss_custom_data' => 'ex: 470' 
	] );
	// add_settings_field(
	// 'iss_field3',
	// __('Registration Installment (first child)', 'adminpref'),
	// 'iss_textinput_field_cb',
	// 'adminpref',
	// 'iss_registrationyear_section',
	// [
	// 'label_for' => 'iss_registrationfee1_installment',
	// 'class' => 'iss_row',
	// 'iss_custom_data' => 'custom',
	// ]
	// );
	add_settings_field ( 'iss_field2', __ ( 'Registration Fee (siblings)', 'adminpref' ), 'iss_textinput_field_cb', 'adminpref', 'iss_registrationyear_section', [ 
			'label_for' => 'iss_registrationfee2',
			'class' => 'iss_row',
			'iss_custom_data' => 'ex: 420' 
	] );
	// add_settings_field(
	// 'iss_field4',
	// __('Registration Installment (siblings)', 'adminpref'),
	// 'iss_textinput_field_cb',
	// 'adminpref',
	// 'iss_registrationyear_section',
	// [
	// 'label_for' => 'iss_registrationfee2_installment',
	// 'class' => 'iss_row',
	// 'iss_custom_data' => 'custom',
	// ]
	// );
	add_settings_field ( 'iss_field5', __ ( 'Open Registration Days', 'adminpref' ), 'iss_textinput_field_cb', 'adminpref', 'iss_registrationyear_section', [ 
			'label_for' => 'iss_openregistrationperiod_days',
			'class' => 'iss_row',
			'iss_custom_data' => 'ex: 7' 
	] );
}

/**
 * register our iss_settings_init to the admin_init action hook
 */
add_action ( 'admin_init', 'iss_settings_init' );

/**
 * custom option and settings:
 * callback functions
 */

// section callbacks can accept an $args parameter, which is an array.
// $args have the following keys defined: title, id, callback.
// the values are defined at the add_settings_section() function.
function iss_registrationyear_section_cb($args) {
	/*
	 * ?>
	 * <p id="<?= esc_attr($args['id']); ?>"><?= esc_html__('Follow the white rabbit.', 'adminpref'); ?></p>
	 * <?php
	 */
}
function iss_textinput_field_cb($args) {
	$options = get_option ( 'iss_options' );
	
	// output the field
	?>
<input id="<?= esc_attr($args['label_for']); ?>" type="text"
	max-length="256" size="50"
	data-custom="<?= esc_attr($args['iss_custom_data']); ?>"
	name="iss_options[<?= esc_attr($args['label_for']); ?>]"
	value="<?php if (isset($options[$args['label_for']])) echo $options[$args['label_for']]; ?>">
	<br/><span class="text-info"><?php  echo $args['iss_custom_data']; ?></span>
<?php
}

// field callbacks can accept an $args parameter, which is an array.
// $args is defined at the add_settings_field() function.
// wordpress has magic interaction with the following keys: label_for, class.
// the "label_for" key value is used for the "for" attribute of the <label>.
// the "class" key value is used for the "class" attribute of the <tr> containing the field.
// you can add custom key value pairs to be used inside your callbacks.
function iss_registrationyear_field_cb($args) {
	$regyearlist = iss_get_registrationyear_list ();
	// get the value of the setting we've registered with register_setting()
	$options = get_option ( 'iss_options' );
	// output the field
	if(sizeof($regyearlist) > 0) {	
	?>
	<select id="<?= esc_attr($args['label_for']); ?>"
	data-custom="<?= esc_attr($args['iss_custom_data']); ?>"
	name="iss_options[<?= esc_attr($args['label_for']); ?>]">
	<option value="">Select Registration Year</option>
	<?php foreach ($regyearlist as $regyear) { ?>
        <option value="<?php echo $regyear['RegistrationYear']; ?>" 
        <?= isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], $regyear[ 'RegistrationYear'], false)) : (''); ?>>
            <?= esc_html($regyear[ 'RegistrationYear'], 'adminpref'); ?>
        </option>
		<?php } ?>
    </select>
<?php } else { ?>
<input id="<?= esc_attr($args['label_for']); ?>" type="text"
			
	data-custom="<?= esc_attr($args['iss_custom_data']); ?>"
	name="iss_options[<?= esc_attr($args['label_for']); ?>]"
	value="<?php if (isset($options[$args['label_for']])) echo $options[$args['label_for']]; ?>">
<?php
}
?><br/><span class="text-info"><?php  echo $args['iss_custom_data']; ?></span>
<?php
}

/**
 * top level menu
 */
function iss_options_page() {
	// add top level menu page
	add_menu_page ( 'School Settings', 'School Setting', 'iss_board', 'adminpref', 'iss_options_page_html' );
}

/**
 * register our iss_options_page to the admin_menu action hook
 */
add_action ( 'admin_menu', 'iss_options_page' );

/**
 * top level menu:
 * callback functions
 */
function iss_options_page_html() {
	// check user capabilities
	if (!iss_current_user_on_board()) {
		return;
	}
	
	// add error/update messages
	
	// check if the user have submitted the settings
	// wordpress will add the "settings-updated" $_GET parameter to the url
	if (isset ( $_GET ['settings-updated'] )) {
		// add settings saved message with the class of "updated"
		add_settings_error ( 'iss_messages', 'iss_message', __ ( 'Settings Saved', 'adminpref' ), 'updated' );
	}
	
	// show error/update messages
	settings_errors ( 'iss_messages' );
	?>
<div class="wrap">
	<h1><?= esc_html(get_admin_page_title()); ?></h1>
	<form action="options.php" method="post">
            <?php
	// output security fields for the registered setting "adminpref"
	settings_fields ( 'adminpref' );
	// output setting sections and their fields
	// (sections are registered for "adminpref", each field is registered to a specific section)
	do_settings_sections ( 'adminpref' );
	// output save settings button
	if (iss_current_user_can_admin())
		submit_button ( 'Save Settings' );
	?>
        </form>
</div>
<?php
}
?>
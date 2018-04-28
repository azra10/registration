<?php
/**
 Plugin Name: ISS Parent/Student Management
 Author: Azra Syed
 Version: 1.0
 */
if (! defined ( 'ISS_PATH' )) {
	 $this_plugin_file = __FILE__;
	 if (isset ( $plugin )) {
	 	$this_plugin_file = $plugin;
	 } 
	define ( 'ISS_PATH', WP_PLUGIN_DIR . '/' . basename ( dirname ( $this_plugin_file ) ) );
	define ( 'ISS_URL', plugin_dir_url ( ISS_PATH ) . basename ( dirname ( $this_plugin_file ) ) );
}
require_once (ISS_PATH . "/functions/function_archive.php");
require_once (ISS_PATH . "/functions/function_changelog.php");
require_once (ISS_PATH . "/functions/function_common.php");
require_once (ISS_PATH . "/functions/function_delete.php");
require_once (ISS_PATH . "/functions/function_permission.php");
require_once (ISS_PATH . "/functions/function_registration.php");
require_once (ISS_PATH . "/functions/function_ui.php");
require_once (ISS_PATH . "/functions/function_update.php");
require_once (ISS_PATH . "/functions/function_validate.php");
require_once (ISS_PATH . "/functions/constants.php");
require_once (ISS_PATH . "/functions/widgets.php");
require_once (ISS_PATH . "/functions/shortcodes.php");

function students_home_page() {
	include (ISS_PATH . "/browsestudent.php");
}
function parents_home_page() {
	include (ISS_PATH . "/browseparent.php");
}
function archived_home_page() {
	include (ISS_PATH . "/browsearchived.php");
}
function view_parent_page() {
	include (ISS_PATH . "/view_parent.php");
}
function print_parent_page() {
	include (ISS_PATH . "/print_parent.php");
}
function delete_parent_page() {
	include (ISS_PATH . "/delete_parent.php");
}
function payment_parent_page() {
	include (ISS_PATH . "/payment_parent.php");
}
function edit_parent_page() {
	include (ISS_PATH . "/edit_parent.php");
}
function email_home_page() {
	include (ISS_PATH . "/email_home.php");
}
function new_parent_page() {
	include (ISS_PATH . "/new_parent.php");
}
function history_parent_page() {
	include (ISS_PATH . "/history_parent.php");
}

function iss_register_menu_page() {
	$my_pages [] = add_menu_page ( 'Parents', 'Parents', 'iss_board', 'parents_home', 'parents_home_page', 'dashicons-id-alt', 3 );
	$my_pages [] = add_menu_page ( 'Students', 'Students', 'iss_board', 'students_home', 'students_home_page', 'dashicons-groups', 4 );
	$my_pages [] = add_submenu_page ( null, 'Payment', 'Payment', 'iss_secretary', 'payment_parent', 'payment_parent_page' );
	$my_pages [] = add_submenu_page ( null, 'Print', 'Print', 'iss_board', 'print_parent', 'print_parent_page' );
	$my_pages [] = add_submenu_page ( null, 'View', 'View', 'iss_board', 'view_parent', 'view_parent_page' );
	$my_pages [] = add_submenu_page ( null, 'Delete', 'Delete', 'iss_secretary', 'delete_parent', 'delete_parent_page' );
	$my_pages [] = add_submenu_page ( null, 'Edit', 'Edit', 'iss_secretary', 'edit_parent', 'edit_parent_page' );
	$my_pages [] = add_submenu_page ( null, 'History', 'History', 'iss_board', 'history_parent', 'history_parent_page' );
	$my_pages [] = add_submenu_page ( null, 'Archived', 'Archived', 'iss_secretary', 'archived_home', 'archived_home_page' );
	$my_pages [] = add_submenu_page ( null, 'Add', 'Add', 'iss_secretary', 'new_parent', 'new_parent_page' );
	$my_pages [] = add_submenu_page ( null, 'Email', 'Email', 'iss_secretary', 'email_home', 'email_home_page' );
	
	foreach ( $my_pages as $my_page ) {
		add_action ( 'load-' . $my_page, 'iss_load_admin_custom_css' );
	}
}

add_action ( 'admin_menu', 'iss_register_menu_page' );

function register_shortcodes(){
//add_shortcode ( 'issv_view_parent', 'view_parent_function' );
add_shortcode ( 'issv_edit_parent', 'edit_parent_function' );
}
// Add custom CSS to plugin pages
function load_custom_issv_style() {
	wp_register_style ( 'custom_issv_bootstrap_min_css', ISS_URL . '/css/bootstrap.min.css' ); 
	wp_enqueue_style ( 'custom_issv_bootstrap_min_css' );
	wp_register_style ( 'custom_issv_bootstrap_table_min_css', ISS_URL . '/css/bootstrap-table.min.css' );
	wp_enqueue_style ( 'custom_issv_bootstrap_table_min_css' );
	wp_register_style ( 'custom_issv_form_css', ISS_URL . '/css/iss_form.css' );
	wp_enqueue_style ( 'custom_issv_form_css' );
	wp_register_style ( 'custom_issv_datepicker_css', ISS_URL . '/css/datepicker.css' );
	wp_enqueue_style ( 'custom_issv_datepicker_css' );
	
	wp_register_script ( 'custom_issv_jquery_script', ISS_URL . '/js/jquery-1.12.4.js' ); 
	wp_enqueue_script ( 'custom_issv_jquery_script' );
	wp_register_script ( 'custom_issv_bootstrap_script', ISS_URL . '/js/bootstrap.min.js' ); 
	wp_enqueue_script ( 'custom_issv_bootstrap_script' );
	wp_register_script ( 'custom_issv_jqueryui_script', ISS_URL . '/js/bootstrap-datepicker.js' ); 
	wp_enqueue_script ( 'custom_issv_jqueryui_script' );
	wp_register_script ( 'custom_issv_bootstrap_script1', ISS_URL . '/js/bootstrap-table.min.js' ); 
	wp_enqueue_script ( 'custom_issv_bootstrap_script1' );
	wp_register_script ( 'custom_issv_datatables_script', ISS_URL . '/js/bootstrap-table-en-US.min.js' );
	wp_enqueue_script ( 'custom_issv_datatables_script' );
	wp_register_script ( 'custom_issv_export_script', ISS_URL . '/js/multiselect.min.js' );
	wp_enqueue_script ( 'custom_issv_export_script' );
	
	wp_register_script ( 'custom_issv_form_script', ISS_URL . '/js/iss_form.js' );
	wp_enqueue_script ( 'custom_issv_form_script' );
}
function iss_load_admin_custom_css() {
	add_action ( 'admin_enqueue_scripts', 'load_custom_issv_style' );
}
add_action( 'init', 'register_shortcodes');
?>
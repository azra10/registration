<?php

/*
 * Plugin Name: ISS Export to CSV
 * Description: Export Parents with students data to a csv file.
 * Version: 1.0.0
 * Author: Azra Syed
 * Text Domain: iss_export
 */

// load_plugin_textdomain( 'iss_export', false, basename( dirname( __FILE__ ) ) . '/languages' );

/**
 * Main plugin class
 *
 * @since 0.1
 *       
 */
class ISS_Export_Parents {
	private $regyear = null;
	/**
	 * Class contructor
	 *
	 * @since 0.1
	 *       
	 */
	public function __construct() {
		add_action ( 'admin_menu', array (
				$this,
				'add_admin_pages' 
		) );
		add_action ( 'init', array (
				$this,
				'generate_csv' 
		) );
	}
	public function load_custom_iss_style() {
		wp_register_script ( 'ecustom_iss_jquery_script', ISS_URL . '/js/jquery-1.12.4.js' );
		wp_enqueue_script ( 'ecustom_iss_jquery_script' );
		
		wp_register_script ( 'custom_iss_export_script', ISS_URL . '/js/multiselect.min.js' );
		wp_enqueue_script ( 'custom_iss_export_script' );
	}
	public function iss_load_admin_custom_css() {
		add_action ( 'admin_enqueue_scripts', 'load_custom_issv_style' );
	}
	/**
	 * Add administration menus
	 *
	 * @since 0.1
	 *       
	 */
	public function add_admin_pages() {
		$my_page = add_menu_page ( __ ( 'ExportParents', 'export-parents-to-csv' ), __ ( 'Export', 'export-parents-to-csv' ), 'iss_board', 'export-parents-to-csv', array (
				$this,
				'users_page' 
		), 'dashicons-download', 7 );
		add_action ( 'load-' . $my_page, 'iss_load_admin_custom_css' );
	}
	
	/**
	 * Process content of CSV file
	 *
	 * @since 0.1
	 *       
	 */
	public function generate_csv() {
		if (isset ( $_POST ['_wpnonce-iss-export-parents-page_export'] )) {
			check_admin_referer ( 'iss-export-parents-page_export', '_wpnonce-iss-export-parents-page_export' );
			
			$sitename = sanitize_key ( get_bloginfo ( 'name' ) );
			if (! empty ( $sitename ))
				$sitename .= '.';
			
			if (! isset ( $_POST ['RegistrationYear'] ) || empty ( $_POST ['RegistrationYear'] )) {
				echo '<div class="updated"><p><strong>' . __ ( 'Registration Year is required.', 'export-parents-to-csv' ) . '</strong></p></div>';
				return;
			} else if (! isset ( $_POST ['ISSGrade'] ) || empty ( $_POST ['ISSGrade'] )) {
				echo '<div class="updated"><p><strong>' . __ ( 'Islamic School Grade is required.', 'export-parents-to-csv' ) . '</strong></p></div>';
				return;
			}  else if (! isset ( $_POST ['ExportType'] ) || empty ( $_POST ['ExportType'] )) {
				echo '<div class="updated"><p><strong>' . __ ( 'ExportType is required.', 'export-parents-to-csv' ) . '</strong></p></div>';
				return;
			} 
			$this->regyear = iss_sanitize_input ( $_POST ['RegistrationYear'] );
			$class = iss_sanitize_input ( $_POST ['ISSGrade'] );
			$type = $_POST ['ExportType'];					
			$orderby= ''; $fields= ''; $filename = ''; $active =true; $emptycolumns = '';
				
			if ($type == 'address') { 
				$fields = array('FatherLastName','FatherFirstName','MotherFirstName','StudentLastName','StudentFirstName','ISSGrade','HomeStreetAddress','HomeCity','HomeState','HomeZip');
				$filename = $this->regyear . 'AddressLabels' .  date ( '.Ymd.His' ) . '.csv';
				$this->export_custom($class, $filename , $fields, $orderby, $active, 'Address Labels');	
			} else if ($type == 'book') { 
				$fields = array('StudentLastName','StudentFirstName','ISSGrade','StudentNew');
				$orderby= 'ISSGrade,StudentLastName,StudentFirstName';
				$filename = $this->regyear . 'BookPacket' .  date ( '.Ymd.His' ) . '.csv';
				$this->export_custom($class, $filename , $fields, $orderby, $active,'Book Package','Book Packet Yes / No, Given to Student Yes / No');	
			} else if ($type == 'class') { 
				$fields = array('StudentLastName','StudentFirstName','StudentGender','ISSGrade');
				$orderby= 'ISSGrade,StudentLastName,StudentFirstName';
				$filename = $this->regyear . 'Class' . $class .  date ( '.Ymd.His' ) . '.csv';
				$this->export_custom($class, $filename , $fields, $orderby, $active, 'Class List');	
			} else if ($type == 'attendance') { 
				$fields = array('StudentLastName','StudentFirstName','StudentGender','StudentBirthDate','RegularSchoolGrade','ISSGrade');
				$orderby= 'ISSGrade,StudentLastName,StudentFirstName';
				$filename = $this->regyear . 'Attendance' . $class .  date ( '.Ymd.His' ) . '.csv';
				$emptycolumns = '';
				$this->export_custom($class, $filename , $fields, $orderby, $active, 'Attendance Sheet');	
			} else if ($type == 'inactive') { 
				$fields = array('FatherLastName','FatherFirstName','MotherFirstName','StudentLastName','StudentFirstName','StudentGender','StudentBirthDate','RegularSchoolGrade','ISSGrade');
				$orderby= 'ISSGrade,StudentLastName,StudentFirstName';
				$filename = $this->regyear . 'Dropped' . $class .  date ( '.Ymd.His' ) . '.csv';
				$active = false;
				$this->export_custom($class, $filename , $fields, $orderby, $active, 'Dropped StudentList');	
			} else if ($type == 'room') { 
				$fields = array('FatherLastName','FatherFirstName','MotherFirstName','StudentLastName','StudentFirstName','StudentGender','ISSGrade','HomePhone','FatherEmail','MotherEmail', 'SchoolEmail');
				$orderby= 'ISSGrade,StudentLastName,StudentFirstName';
				$filename = $this->regyear . 'RoomParent' . $class .  date ( '.Ymd.His' ) . '.csv';
				$this->export_custom($class, $filename , $fields, $orderby, $active, 'Room Parent List');	
			}  else if ($type == 'flat') {
				$this->regyear = iss_sanitize_input ( $_POST ['RegistrationYear'] );
				$filename =  $this->regyear . 'FlatParent' . date ( '.Ymd.His' ) . '.csv';
				$this->export_custom_flat($filename);															
			} else if (isset ( $_POST ['ColumnArray'] ) && (count ( $_POST ['ColumnArray'] ) != 0)) {
				$fields = $_POST ['ColumnArray'];
				$filename =  $this->regyear . 'Grade' . $class . date ( '.Ymd.His' ) . '.csv';
				$this->export_custom($class, $filename, $fields);				
			} else {				
				$this->export_all($class);				
			}
			exit ();
		}
	}
	
	public function export_all($class){
		$filename =   $this->regyear . 'Grade' . $class . date ( '.Ymd.His' ) . '.csv';
		header ( 'Content-Description: File Transfer' );
		header ( 'Content-Disposition: attachment; filename=' . $filename );
		header ( 'Content-Type: text/csv; charset=' . get_option ( 'blog_charset' ), true );
		iss_write_log ( "Export: RegistrationYear:{$this->regyear} Class:{$class} All List" );
		$rows =  iss_get_export_list( $this->regyear);
		
		$head = false;
		foreach ( $rows as $row ) {
			unset ( $row ['ParentViewID'] ); unset ( $row ['created'] ); unset ( $row ['updated'] );
			
			if ($head == false) 
			{ foreach ( $row as $key => $value ) { echo "{$key},"; $head = true; } echo "\n"; }
			
			if (($class == 'All') || ($class == $row ['ISSGrade'])) {
				foreach ( $row as $key => $value ) {
					if (strpos ( $value, ',' ) >0) 
					{ $value = iss_quote_all ( $value ); }
					if (($key == 'SchoolEmail') && isset($row['FatherEmail']) && isset($row['MotherEmail']))
					{$value = ($row['SchoolEmail']== 'Father')? $row['FatherEmail']: $row['MotherEmail']; }
					echo "{$value},";
				}
				echo "\n";
			}
		}
	}
	public function export_custom_flat($filename) {
		header ( 'Content-Description: File Transfer' );
		header ( 'Content-Disposition: attachment; filename=' . $filename );
		header ( 'Content-Type: text/csv; charset=' . get_option ( 'blog_charset' ), true );
		
		iss_write_log ( "Export: RegistrationYear:{$this->regyear} Flat Parent List" );
		
		$rows =  iss_get_export_list( $this->regyear , '*',  'p.ParentID,s.ISSGrade',true, true);
		
		$parentfields = iss_parent_fields();
		$studentfields = iss_student_fields();

		echo implode ( ',', $parentfields ); 
		for( $i=1; $i<5; $i++) {
			echo  ",PrevISSGrade{$i}";
			foreach($studentfields as $fld) echo ",{$fld}{$i}"; 
		}

		$parentid = 0;
		foreach ( $rows as $row ) {						
			
			if ($parentid != $row['ParentID']) 
			{ 
				$parentid = $row['ParentID']; echo "\n"; 						
				foreach ( $parentfields as $field ) {
					$value = $row[$field];
					if (strpos ( $value, ',' ) >0) { $value = iss_quote_all ( $value ); }
					if (($field == 'SchoolEmail') && isset($row['FatherEmail']) && isset($row['MotherEmail']))
					{  $value = ($row['SchoolEmail'] == 'Father')? $row['FatherEmail']: $row['MotherEmail']; }
					echo "{$value},";
				}
			} 
			if (isset($row['ISSGrade'])) 
			{ $pg = iss_previous_issgrade($row['ISSGrade']);  echo "{$pg},";}
			foreach($studentfields as $field) {
				$value = $row[$field];
				if (strpos ( $value, ',' ) >0) 
				{ $value = iss_quote_all ( $value ); }
				echo "{$value},";
			}
		}
	}
	public function export_custom($class, $filename , $fields='*', $orderby ='', $active=true, $type='', $emptycolumns=''){
		header ( 'Content-Description: File Transfer' );
		header ( 'Content-Disposition: attachment; filename=' . $filename );
		header ( 'Content-Type: text/csv; charset=' . get_option ( 'blog_charset' ), true );
		
		iss_write_log ( "Export: RegistrationYear:{$this->regyear} {$type} List" );
		
		echo implode ( ',', $fields ) . $emptycolumns . "\n";

		$rows = iss_get_export_list ( $this->regyear, implode ( ',', $fields ), $orderby, true, $active );
		foreach ( $rows as $row ) {
			
			if (($class == 'All') || ($class == $row ['ISSGrade'])) {
				foreach ($fields as $field ) {
					$value = $row[$field];
					if (strpos ( $value, ',' ) >0) {$value = iss_quote_all ( $value );}
					if (($field == 'SchoolEmail') && isset($row['FatherEmail']) && isset($row['MotherEmail']))
					{$value = ($row['SchoolEmail']== 'Father')? $row['FatherEmail']: $row['MotherEmail']; }
					echo "{$value},";
				}
				echo "\n";
			}
		}		
	}
	/**
	 * Content of the settings page
	 *
	 * @since 0.1
	 *       
	 */
	public function users_page() {
		if (! iss_current_user_on_board())
			wp_die ( __ ( 'You do not have sufficient permissions to access this page.', 'export-parents-to-csv' ) );
		?>

<div class="wrap">
	<h2><?php _e( 'Export Parents to a CSV file', 'export-parents-to-csv' ); ?></h2>
    <?php
		if (isset ( $_GET ['error'] )) {
			echo '<div class="updated"><p><strong>' . __ ( 'No user found.', 'export-parents-to-csv' ) . '</strong></p></div>';
		}
		if (NULL == $this->regyear) {
			$this->regyear = iss_registration_period ();
		}
		$regyearlist = iss_get_registrationyear_list ();
		?>
      <form method="post" action="" enctype="multipart/form-data">
        <?php wp_nonce_field( 'iss-export-parents-page_export', '_wpnonce-iss-export-parents-page_export' ); ?>
         <div class="form-group row">
			<div class="col-sm-4 col-md-2">
				<label>Registration Year</label>
			</div>

			<div class="col-sm-4 col-md-2">
				<select name="RegistrationYear" id="RegistrationYear"
					class="form-control" title="Choose Registration Year" required>
					<option value "" selected>Select Registration Year</option>
                <?php foreach ($regyearlist as $ryear) { ?>
                  <option
						value="<?php echo $ryear['RegistrationYear'];?>"
						<?php echo ($this->regyear == $ryear['RegistrationYear']) ? ' selected' : '';?>>
                    <?php echo $ryear['RegistrationYear'];?>
                  </option>
                  <?php } ?>
              </select>
			</div>
			<div class=" col-sm-3 col-md-2">
				<input type="submit" class="button-primary"
					value="<?php _e( 'Export', 'export-parents-to-csv' ); ?>" /> <input
					type="hidden" name="_wp_http_referer"
					value="<?php echo $_SERVER['REQUEST_URI'] ?>" />
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-4 col-md-2">
				<label>Islamic School Grade</label>
			</div>
			<div class="col-sm-4 col-md-2">
				<select name="ISSGrade" id="ISSGrade" class="form-control"
					title="Choose Class" required>
					<option value="All" selected>All</option>
                <?php
		
				$issclasslist = iss_class_list();
				foreach ( $issclasslist as $class => $name ) {
					echo "<option value=\"$class\">{$name}</option>";
				}
				?>
              </select>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-4 col-md-2">
				<label>Export Type</label>
			</div>
			<div class="col-sm-4 col-md-2">
				<select name="ExportType" id="ExportType" class="form-control"
					title="Choose Export Type" required>
					<option value="custom" selected>Custom Type</option>
					<option value="address">Address Labels</option>
					<option value="book">Book Packet Labels</option>
 					<option value="class">Class List</option>
 					<option value="inactive">Dropped Student List</option>
  					<option value="room">Room Parent List</option>
 					<option value="attendance">Attendance List</option>
					<option value="flat">Flat Parent List</option>
             </select>
			</div>

		</div>
	
		<div> <span style="padding-bottom: 5px; font-weight: bold;">For Custom Type Only: </span>Select specific
			columns and order. By default all columns will be included.</div>
		<div class="row">
			<div class="col-sm-5 col-md-3">
				<select name="FromExport[]" id="multiselect" class="form-control"
					size="30" multiple="multiple">
					<optgroup label="Parent Information">
                  <?php		

					foreach ( iss_parent_tabfields () as $field ) {
						echo "<option value='{$field}'>{$field}</option>";
					}
					?>
                </optgroup>
					<optgroup label="Student Information">
                  <?php
		
foreach ( iss_student_fields () as $field ) {
			echo "<option value='{$field}'>{$field}</option>";
		}
		?>
                </optgroup>
					<optgroup label="Home Information">
                  <?php
		
foreach ( iss_home_tabfields () as $field ) {
			echo "<option value='{$field}'>{$field}</option>";
		}
		?>
                </optgroup>
					<optgroup label="Emergency Information">
                  <?php
		
foreach ( iss_contact_tabfields () as $field ) {
			echo "<option value='{$field}'>{$field}</option>";
		}
		?>
                </optgroup>
					<optgroup label="Payment Information">
                  <?php
		
foreach ( iss_payment_tabfields () as $field ) {
			echo "<option value='{$field}'>{$field}</option>";
		}
		?>
                </optgroup>
				</select>
			</div>

			<div class="col-sm-2 col-md-1">
				<button type="button" id="multiselect_rightAll"
					class="btn btn-block">
					<i class="glyphicon glyphicon-forward"></i>
				</button>
				<button type="button" id="multiselect_rightSelected"
					class="btn btn-block">
					<i class="glyphicon glyphicon-chevron-right"></i>
				</button>
				<button type="button" id="multiselect_leftSelected"
					class="btn btn-block">
					<i class="glyphicon glyphicon-chevron-left"></i>
				</button>
				<button type="button" id="multiselect_leftAll" class="btn btn-block">
					<i class="glyphicon glyphicon-backward"></i>
				</button>
			</div>

			<div class="col-sm-5 col-md-3">
				<select name="ColumnArray[]" id="multiselect_to"
					class="form-control" size="30" multiple="multiple"></select>

				<div class="row">
					<div class="col-sm-6">
						<button type="button" id="multiselect_move_up"
							class="btn btn-block">
							<i class="glyphicon glyphicon-arrow-up"></i>
						</button>
					</div>
					<div class="col-sm-6">
						<button type="button" id="multiselect_move_down"
							class="btn btn-block col-sm-6">
							<i class="glyphicon glyphicon-arrow-down"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
		<p>Note: ParentID, StudentID and Registration year are added to every
			extract,</p>
		<p>these columns are needed in case the changes need to be made in
			exported file and imported back into the system.</p>
		<p>Please delete columns if don't need them.</p>

		<script type="text/javascript">
            jQuery(window).load(function() {
              $('#multiselect').multiselect({
                search: {
                  left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                  right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                }
              });
            });
          </script>


	</form>
</div>
<?php
	}
}
new ISS_Export_Parents ();
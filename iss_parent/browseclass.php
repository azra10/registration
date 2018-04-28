<?php global $wpdb; ?>
  <?php   $regyear = iss_registration_period(); ?>

<div class="wrap">
	<nav class="navbar navbar-light bg-faded">
		<strong class="navbar-brand">Student Classes </strong>
	</nav>
</div>
<div class="container">
	<div class="row">
		<div>
			<strong>Registration Period: <?php if (isset($regyear)) echo $regyear; ?></strong>
			<a class=\
				"page-link\" href="<?php echo get_admin_url() . '?page=user_home'; ?>">Change</a>
		</div>
		<div class="modal" id="pleaseWaitDialog" data-backdrop="static"
			data-keyboard="false">
			<div class="modal-header">
				<h1>Loading...</h1>
			</div>
			<div class="modal-body">
				<div class="progress progress-striped active">
					<div class="bar" style="width: 100%;"></div>
				</div>
			</div>
		</div>

		<nav aria-label="Page navigation">
			<ul class="pagination">
              <?php
														echo "<li class=\"page-item ";
														if (! isset ( $_GET ['initial'] )) {
															echo "  active\"";
														}
														echo "\"><a class=\"page-link\" href=\"admin.php?page=class_home\">All</a></li>";
														?>
                </li>&nbsp;&nbsp;

                <?php
																$letters = array (
																		'KG',
																		'1',
																		'2',
																		'3',
																		'4',
																		'5',
																		'6',
																		'7',
																		'8',
																		'YG',
																		'YB',
																		'XX' 
																);
																
																$item = "";
																
																foreach ( $letters as $letter ) {
																	echo "<li class=\"page-item ";
																	if (isset ( $_GET ['initial'] ) && ($letter == $_GET ['initial'])) {
																		echo " active\"";
																	}
																	echo "\"><a class=\"page-link\" href=\"admin.php?page=class_home&initial={$letter}\">{$letter}</a></li>";
																}
																?>
            </ul>
		</nav>

          <?php
										$result_set = NULL;
										$customers = iss_get_table_name ( "students" );
										if (isset ( $_GET ['initial'] )) {
											
											$initial = iss_sanitize_input ( $_GET ['initial'] );
											$query = "SELECT * FROM {$customers}
    WHERE ISSGrade LIKE '{$initial}%' and RegistrationYear LIKE '{$regyear}' and StudentStatus = 'active'
    ORDER BY StudentLastName, StudentFirstName";
											
											$result_set = $wpdb->get_results ( $query, ARRAY_A );
										} else {
											
											$query = "SELECT * FROM {$customers}
    WHERE RegistrationYear LIKE '{$regyear}%' and StudentStatus = 'active'
    ORDER BY StudentLastName, StudentFirstName";
											
											$result_set = $wpdb->get_results ( $query, ARRAY_A );
										}
										if (count ( $result_set ) == 0) {
											echo "<br><em>No results were found.</em><br> <a href=\"admin.php?page=students_home\">Browse parents by last name.</a>";
										} else {
											// if($result_set != NULL) {
											?>
            <table class="table table-striped iss_student_table"
			id="data_table_simple">
			<thead>
				<tr>
					<td><strong>Last Name</strong></td>
					<td><strong>First Names</strong></td>
					<td><strong>Grade</strong></td>
					<td><strong>Gender</strong></td>
					<td><strong>Action</strong></td>
				</tr>
			</thead>
			<tbody>
                <?php
											foreach ( $result_set as $row ) {
												echo "<tr>";
												echo "<td><i class=\"glyphicon glyphicon-pawn\"></i> {$row['StudentLastName']}</td>";
												echo "<td>{$row['StudentFirstName']}</td>";
												echo "<td>Grade {$row['ISSGrade']}</td>";
												echo "<td>{$row['StudentGender']}</td>";
												echo "<td>";
												echo "<a href=\"admin.php?page=&amp;pid={$row['ParentID']}\"><i class=\"glyphicon glyphicon-print\"></i> View</a>&nbsp;&nbsp;&nbsp;";
												echo "<a href=\"admin.php?page=edit_parent&amp;pid={$row['ParentID']}&amp;regyear={$regyear}&amp;sid={$row['StudentID']}\"><i class=\"glyphicon glyphicon-edit\"></i> Edit</a>&nbsp;&nbsp;";
												echo "</td></tr>";
											}
											echo "</tbody></table>";
										}
										
										?>

<script>
	jQuery(window).load(function() {
	jQuery('#pleaseWaitDialog').hide();
	$('table.iss_student_table').bootstrapTable();
  // DataTable({
  // "pageLength": 25,
  // "searching": false });
	// });
</script>
<?php require("includes/footer.php"); ?>
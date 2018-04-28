<?php global $wpdb; ?>
  <?php   $regyear = iss_registration_period(); ?>
  <?php include(ISS_PATH . "/includes/pheader.php"); ?>

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
					echo "\"><a class=\"page-link\" href=\"admin.php?page=parents_home\">All</a></li>";
					?>
				</li>&nbsp;&nbsp;
				<?php
														
			$letters = array (
							'A',
							'B',
							'C',
							'D',
							'E',
							'F',
							'G',
							'H',
							'I',
							'J',
							'K',
							'L',
							'M',
							'N',
							'O',
							'P',
							'Q',
							'R',
							'S',
							'T',
							'U',
							'V',
							'W',
							'X',
							'Y',
							'Z',
							'New',
							'Archived' 
					);
					$item = "";
					foreach ( $letters as $letter ) {
						echo "<li class=\"page-item ";
						if (isset ( $_GET ['initial'] ) && strtolower ( $letter ) == strtolower ( $_GET ['initial'] )) {
							echo " active\"";
						}
						echo "\"><a class=\"page-link\" href=\"admin.php?page=parents_home&initial={$letter}\">{$letter}</a></li>";
					}
					?>
    </ul>
</nav>

<?php
$result_set = NULL;

$columns = "ParentViewID, ParentID, FatherLastName, FatherFirstName, RegistrationComplete, ParentStatus";

if (isset ( $_POST ['submit'] )) {
	check_admin_referer ( 'iss_parent_search', 'iss_parent_search_nonce' );
	$keyword = iss_sanitize_input ( $_POST ['keyword'] );
	if (strlen ( $keyword ) > 0) {
		$result_set = iss_get_search_parents_list ( $regyear, $columns, $keyword );
	}
} else if (isset ( $_GET ['initial'] )) {
	$initial = iss_sanitize_input ( $_GET ['initial'] );
	if ($initial == 'Archived')
	$result_set = iss_get_archived_parents_list ( $regyear, $columns  );
	else if ($initial == 'New')
	$result_set = iss_get_new_parents_list ( $regyear, $columns );
	else
	$result_set = iss_get_startwith_parents_list ( $regyear, $columns, $initial );
} else {
	$result_set = iss_get_parents_list ( $regyear, $columns );
}

if (count ( $result_set ) == 0) {
	echo "<br><em>No results were found.</em><br> <a href=\"admin.php?page=parents_home\">Browse parents by last name.</a>";
} else {
	?>
<div>
	<div class="bs-bars pull-left">
		<!--<div id="toolbar">
			<selectname "action"><option>Bulk Action</option><option>Archive</option><option>Email</option></select>
                <button id="actionbutton" name="submit" class="btn btn-primary" disabled=""> </i> Submit </button>
              </div>
		<div>-->
			<table class="table table-striped table-responsive table-condensed"
				id="iss_parent_table">
				<thead>
					<tr>
						<th></th>
						<th>ParentID</th>
						<th>Lastname</th>
						<th>Firstname</th>
						<th>Registration</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
            <?php  foreach($result_set as $row) { ?>
             <tr>
						<td></td>
						<td nowrap>
                          <?php echo $row['ParentID'];?>
                        </td>
						<td nowrap><i class="dashicons dashicons-id"></i> <?php echo $row['FatherLastName']; ?></td>
						<td nowrap>
                          <?php echo $row['FatherFirstName'];?>
                        </td>
						<td nowrap>
                          <?php echo $row['RegistrationComplete'];?>
                        </td>
						<td nowrap>
						<?php if (iss_current_user_is_secretery()) {  ?>
								<?php if ($row['ParentStatus'] == 'active') { ?>
										<a
											href="admin.php?page=edit_parent&pid=<?php echo $row['ParentID']; ?>&regyear=<?php if (isset($regyear)) echo $regyear;?>">
												<span style="padding-left: 10px; white-space: nowrap;"> <i
													class="glyphicon glyphicon-edit"></i> Edit
											</span>
										</a> <a
											href="admin.php?page=payment_parent&id=<?php echo $row[ 'ParentViewID'];?>">
												<span style="padding-left: 10px; white-space: nowrap;"> <span
													class="text-primary">$</span> Payment
											</span>
										</a> 
										<!--<a
											href="admin.php?page=email_home&id=<?php echo $row['ParentViewID'];?>"> <span
												style="padding-left: 10px; white-space: nowrap;"> <i
													class="glyphicon glyphicon-envelope"></i> Email
											</span></a> -->
											
										<a
											href="admin.php?page=archived_home&aid=<?php echo $row['ParentViewID'];?>">
												<span style="padding-left: 10px; white-space: nowrap;"> <i
													class="glyphicon glyphicon-eye-close"></i> Archive 	</span>
										</a>
								<?php } else { 	?>
										<a href="admin.php?page=archived_home&uid=<?php echo $row['ParentViewID'];?>">
											<span style="padding-left: 10px; white-space: nowrap;"><i 
											class="glyphicon glyphicon-eye-open"></i> UnArchive  </span>
										</a>                   
	                   <a href="admin.php?page=delete_parent&id=<?php echo $row['ParentViewID'];?>"> 
												<span style="padding-left: 10px; white-space: nowrap;"><i 
												class="glyphicon glyphicon-remove"></i> Delete</span>
										 </a>
								<?php } 	?>
						<?php } 	 	?>

						<a
							href="admin.php?page=history_parent&id=<?php echo $row['ParentViewID'];?>">
								<span style="padding-left: 10px; white-space: nowrap;"> <i
									class="glyphicon glyphicon-header"></i> History
							</span> </a>

            <a
							href="admin.php?page=view_parent&id=<?php echo $row['ParentViewID'];?>"> <span
								style="padding-left: 10px; white-space: nowrap;"> <i
									class="glyphicon glyphicon-eye-open"></i> View
							</span></a> 
							
							<a
							href="admin.php?page=print_parent&id=<?php echo $row['ParentViewID'];?>"> <span
								style="padding-left: 10px; white-space: nowrap;"> <i
									class="glyphicon glyphicon-print"></i> Print
							</span></a>

						</td>
					</tr>
                      <?php } ?>
                  </tbody>
			</table>
		</div>
	</div>
            <?php }?>

              <script>
                jQuery(window).load(function() {
                  jQuery('#pleaseWaitDialog').hide();
                  $('#iss_parent_table').bootstrapTable({
                    pagination: true,
                    pageSize: 15,
                    columns: [{
                      field: 'state',
                      checkbox: true,
                      align: 'center',
                      valign: 'middle'
                    }, {
                      field: 'id',
                    }, {
                      field: 'lastname',
                      align: 'left',
                      valign: 'middle',
                      sortable: true
                    }, {
                      field: 'firstname',
                      align: 'left',
                      valign: 'middle',
                      sortable: true
                    }, {
                      field: 'action',
                      align: 'left'
                    }]
                  });
                  $('#iss_parent_table').bootstrapTable('hideColumn', 'id');

                $('#iss_parent_table').on('check.bs.table uncheck.bs.table ' +
                    'check-all.bs.table uncheck-all.bs.table',
                    function() {
                      $('#actionbutton').prop('disabled', !$('#iss_student_table').bootstrapTable('getSelections').length);

                      // save your data, here just save the current page
                      selections = getIdSelections();
                      console.log(selections);
                      // push or splice the selections if you want to save all data selections
                    });
                  $('#actionbutton').click(function() {
                    var ids = getIdSelections();

                    // $table.bootstrapTable('actionbutton', {
                    //     field: 'id',
                    //     values: ids
                    // });
                    $actionbutton.prop('disabled', true);
                  });

                });

                function getIdSelections() {
                  return $.map($('#iss_parent_table').bootstrapTable('getSelections'), function(row) {
                    return row.id
                  });
                }
              </script>
              <?php require("includes/footer.php"); ?>
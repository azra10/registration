<?php global $wpdb; ?>
    <?php   $regyear = iss_registration_period(); ?>
    <?php include(ISS_PATH . "/includes/sheader.php"); ?>

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
</div>
<div>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php
                                                    
            echo "<li class=\"page-item ";
            if (! isset ( $_GET ['initial'] )) {
                echo "  active\"";
            }
            echo "\"><a class=\"page-link\" href=\"admin.php?page=students_home\">All</a></li>";
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
                    'XX',
                    'New',
                    'Archived'
            );
            $item = "";
            foreach ($letters as $letter) {
                echo "<li class=\"page-item ";
                if (isset ( $_GET ['initial'] ) && strtolower ( $letter ) == strtolower ( $_GET ['initial'] )) {
                    echo " active\"";
                }
                echo "\"><a class=\"page-link\" href=\"admin.php?page=students_home&initial={$letter}\">{$letter}</a></li>";
            }
                                                                ?>
            </ul>
    </nav>

</div>
<?php
$result_set = null;
$columns = "StudentViewID,StudentID,ParentId,StudentFirstName, StudentLastName,ISSGrade,StudentGender,StudentStatus";
if (isset ( $_POST ['submit'] )) {
    check_admin_referer ( 'iss_student_search', 'iss_student_search_nonce' );
    $keyword = iss_sanitize_input ( $_POST ['keyword'] );
    if (strlen ( $keyword ) > 0) {
        $result_set = iss_get_search_students_list ( $regyear, $columns, $keyword );
    }
} elseif (isset ( $_GET ['initial'] )) {
    $initial = iss_sanitize_input ( $_GET ['initial'] );
    if ($initial == 'Archived')
	$result_set = iss_get_archived_students_list ( $regyear , $columns );
	else if ($initial == 'New')
	$result_set = iss_get_new_students_list ( $regyear , $columns );
    else
    $result_set = iss_get_class_students_list ( $regyear, $columns, $initial );
} else {
    $result_set = iss_get_students_list ( $regyear, $columns );
}

if (count ( $result_set ) == 0) {
    echo "<br><em>No results were found.</em><br> <a href=\"admin.php?page=students_home\">Browse parents by last name.</a>";
} else {
    ?>
<div>
    <div class="bs-bars pull-left">
        <!--<div id="toolbar">
            <select id="action"name "action"><option>Bulk Action</option>
                <option>Archive</option>
                <option>Email</option></select>
            <button id="actionbutton" name="submit" class="btn btn-primary"
                disabled="">
                </i> Submit
            </button>
        </div>-->
        <div>
            <table class="table table-striped table-responsive table-condensed"
                id="iss_student_table">
                <thead>
                    <tr>
                        <th></th>
                        <th>StudentID</th>
                        <th>Lastname</th>
                        <th>Firstname</th>
                        <th>Grade</th>
                        <th>Gender</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result_set as $row) { ?>
                      <tr>
                        <td></td>
                        <td>
                            <?php echo $row['StudentID'];?>
                        </td>
                        <td><i class="glyphicon glyphicon-pawn"></i>
                            <?php echo $row['StudentLastName'];?>
                        </td>
                        <td>
                            <?php echo $row['StudentFirstName'];?>
                        </td>
                        <td>Grade
                            <?php echo $row['ISSGrade'];?>
                        </td>
                        <td>
                            <?php echo $row['StudentGender'];?>
                        </td>
                        <td>
                            <?php if (iss_current_user_is_secretery() && ($row['StudentStatus'] == 'active')) { ?>
                            <a
                            href="admin.php?page=edit_parent&pid=<?php echo $row['ParentID']; ?>&regyear=<?php echo (isset($regyear))?
                                 $regyear :''; ?>&sid=<?php echo $row['StudentID'];?>">
                                <span style="padding-left: 10px; white-space: nowrap;"> <i
                                    class="glyphicon glyphicon-edit"></i> Edit
                            </span>
                            </a>
                            <?php } ?>

                              <!--<a
                            href="admin.php?page=view_parent&id=<?php echo $row['ParentID'];?>"> <span
                                style="padding-left: 10px; white-space: nowrap;"> <i
                                    class="glyphicon glyphicon-eye-open"></i> View
                            </span>
                        </a> <a
                            href="admin.php?page=print_parent&id=<?php echo $row['ParentID'];?>"> <span
                                style="padding-left: 10px; white-space: nowrap;"> <i
                                    class="glyphicon glyphicon-print"></i> Print
                            </span></a>-->
                        </td>
                    </tr>
                        <?php } ?>
                  </tbody>
            </table>
        </div>
    </div>
            <?php } ?>

              <script>
                jQuery(window).load(function() {
                  jQuery('#pleaseWaitDialog').hide();
                  $('#iss_student_table').bootstrapTable({
                    pagination: true,
                    pageSize: 15,
                    columns: [{
                      field: 'state',
                      checkbox: true,
                      align: 'center',
                      valign: 'middle'
                    }, {
                      field: 'id',
                      align: 'center',
                      valign: 'middle',
                      sortable: true
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
                      field: 'grade',
                      align: 'left',
                      valign: 'middle',
                      sortable: true
                    }, {
                      field: 'gender',
                      align: 'center',
                      valign: 'middle',
                      sortable: true
                    }, {
                      field: 'action',
                      align: 'left'
                    }]
                  });
                  $('#iss_student_table').on('check.bs.table uncheck.bs.table ' +
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
                  return $.map($('#iss_student_table').bootstrapTable('getSelections'), function(row) {
                    return row.id
                  });
                }
              </script>
                <?php require("includes/footer.php"); ?>
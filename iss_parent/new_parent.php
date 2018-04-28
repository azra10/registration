<?php
iss_write_log ( $_GET );
iss_write_log ( $_POST );

// INITIALIZE
$isstabname = 'parent';
$parentid = 'new';
$regyear = iss_registration_period ();
$issformposturl = '';
$errorstring = '';
$errors = array ();
$issparent = array ();
$edit = true;

// / IF FORM POST REQUEST
if (isset ( $_POST ['_wpnonce-iss-edit-parents-form-page'] )) {
	check_admin_referer ( 'iss-edit-parents-form-page', '_wpnonce-iss-edit-parents-form-page' );
	iss_write_log ( $_POST );
	$parentid = iss_process_newparentrequest ( $_POST, $issparent, $errors );
	if ((0 < $parentid) && ('new' != $parentid)) {
		$issparent = iss_get_parent_by_parentid ( $parentid, $regyear );
		$isstabname = iss_get_next_tab ( $isstabname );
	} else {
		$errorstring = '* Could not save changes, please try again. ';
		iss_write_log($errors);
	}
	if ($isstabname == 'home') {
		$issformposturl = "admin.php?page=edit_parent&pid={$parentid}&regyear={$regyear}";
		$studentid = NULL;
		$studentnew = array ();
		$issstudents = NULL;
		include (ISS_PATH . "/includes/form_edit.php");
		return;
	}
} // form post request
?>
<div class="wrap">
	<nav class="navbar navbar-light bg-faded">
		<strong class="navbar-brand">Add Parent </strong>
		<ul class="nav navbar-nav">
			<li class="nav-item"><a class="page-link"
				href="<?php echo get_admin_url() . '?page=user_home'; ?>"><span
					class="button-primary">Change Registration Period: <?php echo $regyear; ?></span></a>
			</li>
		</ul>
	</nav>
</div>
<?php include(ISS_PATH . "/includes/form_parent.php");  ?>
<script>
  $(document).ready(function () {
      $('button.next-step').prop('disabled', true);
  });
</script>
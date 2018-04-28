<?php   $regyear = iss_registration_period(); ?>
<div class="wrap">
	<nav class="navbar navbar-light bg-faded">
		<strong class="navbar-brand">Payment Details </strong>
		<ul class="nav navbar-nav">
			<li class="nav-item"><a class="page-link"
				href="<?php echo get_admin_url() . '?page=user_home'; ?>"><span
					class="button-primary">Change Registration Period: <?php echo $regyear; ?></span></a>
			</li>
		</ul>
	</nav>
</div>

<?php
// / IF FORM POST REQUEST
if (isset ( $_POST ['_wpnonce-iss-edit-parents-form-page'] )) {
	check_admin_referer ( 'iss-edit-payment-form-page', '_wpnonce-iss-edit-payment-form-page' );
	include (ISS_PATH . "/includes/form_payment_post.php");
}  // form post request
else {
	if (! isset ( $_GET ['id'] ) || empty ( $_GET ['id'] ) || (intval ( $_GET ['id'] ) == 0)) {
		echo '<div class="text-danger"><p><strong>Unknown Parent.</strong></p></div>';
		return;
	}
	
	$id = iss_sanitize_input ( $_GET ['id'] );
	
	// IF PARENT EXIST, PULL PARENT
	$issparent = iss_get_parent_and_payment_by_id ( $id );
	
	if ($issparent == NULL) {
		echo '<p>' . 'Parent not found.' . '</p>';
		return;
	} else {
		
		$parentid = $issparent ['ParentID'];
		$regyear = $issparent ['RegistrationYear'];
		$errorstring = '';
	}
}
$edit = true;
?>
<form class="form-horizontal" method="post" action=""
	enctype="multipart/form-data">
  <?php wp_nonce_field('iss-edit-payment-form-page', '_wpnonce-iss-edit-payment-form-page') ?>
    <input type="hidden" id="ParentID" name="ParentID"
		value="<?php echo $parentid; ?>" /> <input type="hidden"
		id="RegistrationYear" name="RegistrationYear"
		value="<?php echo $regyear; ?>" />

  <?php include(ISS_PATH . "/includes/form_payment.php"); ?>
</form>

<?php
if (isset ( $_GET ['error'] )) {
	echo '<div class="text-danger"><p><strong>User not found.</strong></p></div>';
}
?>
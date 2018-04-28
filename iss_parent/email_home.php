<?php   $regyear = iss_registration_period(); ?>

<div class="wrap">
	<nav class="navbar navbar-light bg-faded">
		<strong class="navbar-brand">Email </strong>
		<ul class="nav navbar-nav">
			<li class="nav-item"><a class="page-link"
				href="<?php echo get_admin_url() . '?page=user_home'; ?>"><span
					class="button-primary">Change Registration Period: <?php echo $regyear; ?></span></a>
			</li>
		</ul>
	</nav>
</div>
<div class="container">
	<div class="row">
<?php
if (! isset ( $_GET ['id'] ) || empty ( $_GET ['id'] ) || (intval ( $_GET ['id'] ) == 0)) {
	echo '<div class="text-danger"><p><strong>Unknown Parent.</strong></p></div>';
	return;
}

$id = iss_sanitize_input ( $_GET ['id'] );

// IF PARENT EXIST, PULL PARENT
$issparent = iss_get_parent_and_payment_by_id ( $id );
if ($issparent == NULL) {
	echo '<p>' . 'No users found.' . '</p>';
} else {
	if (isset ( $_POST ['_wpnonce-iss-email-parents-form-page'] )) {
		check_admin_referer ( 'iss-email-parents-form-page', '_wpnonce-iss-email-parents-form-page' );
		
		// retrieve options name/value
		if (isset ( $_POST ['requesttype'] ) || ! empty ( $_POST ['requesttype'] )) {
			$requesttype = iss_sanitize_input ( $_POST ['requesttype'] );
		}
		if (isset ( $_POST ['emailaddresses'] )) {
			$emailaddresses = $_POST ['emailaddresses'];
		}
		if (isset ( $_POST ['emailsubject'] ) || ! empty ( $_POST ['emailsubject'] )) {
			$emailsubject = iss_sanitize_input ( $_POST ['emailsubject'] );
		}
		if (isset ( $_POST ['emailbody'] ) || ! empty ( $_POST ['emailbody'] )) {
			$emailbody = iss_sanitize_input ( $_POST ['emailbody'] );
		}
		
		if (empty ( $requesttype ) || (count ( $emailaddresses ) == 0)) {
			echo '<div class="text-danger"><p><strong>Email addresses & Request type are required.</strong></p></div>';
			return;
		}
		
		$success = false;
		if ($requesttype === 'normal') {
			if (empty ( $emailsubject ) || empty ( $emailbody )) {
				echo '<div class="text-danger"><p><strong>Email subject and body are required.</strong></p></div>';
				return;
			}
		} else if ($requesttype === 'registration') {
			$emailsubject = iss_get_school_name () . ": Registration Request";
			$code = iss_get_parent_registration_code ( $id );
			$emailbody = "Please click on the following link to complete your registration. <br><a target=\"_blank\" href=\"" . home_url ( '/registration?code=' ) . $code . "\">Complete Registration</a>";
		} else if ($requesttype === 'payment') {
			$emailsubject = iss_get_school_name () . ": Tuition Payment Request";
			$emailbody = "Please click on the following link to pay the fee.";
		}
		
		$str = implode ( ',', $emailaddresses );
		echo "<table class=\"table\">";
		echo "<tr><td>To:</td><td>{$str}</td></tr>";
		echo "<tr><td>Subject: </td><td>{$emailsubject}</td></tr>";
		echo "<tr><td>Body: </td><td>{$emailbody}</td></tr>";
		echo "</table>";
	} else {
		?>
    <form class="form-horizontal" method="post" action=""
			enctype="multipart/form-data">
     <?php wp_nonce_field('iss-email-parents-form-page', '_wpnonce-iss-email-parents-form-page') ?>

      <div class="row">
				<div class="rfpanel col-md-11 text-primary">
					<div class="form-group">
						<label class="col-md-2 control-label"> <strong>To</strong>
						</label>
						<div class="col-md-10">
							<label class="radio-inline" for="emailaddresses"> <input
								type="checkbox" name="emailaddresses[]"
								value="<?php echo $issparent['MotherEmail']?>"
								<?php echo ($issparent[ 'SchoolEmail']=='Mother' )? 'checked': '';?> />
								<span><strong> <?php echo ($issparent[ 'SchoolEmail']=='Mother' )? 'School':'Mother';?> Email </strong>
									<i><?php echo $issparent['MotherEmail'];?></i><span></label> <label
								class="radio-inline" for="emailaddresses"> <input
								type="checkbox" name="emailaddresses[]"
								value="<?php echo $issparent['FatherEmail']?>"
								<?php echo ($issparent[ 'SchoolEmail']=='Father' )? 'checked': '';?> />
								<span> <strong> <?php echo ($issparent[ 'SchoolEmail']=='Father' )? 'School':'Father';?> Email </strong>
									<i><?php echo $issparent['FatherEmail'];?></i></span>
							</label>
						</div>
						<div class="text-danger col-md-offset-4">
              <?php if (isset($error['EmailAddress'])) echo $errors['EmailAddress']; ?>
            </div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="rfpanel col-md-11 text-primary">

					<div class="form-group">
						<label class="col-md-2 control-label"> <strong> Request</strong>
						</label>
						<div class="col-md-10">
							<label class="radio-inline" for="requesttype"> <input
								type="radio" id="requesttype" name="requesttype" value="normal"
								checked=""> <span><Strong> Noraml </Strong></span>
							</label> <label class="radio-inline" for="requesttype"> <input
								type="radio" id="requesttype" name="requesttype"
								value="registration"> <span><Strong> Registration Request</Strong></span>
							</label> <label class="radio-inline" for="requesttype"> <input
								type="radio" id="requesttype" name="requesttype" value="payment">
								<span><Strong> Payment Request</Strong></span>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="rfpanel col-md-10 text-primary">
					<label class="col-md-2 control-label" for="EmailSubject">Email
						Subject</label>
					<div class="col-md-10 input-group">
						<input size="200" class="form-control input-md" type="text"
							id="emailsubject" name="emailsubject" maxlength="256" />
					</div>
					<div class="text-danger col-md-offset-4">
            <?php if (isset($error['EmailSubject'])) echo $errors['EmailSubject']; ?>
          </div>
				</div>
			</div>
			<div class="row">
				<div class="rfpanel col-md-10 text-primary">
					<label class="col-md-2 control-label" for="EmailBody">Email Body</label>
					<div class="col-md-10 input-group">
						<textarea rows="4" cols="60" class="form-control input-md"
							type="text" id="emailbody" name="emailbody" maxlength="256">
            </textarea>
					</div>
					<div class="text-danger col-md-offset-4">
            <?php if (isset($error['EmailBody'])) echo $errors['EmailBody']; ?>
          </div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-10">
					<ul class="list-inline text-center">
						<li>
							<button type="submit" name="submit" value="save"
								class="btn btn-primary">Send Email</button>
						</li>
				
				</div>
			</div>
		</form>
  <?php
	
}
}
?>

    <script>
      $(document).ready(function() {
        $('input[type=radio][name=requesttype]').on('change', function() {
          switch ($(this).val()) {
            case 'payment':
              requesttypefunc(true);
              break;
            case 'registration':
              requesttypefunc(true);
              break;
            case 'normal':
              requesttypefunc(false);
              break;
          }
        });
      });

      function requesttypefunc(checked) {
        if (checked) {
          $('#emailsubject').prop('disabled', true);
          $('#emailbody').prop('disabled', true);
        } else {
          $('#emailsubject').prop('disabled', false);
          $('#emailbody').prop('disabled', false);
        }
      }
    </script>

    <?php require("includes/footer.php"); ?>
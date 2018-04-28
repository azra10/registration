<form class="form-horizontal" method="post"
	action="<?php echo $issformposturl;?>" enctype="multipart/form-data">
  <?php wp_nonce_field('iss-edit-parents-form-page', '_wpnonce-iss-edit-parents-form-page') ?>
    <input type="hidden" id="tabname" name="tabname" value="home" /> <input
		type="hidden" id="ParentID" name="ParentID"
		value="<?php echo $parentid; ?>" /> <input type="hidden"
		id="RegistrationYear" name="RegistrationYear"
		value="<?php echo $regyear; ?>" />
    <?php wp_nonce_field('iss-edit-parents-form-page', '_wpnonce-iss-edit-parents-form-page') ?>

    <div class="row">
		<div class="col-md-offset-1 globalformerror text-warning"></div>
	</div>
	<div class="row">
		<div class="col-md-offset-1 text-danger formerror"><?php echo $errorstring ?></div>
	</div>
	<div class="row">
		<div class="rfpanel col-md-5">

			<legend>HOME ADDRESS #1</legend>

			<!-- Text input-->
			<div class="form-group row">
				<label class="col-md-4 control-label" for="HomeStreetAddress">Address
					<span class="text-danger">*</span>
				</label>
				<div class="col-md-7 input-group">
					<input class="form-control input-md"
						placeholder="Street Address (required)" type="text"
						<?php if (!$edit) { echo "disabled"; } ?>
						value="<?php echo $issparent['HomeStreetAddress']; ?>"
						id="HomeStreetAddress" name="HomeStreetAddress" required=""
						maxlength="200"> <span class="input-group-addon danger"><span
						class="glyphicon glyphicon-remove"></span></span>
				</div>
				<div class="text-danger col-md-offset-4"><?php if (isset($errors['HomeStreetAddress'])) echo $errors['HomeStreetAddress']; ?> </div>
			</div>

			<!-- Text input-->
			<div class="form-group row">
				<label class="col-md-4 control-label" for="HomeCity">City <span
					class="text-danger">*</span></label>
				<div class="col-md-7 input-group">
					<input class="form-control input-md" placeholder="City (required)"
						type="text" <?php if (!$edit) { echo "disabled"; } ?>
						value="<?php echo $issparent['HomeCity']; ?>" id="HomeCity"
						name="HomeCity" required="" maxlength="100"> <span
						class="input-group-addon danger"><span
						class="glyphicon glyphicon-remove"></span></span>
				</div>
				<div class="text-danger col-md-offset-4"><?php if (isset($errors['HomeCity'])) echo $errors['HomeCity']; ?> </div>
			</div>

			<!-- Text input-->
			<div class="form-group row">
				<label class="col-md-4 control-label" for="HomeZipCode">Zip Code <span
					class="text-danger">*</span></label>
				<div class="col-md-7 input-group" data-validate="number">
					<input class="form-control input-md"
						placeholder="Zip Code (required)" type="text"
						<?php if (!$edit) { echo "disabled"; } ?>
						value="<?php echo $issparent['HomeZip']; ?>" id="HomeZipCode"
						name="HomeZip" required="" maxlength="5" validate="true"> <span
						class="input-group-addon danger"><span
						class="glyphicon glyphicon-remove"></span></span>
				</div>
				<div class="text-danger col-md-offset-4"><?php if (isset($errors['HomeZip'])) echo $errors['HomeZip']; ?> </div>
			</div>

			<!-- Prepended text-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="HomePhone">Home Phone <span
					class="text-danger">*</span></label>

				<div class="col-md-7 input-group" data-validate="phone">
					<input class="form-control input-md"
						placeholder="Home Phone (required)" type="text"
						<?php if (!$edit) { echo "disabled"; } ?>
						value="<?php echo $issparent['HomePhone']; ?>" id="HomePhone"
						name="HomePhone" required="" maxlength="20" validate="true"> <span
						class="input-group-addon"><i class=" glyphicon glyphicon-earphone"
						aria-hidden="true"></i></span>
				</div>
			</div>
			<div class="text-danger col-md-offset-4"><?php if (isset($errors['HomePhone'])) echo $errors['HomePhone']; ?> </div>
		</div>

		<div class="rfpanel col-md-5">

			<legend>
				HOME ADDRESS #2 <span class="text-warning">(optional)</span>
			</legend>

			<!-- Text input-->
			<div class="form-group row">
				<label class="col-md-4 control-label" for="MotherStreetAddress">Street
					Address</label>
				<div class="col-md-7 input-group">
					<input class="form-control input-md"
						placeholder="Address (optional)" type="text"
						<?php if (!$edit) { echo "disabled";} ?>
						value="<?php echo $issparent['MotherStreetAddress']; ?>"
						id="MotherStreetAddress" name="MotherStreetAddress"
						maxlength="200"> <span class="input-group-addon"><span
						class="glyphicon glyphicon-ok"></span>
				
				</div>
				<div class="text-danger col-md-offset-4"><?php if (isset($errors['MotherStreetAddress'])) echo $errors['MotherStreetAddress']; ?> </div>
			</div>

			<!-- Text input-->
			<div class="form-group row">
				<label class="col-md-4 control-label" for="home2city">City</label>
				<div class="col-md-7 input-group">
					<input class="form-control input-md" placeholder="City (optional)"
						type="text" <?php if (!$edit) { echo "disabled"; } ?>
						value="<?php echo $issparent['MotherCity']; ?>" id="MotherCity"
						name="MotherCity" maxlength="100"> <span class="input-group-addon"><span
						class="glyphicon glyphicon-ok"></span>
				
				</div>
				<div class="text-danger col-md-offset-4"><?php if (isset($errors['MotherCity'])) echo $errors['MotherCity']; ?> </div>
			</div>

			<!-- Text input-->
			<div class="form-group row">
				<label class="col-md-4 control-label" for="MotherZip">Zip Code</label>
				<div class="col-md-7 input-group" data-validate="number">
					<input class="form-control input-md"
						placeholder="Zip Code (optional)" type="text"
						<?php if (!$edit) { echo "disabled"; } ?>
						value="<?php echo $issparent['MotherZip']; ?>" id="MotherZip"
						name="MotherZip" maxlength="5" validate="true"> <span
						class="input-group-addon "><span class="glyphicon glyphicon-ok"></span></span>
				</div>
				<div class="text-danger col-md-offset-4"><?php if (isset($errors['MotherZip'])) echo $errors['MotherZip']; ?> </div>
			</div>

			<!-- Prepended text-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="MotherHomePhone">Home
					Phone</label>
				<div class="col-md-7 input-group" data-validate="phone">
					<input class="form-control input-md"
						placeholder="Home Phone (optional)" type="text"
						<?php if (!$edit) {  echo "disabled"; }?>
						value="<?php echo $issparent['MotherHomePhone']; ?>"
						id="MotherHomePhone" name="MotherHomePhone" maxlength="20"
						validate="true"> <span class="input-group-addon"><i
						class=" glyphicon glyphicon-earphone" aria-hidden="true"></i></span>
				</div>
				<div class="text-danger col-md-offset-4"><?php if (isset($errors['MotherHomePhone'])) echo $errors['MotherHomePhone']; ?> </div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="rfpanel col-md-10 text-primary">

			<!-- Multiple Radios -->
			<div class="form-group">
				<label class="col-md-10  control-label" for="schoolemail"> Listing
					of Home Address, Home Phone Number and Home Email Address in the
					School Directory. </label>
				<div class="col-md-2">
					<label class="radio-inline" for="ShareAddress"> <input type="radio"
						name="ShareAddress" value="Yes"
						<?php echo (empty($issparent['ShareAddress']) || ($issparent['ShareAddress']=='Yes'))?'checked':'' ?>
						size="5" <?php if (!$edit) {  echo "disabled"; }?>><Strong> Yes</Strong>
					</label> <label class="radio-inline" for="ShareAddress"> <input
						type="radio" name="ShareAddress" value="No"
						<?php echo ($issparent['ShareAddress']=='No')?'checked':'' ?>
						size="5" <?php if (!$edit) {  echo "disabled"; }?>><Strong> No</Strong>
					</label>
				</div>
				<div class="text-danger col-md-offset-8"><?php if (isset($errors['ShareAddress'])) echo $errors['ShareAddress']; ?> </div>
			</div>
			<!-- Multiple Radios -->
			<div class="form-group">
				<label class="col-md-10  control-label" for="TakePicture">
					Permission to take Child's Picture. </label>
				<div class="col-md-2">
					<label class="radio-inline" for="TakePicture"> <input type="radio"
						name="TakePicture" value="Yes"
						<?php echo (empty($issparent['TakePicture']) || ($issparent['TakePicture']=='Yes'))?'checked':'' ?>
						size="5" <?php if (!$edit) {  echo "disabled"; }?>><Strong> Yes</Strong>
					</label> <label class="radio-inline" for="TakePicture"> <input
						type="radio" name="TakePicture" value="No"
						<?php echo ($issparent['TakePicture']=='No')?'checked':'' ?>
						size="5" <?php if (!$edit) {  echo "disabled"; }?>><Strong> No</Strong>
					</label>
				</div>
				<div class="text-danger col-md-offset-8"><?php if (isset($errors['TakePicture'])) echo $errors['TakePicture']; ?> </div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-offset-1 col-md-4 "></div>
		<div class="col-md-5">
			<ul class="list-inline pull-right">
				<li><button type="button" class="btn btn-primary prev-step"
						data-toggle="tooltip" data-placement="top"
						title="Leave without saving changes.">Previous</button></li>
				<li><button type="button" class="btn btn-primary next-step"
						data-toggle="tooltip" data-placement="top"
						title="Leave without saving changes.">Next</button>
				
				<li>
                <?php if ($edit) { ?>
                
				
				<li><button type="submit" class="btn btn-primary"
						data-toggle="tooltip" data-placement="top"
						title="All required fields must be filled in!">Save Changes</button>
				
				<li>
                <?php } ?>
            
			
			</ul>
		</div>
	</div>
</form>

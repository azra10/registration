<form class="form-horizontal" method="post"
	action="<?php echo $issformposturl;?>" enctype="multipart/form-data">
    <?php wp_nonce_field('iss-edit-parents-form-page', '_wpnonce-iss-edit-parents-form-page') ?>
    <input type="hidden" id="ParentID" name="ParentID"
		value="<?php echo $parentid; ?>" /> <input type="hidden"
		id="RegistrationYear" name="RegistrationYear"
		value="<?php echo $regyear; ?>" /> <input type="hidden" id="tabname"
		name="tabname" value="contact" />

	<div class="row">
		<div class="col-md-offset-1 globalformerror text-warning"></div>
	</div>
	<div class="row">
		<div class="col-md-offset-1 text-danger formerror"><?php echo $errorstring ?></div>
	</div>
	<div class="row">
		<div class="rfpanel col-md-5">

			<legend>CONTACT #1</legend>

			<!-- Text input-->
			<div class="form-group row">
				<label class="col-md-4 control-label" for="EmergencyContactName1">Name
					<span class="text-danger">*</span>
				</label>
				<div class="col-md-7 input-group">
					<input class="form-control input-md" placeholder="Name (reuired)"
						type="text" <?php if (!$edit) { echo "disabled"; } ?>
						value="<?php echo $issparent['EmergencyContactName1']; ?>"
						id="EmergencyContactName1" name="EmergencyContactName1"
						required="" maxlength="100"> <span
						class="input-group-addon danger"><span
						class="glyphicon glyphicon-remove"></span></span>
				</div>
				<div class="text-danger col-md-offset-4"><?php if (isset($errors['EmergencyContactName1'])) echo $errors['EmergencyContactName1']; ?> </div>
			</div>

			<!-- Prepended text-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="EmergencyContactPhone1">Phone
					<span class="text-danger">*</span>
				</label>
				<div class="col-md-7 input-group" data-validate="phone">
					<input class="form-control input-md" placeholder="Phone (reuired)"
						type="text" <?php if (!$edit) { echo "disabled"; } ?>
						value="<?php echo $issparent['EmergencyContactPhone1']; ?>"
						id="EmergencyContactPhone1" name="EmergencyContactPhone1"
						required="" maxlength="20" validate="true"> <span
						class="input-group-addon"><i class="glyphicon glyphicon-phone"
						aria-hidden="true"></i></span>
				</div>
			</div>
			<div class="text-danger col-md-offset-4"><?php if (isset($errors['EmergencyContactPhone1'])) echo $errors['EmergencyContactPhone1']; ?> </div>
		</div>

		<div class="rfpanel col-md-5">

			<legend>CONTACT #2 </legend>

			<!-- Text input-->
			<div class="form-group row">
				<label class="col-md-4 control-label" for="EmergencyContactName2">Name
					<span class="text-danger">*</span>
				</label>
				<div class="col-md-7 input-group">
					<input class="form-control input-md" placeholder="Name (reuired)"
						type="text" <?php if (!$edit) { echo "disabled"; } ?>
						value="<?php echo $issparent['EmergencyContactName2']; ?>"
						id="EmergencyContactName2" name="EmergencyContactName2"
						required="" maxlength="100"> <span
						class="input-group-addon danger"><span
						class="glyphicon glyphicon-remove"></span></span>
				</div>
				<div class="text-danger col-md-offset-4"><?php if (isset($errors['EmergencyContactName2'])) echo $errors['EmergencyContactName2']; ?> </div>
			</div>

			<!-- Prepended text-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="EmergencyContactPhone2">Phone
					<span class="text-danger">*</span>
				</label>

				<div class="col-md-7 input-group" data-validate="phone">
					<input class="form-control input-md" placeholder="Phone (reuired)"
						type="text" <?php if (!$edit) { echo "disabled"; } ?>
						value="<?php echo $issparent['EmergencyContactPhone2']; ?>"
						id="EmergencyContactPhone2" name="EmergencyContactPhone2"
						required="" maxlength="20" validate="true"> <span
						class="input-group-addon"><i class=" glyphicon glyphicon-phone"
						aria-hidden="true"></i></span>
				</div>
				<div class="text-danger col-md-offset-4"><?php if (isset($errors['EmergencyContactPhone2'])) echo $errors['EmergencyContactPhone2']; ?> </div>
			</div>

		</div>
	</div>

	<div class="row">
		<div class="rfpanel col-md-10 text-primary">
			<label class="col-md-2 control-label" for="SpecialNeedNote">Special
				Needs</label>
			<div class="col-md-10 input-group">
				<div>Does your child require any special needs at regular school or
					any food allergies that we should know about?</div>
				<textarea rows="4" cols="60" class="form-control input-md"
					type="text" <?php if (!$edit) { echo "disabled"; } ?>
					id="SpecialNeedNote" name="SpecialNeedNote" maxlength="256"><?php echo $issparent['SpecialNeedNote']; ?>
          </textarea>
			</div>
			<div class="text-danger col-md-offset-4">
          <?php if (isset($errors['SpecialNeedNote'])) echo $errors['SpecialNeedNote']; ?>
        </div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-offset-1 col-md-4 "></div>
		<div class="col-md-5">
			<ul class="list-inline pull-right skiptab">
				<li><button type="button" class="btn btn-primary prev-step"
						data-toggle="tooltip" data-placement="top"
						title="Leave without saving changes.">Previous</button></li>
				<li><button type="button" class="btn btn-primary next-step"
						data-toggle="tooltip" data-placement="top"
						title="Leave without saving changes.">Next</button></li>
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

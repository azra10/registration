<form class="form-horizontal" method="post"
	action="<?php echo $issformposturl;?>" enctype="multipart/form-data">
  <?php wp_nonce_field('iss-edit-parents-form-page', '_wpnonce-iss-edit-parents-form-page') ?>
    <input type="hidden" id="ParentID" name="ParentID"
		value="<?php echo $parentid; ?>" /> <input type="hidden"
		id="ParentStatus" name="ParentStatus"
		value="<?php if (isset($issparent['ParentStatus'])) {echo $issparent['ParentStatus'];} else {echo 'new';} ?>  " /> <input  
		type="hidden" id="RegistrationYear" name="RegistrationYear"
		value="<?php echo $regyear; ?>" /> <input type="hidden" id="tabname"
		name="tabname" value="parent" />
		<?php if (!isset($issparent['ParentNew'])) { ?>
		<input type="hidden" id="ParentNew" name="ParentNew" value="Yes">
		<?php }?>                     
		
	<div class="row">
		<div class="col-md-offset-1 globalformerror text-warning"></div>
	</div>
	<div class="row">
		<div class="col-md-offset-1 text-danger formerror"><?php echo $errorstring ?></div>
	</div>

	<div class="row">
		<div class="rfpanel col-md-5">

			<legend>FATHER</legend>
			<!-- Text input-->
			<div class="form-group row">
				<label class="col-md-4 control-label" for="FatherLastName"> Last
					Name <span class="text-danger">*</span>
				</label>
				<div class="col-md-7 input-group">
					<input class="form-control input-md"
						placeholder="Father Last Name (required)" type="text"
						<?php if (!$edit) { echo "disabled"; } ?>
						value="<?php if (isset($issparent['FatherLastName'])) echo $issparent['FatherLastName']; ?>"
						id="FatherLastName" name="FatherLastName" required="true"
						maxlength="100"> <span class="input-group-addon danger"><span
						class="glyphicon glyphicon-remove"></span></span>
				</div>
				<div class="text-danger col-md-offset-4">
            <?php if (isset($errors['FatherLastName'])) echo $errors['FatherLastName']; ?>
          </div>
			</div>

			<!-- Text input-->
			<div class="form-group row">
				<label class="col-md-4 control-label" for="FatherFirstName"> First
					Name <span class="text-danger">*</span>
				</label>
				<div class="col-md-7 input-group">
					<input class="form-control input-md"
						placeholder="Father First Name (required)" type="text"
						<?php if (!$edit) { echo "disabled"; } ?>
						value="<?php if (isset($issparent['FatherFirstName'])) echo $issparent['FatherFirstName']; ?>"
						id="FatherFirstName" name="FatherFirstName" required=""
						maxlength="100"> <span class="input-group-addon danger"><span
						class="glyphicon glyphicon-remove"></span></span>
				</div>
				<div class="text-danger col-md-offset-4">
            <?php if (isset($errors['FatherFirstName'])) echo $errors['FatherFirstName']; ?>
          </div>
			</div>

			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="FatherCellPhone"> Cell
					Phone <span class="text-danger">*</span>
				</label>
				<div class="col-md-7 input-group" data-validate="phone">
					<input class="form-control input-md"
						placeholder="Father Cell Phone (required)" type="text"
						<?php if (!$edit) { echo "disabled"; } ?>
						value="<?php if (isset($issparent['FatherCellPhone'])) echo $issparent['FatherCellPhone']; ?>"
						id="FatherCellPhone" name="FatherCellPhone" maxlength="20"
						required="true" validate="true"> <span class="input-group-addon"><i
						class=" glyphicon glyphicon-phone" aria-="" hidden="true"></i></span>
				</div>
				<div class="text-danger col-md-offset-4">
					<?php if (isset($errors['FatherCellPhone'])) echo $errors['FatherCellPhone']; ?>
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="FatherEmail"> Email </label>
				<div class="col-md-7 input-group" data-validate="email">
					<input class="form-control input-md"
						placeholder="Father Email (optional)" type="text"
						<?php if (!$edit) { echo "disabled"; } ?>
						value="<?php if (isset($issparent['FatherEmail'])) echo $issparent['FatherEmail']; ?>" 
						id="FatherEmail" name="FatherEmail"  maxlength="100" 
						validate="true"> <span class="input-group-addon"> <i class="glyphicon glyphicon-envelope"
						aria-="" hidden="true"></i></span>
				</div>
				<div class="text-danger col-md-offset-4">
					<?php if (isset($errors['FatherEmail'])) echo $errors['FatherEmail']; ?>
				</div>
			</div>

			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="FatherWorkPhone">Work
					Phone</label>
				<div class="col-md-7 input-group" data-validate="phone">
					<input class="form-control input-md"
						placeholder="Father Work Phone (optional)" type="text"
						<?php if (!$edit) { echo "disabled"; } ?>
						value="<?php if (isset($issparent['FatherWorkPhone'])) echo $issparent['FatherWorkPhone']; ?>"
						id="FatherWorkPhone" name="FatherWorkPhone" maxlength="20"
						validate="true"> <span class="input-group-addon"><i
						class=" glyphicon glyphicon-earphone" aria-="" hidden="true"></i></span>
				</div>
			</div>
			<div class="text-danger col-md-offset-4">
          <?php if (isset($errors['FatherWorkPhone'])) echo $errors['FatherWorkPhone']; ?>
        </div>
		</div>
		<div class="rfpanel col-md-5">

			<legend>MOTHER</legend>
			<!-- Text input-->
			<div class="form-group row">
				<label class="col-md-4 control-label" for="MotherLastName"> Last
					Name <span class="text-danger">*</span>
				</label>
				<div class="col-md-7 input-group">
					<input class="form-control input-md"
						placeholder="Mother Last Name (required)" type="text"
						<?php if (!$edit) { echo "disabled"; } ?>
						value="<?php if (isset($issparent['MotherLastName'])) echo $issparent['MotherLastName']; ?>"
						id="MotherLastName" name="MotherLastName" required=""
						maxlength="100"> <span class="input-group-addon danger"><span
						class="glyphicon glyphicon-remove"></span></span>
				</div>
				<div class="text-danger col-md-offset-4">
					<?php if (isset($errors['MotherLastName'])) echo $errors['MotherLastName']; ?>
				</div>
			</div>

			<!-- Text input-->
			<div class="form-group row">
				<label class="col-md-4 control-label" for="MotherrFirstName"> First
					Name <span class="text-danger">*</span>
				</label>
				<div class="col-md-7 input-group">
					<input class="form-control input-md"
						placeholder="Mother First Name (required)" type="text"
						<?php if (!$edit) { echo "disabled"; } ?>
						value="<?php if (isset($issparent['MotherFirstName'])) echo $issparent['MotherFirstName']; ?>"
						id="MotherFirstName" name="MotherFirstName" required=""
						maxlength="100"> <span class="input-group-addon danger"><span
						class="glyphicon glyphicon-remove"></span> </span>
				</div>
				<div class="text-danger col-md-offset-4">
					<?php if (isset($errors['MotherFirstName'])) echo $errors['MotherFirstName']; ?>
				</div>
			</div>

			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="MotherCellPhone"> Cell Phone  </label>
				<div class="col-md-7 input-group" data-validate="phone">
					<input class="form-control input-md"
						placeholder="Mother Cell Phone (optional)" type="text"
						<?php if (!$edit) { echo "disabled"; } ?>
						value="<?php if (isset($issparent['MotherCellPhone'])) echo $issparent['MotherCellPhone']; ?>"
						id="MotherCellPhone" name="MotherCellPhone" 
						maxlength="20" validate="true"> <span class="input-group-addon"><i
						class=" glyphicon glyphicon-phone" aria-="" hidden="true"></i></span>
				</div>
				<div class="text-danger col-md-offset-4">
            <?php if (isset($errors['MotherCellPhone'])) echo $errors['MotherCellPhone']; ?>
          </div>
			</div>

			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="MotherEmail"> Email  </label>
				<div class="col-md-7 input-group" data-validate="email">
					<input class="form-control input-md"
						placeholder="Mother Email (optional)" type="text"
						<?php if (!$edit) { echo "disabled"; } ?>
						value="<?php if (isset($issparent['MotherEmail'])) echo $issparent['MotherEmail']; ?>" 
						id="MotherEmail" name="MotherEmail"  maxlength="100" validate="true">
					<span class="input-group-addon"><i
						class="glyphicon glyphicon-envelope" aria-="" hidden="true"></i></span>
				</div>
				<div class="text-danger col-md-offset-4">
					<?php if (isset($errors['MotherEmail'])) echo $errors['MotherEmail']; ?>
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="motherworkphone">Work
					Phone</label>
				<div class="col-md-7 input-group" data-validate="phone">
					<input class="form-control input-md"
						placeholder="Mother Work Phone (optional)" type="text"
						<?php if (!$edit) { echo "disabled"; } ?>
						value="<?php if (isset($issparent['MotherWorkPhone'])) echo $issparent['MotherWorkPhone']; ?>"
						id="MotherWorkPhone" name="MotherWorkPhone" maxlength="20"
						validate="true"> <span class="input-group-addon"><i
						class=" glyphicon glyphicon-earphone" aria-="" hidden="true"></i></span>
				</div>
			</div>
			<div class="text-danger col-md-offset-4">
          <?php if (isset($errors['MotherWorkPhone'])) echo $errors['MotherWorkPhone']; ?>
        </div>
		</div>
	</div>

	<div class="row">
		<div class="rfpanel col-md-5 text-primary">
			<!-- Multiple Radios -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="schoolemail"> <strong>SCHOOL
						EMAIL</strong>
				</label>
				<div class="col-md-7">
					<label class="radio-inline" for="schoolemail"> <input type="radio"
						name="SchoolEmail" value="Mother"
						<?php echo (isset($issparent['SchoolEmail']) && (($issparent[ 'SchoolEmail']=='Mother' ) || empty($issparent[ 'SchoolEmail']) || ($issparent[ 'SchoolEmail']!='Father' )))? 'checked': ''; ?>
						size="20" <?php if (!$edit) { echo "disabled"; } ?>> <Strong>
							Mother Email</Strong>
					</label> <label class="radio-inline" for="schoolemail"> <input
						type="radio" name="SchoolEmail" value="Father"
						<?php echo (isset($issparent['SchoolEmail']) && ($issparent[ 'SchoolEmail']=='Father' ))? 'checked': ''; ?>
						size="20" <?php if (!$edit) { echo "disabled"; } ?>> <Strong>
							Father Email</Strong>
					</label>
				</div>
				<div class="text-danger col-md-offset-4">
            <?php if (isset($errors['SchoolEmail'])) echo $errors['SchoolEmail']; ?>
          </div>
			</div>
		</div>

		<div class="rfpanel col-md-5">
			<div class="form-group">
				<label class="col-md-4 control-label" for="FamilySchoolStartYear"> <strong>School
						Start Year</strong>
				</label>
				<div class="col-md-7 input-group" data-validate="number">
					<input class="form-control input-md"
						placeholder="Start Year (Ex: 2010)" type="text"
						<?php if (!$edit) { echo "disabled"; } ?>
						value="<?php if (isset($issparent['FamilySchoolStartYear'])) echo $issparent['FamilySchoolStartYear']; ?>"
						id="FamilySchoolStartYear" name="FamilySchoolStartYear"
						maxlength="5" validate="true"> <span class="input-group-addon"><span
						class="glyphicon glyphicon-ok"></span></span>
				</div>
				<div class="text-danger col-md-offset-4">
            <?php if (isset($errors['FamilySchoolStartYear'])) echo $errors['FamilySchoolStartYear']; ?>
          </div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-10">
			<ul class="list-inline pull-right skiptab">
				<li>
					<button type="button" class="btn btn-primary next-step"
						data-toggle="tooltip" data-placement="top"
						title="Leave without saving changes.">Next</button>
				
				<li>
            <?php if ($edit) { ?>
            
				
				<li>
					<button type="submit" class="btn btn-primary" data-toggle="tooltip"
						data-placement="top"
						title="All required fields must be filled in!">Save Changes</button>
				
				<li>
            <?php } ?>
        
			
			</ul>
		</div>
	</div>
</form>
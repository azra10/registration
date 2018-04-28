
<div class="row">
	<div class="col-md-10">
		<div class="col-md-offset-4 globalformerror text-warning"></div>
		<div class="row">
			<div class="col-md-offset-1 text-danger formerror"><?php echo $errorstring ?></div>
		</div>

		<!-- Text input-->
		<div class="form-group ">
			<label class="col-md-4 control-label" for="StudentLastName">Last Name
				<span class="text-danger">*</span>
			</label>
			<div class="col-md-7 input-group">
				<input class="form-control input-md"
					placeholder="Student Last Name (required)" type="text"
					<?php if (!$edit) { echo "disabled"; } ?>
					value="<?php echo $student['StudentLastName']; ?>"
					id="StudentLastName" name="StudentLastName" required="true"
					maxlength="100"> <span class="input-group-addon danger"><span
					class="glyphicon glyphicon-remove"></span></span>
			</div>
			<div class="text-danger col-md-offset-4"><?php if (isset($errors[$student['StudentID'] . 'StudentLastName'])) echo $errors[$student['StudentID'] . 'StudentLastName']; ?> </div>
		</div>
		<!-- Text input-->
		<div class="form-group ">
			<label class="col-md-4 control-label" for="StudentFirstName">First
				Name <span class="text-danger">*</span>
			</label>
			<div class="col-md-7 input-group">
				<input class="form-control input-md"
					placeholder="Student First Name (required)" type="text"
					<?php if (!$edit) { echo "disabled"; } ?>
					value="<?php echo $student['StudentFirstName']; ?>"
					id="StudentFirstName" name="StudentFirstName" required="true"
					maxlength="100"> <span class="input-group-addon danger"><span
					class="glyphicon glyphicon-remove"></span></span>
			</div>
			<div class="text-danger col-md-offset-4"><?php if (isset($errors[$student['StudentID'] . 'StudentFirstName'])) echo $errors[$student['StudentID'] . 'StudentFirstName']; ?> </div>
		</div>
		<!-- Text input-->
		<!-- TODO selection is not causing validation event
     data-auto-close="true" data-start-date="-18y" data-end-date="-5y" data-date-format="yyyy-mm-dd" 
           -->
		<div class="form-group">
			<label class="col-md-4 control-label" for="StudentBirthDate">Birth
				Date <span class="text-danger">*</span>
			</label>
			<div class="col-md-7 input-group">
				<input name="StudentBirthDate" placeholder="Birth Date (required)"
					<?php if (!$edit) { echo "disabled"; } ?>
					value="<?php echo $student['StudentBirthDate']; ?>"
					class="form-control input-md datewidget" type="text" maxlength="10">
				<span class="input-group-addon"><span
					class="glyphicon glyphicon-calendar"></span></span>
			</div>
			<div class="text-danger col-md-offset-4 datewidgeterror"><?php if (isset($errors[$student['StudentID'] . 'StudentBirthDate'])) echo $errors[$student['StudentID'] . 'StudentBirthDate']; ?> </div>
		</div>
		<div class="form-group">
			<label class="col-md-4 control-label" for="StudentEmail"> Email </label>
			<div class="col-md-7 input-group" data-validate="email">
				<input class="form-control input-md"
					placeholder="Student Email (optional)" type="text"
					<?php if (!$edit) { echo "disabled"; } ?>
					value="<?php echo $student['StudentEmail']; ?>" id="StudentEmail"
					name="StudentEmail" maxlength="100" validate="true"> <span
					class="input-group-addon"> <i class="glyphicon glyphicon-envelope"
					aria-="" hidden="true"></i>
				</span>
			</div>
		</div>
		<!-- Text input-->
		<div class="form-group">
			<label class="col-md-4 control-label" for="StudentGender">Gender</label>
			<div class="col-md-7">
				<label class="radio-inline" for="StudentGender"> <input
					name="StudentGender" id="StudentGender" value="M" type="radio"
					<?php echo ($student['StudentGender']=='M' || empty($student['StudentGender']))?'checked':'' ?>>
					Male
				</label> <label class="radio-inline" for="studentStudentGender"> <input
					name="StudentGender" id="StudentGender" value="F" type="radio"
					<?php echo ($student['StudentGender']=='F')?'checked':'' ?>> Female
				</label>
			</div>
		</div>
		<!-- Select Basic -->
		<div class="form-group">
			<label class="col-md-4 control-label" for="RegularSchoolGrade">Regular
				School</label>
			<div class="col-md-7">
				<select id="RegularSchoolGrade" name="RegularSchoolGrade"
					class="form-control" title="Choose Regular School Grade"
					<?php if (!$edit) { echo "disabled"; } ?>>
					<option value="">Select</option>              
            <?php foreach ($regschclasslist as $id=> $value) { ?> 
                <option value="<?php echo $id;?>"
						<?php echo ($id == $student['RegularSchoolGrade']) ? ' selected' : '';?>><?php echo $value;?>
                </option> 
                    <?php } ?>                   
            </select>
				<div class="text-danger"><?php if (isset($errors[$student['StudentID'] . 'RegularSchoolGrade'])) echo $errors[$student['StudentID'] . 'RegularSchoolGrade']; ?> </div>
			</div>
		</div>
		<!--  Select Basic -->
		<div class="form-group">
			<label class="col-md-4 control-label" for="ISSGrade">Islamic School</label>
			<div class="col-md-7">
				<select class="form-control" id="ISSGrade" name="ISSGrade"
					title="Choose Islamic School Grade" required=""
					<?php if (!$edit) { echo "disabled"; } ?>>
					<option value="">Select</option>
                <?php foreach ($issclasslist as $id=> $value) { ?> 
                <option value="<?php echo $id;?>"
						<?php echo ($id == $student['ISSGrade']) ? ' selected' : '';?>><?php echo $value;?>
                </option> 
                    <?php } ?> 
            </select>
				<div class="text-danger"><?php if (isset($errors[$student['StudentID'] . 'ISSGrade'])) echo $errors[$student['StudentID'] . 'ISSGrade']; ?> </div>
			</div>
		</div>
		<!--  Select Basic -->
		<div class="form-group">
			<label class="col-md-4 control-label" for="StudentStatus">Status</label>
			<div class="col-md-7">
				<select id="StudentStatus" name="StudentStatus" class="form-control"
					<?php if (!$edit) { echo "disabled"; } ?>
					value="<?php echo $student['StudentStatus']; ?>">
					<option value="active"
						<?php echo ('active' == $student['StudentStatus']) ? ' selected' : '';?>>Active</option>
					<option value="inactive"
						<?php echo ('inactive' == $student['StudentStatus']) ? ' selected' : '';?>>Inactive</option>
				</select>
			</div>
		</div> 
    <?php if ($edit) {?>
    <div>
			<button type="submit" class="btn btn-primary col-md-offset-4"
				data-toggle="tooltip" data-placement="top"
				title="All required fields must be filled in!">Save Student</button>
			<span class="text-success formsucess"><?php if(isset($successstring)) echo $successstring; ?> </span>
		</div> 
    <?php } // if edit  ?>
     </div>
</div>
</form>

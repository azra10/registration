<?php if (iss_current_user_is_secretery()) { ?>

<legend>Admin Only</legend>
<div class="row">
	<div class="rfpanel col-md-5">

		<legend>INSTALLMENT #1</legend>

		<!-- Text input-->
		<div class="form-group row">
			<label class="col-md-4 control-label" for="PaymentInstallment1">Payment
				Amount</label>
			<div class="col-md-7 input-group" data-validate="number">
				<span class="input-group-addon">$</span> <input
					class="form-control input-md" placeholder="Payment Amount"
					type="text" <?php if (!$edit) { echo "disabled"; } ?>
					value="<?php echo $issparent['PaymentInstallment1']; ?>"
					id="PaymentInstallment1" name="PaymentInstallment1" maxlength="100"
					validate="true"> <span class="input-group-addon"><span
					class="glyphicon glyphicon-ok"></span></span>
			</div>
			<div class="text-danger col-md-offset-4">
            <?php if (isset($errors['PaymentInstallment1'])) echo $errors['PaymentInstallment1']; ?>
          </div>
		</div>

		<!-- Text input-->
		<div class="form-group row">
			<label class="col-md-4 control-label" for="PaymentMethod1">Payment
				Method </label>
			<div class="col-md-7 input-group">
				<input class="form-control input-md" placeholder="Payment Method"
					type="text" <?php if (!$edit) { echo "disabled"; } ?>
					value="<?php echo $issparent['PaymentMethod1']; ?>"
					id="PaymentMethod1" name="PaymentMethod1" maxlength="100"> <span
					class="input-group-addon"><span class="glyphicon glyphicon-ok"></span></span>
			</div>
			<div class="text-danger col-md-offset-4">
            <?php if (isset($errors['PaymentMethod1'])) echo $errors['PaymentMethod1']; ?>
          </div>
		</div>
		<!-- Prepended text-->
		<div class="form-group">
			<label class="col-md-4 control-label" for="PaymentDate1">Payment Date
			</label>
			<div class="col-md-7 input-group">
				<input class="form-control input-md datewidget"
					placeholder="Payment Date " type="text"
					<?php if (!$edit) { echo "disabled"; } ?>
					data-date-format="yyyy-mm-dd"
					value="<?php echo $issparent['PaymentDate1']; ?>" id="PaymentDate1"
					name="PaymentDate1" maxlength="10"> <span class="input-group-addon"><i
					class="glyphicon glyphicon-calendar" aria-hidden="true"></i></span>
			</div>
			<div class="text-danger col-md-offset-4">
            <?php if (isset($errors['PaymentDate1'])) echo $errors['PaymentDate1']; ?>
          </div>
		</div>

	</div>

	<div class="rfpanel col-md-5">

		<legend>INSTALLMENT #2 </legend>

		<!-- Text input-->
		<div class="form-group row">
			<label class="col-md-4 control-label" for="PaymentInstallment2">Payment
				Amount</label>
			<div class="col-md-7 input-group" data-validate="number">
				<span class="input-group-addon">$</span> <input
					class="form-control input-md" placeholder="Payment Amount"
					type="text" <?php if (!$edit) { echo "disabled"; } ?>
					value="<?php echo $issparent['PaymentInstallment2']; ?>"
					id="PaymentInstallment2" name="PaymentInstallment2" maxlength="100"
					validate="true"> <span class="input-group-addon"><span
					class="glyphicon glyphicon-ok"></span></span>
			</div>
			<div class="text-danger col-md-offset-4">
            <?php if (isset($errors['PaymentInstallment2'])) echo $errors['PaymentInstallment2']; ?>
          </div>
		</div>

		<!-- Text input-->
		<div class="form-group row">
			<label class="col-md-4 control-label" for="PaymentMethod2">Payment
				Method </label>
			<div class="col-md-7 input-group">
				<input class="form-control input-md" placeholder="Payment Method"
					type="text" <?php if (!$edit) { echo "disabled"; } ?>
					value="<?php echo $issparent['PaymentMethod2']; ?>"
					id="PaymentMethod2" name="PaymentMethod2" maxlength="100"> <span
					class="input-group-addon"><span class="glyphicon glyphicon-ok"></span></span>
			</div>
			<div class="text-danger col-md-offset-4">
            <?php if (isset($errors['PaymentMethod2'])) echo $errors['PaymentMethod2']; ?>
          </div>
		</div>
		<!-- Prepended text-->
		<div class="form-group">
			<label class="col-md-4 control-label" for="PaymentDate2">Payment Date</label>

			<div class="col-md-7 input-group">
				<input class="form-control input-md datewidget"
					placeholder="Payment Date " type="text"
					<?php if (!$edit) { echo "disabled"; } ?>
					data-date-format="yyyy-mm-dd"
					value="<?php echo $issparent['PaymentDate2']; ?>" id="PaymentDate2"
					name="PaymentDate2" maxlength="10"> <span class="input-group-addon"><i
					class=" glyphicon glyphicon-calendar" aria-hidden="true"></i></span>
			</div>
			<div class="text-danger col-md-offset-4">
            <?php if (isset($errors['PaymentDate2'])) echo $errors['PaymentDate2']; ?>
          </div>
		</div>

	</div>
</div>
<div class="row">
	<div class="rfpanel col-md-5">
		<div class="row">
			<label class="col-md-4 control-label" for="Comments">Paid In Full</label>
			<div class="col-md-7">
				<label class="radio-inline" for="PaidInFull"> <input type="radio"
					name="PaidInFull" value="Yes"
					<?php echo ($issparent[ 'PaidInFull']=='Yes')? 'checked': '' ?>
					size="3" <?php if (!$edit) { echo "disabled"; } ?>> <Strong> Yes</Strong>
				</label> <label class="radio-inline" for="PaidInFull"> <input
					type="radio" name="PaidInFull" value="No"
					<?php echo (($issparent[ 'PaidInFull']!='Yes' ))? 'checked': '' ?>
					size="3" <?php if (!$edit) { echo "disabled"; } ?>> <Strong> No</Strong>
				</label>
			</div>
		</div>
		<div class="row">
			<label class="col-md-4 control-label" for="FinancialAid">Financial Aid</label>
			<div class="col-md-7">
				<label class="radio-inline" for="FinancialAid"> <input type="radio"
					name="FinancialAid" value="Yes"
					<?php echo ($issparent[ 'FinancialAid']=='Yes')? 'checked': '' ?>
					size="3" <?php if (!$edit) { echo "disabled"; } ?>> <Strong> Yes</Strong>
				</label> <label class="radio-inline" for="FinancialAid"> <input
					type="radio" name="FinancialAid" value="No"
					<?php echo (($issparent[ 'FinancialAid']!='Yes' ))? 'checked': '' ?>
					size="3" <?php if (!$edit) { echo "disabled"; } ?>> <Strong> No</Strong>
				</label>
			</div>
		</div>
	</div>
	<div class="rfpanel col-md-5">
		<label class="col-md-4 control-label" for="TotalAmountDue">Total
			Amount Due</label>
		<div class="col-md-7 input-group" data-validate="number">
			<span class="input-group-addon">$</span> <input
				class="form-control input-md" placeholder="Total Amount Due"
				type="text" <?php if (!$edit) { echo "disabled"; } ?>
				value="<?php echo $issparent['TotalAmountDue']; ?>"
				id="TotalAmountDue" name="TotalAmountDue" maxlength="100"
				validate="true"> <span class="input-group-addon"><span
				class="glyphicon glyphicon-ok"></span></span>
		</div>
		<div class="text-danger col-md-offset-4">
          <?php if (isset($errors['TotalAmountDue'])) echo $errors['TotalAmountDue']; ?>
        </div>
	</div>
</div>
<div class="row">
	<div class="rfpanel col-md-10">
		<label class="col-md-2 control-label" for="Comments">Registration
			Status</label>
		<div class="col-md-8">
			<!--<label class="radio-inline" for="RegistrationComplete"> <input
				type="radio" name="RegistrationComplete" value="New"
				<?php echo (($issparent[ 'RegistrationComplete']=='New' ) || empty($issparent[ 'RegistrationComplete']))? 'checked': '' ?>
				size="3" <?php if (!$edit) { echo "disabled"; } ?>> <Strong> New Family</Strong>
			</label> -->
			<label class="radio-inline" for="RegistrationComplete"> <input
				type="radio" name="RegistrationComplete" value="Open"
				<?php echo (($issparent[ 'RegistrationComplete']=='Open' ) || empty($issparent[ 'RegistrationComplete']))? 'checked': '' ?>
				size="3" <?php if (!$edit) { echo "disabled"; } ?>> <Strong> Open Enrollment</Strong>
			</label> 
			<!--<label class="radio-inline" for="RegistrationComplete"> <input
				type="radio" name="RegistrationComplete" value="Pending"
				<?php echo ($issparent[ 'RegistrationComplete']=='Pending' )? 'checked': '' ?>
				size="3" <?php if (!$edit) { echo "disabled"; } ?>> <Strong> Pending Staff
					Approval</Strong>
			</label> -->
			
			<label class="radio-inline" for="RegistrationComplete"> <input
				type="radio" name="RegistrationComplete" value="Complete"
				<?php echo ($issparent[ 'RegistrationComplete']=='Complete' )? 'checked': '' ?>
				size="3" <?php if (!$edit) { echo "disabled"; } ?>> <Strong>
					Complete</Strong>
			</label>

		</div>
	</div>
</div>
<div class="row">
	<div class="rfpanel col-md-10 text-primary">
		<label class="col-md-2 control-label" for="Comments">Comments</label>
		<div class="col-md-10 input-group">
			<textarea rows="4" cols="60" class="form-control input-md"
				type="text" <?php if (!$edit) { echo "disabled"; } ?> id="Comments"
				name="Comments" maxlength="256"><?php echo $issparent['Comments']; ?>
          </textarea>
		</div>
		<div class="text-danger col-md-offset-4 col-md-8">
          <?php if (isset($errors['Comments'])) echo $errors['Comments']; ?>
        </div>
	</div>
</div>

<div class="row">
	<div class="col-md-10">
		<ul class="list-inline text-center">
			<li><button type="button" class="btn btn-primary prev-step"
					data-toggle="tooltip" data-placement="top"
					title="Leave without saving changes.">Previous</button></li>
			<?php if ($edit) {?>
			<li>
				<button type="submit" name="submit" value="save"
					class="btn btn-primary" data-toggle="tooltip" data-placement="top"
					title="All required fields must be filled in!">Save Changes</button>
			</li>
			<?php } // if edit  ?>
	</div>
</div>


    <?php } // if admin ?>
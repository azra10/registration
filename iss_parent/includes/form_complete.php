<form class="form-horizontal" method="post"
	action="<?php echo $issformposturl;?>" enctype="multipart/form-data">
    <?php wp_nonce_field('iss-edit-parents-form-page', '_wpnonce-iss-edit-parents-form-page') ?>
    <input type="hidden" id="ParentID" name="ParentID"
        value="<?php echo $parentid; ?>" /> <input type="hidden" id="tabname"
        name="tabname" value="complete" /> <input type="hidden"
        id="RegistrationYear" name="RegistrationYear"
        value="<?php echo $regyear; ?>" />

    <div>
        <div class="col-md-offset-0 col-md-10 globalformerror text-warning"></div>
    </div>
    <div class="row">
        <div class="col-md-offset-1 text-danger formerror">
        <?php echo $errorstring ?>
      </div>
    </div>

<?php if (!iss_current_user_is_secretery()) { ?>
      <div class="row">
        <div class="rfpanel col-md-5">
        	<div class="form-group row">
				<label class="col-md-4 control-label" for="Comments">Paid In Full</label>
				<div class="col-md-7">
					<label class="radio-inline" for="PaidInFull"> <input type="radio"
						name="PaidInFull" value="Yes"
						<?php echo ($issparent[ 'PaidInFull']=='Yes' )? 'checked': '' ?>
						size="3" disabled=""> <Strong> Yes</Strong>
					</label> <label class="radio-inline" for="PaidInFull"> <input
						type="radio" name="PaidInFull" value="No"
						<?php echo (($issparent[ 'PaidInFull']!='Yes' ))? 'checked': '' ?>
						size="3" disabled=""> <Strong> No</Strong>
					</label>
				</div>
            </div>
            <div class="form-group row">
				<label class="col-md-4 control-label" for="TotalAmountDue">Total Amount Due</label>
				<div class="col-md-7 input-group" data-validate="number">
					<span class="input-group-addon">$</span> <input
						class="form-control input-md"  type="text" disabled="" value="
						<?php echo $issparent['TotalAmountDue']; ?>" > 
				</div>
            </div>
			<div class="form-group row">
				<label class="col-md-4 control-label" for="TotalAmountDue">Installment #1 Amount</label>
				<div class="col-md-7 input-group" data-validate="number">
					<span class="input-group-addon">$</span> <input
						class="form-control input-md"  type="text" disabled="" value="
						<?php echo $issparent['PaymentInstallment1']; ?>" > 
				</div>
            </div>
  			<div class="form-group row">
				<label class="col-md-4 control-label" for="TotalAmountDue">Installment #2 Amount</label>
				<div class="col-md-7 input-group" data-validate="number">
					<span class="input-group-addon">$</span> <input
						class="form-control input-md"  type="text" disabled="" value="
						<?php echo $issparent['PaymentInstallment2']; ?>" > 
				</div>
            </div>
        </div>
        <div class="rfpanel col-md-5">
            <div class="col-md-11  text-info"><b>PLEASE NOTE: </b>
            Should you require <b>financial assistance</b> then please indicate below
                appropriately. Additionally, please complete and return the
                financial aid assistance form separately. Please note: Financial Aid
                information is held in strict confidentiality.</div>            
        </div>
    </div>
<?php if (empty($issparent['RegistrationComplete']) || ($issparent['RegistrationComplete'] == 'Open')) { ?>
      <div class="row">
        <div class="rfpanel col-md-10  text-warning">Registration does not
            guarantee placement in a particular grade. Students are normally
            placed according to their age. However students who do not meet
            schools academic requirements will be held back to repeat their
            grade.</div>
    </div>
    <div class="row">
        <div class="agree col-md-10 input-group" data-validate="checked">
            &nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" id="agree"
                name="agree"> <span class="input-group-addon danger"> I agree to
                abide by all school rules and regulations. I understand that the
                school cannot be held held responsible or liable for any kind of
                damages.</span>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-10">
            <ul class="list-inline text-center">
                <li><button type="button" class="btn btn-primary prev-step"
                        data-toggle="tooltip" data-placement="top"
                        title="Leave without saving changes.">Previous</button></li>
                <li>
                    <button type="submit" name="submit" value="complete"
                        class="btn btn-primary completesubmit" data-toggle="tooltip"
                        data-placement="top"
                        title="All required fields must be filled in!">Complete
                        Registration - Pay Later</button>
                </li>
                <li>
                    <button type="submit" value="completepay"
                        class="btn btn-primary completesubmit" data-toggle="tooltip"
                        data-placement="top"
                        title="All required fields must be filled in!">Complete
                        Registration - Pay Online</button>
                </li>
                <input type="hidden" name="RegistrationComplete" value="Pending">
            </ul>
        </div>
    </div>
    <br />
<?php } else { ?>
 <div class="row">
        <div class="col-md-offset-1 col-md-4 "></div>
        <div class="col-md-5">
            <ul class="list-inline pull-right">
                <li><button type="button" class="btn btn-primary prev-step"
                        data-toggle="tooltip" data-placement="top"
                        title="Leave without saving changes.">Previous</button></li>
            </ul>
        </div>
    </div>

<?php
}
}
include ISS_PATH . '/includes/form_payment.php';
?>
</form>
<script>
  $(document).ready(function() {

  });
</script>
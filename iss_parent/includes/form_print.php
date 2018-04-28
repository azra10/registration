<div style="width: 930px;">
	<button id="submit-print" onclick="printContent('issviewpageid')"
		style="float: right; margin: 5px;"></button>
	<script>
    function printContent(el) {
      var restorepage = document.body.innerHTML;
      var printcontent = document.getElementById(el).innerHTML;
      document.body.innerHTML = printcontent;
      window.print();
      document.body.innerHTML = restorepage;
    }
  </script>
</div>
<div id="issviewpageid">
	<STYLE type="text/css">
#page1 {
	margin: 4px 0px 0px 0px;
	padding: 0px;
	width: 930px;
	border: black 1px solid;
}

#page2 {
	margin: 4px 0px 0px 0px;
	padding: 0px;
	width: 930px;
	border: black 1px solid;
}

#page2 div {
	padding: 5px 5px 5px 5px;
}

#page2 select {
	width: 80px;
}

#parent_form_table label {
	float: left;
}

#parent_form_table span {
	float: right;
	width: 250px;
}

#student_table span {
	width: 150px;
}

#student_table select {
	width: 80px;
}

.continue_page {
	font: italic bold .8em 'Calibri';
	line-height: 13px;
	float: right;
	vpage-break-after: always;
}

.p0 {
	text-align: center;
	padding-bottom: 4px
}

.ft0 {
	font: italic 1.4em 'Arial';
	line-height: 31px;
}

.ft1 {
	font: bold 1.1em 'Calibri';
	line-height: 27px;
}

.reg_fee {
	font: italic bold 1.4em 'Calibri';
	color: #900000;
	line-height: 23px;
	text-align: center;
	padding: 0px 24px 0px 24px;
	margin-top: 14px;
	margin-bottom: 0px;
}

.notehead {
	font: italic bold 1.5em 'Calibri';
	line-height: 18px;
	text-align: center;
	padding: 0px 5px 0px 5px;
}
.notetext {
	line-height: 16px;
}
.stu_head {
	font: bold 1.2em 'Calibri';
	text-decoration: underline;
	line-height: 16px;
	text-align: center;
}

.ft37 {
	font: bold 1.4em 'Calibri';
	color: #993300;
}
}
</STYLE>

	<DIV id="page1">
	<div class="p0 ft0"><?php echo iss_get_school_name();?></div>
		<div class="p0 ft0">In The Name of Allah, Most Merciful, Most
			Compassionate</div>

		<TABLE cellpadding=0 cellspacing=0 id="parent_form_table"
			class="table table-striped">
			<TR>
				<TD class="form-group"><label class="control-label"> Father's Last
						Name:</label> <span> <?php echo $issparent['FatherLastName']; ?></span>
				</TD>
				<TD class="form-group"><label class="control-label"> Mother's Last
						Name:</label> <span><?php echo $issparent['MotherLastName']; ?></span>
				</TD>
			</TR>
			<TR>
				<TD class="form-group"><label class="control-label"> Father's First
						Name:</label> <span><?php echo $issparent['FatherFirstName']; ?></span>
				</TD>
				<TD class="form-group"><label class="control-label"> Mother's First
						Name:</label> <span><?php echo $issparent['MotherFirstName']; ?></span>
				</TD>
			</TR>
			<TR>
				<TD class="form-group"><label class="control-label"> Street Address:</label>
					<span><?php echo $issparent['HomeStreetAddress']; ?></span></TD>
				<TD class="form-group"><label class="control-label"> Mother's Street
						Address:</label> <span><?php echo $issparent['MotherFirstName']; ?></span>
				</TD>
			</TR>
			<TR>
				<TD class="form-group"><label class="control-label"> City:</label> <span><?php echo $issparent['HomeCity']; ?></span>
				</TD>
				<TD class="form-group"><label class="control-label"> Mother's City:</label>
					<span><?php echo $issparent['MotherCity']; ?></span></TD>
			</TR>
			<TR>
				<TD class="form-group"><label class="control-label"> Zip Code:</label>
					<span><?php echo $issparent['HomeZip']; ?></span></TD>
				<TD class="form-group"><label class="control-label"> Mother's Zip
						Code:</label> <span><?php echo $issparent['MotherZip']; ?></span>
				</TD>
			</TR>
			<TR>
				<TD class="form-group"><label class="control-label"> Home Phone#(1):</label>
					<span><?php echo $issparent['HomePhone']; ?></span></TD>
				<TD class="form-group"><label class="control-label"> Home Phone#(2):</label>
					<span><?php echo $issparent['MotherHomePhone']; ?></span></TD>
			</TR>
			<TR>
				<TD class="form-group"><label class="control-label"> Father's Email:</label>
					<span><?php echo $issparent['FatherEmail']; ?></span></TD>
				<TD class="form-group"><label class="control-label"> Mother's Email:</label>
					<span><?php echo $issparent['MotherEmail']; ?></span></TD>
			</TR>
			<TR>
				<TD colspan="2"><label class="control-label">VERY IMPORTANT: Please
						list one email for all School communications.</label> <span
					style="background: none repeat scroll 0% 0% #FF9;"><?php echo $issparent['SchoolEmail']; ?></span>
				</TD>
			</TR>
			<TR>
				<TD class="form-group"><label class="control-label"> Father's
						CellPhone#:</label> <span><?php echo $issparent['FatherCellPhone']; ?></span>
				</TD>
				<TD class="form-group"><label class="control-label"> Mother's
						CellPhone#:</label> <span><?php echo $issparent['MotherCellPhone']; ?></span>
				</TD>
			</TR>
			<TR>
				<TD class="form-group"><label class="control-label"> Father's Work
						Phone#:</label> <span><?php echo $issparent['FatherWorkPhone']; ?></span>
				</TD>
				<TD class="form-group"><label class="control-label"> Mother's Work
						Phone#:</label> <span><?php echo $issparent['MotherWorkPhone']; ?></span>
				</TD>
			</TR>
			<TR>
				<TD colspan="2"><label class="control-label">Please enter the month
						and year of your family’s first association with the school.</label>
					<span> <?php echo $issparent['FamilySchoolStartYear']; ?></span></TD>
			</TR>
			<TR>
				<TD colspan="2">
					<div>
						<label class="control-label"> Emergency Contact Name & Phone (1):</label>
						<span style="background: none repeat scroll 0% 0% #FF9;"> <?php echo $issparent['EmergencyContactName1']; ?> </span>
						<span style="background: none repeat scroll 0% 0% #FF9;"> <?php echo $issparent['EmergencyContactPhone1']; ?></span>
					</div>
				</TD>
			</TR>
			<TR>
				<TD colspan="2">
					<div>
						<label class="control-label"> Emergency Contact Name & Phone (2):</label>
						<span style="background: none repeat scroll 0% 0% #FF9;"><?php echo $issparent['EmergencyContactName2']; ?></span>
						<span style="background: none repeat scroll 0% 0% #FF9;"><?php echo $issparent['EmergencyContactPhone2']; ?></span>
					</div>
				</TD>
			</TR>
			<!-- Chilren Table-->
			<TR>
				<td colspan="2" class="ft1" style="text-align: center;">Child(ren)
					Details</TD>
			</TR>
			<TR>
				<TD colspan="2">
					<TABLE id="student_table" class="table table-striped">

						<TR style="padding: 10px 0 05px 0;">
							<td>ID</td>
							<td class="stu_head">First Name</td>
							<td class="stu_head">Last Name</td>
							<td class="stu_head">Birth Date</td>
							<td class="stu_head">Gender</td>
							<td class="stu_head">Islamic School</td>
							<td class="stu_head">Regular School</td>
						</TR>

            <?php   foreach( $issstudents as $student ) { ?>
              <TR>
							<td>
                  <?php echo $student['StudentID'] ?>
                </td>
							<td><span><?php  echo $student['StudentFirstName']; ?></span></td>
							<td><span><?php  echo $student['StudentLastName']; ?></span></td>
							<td><span><?php  echo $student['StudentBirthDate']; ?></span></td>
							<td><select>
									<option selected>
                      <?php echo $student[ 'StudentGender'];?>
                    </option>
							</select></td>
							<td><select>
									<option selected>
                      <?php echo $student[ 'RegularSchoolGrade']; ?>
                    </option>
							</select></td>
							<td style="width: 10%;"><select>
									<option selected>
                      <?php echo $student[ 'ISSGrade']; ?>
                    </option>
							</select></td>

						</TR>

              <?php } ?>
          </TABLE>
				</TD>
			</TR>
		</TABLE>

		<P class="reg_fee">Registration fee is <?php echo '$' . iss_adminpref_registrationfee_firstchild() ?> a year for the first child, payable in 
	<?php echo '$' . iss_adminpref_registrationfee_installments() ?> installments of 
    <?php echo '$' . iss_adminpref_registrationfee_firstchild_installment() ?> each. Fees for siblings are 
    <?php echo '$' . iss_adminpref_registrationfee_sibling() ?>/year, payable in 2 installments of 
    <?php echo '$' . iss_adminpref_registrationfee_sibling_installment() ?> each.</P>
		<P class="continue_page" style="">(continued on back)</P>
		<hr />
	</DIV>
	<p style="page-break-after:always;"></p>
	<div id="page2">
		<DIV>
			<SPAN class="notehead">PLEASE NOTE: </SPAN>
			<div class="notetext">Should you require <b>financial assistance</b> then please indicate below
				appropriately. Additionally, please complete and return the
				financial aid assistance form separately. Please note: Financial Aid
				information is held in strict confidentiality.</div>
		</DIV>
		<div>
			<SPAN class="notehead">SPECIAL NEEDS: </SPAN>
			<div class="notetext">Does your child require any special needs at regular school or any
			food allergies that we should know about?</div>
			<P>
				If yes, please explain:
				<TEXTAREA class="form-control" rows="5"
					style="width: 100%; border: 1px solid gray;" name="SpecialNeedNote"
					disabled value="
<?php echo $issparent['SpecialNeedNote']; ?>"
					id="SpecialNeedNote" maxlength="250"></TEXTAREA>
			</p>
		</div>
		<div>
			Listing of Home Address, Home Phone Number and Home Email Address in
			the School Directory. <select>
				<option selected>
          <?php echo $issparent['ShareAddress'] ?>
        </option>
			</select> <br />
		</div>
		<div>
			Permission to take Child's Picture. <select>
				<option selected>
          <?php echo $issparent['TakePicture'] ?>
        </option>
			</select> <br />
		</div>
		<div class="ft37">Registration does not guarantee placement in a
			particular grade. Students are normally placed according to their
			age. However students who do not meet schools academic requirements
			will be held back to repeat their grade.</div>


		<TABLE cellpadding="5" cellspacing="5" style="width: 100%;"
			class="table table-striped">
			<TR>
				<TD style="width: 15%;">Installments</TD>
				<TD style="width: 15%;">PAYMENT DATE</TD>
				<TD style="width: 15%;">CASH/CHECK#</TD>
				<TD style="width: 15%;">AMOUNT</TD>
			</TR>
			<TR>
				<TD>1</TD>
				<TD>
          <?php echo $issparent['PaymentDate1'] ?>
        </TD>
				<TD>
          <?php echo $issparent['PaymentMethod1'] ?>
        </TD>
				<TD>
          <?php echo $issparent['PaymentInstallment1'] ?>
        </TD>

			</TR>
			<TR>
				<TD>2</TD>
				<TD>
          <?php echo $issparent['PaymentDate2'] ?>
        </TD>
				<TD>
          <?php echo $issparent['PaymentMethod2'] ?>
        </TD>
				<TD>
          <?php echo $issparent['PaymentInstallment2'] ?>
        </TD>

			</TR>
		</TABLE>

	</div>
</div>
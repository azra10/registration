<div class="wrap">
	<nav class="navbar navbar-light bg-faded">
		<strong class="navbar-brand">Parent &amp; Students Information
			( Editable <?php echo ($issparent['ParentNew'] == 'Yes')? '- New Parent ': '';?>)</strong>
	</nav>
</div>
<div class="container">
	<strong>Registration Year <?php echo $regyear; ?>	</strong>			
	
	<div class="row">
		<section>
			<div class="wizard">  
                <?php include ISS_PATH . '/includes/menu.php'; ?>                
                <div class="tab-content">
					<div
						class="tab-pane <?php echo ($isstabname == 'parent')? 'active': '';?>"
						role="tabpanel" id="parent">
                        <?php include ISS_PATH . '/includes/form_parent.php'; ?>
                    </div>
					<div
						class="tab-pane <?php echo ($isstabname == 'home')? 'active': '';?>"
						role="tabpanel" id="home">
                        <?php include ISS_PATH . '/includes/form_home.php'; ?>
                    </div>
					<div
						class="tab-pane <?php echo ($isstabname == 'contact')? 'active': '';?>"
						role="tabpanel" id="emergency">
                        <?php include ISS_PATH . '/includes/form_contact.php'; ?>                                                      
                    </div>
					<div
						class="tab-pane <?php echo strpos($isstabname, "student",  0) === 0? 'active': ''; ?>"
						role="tabpanel" id="student">
                        <?php include ISS_PATH . '/includes/form_student.php'; ?>                              
                    </div>
					<div
						class="tab-pane <?php echo ($isstabname == 'complete')? 'active': '';?>"
						role="tabpanel" id="complete">
                        <?php include ISS_PATH . '/includes/form_complete.php'; ?>                              
                    </div>
				</div>
			</div>
		</section>
	</div>
</div>



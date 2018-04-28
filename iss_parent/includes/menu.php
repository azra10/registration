


<div class="wizard-inner">
	<div class="connecting-line"></div>
	<ul class="nav nav-tabs formparentmenu" role="tablist">

		<li role="presentation"
			class="<?php echo ($isstabname == 'parent')? 'active': 'disbaled';?>">
			<a href="#parent" data-toggle="tab" aria-controls="Parent" role="tab"
			title="Parent"> <span class="round-tab"> <i
					class="glyphicon glyphicon-user"></i>
			</span>
		</a>
		</li>

		<li role="presentation"
			class="<?php echo ($isstabname == 'home')? 'active': 'disbaled';?>">
			<a href="#home" data-toggle="tab" aria-controls="Home Address"
			role="tab" title="Home Address"> <span class="round-tab"> <i
					class="glyphicon glyphicon-home"></i>
			</span>
		</a>
		</li>
		<li role="presentation"
			class="<?php echo ($isstabname == 'contact')? 'active': 'disbaled';?>">
			<a href="#emergency" data-toggle="tab"
			aria-controls="Emergency Contact" role="tab"
			title="Emergency Contact"> <span class="round-tab"> <i
					class="glyphicon glyphicon-plus"></i>
			</span>
		</a>
		</li>

		<li role="presentation"
			class="<?php echo strpos($isstabname, "student",  0) === 0? 'active': ''; ?>">
			<a href="#student" data-toggle="tab" aria-controls="Student"
			role="tab" title="Student"> <span class="round-tab"> <i
					class="glyphicon glyphicon-baby-formula"></i>
			</span>
		</a>
		</li>
		<!-- <li role="presentation" class="< ?php echo ($isstabname == 'payment')? 'active': 'disbaled';?>">
            <a href="#payment" data-toggle="tab" aria-controls="complete" role="tab" title="Payment">
                <span class="round-tab">
                    <i class="glyphicon glyphicon-usd"></i>
                </span>
            </a>
        </li> -->
		<li role="presentation"
			class="<?php echo ($isstabname == 'complete')? 'active': 'disbaled';?>">
			<a href="#complete" data-toggle="tab" aria-controls="complete"
			role="tab" title="Complete"> <span class="round-tab"> <i
					class="glyphicon glyphicon-ok"></i>
			</span>
		</a>
		</li>
	</ul>
</div>
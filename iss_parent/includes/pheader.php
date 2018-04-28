<div class="wrap">
	<nav class="navbar navbar-light bg-faded">
		<strong class="navbar-brand">Parents </strong>
		<ul class="nav navbar-nav">
<?php if (iss_current_user_is_secretery() && (strlen($regyear)>0)) { ?>
      <li class="nav-item"><a class="nav-link"
				href="admin.php?page=new_parent"><i class="icon-plus-sign"></i> <span
					class="button-primary">Add Parent</span></a></li>
<?php } ?>
      <li class="nav-item"><a class="page-link"
				href="<?php echo get_admin_url() . '?page=user_home'; ?>"><span
					class="button-primary">Change Registration Period: <?php echo $regyear; ?></span></a>
			</li>
			<li class="nav-item"><span style="padding-left: 60px;"></span></li>
		</ul>

		<form action="" method="post" class="navbar-form">
      <?php wp_nonce_field( 'iss_parent_search','iss_parent_search_nonce' ); ?>
        <input type="text" style="padding: 8px 8px;" name="keyword"
				value="" id="keyword" class="search-query"
				placeholder="First/Last Name"> <input type="submit" name="submit"
				id="submit" value="Search Parent" class="button-primary">
		</form>
	</nav>
</div>
<div>
	<div class="row">
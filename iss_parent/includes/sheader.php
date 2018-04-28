<div class="wrap">
	<nav class="navbar navbar-light bg-faded">
		<strong class="navbar-brand">Students </strong>
		<ul class="nav navbar-nav">
			<li class="nav-item"><a class="page-link"
				href="<?php echo get_admin_url() . '?page=user_home'; ?>"><span
					class="button-primary">Change Registration Period: <?php echo $regyear; ?></span></a>
			</li>
			<li class="nav-item"><span style="padding-left: 60px;"></span></li>
		</ul>
		<form action="" method="post" class="navbar-form">
      <?php wp_nonce_field( 'iss_student_search','iss_student_search_nonce' ); ?>
        <input type="text" style="padding: 8px 8px;" name="keyword"
				value="" id="keyword" class="search-query"
				placeholder="First/Last Name"> <input type="submit" name="submit"
				id="submit" value="Search Student" class="button-primary">
		</form>
	</nav>
</div>
<div>
	<div class="row">
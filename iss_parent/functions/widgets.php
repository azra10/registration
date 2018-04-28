<?php
function iss_student_search_dashboard_widget_function() {
	?>
<form action="admin.php?page=students_home" method="post">
			<?php wp_nonce_field( 'iss_student_search','iss_student_search_nonce' ); ?>
			<input type="text" name="keyword" value="" id="keyword"
		placeholder="Search Students" class="form-control"> <input
		type="submit" name="submit" id="submit" value="Search"
		class="button-primary">
</form>
<?php
}
function iss_student_search_add_dashboard_widgets() {
	if (iss_current_user_on_board()) {
		wp_add_dashboard_widget ( 'iss_student_search_dashboard_widget', "Search Students", 'iss_student_search_dashboard_widget_function' );
	}
}
add_action ( 'wp_dashboard_setup', 'iss_student_search_add_dashboard_widgets' );
function iss_parent_search_dashboard_widget_function() {
	?>
<form action="admin.php?page=parents_home" method="post">
			<?php wp_nonce_field( 'iss_parent_search','iss_parent_search_nonce' ); ?>
			<input type="text" name="keyword" value="" id="keyword"
		placeholder="Search Parents" class="form-control"> <input
		type="submit" name="submit" id="submit" value="Search"
		class="button-primary">
</form>
<?php
}
function iss_parent_search_add_dashboard_widgets() {
	if (iss_current_user_on_board()) {
		wp_add_dashboard_widget ( 'iss_parent_search_dashboard_widget', "Search Parents", 'iss_parent_search_dashboard_widget_function' );
	}
}
add_action ( 'wp_dashboard_setup', 'iss_parent_search_add_dashboard_widgets' );
function iss_news_search_dashboard_widget_function() {
	?>
<div>
	<p>
		<strong>Testing in progress!</strong>
	</p>
	<p>Feel free change, add, delete or archive information.</p>
</div>
<?php
}
function iss_news_search_add_dashboard_widgets() {
	if (iss_current_user_on_board()) {
		wp_add_dashboard_widget ( 'iss_news_search_dashboard_widget', "ISS Admin Message", 'iss_news_search_dashboard_widget_function' );
	}
}
//add_action ( 'wp_dashboard_setup', 'iss_news_search_add_dashboard_widgets' );
?>
<?php global $wpdb; ?>
  <?php   $regyear = iss_registration_period(); ?>

      <div class="wrap">
        <nav class="navbar navbar-light bg-faded">
          <strong class="navbar-brand">Archived Parents </strong>
          <ul class="nav navbar-nav">
            <li class="nav-item">
              <a class="page-link" href="<?php echo get_admin_url() . '?page=user_home'; ?>">
                <span class="button-primary">Change Registration Period: <?php if (isset($regyear)) echo $regyear; ?></span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
      <div>
      <div class="row">

<?php
if (isset ( $_GET ['aid'] )) {
    $aid = iss_sanitize_input ( $_GET ['aid'] );
    if (! empty ( $aid )) { 
      iss_archive_family ( $aid );
      echo ' Family Arichived';
    }
} else if (isset ( $_GET ['uid'] )) {
    $uid = iss_sanitize_input ( $_GET ['uid'] );
    if (! empty ( $uid )) { 
      iss_unarchive_family ( $uid );
      echo ' Family Unarchived.';
    }
} else {
  echo 'Unknown Command';
}

?>
<?php require("includes/footer.php"); ?>
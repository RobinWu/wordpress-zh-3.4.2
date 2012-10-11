<?php
/*
Plugin Name: Copyright Notices
Plugin URI: http://www.xxx.com
Description: A plugin that allows ....
Author: Robin
Version: 1.0
Author URI: http://www.xxx.com
 */

function copyright_notices_admin() {
  if(isset($_POST['submit'])){
    if(wp_verify_nonce($_POST['_wpnonce'], 'copyright_notices_admin_options-update')) {
      update_option('copyright_notices_text', stripslashes($_POST['copyright_text']));
      echo '<div class="updated"><p>'._('Success! Your changes were successfully saved').'</p></div>';
    }
    else {
      echo 'div class="error"><p>'._('Whoops! There was a problem with the data you posted. please try again.');
    }
  }
?>
<div class="wrap">
  <?php screen_icon(); ?>
  <h2>Copyright Notices Configuration</h2>
  <p>On this page, you will configure all the aspects of this plugins.</p>
  <form action="" method="post" id="copyright-notices-conf-form">
    <h3><label for="copyright_text">Copyright Text to be inserted in the footer of your name</label></h3>
    <p>
      <input type="text" name="copyright_text" id="copyright_text"
        value="<?php echo esc_attr(get_option('copyright_notices_text')); ?>" />
    </p>
    <p class="submit">
      <input type="submit" name="submit" value="Update options &raquo;"/>
    </p>
    <?php wp_nonce_field('copyright_notices_admin_options-update'); ?>
  </form>
</div>
<?php
}
function copyright_notices_admin_page() {
  add_submenu_page('plugins.php', 'Copyright Notices Configuration', 'Copyright Notices Configuration', 'manage_options', 'copyright-notices', 'copyright_notices_admin');
}
add_action('admin_menu', 'copyright_notices_admin_page');

function display_copyright() {
  if($copyright_text=get_option('copyright_notices_text')) {
    echo '<p class="copyright_text">'.$copyright_text.'</p>';
  }
}
add_action('wp_footer', 'display_copyright');
?>

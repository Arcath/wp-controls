<?php
if(class_exists('WP_Customize_Control')){
  function wp_controls_get_base_path(){
    $base = get_template_directory_uri();

    $parts = explode(get_template(), dirname(__FILE__));

    $url = str_replace('\\', '/', $base . $parts[1]);

    return $url;
  }

  require_once('controls/multi_images.php');
  require_once('controls/media_icons.php');
}
?>

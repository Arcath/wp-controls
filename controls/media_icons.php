<?php
class Media_Icons_Control extends WP_Customize_Control{
  public function __construct($manager, $id, $args = array()){
    add_action('customize_controls_enqueue_scripts', array($this, 'assets'));
    parent::__construct($manager, $id, $args);
  }
  public function assets(){
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_style('font-awesome-picker', wp_controls_get_base_path() . '/node_modules/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css');
    wp_enqueue_script('font-awesome', 'https://use.fontawesome.com/releases/v5.0.13/js/all.js', array('jquery'));
    wp_enqueue_script('font-awesome-picker', wp_controls_get_base_path() . '/node_modules/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js', array('jquery', 'font-awesome'));
    wp_enqueue_script('controls-customizer', wp_controls_get_base_path() . '/assets/customizer.js', array('jquery', 'customize-preview', 'wp-color-picker', 'font-awesome', 'font-awesome-picker'));
  }
  public function render_content(){
    ?>
    <script type="text/javascript">
      if(!(window.hasOwnProperty('mediaIconsLoad'))){
        window.mediaIconsLoad = {}
      }

      window.mediaIconsLoad['<?php echo($this->settings['default']->id); ?>'] = [
        <?php foreach($this->value() as $icon):
          echo(json_encode($icon)); ?>,
        <?php endforeach; ?>
      ]
    </script>
    <label id="mediaIcons">
      <b><?php echo $this->label ?></b>
      <br />
      <i>
        <?php echo $this->description; ?>
      </i>
      <a href="#" id="mi-add-new" class="">Add New</a>
      <ul id="media-icons-list">
      </ul>
      <input type="hidden" <?php echo($this->link()); ?> id="media-icons-data">
    </label>
  <?php
  }
}
?>

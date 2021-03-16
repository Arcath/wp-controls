<?php
class Media_Icons_Control extends WP_Customize_Control{
  public function __construct($manager, $id, $args = array()){
    add_action('customize_controls_enqueue_scripts', array($this, 'assets'));
    parent::__construct($manager, $id, $args);
  }
  public function assets(){
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_style('media-icons-styles', wp_controls_get_base_path() . '/assets/css/media-icons.css');

    wp_enqueue_script('react', 'https://unpkg.com/react@16/umd/react.production.min.js', array(), null);
    wp_enqueue_script('react-dom', 'https://unpkg.com/react-dom@16/umd/react-dom.production.min.js', array('react'), null);
    wp_enqueue_script('babel', 'https://unpkg.com/babel-standalone@6/babel.min.js', array(), null);

    wp_enqueue_script('font-awesome');

    wp_enqueue_script('media-icons-control-component', wp_controls_get_base_path() . '/assets/media_icons.js', array('react', 'react-dom', 'babel'));

    add_filter('script_loader_tag', function($tag, $handle, $src){
      if('media-icons-control-component' == $handle){
        $tag = str_replace("<script", "<script type='text/babel'", $tag);
      }
    
      return $tag;
    }, 10, 3);


  }
  public function render_content(){
    $json = "[";

    foreach($this->value() as $icon):
        $json = $json . json_encode($icon) . ",";
    endforeach;

    $json = substr($json, 0, -1) . "]";

    $icons = wp_fontawesome_get_icons();

    $iconNames = array_keys($icons);

    $iconString = json_encode($iconNames);

    ?>
    <label id="mediaIcons" data-control="<?php echo($this->settings['default']->id); ?>"></label>
    <input type="hidden" <?php echo($this->link()); ?> />
    <script type="text/javascript">jQuery(document).on('load-media-icons', function(){ 
      media_icons_control("<?php echo($this->settings['default']->id); ?>", "<?php echo(base64_encode($json)); ?>", "<?php echo(base64_encode($iconString)); ?>");
    });</script>
  <?php
  }
}
?>
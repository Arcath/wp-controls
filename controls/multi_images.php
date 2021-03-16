<?php
class MultiImagesControl extends WP_Customize_Control{
  public function __construct($manager, $id, $args = array()){
    add_action('customize_controls_enqueue_scripts', array($this, 'assets'));
    parent::__construct($manager, $id, $args);
  }

  public function assets(){;
    wp_enqueue_script('react', 'https://unpkg.com/react@16/umd/react.production.min.js', array(), null);
    wp_enqueue_script('react-dom', 'https://unpkg.com/react-dom@16/umd/react-dom.production.min.js', array('react'), null);
    wp_enqueue_script('babel', 'https://unpkg.com/babel-standalone@6/babel.min.js', array(), null);
    
    wp_enqueue_script('multi-images-control-component', wp_controls_get_base_path() . '/assets/multi_images.js', array('react', 'react-dom', 'babel'));

    add_filter('script_loader_tag', function($tag, $handle, $src){
      if('multi-images-control-component' == $handle){
        $tag = str_replace("<script", "<script type='text/babel'", $tag);
      }
    
      return $tag;
    }, 10, 3);
  }

  public function render_content(){
    $data = array();

    foreach($this->value() as $imageId){
      $imageData = wp_get_attachment_metadata($imageId);
      $thumbnail = wp_get_attachment_image_src($imageId, 'thumbnail')[0];

      array_push($data, array(
        'id' => $imageId,
        'thumbnail' => $thumbnail
      ));
    }

    $json = json_encode($data);
    ?>
    <div data-control="<?php echo($this->settings['default']->id); ?>"></div>
    <script type="text/javascript">
      jQuery(document).on('load-multi-images', function(){ 
        multi_images_control("<?php echo($this->settings['default']->id); ?>", "<?php echo(base64_encode($json)); ?>");
      });
    </script>
    <?php
  }
}
?>

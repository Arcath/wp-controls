<?php
class MultiImagesControl extends WP_Customize_Control{
  public function __construct($manager, $id, $args = array()){
    add_action('customize_controls_enqueue_scripts', array($this, 'assets'));
    parent::__construct($manager, $id, $args);
  }

  public function assets(){;
    wp_enqueue_script('controls-customizer', wp_controls_get_base_path() . '/assets/multi_images.js', array('jquery'));
  }

  public function render_content(){
    ?>
    <script type="text/javascript">
      if(!(window.hasOwnProperty('multiImagesLoad'))){
        window.multiImagesLoad = {}
      }

      window.multiImagesLoad['<?php echo($this->settings['default']->id); ?>'] = [
        <?php $i = 0; foreach($this->value() as $image):
          $data = wp_get_attachment_metadata($image);
          if(isset($data['sizes'])){
            $data['id'] = $image;
            foreach($data['sizes'] as $size => $sizeData){
              $data['sizes'][$size]['url'] = wp_get_attachment_image_src($image, $size)[0];
            }
            echo(json_encode($data) . ',');
          } ?>
        <?php endforeach; ?>
      ]
    </script>
    <label id="multiImages">
      <b><?php echo $this->label ?></b>
      <br />
      <i>
        <?php echo $this->description; ?>
      </i>
      <input type="button" id="multiImages-add" class="button" value="<?php _e('Add an Image', 'wp-controls'); ?>">
      <label>
        <ul id="multiImages-images">
        </ul>
      </label>
      <input type="hidden" <?php echo($this->link()); ?> id="multi-images-data">
    </label>
    <script>
      jQuery(document).on('ready',function(){
        multi_images_bind_events('<?php echo($this->settings['default']->id); ?>')
      })
    </script>
    <?php
  }
}
?>

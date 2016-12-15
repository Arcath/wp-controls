<?php
class Text_Area_Control extends WP_Customize_Control{
  public $type = 'textarea';
  public function __construct($manager, $id, $args = array()){
    $this->statuses = array('' => __('Default', 'wp-controls'));
    parent::__construct($manager, $id, $args);
  }
  public function render_content(){
    echo '<label>
      <span class="customize-control-title">' . esc_html($this->label) . '</span>
        <textarea rows="5" style="width:100%;" ';
        $this->link();
        echo '>' . esc_textarea($this->value()) . '</textarea>
      </label>';
  }
}
?>

<?php
class Dropdown_Categories_Control extends WP_Customize_Control{
  public $type = 'dropdown-categories';
  public function render_content(){
    $dropdown = wp_dropdown_categories(
      array(
        'name' => '_customize-dropdown-categories-' . $this->id,
        'echo' => 0,
        'hide_empty' => false,
        'show_option_none' => '&mdash; ' . __('Select', 'wp-controls') . ' &mdash;',
        'hide_if_empty' => false,
        'selected' => $this->value(),
      )
    );
    $dropdown = str_replace('<select', '<select ' . $this->get_link(), $dropdown);
    printf(
      '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
      $this->label,
      $dropdown
    );
  }
}
?>

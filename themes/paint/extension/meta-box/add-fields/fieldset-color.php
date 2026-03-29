<?php
/* Render fields */
add_filter('cmb2_render_fieldset_color', 'paint_cmb_render_fieldset_color', 10, 5);
function paint_cmb_render_fieldset_color($field, $value, $object_id, $object_type, $field_type): void
{
// make sure we specify each part of the value we need.
  $value = wp_parse_args($value, array(
    'name' => '',
    'color' => ''
  ));
  ?>
  <div class="cmb-label">
    <label for="<?php echo $field_type->_id('_name'); ?>">
      <?php esc_html_e('Tên màu', 'paint'); ?>
    </label>

  </div>

  <div class="cmb-field">
    <?php
    echo $field_type->input(array(
      'name' => $field_type->_name('[name]'),
      'id' => $field_type->_id('_name'),
      'value' => $value['name']
    ));
    ?>
  </div>

  <div class="cmb-label">
    <label for="<?php echo $field_type->_id('_color'); ?>">
      <?php esc_html_e('Mã màu', 'paint'); ?>
    </label>
  </div>

  <div class="cmb-field">
    <?php echo $field_type->colorpicker(array(
      'name' => $field_type->_name('[color]'),
      'id' => $field_type->_id('_color'),
      'value' => $value['color']
    )); ?>
  </div>

  <?php
  echo $field_type->_desc(true);
}

add_filter('cmb2_sanitize_fieldset_color', 'paint_cmb_sanitize_fieldset_color_field', 10, 5);
function paint_cmb_sanitize_fieldset_color_field($check, $meta_value, $object_id, $field_args, $sanitize_object)
{
  if (is_array($meta_value) && $field_args['repeatable']) {
    foreach ($meta_value as $key => $val) {
      if (empty($val['name'])) {
        unset($meta_value[$key]);
        continue;
      }

      $meta_value[$key] = array_map('sanitize_text_field', $val);
    }

    return $meta_value;
  }
  return $check;
}

add_filter('cmb2_types_esc_fieldset_color', 'paint_cmb_types_esc_fieldset_color_field', 10, 4);
function paint_cmb_types_esc_fieldset_color_field($check, $meta_value, $field_args, $field_object)
{
  if (is_array($meta_value) && $field_args['repeatable']) {
    foreach ($meta_value as $key => $val) {
      $meta_value[$key] = array_map('esc_attr', $val);
    }

    return $meta_value;
  }
  return $check;
}
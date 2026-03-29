<?php
$paint_unique_id = esc_attr(uniqid('search-form-'));

$taxonomies = get_terms(array(
  'taxonomy' => 'paint_discover_cat',
  'hide_empty' => false
));

$cat = !empty($_GET['cat']) ? (int) $_GET['cat'] : '';
?>

<form method="get" action="<?php echo esc_url(home_url('/')); ?>" class="form-search-custom form-search-discover">
  <div class="group-control">
    <select class="select-cat" name="cat" aria-label="">
      <option value="0" <?php echo esc_attr( empty($cat) ? 'selected' : '' ) ?>>Tất cả danh mục</option>
      <?php
      if ( $taxonomies ) :
        foreach ($taxonomies as $taxonomy) :
          ?>
          <option
            value="<?php echo esc_attr($taxonomy->term_id) ?>"
            <?php echo esc_attr( !empty($cat) && $cat == $taxonomy->term_id ? 'selected' : '' ) ?>
          >
            <?php echo esc_html( $taxonomy->name ) ?>
          </option>
        <?php
        endforeach;
      endif;
      ?>
    </select>
  </div>

  <div class="group-control">
    <input type="search" id="<?php echo $paint_unique_id; ?>" class="search-field form-control"
           placeholder="<?php echo esc_attr_x('Nhập từ khóa...', 'placeholder', 'paint'); ?>"
           value="<?php echo get_search_query(); ?>" name="s" aria-label=""/>
  </div>

  <div class="group-control">
    <button type="submit" class="search-submit btn btn-primary">
      <?php esc_html_e('Tìm kiếm', 'paint') ?>
    </button>
  </div>

  <input type="hidden" readonly name="post_type" value="paint_discover">
</form>

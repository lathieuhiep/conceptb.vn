<?php $paint_unique_id = esc_attr(uniqid('search-form-')); ?>

<form method="get" action="<?php echo esc_url(home_url('/')); ?>" class="form-search-box">
  <input type="hidden" readonly name="post_type" value="paint_project">

  <div class="group-control">
    <input type="search" id="<?php echo $paint_unique_id; ?>" class="search-field"
           placeholder="<?php echo esc_attr_x('Nhập từ khóa...', 'placeholder', 'paint'); ?>"
           value="<?php echo get_search_query(); ?>" name="s" aria-label=""/>

    <button type="submit" class="search-submit">
      <i class="fa-solid fa-magnifying-glass"></i>
    </button>
  </div>
</form>
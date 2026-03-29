<?php $paint_unique_id = esc_attr(uniqid('search-form-')); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="group-search">
        <input type="text" id="<?php echo $paint_unique_id; ?>" class="search-field"
               placeholder="<?php echo esc_attr_x('Tìm kiếm', 'placeholder', 'paint'); ?>"
               value="<?php echo get_search_query(); ?>" name="s" aria-label=""/>

        <button type="submit" class="search-submit">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>

        <button type="button" id="btn-close-search" class="btn btn-close-search">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</form>
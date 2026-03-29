<?php
$paint_unique_id = esc_attr(uniqid('search-form-'));

$taxonomies = get_terms(array(
    'taxonomy' => 'paint_project_cat',
    'hide_empty' => false
));

$cat = !empty($_GET['cat']) ? (int)$_GET['cat'] : '';
?>

<form method="get" action="<?php echo esc_url(home_url('/')); ?>" class="form-search-project">
    <div class="control-warp">
        <div class="group-control group-control-radio">
            <?php
            if ($taxonomies) :
                foreach ($taxonomies as $taxonomy) :
                    ?>
                    <div class="radio-list">
                        <input type="radio" class="btn-check" name="cat"
                               id="cat-<?php echo esc_attr($taxonomy->term_id) ?>" autocomplete="off"
                               value="<?php echo esc_attr($taxonomy->term_id) ?>" <?php echo esc_attr(!empty($cat) && $cat == $taxonomy->term_id ? 'checked' : '') ?>>
                        <label class="btn"
                               for="cat-<?php echo esc_attr($taxonomy->term_id) ?>"><?php echo esc_html($taxonomy->name) ?></label>
                    </div>
                <?php endforeach; ?>
                <div class="radio-list">
                    <input type="radio" class="btn-check" name="cat" id="cat-0" autocomplete="off"
                           value="0" <?php echo esc_attr(!empty($cat) && $cat == 'cat-0' ? 'checked' : '') ?>>
                    <label class="btn" for="cat-0"><?php esc_html_e('Tất cả', 'paint'); ?></label>
                </div>
            <?php endif; ?>
        </div>

        <div class="group-control group-search-key">
            <input type="text" id="<?php echo $paint_unique_id; ?>" class="search-field form-control"
                   placeholder="<?php echo esc_attr_x('Nhập từ khóa...', 'placeholder', 'paint'); ?>"
                   value="<?php echo get_search_query(); ?>" name="s" aria-label=""/>

            <button type="submit" class="search-submit btn btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </div>

    <input type="hidden" readonly name="post_type" value="paint_project">
</form>

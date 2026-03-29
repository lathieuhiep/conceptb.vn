<?php
$color_code_name = get_post_meta(get_the_ID(), 'paint_cmb_color_code_name', true);
$color_code_list = get_post_meta(get_the_ID(), 'paint_cmb_color_code_standard', true);

if (!empty($color_code_list)) :
    $i = 1;
    ?>

    <div class="group-color__grid" data-color-code-id="<?php echo esc_attr( get_the_ID() ); ?>">
        <?php
        foreach ($color_code_list as $key => $color_code_item) :
            if ($i == 1 || $i % 3 == 1) :
        ?>
            <div class="list-color">

        <?php endif; ?>

            <div class="item">
                <figure class="item__thumbnail" data-key="<?php echo esc_attr($key); ?>">
                    <?php echo wp_get_attachment_image($color_code_item['image_id'], 'medium_large'); ?>
                </figure>

                <div class="info text-center">
                    <?php if (!empty($color_code_name)) : ?>
                        <span class="name">
                            <?php echo esc_html($color_code_name); ?>
                        </span>
                    <?php endif; ?>

                    <span class="paint-number">
                        <?php echo esc_html($color_code_item['paint_number']) ?>
                    </span>
                </div>
            </div>

        <?php if ($i % 3 == 0 || $i == count($color_code_list)) : ?>
            </div>
        <?php
        endif;
            $i++;
        endforeach;
        ?>
    </div>

<?php
endif;
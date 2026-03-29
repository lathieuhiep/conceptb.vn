<?php
global $current_user;
$user_id = $current_user->id;

$dataUserSave = paint_get_user_saved($user_id, get_the_ID());
?>

<div class="entry-post">
  <?php while (have_posts()) : the_post(); ?>
    <h1 class="title">
      <?php the_title(); ?>
    </h1>

    <div class="entry-content">
      <div class="thumbnail-image position-relative">
        <a class="download-image position-absolute" href="<?php the_post_thumbnail_url('full'); ?>" download>
          <i class="fa-solid fa-download"></i>
          <span class="txt"><?php esc_html_e('Lưu', 'pain'); ?></span>
        </a>

        <a class="view-popup position-absolute" href="<?php the_post_thumbnail_url('large'); ?>" data-lity>
          <i class="fa-solid fa-magnifying-glass"></i>
        </a>

        <?php the_post_thumbnail('large'); ?>
      </div>

      <div class="post-info">
        <div class="post-info__left">
          <div class="desc">
            <?php the_content(); ?>
          </div>

          <div class="meta-filed">
            <?php
            $color = get_post_meta(get_the_ID(), 'paint_cmb_discover_color', true);
            $color_url = get_post_meta(get_the_ID(), 'paint_cmb_discover_color_url', true);

            if ( !empty( $color ) ) :
            ?>
              <div class="meta-filed__item">
                <div class="label">
                  <?php esc_html_e('Mã màu', 'paint') ?>:
                </div>

                <div class="content meta-filed-color">
                  <a href="<?php echo esc_url( $color_url ) ?>" target="_blank">
                    <?php echo esc_html( $color ) ?>
                  </a>
                </div>
              </div>
            <?php
            endif;

            $classify = get_post_meta(get_the_ID(), 'paint_cmb_discover_classify', true);

            if ( !empty($classify) ) :
            ?>
              <div class="meta-filed__item">
                <div class="label">
                  <?php esc_html_e('Phân loại', 'paint') ?>:
                </div>

                <div class="content meta-filed-classify">
                  <?php echo esc_html($classify ) ?>
                </div>
              </div>
            <?php
            endif;

            $construction_tools = get_post_meta(get_the_ID(), 'paint_cmb_discover_construction_tools', true);

            if ( !empty( $construction_tools ) ) :
            ?>
              <div class="meta-filed__item">
                <div class="label">
                  <?php esc_html_e('Dụng cụ thi công', 'paint') ?>:
                </div>

                <div class="content meta-filed-construction-tools">
                  <?php
                  foreach ( $construction_tools as $attachment_id => $attachment_url) :
                    echo wp_get_attachment_image( $attachment_id );
                  endforeach;
                  ?>
                </div>
              </div>
            <?php
            endif;

            $video = get_post_meta(get_the_ID(), 'paint_cmb_discover_video', true);

            if (!empty( $video )) :
            ?>
              <div class="meta-filed__item">
                <div class="label">
                  <?php esc_html_e('Video hướng dẫn', 'paint') ?>:
                </div>

                <div class="content meta-filed-video">
                  <a href="<?php echo esc_url( $video ) ?>" target="_blank">
                    <i class="fa-brands fa-youtube"></i>
                  </a>
                </div>
              </div>
            <?php endif; ?>
          </div>

          <?php paint_comment_form(); ?>
        </div>

        <div class="post-info__right d-flex justify-content-between">
          <div class="fb-share-button"
               data-href="<?php the_permalink(); ?>"
               data-layout="button_count"
               data-size="large"
          >
            <a target="_blank"
               href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse"
               class="fb-xfbml-parse-ignore"
            >
              Chia sẻ
            </a>
          </div>

            <?php if ( $user_id ) : ?>
            <div class="action-box">
                <button type="button" class="btn-user-save border-0 p-0" data-post-id="<?php echo esc_attr(get_the_ID()) ?>">
                    <?php if ($dataUserSave && $dataUserSave->status == 1) : ?>
                        <i class="fa-solid fa-bookmark"></i>
                    <?php else: ?>
                        <i class="fa-regular fa-bookmark"></i>
                    <?php endif; ?>
                </button>
            </div>
            <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endwhile;
  wp_reset_postdata(); ?>
</div>
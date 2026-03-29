<?php
/*
 Template Name: Đã lưu
 */

if (!is_user_logged_in()) {
  wp_redirect(home_url());
  exit;
}

get_header();
?>

<div class="site-container user-info-warp user-saved-warp">
  <div class="container">
    <?php
    get_template_part('template-parts/account-management/inc', 'heading');
    ?>
    
    <div class="tab-user-info grid-info">
      <?php get_template_part('template-parts/account-management/inc', 'nav'); ?>
      
      <div class="tab-user-content">
        <ul class="nav nav-pills tab-user-saved justify-content-center" id="pills-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-discover-tab" data-bs-toggle="pill" data-bs-target="#pills-discover" type="button" role="tab" aria-controls="pills-discover" aria-selected="true">
              <?php esc_html_e('Khám phá', 'paint'); ?>
            </button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-project-tab" data-bs-toggle="pill" data-bs-target="#pills-project" type="button" role="tab" aria-controls="pills-project" aria-selected="false">
              <?php esc_html_e('Dự án', 'paint'); ?>
            </button>
          </li>
        </ul>

        <div class="tab-content tab-user-saved-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-discover" data-post-type="paint_discover" role="tabpanel" aria-labelledby="pills-discover-tab">
            <?php
            $paintDiscoverIds = paint_get_all_user_saved('paint_discover');

            if ( $paintDiscoverIds ) :
              $args = array(
                'post_type' => 'paint_discover',
                'post__in' => $paintDiscoverIds,
              );

              $query = new WP_Query($args);
            ?>

              <div class="grid-masonry-warp discover-user-saved">
                <?php
                while ($query->have_posts()) :
                  $query->the_post();

                  get_template_part('components/inc', 'discover-user-saved');

                endwhile;
                wp_reset_postdata();
                ?>
              </div>

            <?php else: ?>
              <p class="text-center">
                <?php esc_html_e('Chưa có khám phá được lưu', 'paint'); ?>
              </p>
            <?php endif; ?>
          </div>

          <div class="tab-pane fade" id="pills-project" data-post-type="paint_project" role="tabpanel" aria-labelledby="pills-project-tab">
            <?php
            $paintProjectIds = paint_get_all_user_saved('paint_project');

            if ( $paintProjectIds ) :
              $args = array(
                'post_type' => 'paint_project',
                'post__in' => $paintProjectIds,
              );

              $query = new WP_Query($args);
            ?>
              <div class="grid-masonry-warp project-user-saved">
                <?php
                while ($query->have_posts()) :
                  $query->the_post();

                  get_template_part('components/inc', 'project-user-saved');

                endwhile;
                wp_reset_postdata();
                ?>
              </div>
            <?php else: ?>
                <p class="text-center">
                  <?php esc_html_e('Chưa có dự án được lưu', 'paint'); ?>
                </p>
            <?php endif; ?>
          </div>
        </div>

        <div class="spinner-warp text-center mt-5 d-none">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();

<div class="site-blog">
  <div class="container">
    <div class="grid">
      <?php
      if ( have_posts() ) :
      while ( have_posts() ) : the_post();
      ?>
        <div id="post-<?php the_ID(); ?>" class="item">
          <figure class="item__image">
            <?php the_post_thumbnail('large'); ?>
          </figure>

          <div class="item__entry">
            <h2 class="title-post">
              <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <?php the_title(); ?>
              </a>
            </h2>

            <div class="meta-post">
              <p class="date">
                <?php echo get_the_date(); ?>
              </p>

              <div class="excerpt">
                <p>
                  <?php
                  if (has_excerpt()) :
                    echo esc_html(get_the_excerpt());
                  else:
                    echo wp_trim_words(get_the_content(), 20, '...');
                  endif;
                  ?>
                </p>

                <?php paint_link_page(); ?>
              </div>
            </div>

            <a href="<?php the_permalink(); ?>" class="text-read-more">
              <span><?php esc_html_e('Xem bài viết', 'paint'); ?></span>

              <i class="fa-solid fa-arrow-right"></i>
            </a>
          </div>
        </div>
      <?php
      endwhile;
      wp_reset_postdata();
      ?>
    </div>

    <?php
    paint_pagination();
    else:
      if (is_search()) :
        get_template_part('template-parts/search/content', 'no-data');
      endif;
    endif;
    ?>
  </div>
</div>
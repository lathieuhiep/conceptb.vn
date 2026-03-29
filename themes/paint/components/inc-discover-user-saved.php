<div class="item grid-sizer">
  <figure class="thumbnail-image">
    <a href="<?php the_permalink(); ?>">
      <?php the_post_thumbnail('large'); ?>
    </a>
  </figure>

  <h2 class="title-item view-detail">
    <a href="<?php the_permalink(); ?>">
      <?php the_title() ?>
    </a>
  </h2>

  <?php if (has_term('', 'paint_discover_cat')) : ?>
    <div class="meta">
      <?php the_terms(get_the_ID(), 'paint_discover_cat', '', ', '); ?>
    </div>
  <?php endif; ?>
</div>
<?php if (is_active_sidebar('paint-sidebar-main')): ?>

  <aside class="<?php echo esc_attr(paint_col_sidebar()); ?> site-sidebar order-1">
    <?php dynamic_sidebar('paint-sidebar-main'); ?>
  </aside>

<?php endif; ?>
<div class="site-container site-tool-warp">
  <div class="container">
    <div class="grid-warp <?php echo esc_attr(is_active_sidebar('paint-sidebar-tool') ? 'active-sidebar' : ''); ?>">
      <?php if (is_active_sidebar('paint-sidebar-tool')) : ?>
        <div class="sidebar">
          <?php dynamic_sidebar('paint-sidebar-tool'); ?>
        </div>
      <?php
      endif;

      get_template_part('template-parts/tool/inc', 'tax-tool');
      ?>
    </div>
  </div>
</div>
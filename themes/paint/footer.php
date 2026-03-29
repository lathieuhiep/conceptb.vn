    </div><!--End Sticky Footer-->

    <?php if (!is_404()) : ?>
      <footer class="site-footer d-flex flex-column gap-11">
        <?php
        get_template_part('template-parts/footer/inc', 'multi-column');
        get_template_part('template-parts/footer/inc', 'copyright');
        ?>
      </footer>
    <?php endif; ?>
</div><!--End main-warp-->

<?php
get_template_part('template-parts/header/inc','menu-mobile');

// Back to top button
$show_back_to_top = paint_get_option('general_opt_back_to_top', true);
if ($show_back_to_top) :
?>
  <div id="back-top">
    <a href="#">
      <i class="fa fa-chevron-up"></i>
    </a>
  </div>
<?php
endif;

wp_footer();
?>

</body>
</html>

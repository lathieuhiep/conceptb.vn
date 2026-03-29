<?php
$idProduct = $args['idProduct'] ?? '';

if ( $idProduct ) :
$opt_process = get_post_meta($idProduct, 'paint_cmb_product_construction_process', true); ?>

<div class="construction-process-product">
  <div class="content">
    <?php if ($opt_process) : ?>
      <div class="accordion accordion-my-theme accordion-process" id="accordionProcess">
        <?php
        foreach ($opt_process as $key => $item) :
          if ( !empty( $item['content'] ) ) :
        ?>
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading-<?php echo esc_html($key); ?>">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo esc_html($key); ?>" aria-expanded="true" aria-controls="collapse-<?php echo esc_html($key); ?>">
                <?php echo esc_html( $item['step'] ); ?>
              </button>
            </h2>

            <div id="collapse-<?php echo esc_html($key); ?>" class="accordion-collapse collapse<?php echo esc_attr( $key == 0 ? ' show' : '' ); ?>" aria-labelledby="heading-<?php echo esc_html($key); ?>" data-bs-parent="#accordionProcess">
              <div class="accordion-body">
                <?php echo wpautop( $item['content'] ); ?>
              </div>
            </div>
          </div>
        <?php
          endif;
        endforeach;
        ?>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php
endif;
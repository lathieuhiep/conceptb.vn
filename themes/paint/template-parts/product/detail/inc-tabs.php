<div class="tabs-warp">
    <ul class="nav nav-pills product-detail-tabs-nav" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active success-loading" id="color-code-tab" data-bs-toggle="pill"
                    data-bs-target="#color-code"
                    type="button" role="tab" aria-controls="color-code" aria-selected="true">
                <?php esc_html_e('Bảng màu', 'paint'); ?>
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="gallery-tab" data-bs-toggle="pill" data-bs-target="#gallery" type="button"
                    role="tab"
                    aria-controls="gallery" aria-selected="false">
                <?php esc_html_e('Công trình thực tế', 'paint'); ?>
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="product-construction-process-tab" data-bs-toggle="pill"
                    data-bs-target="#product-construction-process"
                    type="button"
                    role="tab" aria-controls="product-construction-process" aria-selected="false">
                <?php esc_html_e('Quy trình thi công', 'paint'); ?>
            </button>
        </li>
    </ul>

    <div class="spinner-warp text-center d-none">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="tab-content" id="pills-tabContent">
        <div class="color-code-tab tab-pane fade show active" id="color-code" role="tabpanel"
             aria-labelledby="color-code-tab"
             tabindex="0">
            <?php get_template_part('template-parts/product/detail/inc', 'product-color'); ?>
        </div>

        <div class="gallery-tab tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab"
             tabindex="0"></div>

        <div class="product-construction-process-tab tab-pane fade" id="product-construction-process" role="tabpanel"
             aria-labelledby="product-construction-process-tab" tabindex="0"></div>
    </div>
</div>

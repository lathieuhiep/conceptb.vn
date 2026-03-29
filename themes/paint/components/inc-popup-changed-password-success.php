<div class="modal fade" id="modalChangedPasswordSuccess" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center border-0">
                <h4 class="modal-title" id="staticBackdropLabel">
                    <?php esc_html_e('Đổi mật khẩu thành công', 'paint'); ?>
                </h4>
            </div>
            
            <div class="modal-body d-flex align-items-center flex-column">
                <a href="<?php echo esc_url( paint_get_tpl_url('templates/login.php') ) ?>" class="btn btn-action">
                    <?php esc_html_e('ĐĂNG NHẬP LẠI', 'paint'); ?>
                </a>
                
                <a href="<?php echo esc_url(get_home_url('/')); ?>" class="btn btn-action">
                    <?php esc_html_e('QUAY VỀ TRANG CHỦ', 'paint'); ?>
                </a>
            </div>
        </div>
    </div>
</div>
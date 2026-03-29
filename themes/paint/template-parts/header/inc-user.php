<div class="site-user">
    <div class="site-user__box text-lg-end">
        <i class="fa-regular fa-circle-user"></i>

        <?php
        if (is_user_logged_in()) :
            $current_user = wp_get_current_user();
            ?>
            <span class="txt user-name"><?php echo esc_html($current_user->user_nicename); ?></span>

            <button class="btn btn-collapse-user d-lg-none p-0 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#userManagerBox" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa-solid fa-angle-down"></i>
            </button>
        <?php else: ?>
            <a class="txt txt-login"
               href="<?php echo esc_url(paint_get_tpl_url('templates/login.php')) ?>">
                <?php esc_html_e('Đăng nhập', 'paint'); ?>
            </a>
        <?php endif; ?>
    </div>

    <?php if (is_user_logged_in()) : ?>
        <ul id="userManagerBox" class="site-user__manager collapse">
            <li>
                <a href="<?php echo esc_url(paint_get_tpl_url('templates/personal-info.php')); ?>">
                    <?php esc_html_e('Thông tin tài khoản', 'paint'); ?>
                </a>
            </li>

            <li>
                <a href="<?php echo esc_url(paint_get_tpl_url('templates/saved.php')); ?>">
                    <?php esc_html_e('Đã lưu', 'paint'); ?>
                </a>
            </li>

            <li>
                <a href="<?php echo esc_url(paint_get_tpl_url('templates/change-password.php')); ?>">
                    <?php esc_html_e('Đổi mật khẩu', 'paint'); ?>
                </a>
            </li>

            <li>
                <a href="<?php echo wp_logout_url(home_url()); ?>">
                    <?php esc_html_e('Đăng xuất', 'paint'); ?>
                </a>
            </li>
        </ul>
    <?php endif; ?>
</div>
<?php
/*
 Template Name: Đổi mật khẩu
 */

if ( !is_user_logged_in() ) {
  wp_redirect(home_url());
  exit;
}

get_header();

get_template_part('components/inc', 'spinner-loading');
?>

<div class="site-container user-info-warp">
  <div class="container">
    <?php
    get_template_part('template-parts/account-management/inc', 'heading', [
      'title' => esc_html__('ĐỔI MẬT KHẨU')
    ]);
    ?>

    <div class="tab-user-info grid-info">
      <?php get_template_part('template-parts/account-management/inc', 'nav'); ?>

      <div class="tab-user-content">
        <form id="change-password-form" class="user-update-form change-password-form" method="post">
          <div class="group-control">
            <label for="old-password" class="form-label">
              <?php esc_html_e('Mật khẩu cũ', 'paint'); ?>
            </label>

            <input
              id="old-password"
              name="old_password"
              type="password"
              class="form-control"
              value=""
            >
          </div>

          <div class="group-control">
            <label for="password" class="form-label">
              <?php esc_html_e('Mật khẩu mới', 'paint'); ?>
            </label>

            <input
              id="password"
              name="password"
              type="password"
              class="form-control"
              value=""
            >
          </div>

          <div class="group-control">
            <label for="password-confirm" class="form-label">
              <?php esc_html_e('Nhập lại mật khẩu mới', 'paint'); ?>
            </label>

            <input
              id="password-confirm"
              type="password"
              class="form-control"
              name="password_confirm"
              value=""
            >
          </div>

          <div class="group-control action-box text-center">
            <button type="submit" name="f-submit" class="btn btn-submit">
              <?php esc_html_e('ĐỔI MẬT KHẨU', 'paint'); ?>
            </button>
          </div>

          <?php wp_nonce_field( 'changePassword', 'security' ); ?>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();
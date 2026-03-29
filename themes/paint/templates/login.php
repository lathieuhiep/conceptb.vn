<?php
/*
 Template Name: Login Page
 */

if ( is_user_logged_in() ) {
  wp_redirect( home_url() ); exit;
}

get_header();

get_template_part('components/inc', 'spinner-loading');
?>
    <div class="site-container login-warp user-warp">
        <div class="container">
            <div class="grid">
                <div class="grid__item d-flex align-items-center">
                    <h1 class="page-title text-uppercase m-0">
                        <?php the_title(); ?>
                    </h1>
                </div>

                <div class="grid__item">
                    <form id="login-form" method="post" action="" class="wp-user-form form-user">
                        <div class="files">
                            <div class="grid-control username-control">
                                <input
                                  id="username"
                                  type="text"
                                  name="username"
                                  class="form-control"
                                  required
                                  value="<?php echo esc_attr($_REQUEST['username'] ?? ''); ?>"
                                  placeholder="<?php esc_attr_e('Email/ Số điện thoại/ Tên đăng nhập', 'paint'); ?>"
                                  aria-label=""
                                />
                            </div>

                            <div class="grid-control password-control">
                                <input
                                  id="password"
                                  type="password"
                                  name="password"
                                  class="form-control"
                                  required
                                  value=""
                                  placeholder="<?php esc_attr_e('Mật khẩu', 'paint'); ?>"
                                  aria-label=""
                                />
                            </div>

                            <div class="grid-control">
                                <div class="box-lost-password mb-5">
                                    <a class="lost" href="<?php echo wp_lostpassword_url(); ?>">
                                        <?php esc_html_e('Quên mật khẩu', 'paint'); ?>
                                    </a>
                                </div>

                                <div class="text-center">
                                    <button
                                      type="submit"
                                      name="submit"
                                      class="btn btn-submit btn-submit-login text-uppercase fw-bold border-0 rounded-0"
                                      data-url="<?php echo esc_attr(home_url('/')); ?>"
                                    >
                                        <?php esc_html_e('Đăng nhập', 'paint'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="not-account text-center">
                            <span
                              class="d-inline-block me-2"><?php esc_html_e('Bạn chưa có tài khoản?', 'paint'); ?></span>

                            <a href="<?php echo esc_url(paint_get_tpl_url('templates/register.php')) ?>">
                                <?php esc_html_e('Đăng ký ngay'); ?>
                            </a>
                        </div>
                        
                        <?php wp_nonce_field('ajax-login-nonce', 'security'); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();

<?php
/*
 Template Name: Register Page
 */

if ( is_user_logged_in() ) {
  wp_redirect( home_url() ); exit;
}

global $wpdb;
$table_extended_users = $wpdb->prefix . 'extended_users';

$username = $first_name = $last_name = $phone_number = $email = $password = '';

$errors = new WP_Error();
$errorUser = $errorFirstName = $errorLastName = $errorPhoneNumber = $errorEmail = $errorPassword = $errorPasswordConfirm = '';

if ( isset($_POST['f-submit']) ) {
  $username = $wpdb->_escape($_POST['username']);
  $first_name = $wpdb->_escape($_POST['first_name']);
  $last_name = $wpdb->_escape($_POST['last_name']);
  $phone_number = $wpdb->_escape($_POST['phone_number']);
  $email = $wpdb->_escape($_POST['email']);
  $password = $wpdb->_escape($_POST['password']);
  $passwordConfirm = $wpdb->_escape($_POST['password_confirm']);

  // check validate email
  if ( empty( $username )  ) {
    $errors->add('username', esc_html__('Tên đăng nhập không được để trống', 'paint'));
  }

  if (strpos($username, ' ')) {
    $errors->add('username', esc_html__('Tên đăng nhập không được có khoảng trắng', 'paint'));
  }

  if (username_exists( $username ) ) {
    $errors->add('username', esc_html__('Tên đăng nhập đã tồn tại', 'paint'));
  }

  // check validate first name
  if ( empty( $first_name )  ) {
    $errors->add('first_name', esc_html__('Họ không được để trống', 'paint'));
  }

  // check validate last name
  if ( empty( $last_name )  ) {
    $errors->add('last_name', esc_html__('Tên không được để trống', 'paint'));
  }

  // check phone number
  if ( empty($phone_number) ) {
    $errors->add('phone_number', esc_html__('Số điện thoại không được để trống', 'paint'));
  }

  if (!empty($phone_number)) {
    if ( !is_numeric($phone_number) ) {
      $errors->add('phone_number', esc_html__('Số điện thoại chỉ nhập số', 'paint'));
    }

    if ( strlen($phone_number) < 10 || strlen($phone_number) > 11 ) {
      $errors->add('phone_number', esc_html__('Số điện thoại độ dài là 10 hoặc 11 số', 'paint'));
    }

    $phone_exists = $wpdb->get_var( "SELECT COUNT(phone_number) FROM $table_extended_users WHERE phone_number = $phone_number" );

    if ($phone_exists > 0) {
      $errors->add('phone_number', esc_html__('Số điện thoại đã tồn tại', 'paint'));
    }
  }

  // check validate email
  if ( !empty($email) ) {
    if (!is_email($email)) {
      $errors->add('email', esc_html__('Email không đúng định dạng', 'paint'));
    }

    if (email_exists($email)) {
      $errors->add('email', esc_html__('Email đã tồn tại', 'paint'));
    }
  }

  // check validate password
  if ( strlen($password) < 8  ) {
    $errors->add('password', esc_html__('Độ dài tối thiểu của mật khẩu là 8 kí tự', 'paint'));
  }

  if ( strlen($password) > 32  ) {
    $errors->add('password', esc_html__('Độ dài tối đa của mật khẩu là 32 kí tự', 'paint'));
  }

  if ( strcmp($password, $passwordConfirm) !== 0 ) {
    $errors->add('password_confirm', esc_html__('Mật khẩu không khớp', 'paint'));
  }

  // error message
  if ( $errors->errors ) {
    $errorUser = $errors->errors['username'][0] ?? '';
    $errorFirstName = $errors->errors['first_name'][0] ?? '';
    $errorLastName = $errors->errors['last_name'][0] ?? '';
    $errorPhoneNumber = $errors->errors['phone_number'][0] ?? '';
    $errorEmail = $errors->errors['email'][0] ?? '';
    $errorPassword = $errors->errors['password'][0] ?? '';
    $errorPasswordConfirm = $errors->errors['password_confirm'][0] ?? '';
  }

  //
  if (count($errors->errors) == 0) {
    $userdata = array(
      'user_login' => $username,
      'user_email' => $email,
      'user_pass' => $password,
      'first_name' => $first_name,
      'last_name' => $last_name,
    );

    $user_id = wp_insert_user($userdata);

    $wpdb->insert($table_extended_users, array(
      'user_id' => $user_id,
      'phone_number' => $phone_number
    ));
    
    //auto login
    $info = array();
    $info['user_login'] = $username;
    $info['user_password'] = $password;
    $info['remember'] = true;
    
    $user_signon = wp_signon( $info, true );
    
    if (!is_wp_error( $user_signon )) {
      wp_redirect( home_url() ); exit;
    }
  }
}

get_header();
?>
<div class="site-container register-warp user-warp">
  <div class="container">
    <div class="grid">
      <div class="grid__item d-flex align-items-center">
        <h1 class="page-title text-uppercase m-0">
          <?php the_title(); ?>
        </h1>
      </div>

      <div class="grid__item">
        <form id="register-form" method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" class="form-user">
          <!-- username -->
          <div class="grid-control">
            <input
              id="username"
              type="text"
              class="form-control"
              name="username"
              value="<?php echo esc_attr($username) ?>"
              placeholder="<?php esc_attr_e('Tên đăng nhập *', 'paint'); ?>"
              aria-label=""
            >

            <?php if ( $errorUser ) : ?>
              <p class="error">
                <?php echo esc_html($errorUser); ?>
              </p>
            <?php endif; ?>
          </div>

          <!-- full name -->
          <div class="grid-control grid-control-full-name">
            <div class="item">
              <input
                id="first-name"
                type="text"
                class="form-control"
                name="first_name"
                value="<?php echo esc_attr($first_name) ?>"
                placeholder="<?php esc_attr_e('Họ *', 'paint'); ?>"
                aria-label=""
              >

              <?php if ( $errorFirstName ) : ?>
                <p class="error">
                  <?php echo esc_html($errorFirstName); ?>
                </p>
              <?php endif; ?>
            </div>

            <div class="item">
              <input
                id="last-name"
                type="text"
                class="form-control"
                name="last_name"
                value="<?php echo esc_attr($last_name) ?>"
                placeholder="<?php esc_attr_e('Tên *', 'paint'); ?>"
                aria-label=""
              >

              <?php if ( $errorLastName ) : ?>
                <p class="error">
                  <?php echo esc_html($errorLastName); ?>
                </p>
              <?php endif; ?>
            </div>
          </div>

          <!-- phone number -->
          <div class="grid-control">
            <input id="phone-number" type="tel" class="form-control" name="phone_number" value="<?php echo esc_attr($phone_number) ?>" placeholder="<?php esc_attr_e('Số điện thoại *', 'paint'); ?>" aria-label="">

            <?php if ( $errorPhoneNumber ) : ?>
              <p class="error">
                <?php echo esc_html($errorPhoneNumber); ?>
              </p>
            <?php endif; ?>
          </div>

          <!-- email -->
          <div class="grid-control">
            <input
              id="email"
              type="text"
              class="form-control"
              name="email"
              value="<?php echo esc_attr($email) ?>"
              placeholder="<?php esc_attr_e('Email', 'paint'); ?>"
              aria-label=""
            >

            <?php if ( $errorEmail ) : ?>
              <p class="error">
                <?php echo esc_html($errorEmail); ?>
              </p>
            <?php endif; ?>
          </div>

          <!-- password -->
          <div class="grid-control">
            <input
              id="password"
              type="password"
              class="form-control"
              name="password"
              placeholder="<?php esc_attr_e('Mật khẩu *', 'paint'); ?>"
              aria-label=""
            >

            <?php if ( $errorPassword ) : ?>
              <p class="error">
                <?php echo esc_html($errorPassword); ?>
              </p>
            <?php endif; ?>
          </div>

          <!-- password_confirm -->
          <div class="grid-control">
            <input
              id="password-confirm"
              type="password"
              class="form-control"
              name="password_confirm"
              placeholder="<?php esc_attr_e('Xác nhận mật khẩu *', 'paint'); ?>"
              aria-label=""
            >

            <?php if ( $errorPasswordConfirm ) : ?>
              <p class="error">
                <?php echo esc_html($errorPasswordConfirm); ?>
              </p>
            <?php endif; ?>
          </div>

          <div class="grid-control grid-control-submit text-center">
            <button type="submit" name="f-submit" class="btn btn-submit text-uppercase fw-bold border-0 rounded-0">
              <?php esc_html_e('Đăng kí', 'paint'); ?>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
get_footer();

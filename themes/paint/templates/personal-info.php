<?php
/*
 Template Name: Thông tin cá nhân
 */

if (!is_user_logged_in()) {
  wp_redirect(home_url());
  exit;
}

global $wpdb;
global $current_user;

$currentUserId = $current_user->id;
$table_extended_users = $wpdb->prefix . 'extended_users';

// query get data extended users
$queryExtendedUser = $wpdb->get_row( "SELECT id, user_id, phone_number, date_birth, province, district, wards, street FROM $table_extended_users WHERE user_id = $currentUserId" );

$email = $current_user->user_email;
$phone_number = $queryExtendedUser->phone_number ?? null;
$date_birth = $queryExtendedUser->date_birth ?? null;
$province = $queryExtendedUser->province ?? null;
$district = $queryExtendedUser->district ?? null;
$wards = $queryExtendedUser->wards ?? null;
$street = $queryExtendedUser->street ?? null;

$errors = new WP_Error();
$userDataUpdate = '';
$errorDateBirth = $errorEmail = $errorPhoneNumber = $errorProvince = $errorDistrict = $errorWards = $errorStreet = '';

if ( !empty($currentUserId) && isset($_POST['f-submit']) ) {
    $date_birth = $wpdb->_escape($_POST['date_birth']) ?? '1970-01-01';
    $phone_number = $wpdb->_escape($_POST['phone_number']) ?? null;
    $email = $wpdb->_escape($_POST['email']) ?? null;
    $province = $wpdb->_escape($_POST['province']) ?? null;
    $district = $wpdb->_escape($_POST['district']) ?? null;
    $wards = $wpdb->_escape($_POST['wards']) ?? null;
    $street = $wpdb->_escape($_POST['street']) ?? null;
    
    // check date birth
    $pattern_format_date = '/^\d{4}-\d{2}-\d{2}$/';
    if ( !empty( $date_birth ) && !preg_match($pattern_format_date, $date_birth) ) {
        $errors->add('date_birth', esc_html__('Ngày sinh không đúng định dạng', 'paint'));
    }
    
    // check validate email
    if ( !empty($email) ) {
        if (!is_email($email)) {
            $errors->add('email', esc_html__('Email không đúng định dạng', 'paint'));
        }
       
        if (email_exists($email) && email_exists($email) != $current_user->ID) {
            $errors->add('email', esc_html__('Email đã tồn tại', 'paint'));
        }
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
        
        $phone_exists = $wpdb->get_var( "SELECT COUNT(phone_number) FROM $table_extended_users WHERE phone_number = $phone_number AND user_id <> $currentUserId" );
        
        if ($phone_exists > 0) {
            $errors->add('phone_number', esc_html__('Số điện thoại đã tồn tại', 'paint'));
        }
    }
    
    // error message
    if ( $errors->errors ) {
        $errorDateBirth = $errors->errors['date_birth'][0] ?? '';
        $errorEmail = $errors->errors['email'][0] ?? '';
        $errorPhoneNumber = $errors->errors['phone_number'][0] ?? '';
    }
   
    // update info
    if ( count($errors->errors) == 0 ) {
        
        if ( empty( $queryExtendedUser ) ) {
            
            $wpdb->insert($table_extended_users, array(
              'user_id' => $currentUserId,
              'phone_number' => $phone_number,
              'date_birth' => $date_birth,
              'province' => $province,
              'district' => $district,
              'wards' => $wards,
              'street' => $street,
            ));
            
        } else {
            $wpdb->update($table_extended_users, array(
              'user_id' => $currentUserId,
              'phone_number' => $phone_number,
              'date_birth' => $date_birth,
              'province' => $province,
              'district' => $district,
              'wards' => $wards,
              'street' => $street,
            ), array('id' => $queryExtendedUser->id));
            
        }
        
        // update email
        if ($email != $current_user->user_email) {
            $user_data = wp_update_user( array( 'ID' => $currentUserId, 'user_email' => $email ) );
            
            if ( is_wp_error( $user_data ) ) {
                $userDataUpdate = 'Error.';
            }
        }
        
    }
}

get_header();
?>
  
  <div class="site-container user-info-warp">
    <div class="container">
      <?php
      get_template_part('template-parts/account-management/inc', 'heading', [
        'title' => esc_html__('THÔNG TIN CÁ NHÂN')
      ]);
      ?>

      <div class="tab-user-info grid-info">
        <?php get_template_part('template-parts/account-management/inc', 'nav'); ?>

        <div class="tab-user-content">
            <?php
            if ( isset($_POST['f-submit'] ) ) {
                if ( count($errors->errors) == 0 && $userDataUpdate == '' ) :
            ?>
            <p class="txt-success text-center mb-5">
                <?php esc_html_e('Cập nhật thành công', 'paint'); ?>
            </p>
            
            <?php else: ?>
                <p class="txt-error text-center mb-5">
                    <?php esc_html_e('Đã có lỗi xảy ra', 'paint'); ?>
                </p>
            <?php
                endif;
            }
            ?>
            
          <form id="user-update-form" class="user-update-form" method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
            <div class="row row-cols-1 row-cols-sm-2">
              <div class="col">
                <div class="group-control">
                  <label for="user-name" class="form-label">
                    <?php esc_html_e('Tên đăng nhập', 'paint'); ?>
                  </label>

                  <input id="user-name" type="text" class="form-control" value="<?php echo esc_attr( $current_user->user_login ); ?>" aria-label="" readonly disabled>
                </div>

                <div class="group-control">
                  <label for="date-birth" class="form-label">
                    <?php esc_html_e('Ngày sinh', 'paint'); ?>
                  </label>

                  <input id="date-birth" type="date" class="form-control" value="<?php echo esc_attr($date_birth) ?>" name="date_birth">
                    
                    <?php if ( $errorDateBirth ) : ?>
                        <p class="error">
                            <?php echo esc_html($errorDateBirth); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="group-control">
                  <label for="email" class="form-label">
                    <?php esc_html_e('Email', 'paint'); ?>
                  </label>

                  <input id="email" type="email" class="form-control" value="<?php echo esc_attr( $email ); ?>" name="email">
                    
                    <?php if ( $errorEmail ) : ?>
                        <p class="error">
                            <?php echo esc_html($errorEmail); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="group-control">
                  <label for="phone-number" class="form-label">
                    <?php esc_html_e('Số điện thoại', 'paint'); ?>
                  </label>

                  <input id="phone-number" type="tel" class="form-control" value="<?php echo esc_attr($phone_number) ?>" name="phone_number">
                    
                    <?php if ( $errorPhoneNumber ) : ?>
                        <p class="error">
                            <?php echo esc_html($errorPhoneNumber); ?>
                        </p>
                    <?php endif; ?>
                </div>
              </div>

              <div class="col">
                <div class="group-control">
                  <label class="form-label">
                    <?php esc_html_e('Địa chỉ', 'paint'); ?>
                  </label>

                  <input
                    id="province"
                    type="text"
                    class="form-control"
                    placeholder="<?php esc_attr_e('Tỉnh / Thành phố', 'paint'); ?>"
                    value="<?php echo esc_attr($province) ?>"
                    name="province"
                    aria-label=""
                  >

                  <input
                    id="district"
                    type="text"
                    class="form-control"
                    placeholder="<?php esc_attr_e('Quận / Huyện', 'paint'); ?>"
                    value="<?php echo esc_attr($district) ?>"
                    name="district"
                    aria-label=""
                  >

                  <input
                    id="wards"
                    type="text"
                    class="form-control"
                    placeholder="<?php esc_attr_e('Phường / Xã', 'paint'); ?>"
                    value="<?php echo esc_attr($wards) ?>"
                    name="wards"
                    aria-label=""
                  >

                  <input
                    id="street"
                    type="text"
                    class="form-control"
                    placeholder="<?php esc_attr_e('Số nhà', 'paint'); ?>"
                    value="<?php echo esc_attr($street) ?>"
                    name="street"
                    aria-label=""
                  >
                </div>
              </div>
            </div>

            <div class="action-box text-center">
              <button type="submit" name="f-submit" class="btn btn-submit">
                <?php esc_html_e('CẬP NHẬT THÔNG TIN', 'paint'); ?>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<?php
get_footer();

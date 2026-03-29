<?php
// get current url page
$obj_id = get_queried_object_id();
$current_url = get_permalink( $obj_id );

// list menu
$menu_acc_management = [
  [
    'title' => esc_html__('Thông tin cá nhân', 'paint'),
    'url' => paint_get_tpl_url('templates/personal-info.php')
  ],
  [
    'title' => esc_html__('Đã lưu', 'paint'),
    'url' => paint_get_tpl_url('templates/saved.php'),
  ],
  [
    'title' => esc_html__('Đổi mật khẩu', 'paint'),
    'url' => paint_get_tpl_url('templates/change-password.php'),
  ],
  [
    'title' => esc_html__('Đăng xuất', 'paint'),
    'url' => wp_logout_url( home_url() ),
  ],
];
?>

<nav class="nav-acc-management">
  <ul>
    <?php foreach ($menu_acc_management as $itemMenu) : ?>
      <li>
        <a class="nav-link<?php echo esc_attr( $itemMenu['url'] == $current_url ? ' active' : '' ); ?>" href="<?php echo esc_url( $itemMenu['url'] ) ?>">
          <?php echo esc_html( $itemMenu['title'] ); ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>
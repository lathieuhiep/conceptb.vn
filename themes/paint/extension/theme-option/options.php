<?php
// A Custom function for get an option
if (!function_exists('paint_get_option')) {
    function paint_get_option($option = '', $default = null)
    {
        $options = get_option('options'); // Attention: Set your unique id of the framework

        return (isset($options[$option])) ? $options[$option] : $default;
    }
}

// Control core classes for avoid errors
if (class_exists('CSF')) {
    // Set a unique slug-like ID
    $paint_prefix = 'options';
    $paint_my_theme = wp_get_theme();

    // Create options
    CSF::createOptions($paint_prefix, array(
        'menu_title' => esc_html__('Theme Options', 'paint'),
        'menu_slug' => 'theme-options',
        'menu_position' => 2,
        'admin_bar_menu_icon' => 'dashicons-admin-generic',
        'framework_title' => $paint_my_theme->get('Name') . ' ' . esc_html__('Options', 'paint'),
        'footer_text' => esc_html__('Thank you for using my theme', 'paint'),
        'footer_after' => '<pre>Contact me:<br />Zalo/Phone: 0975458209 - Skype: lathieuhiep - facebook: <a href="https://www.facebook.com/lathieuhiep" target="_blank">lathieuhiep</a></pre>',
    ));

    // Create a section general
    CSF::createSection($paint_prefix, array(
        'title' => esc_html__('Cài đặt chung', 'paint'),
        'icon' => 'fas fa-cog',
        'fields' => array(
            // favicon
            array(
                'id' => 'general_opt_favicon',
                'type' => 'media',
                'title' => esc_html__('Chọn ảnh favicon', 'paint'),
                'library' => 'image',
                'url' => false
            ),

            // logo
            array(
                'id' => 'general_opt_logo',
                'type' => 'media',
                'title' => esc_html__('Chọn ảnh logo', 'paint'),
                'library' => 'image',
                'url' => false
            ),

            // show loading
            array(
                'id' => 'general_opt_loading',
                'type' => 'switcher',
                'title' => esc_html__('Sử dụng chờ tài trang', 'paint'),
                'text_on' => esc_html__('Có', 'paint'),
                'text_off' => esc_html__('Không', 'paint'),
                'text_width' => 80,
                'default' => false
            ),

            array(
                'id' => 'general_opt_image_loading',
                'type' => 'media',
                'title' => esc_html__('Chọn ảnh chờ tài trang', 'paint'),
                'subtitle' => esc_html__('Sử dụng file .git', 'paint') . ' <a href="https://loading.io/" target="_blank">loading.io</a>',
                'dependency' => array('general_opt_loading', '==', 'true'),
                'url' => false
            ),

            // show back to top
            array(
                'id' => 'general_opt_back_to_top',
                'type' => 'switcher',
                'title' => esc_html__('Sử dụng nút về đầu trang', 'paint'),
                'text_on' => esc_html__('Có', 'paint'),
                'text_off' => esc_html__('Không', 'paint'),
                'text_width' => 80,
                'default' => true
            ),
        )
    ));

    //
    // -> Create a section info company
    CSF::createSection($paint_prefix, array(
        'title' => esc_html__('Thông tin công ty', 'paint'),
        'icon' => 'fas fa-info',
        'fields' => array(
            array(
                'id' => 'opt-info-company-address',
                'type' => 'text',
                'title' => esc_html__('Địa chỉ', 'paint'),
                'default' => esc_html__('Khu Công nghiệp Kiêu Kỵ, Gia Lâm, Hà Nội', 'paint')
            ),

            array(
                'id' => 'opt-info-company-phone',
                'type' => 'repeater',
                'title' => esc_html__('Điện thoại', 'paint'),
                'fields' => array(
                    array(
                        'id' => 'phone',
                        'type' => 'text',
                        'title' => esc_html__('Nhập số', 'paint'),
                    ),
                ),
                'default' => array(
                    array(
                        'phone' => '0334.991.555',
                    ),
                    array(
                        'phone' => '0122345678',
                    )
                )
            ),

            array(
                'id' => 'opt-info-company-email',
                'type' => 'text',
                'title' => esc_html__('Email', 'paint'),
                'default' => 'sonbeecolor@gmail.com'
            ),
        )
    ));

    //
    // -> Create a section template faq
    CSF::createSection($paint_prefix, array(
        'id' => 'template_faq_opt',
        'icon' => 'fas fa-question-circle',
        'title' => esc_html__('Trang FAQ', 'paint'),
        'fields' => array(
            // Limit
            array(
                'id' => 'template_faq_opt_limit',
                'type' => 'number',
                'title' => esc_html__('Số bài viêt cần lấy', 'paint'),
                'default' => 10,
            ),

            // order by
            array(
                'id' => 'template_faq_opt_order_by',
                'type' => 'select',
                'title' => esc_html__('Lấy bài viết theo', 'paint'),
                'options' => array(
                    'id' => esc_html__('ID', 'beecolor'),
                    'title' => esc_html__('Tiêu đề', 'paint'),
                    'date' => esc_html__('Ngày tạo', 'paint'),
                ),
                'default' => 'id'
            ),

            // order
            array(
                'id' => 'template_faq_opt_order',
                'type' => 'select',
                'title' => esc_html__('Sắp xếp bài viết', 'paint'),
                'options' => array(
                    'ASC' => esc_html__('Trên xuống dưới', 'paint'),
                    'DESC' => esc_html__('Dưới lên trên', 'paint'),
                ),
                'default' => 'ASC'
            )
        )
    ));
    // -> End section template faq

    //
    // -> Create a section blog
    CSF::createSection($paint_prefix, array(
        'id' => 'paint_opt_blog',
        'icon' => 'fas fa-blog',
        'title' => esc_html__('Bài viết', 'paint'),
    ));

    // Category Post
    CSF::createSection($paint_prefix, array(
        'parent' => 'paint_opt_blog',
        'title' => esc_html__('Chuyên mục', 'paint'),
        'fields' => array(
            array(
                'id' => 'paint_opt_blog_cat_sidebar',
                'type' => 'select',
                'title' => esc_html__('Vị trí sidebar', 'paint'),
                'options' => array(
                    'hide' => esc_html__('Hide', 'paint'),
                    'left' => esc_html__('Left', 'paint'),
                    'right' => esc_html__('Right', 'paint'),
                ),
                'default' => 'right'
            ),

            array(
                'id' => 'paint_opt_blog_per_row',
                'type' => 'select',
                'title' => esc_html__('Bài viết trên 1 hàng', 'paint'),
                'options' => array(
                    '2' => esc_html__('2 Bài', 'paint'),
                    '3' => esc_html__('3 Bài', 'paint'),
                    '4' => esc_html__('4 Bài', 'paint'),
                ),
                'default' => '3'
            ),
        )
    ));

    // Single Post
    CSF::createSection($paint_prefix, array(
        'parent' => 'paint_opt_blog',
        'title' => esc_html__('Chi tiết', 'paint'),
        'fields' => array(
            array(
                'id' => 'paint_opt_single_sidebar',
                'type' => 'select',
                'title' => esc_html__('Vị trí sidebar', 'paint'),
                'options' => array(
                    'hide' => esc_html__('Hide', 'paint'),
                    'left' => esc_html__('Left', 'paint'),
                    'right' => esc_html__('Right', 'paint'),
                ),
                'default' => 'right'
            ),

            array(
                'id' => 'paint_opt_single_share',
                'type' => 'switcher',
                'title' => esc_html__('Chia sẻ bài viết', 'paint'),
                'text_on' => esc_html__('Có', 'paint'),
                'text_off' => esc_html__('Không', 'paint'),
                'default' => true,
                'text_width' => 80
            ),

            array(
                'id' => 'paint_opt_single_related',
                'type' => 'switcher',
                'title' => esc_html__('Hiển thị bài viết liên quan', 'paint'),
                'text_on' => esc_html__('Có', 'paint'),
                'text_off' => esc_html__('Không', 'paint'),
                'default' => true,
                'text_width' => 80
            ),
        )
    ));

    //
    // -> Create a section template project
    CSF::createSection($paint_prefix, array(
        'icon' => 'fas fa-folder-open',
        'title' => esc_html__('Dự Án', 'paint'),
        'description' => esc_html__('Thiết lập cho danh mục và lưu trữ'),
        'fields' => array(
            // Limit
            array(
                'id' => 'template_project_opt_limit',
                'type' => 'number',
                'title' => esc_html__('Số bài viêt cần lấy', 'paint'),
                'default' => 12,
            ),

            // order by
            array(
                'id' => 'template_project_opt_order_by',
                'type' => 'select',
                'title' => esc_html__('Lấy bài viết theo', 'paint'),
                'options' => array(
                    'id' => esc_html__('ID', 'beecolor'),
                    'title' => esc_html__('Tiêu đề', 'paint'),
                    'date' => esc_html__('Ngày tạo', 'paint'),
                ),
                'default' => 'id'
            ),

            // order
            array(
                'id' => 'template_project_opt_order',
                'type' => 'select',
                'title' => esc_html__('Sắp xếp bài viết', 'paint'),
                'options' => array(
                    'ASC' => esc_html__('Trên xuống dưới', 'paint'),
                    'DESC' => esc_html__('Dưới lên trên', 'paint'),
                ),
                'default' => 'ASC'
            )
        )
    ));
    // -> End section template project

    //
    // -> Create a section post type tool
    CSF::createSection($paint_prefix, array(
        'title' => esc_html__('Dụng cụ', 'paint'),
        'icon' => 'fas fa-tools',
        'fields' => array()
    ));

    //
    // -> Create a section post type discover
    CSF::createSection($paint_prefix, array(
        'title' => esc_html__('Khám phá', 'paint'),
        'id' => 'paint_opt_discover',
        'icon' => 'fas fa-images',
    ));

    // taxonomy discover
    CSF::createSection($paint_prefix, array(
        'parent' => 'paint_opt_discover',
        'title' => esc_html__('Chuyên mục', 'paint'),
        'fields' => array(
            // Limit
            array(
                'id' => 'discover_opt_limit',
                'type' => 'number',
                'title' => esc_html__('Số bài viêt cần lấy', 'paint'),
                'default' => 12,
            ),
        )
    ));

    // Single discover
    CSF::createSection($paint_prefix, array(
        'parent' => 'paint_opt_discover',
        'title' => esc_html__('Chi tiết', 'paint'),
        'fields' => array(
            array(
                'id' => 'paint_opt_discover_single',
                'type' => 'text',
                'title' => esc_html__('Link tư vấn', 'paint'),
            ),
        )
    ));

    //
    // -> Create a section post type product
    CSF::createSection($paint_prefix, array(
        'title' => esc_html__('Sản phẩm', 'paint'),
        'id' => 'paint_opt_product',
        'icon' => 'fas fa-shopping-cart',
    ));

    // taxonomy product
    CSF::createSection($paint_prefix, array(
        'parent' => 'paint_opt_product',
        'title' => esc_html__('Chuyên mục', 'paint'),
        'fields' => array(
            // Limit
            array(
                'id' => 'paint_opt_product_cat_limit',
                'type' => 'number',
                'title' => esc_html__('Số sản phẩm cần lấy', 'paint'),
                'default' => 8,
            ),

            // contact
            array(
                'id' => 'opt-link-2',
                'type' => 'link',
                'title' => 'Link',
                'default' => array(
                    'url' => 'http://codestarframework.com/',
                    'text' => 'Codestar Framework',
                    'target' => '_blank'
                ),
            ),

        )
    ));

    // product detail
    CSF::createSection($paint_prefix, array(
        'parent' => 'paint_opt_product',
        'title' => esc_html__('Chi tiết', 'paint'),
        'fields' => array(
            // contact
            array(
                'id' => 'paint_opt_product_detail_contact',
                'type' => 'link',
                'title' => esc_html__('Link liên hệ', 'paint'),
                'default' => array(
                    'url' => '#',
                ),
            ),
        )
    ));

    //
    // Create a section social network
    CSF::createSection($paint_prefix, array(
        'title' => esc_html__('Mạng xã hội', 'paint'),
        'icon' => 'fab fa-hive',
        'fields' => array(
            array(
                'id' => 'paint_opt_social_network',
                'type' => 'sortable',
                'title' => 'Sortable',
                'fields' => array(
                    array(
                        'id' => 'facebook',
                        'type' => 'text',
                        'title' => esc_html__('URL Facebook', 'paint'),
                    ),

                    array(
                        'id' => 'youtube',
                        'type' => 'text',
                        'title' => esc_html__('URL Youtube', 'paint'),
                    ),

                    array(
                        'id' => 'tiktok',
                        'type' => 'text',
                        'title' => esc_html__('URL Tiktok', 'paint'),
                    ),

                    array(
                        'id' => 'pinterest',
                        'type' => 'text',
                        'title' => esc_html__('URL Pinterest', 'paint'),
                    ),
                ),
                'default' => array(
                    'facebook' => 'https://www.facebook.com/Bcolor.vn',
                    'youtube' => 'https://www.youtube.com/@BColorVietNam',
                    'tiktok' => 'https://www.tiktok.com/@sondabcolor?lang=vi-VN',
                    'pinterest' => 'https://www.pinterest.com/SonBColor/',
                ),
            ),

        )
    ));

    // Create a section social sharing
    CSF::createSection($paint_prefix, array(
        'title' => esc_html__('Chia sẻ mạng xã hội', 'paint'),
        'icon' => 'fab fa-hive',
        'fields' => array(
            array(
                'id' => 'social_sharing_facebook_app_id',
                'type' => 'text',
                'title' => esc_html__('Facebook App Id', 'paint'),
            ),
        )
    ));

    //
    // -> Create a section footer
    CSF::createSection($paint_prefix, array(
        'id' => 'parent_footer',
        'icon' => 'fas fa-stream',
        'title' => esc_html__('Chân trang', 'paint'),
    ));

    // footer columns
    CSF::createSection($paint_prefix, array(
        'parent' => 'parent_footer',
        'title' => esc_html__('Thiết lâp cột', 'paint'),
        'fields' => array(
            // select columns
            array(
                'id' => 'paint_opt_footer_columns',
                'type' => 'select',
                'title' => esc_html__('Number of footer columns', 'paint'),
                'options' => array(
                    '0' => esc_html__('Hide', 'paint'),
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                ),
                'default' => '4'
            ),

            // column width 1
            array(
                'id' => 'paint_opt_footer_column_width_1',
                'type' => 'fieldset',
                'title' => esc_html__('Column width 1', 'paint'),
                'fields' => array(
                    array(
                        'id' => 'sm',
                        'type' => 'slider',
                        'title' => esc_html__('sm: ≥576px', 'paint'),
                        'default' => 12,
                        'min' => 1,
                        'max' => 12,
                    ),

                    array(
                        'id' => 'md',
                        'type' => 'slider',
                        'title' => esc_html__('md: ≥768px', 'paint'),
                        'default' => 6,
                        'min' => 1,
                        'max' => 12,
                    ),

                    array(
                        'id' => 'lg',
                        'type' => 'slider',
                        'title' => esc_html__('lg: ≥992px', 'paint'),
                        'default' => 3,
                        'min' => 1,
                        'max' => 12,
                    ),

                    array(
                        'id' => 'xl',
                        'type' => 'slider',
                        'title' => esc_html__('xl: ≥1200px', 'paint'),
                        'default' => 3,
                        'min' => 1,
                        'max' => 12,
                    ),
                ),
                'dependency' => array('paint_opt_footer_columns', '!=', '0')
            ),

            // column width 2
            array(
                'id' => 'paint_opt_footer_column_width_2',
                'type' => 'fieldset',
                'title' => esc_html__('Column width 2', 'paint'),
                'fields' => array(
                    array(
                        'id' => 'sm',
                        'type' => 'slider',
                        'title' => esc_html__('sm: ≥576px', 'paint'),
                        'default' => 12,
                        'min' => 1,
                        'max' => 12,
                    ),

                    array(
                        'id' => 'md',
                        'type' => 'slider',
                        'title' => esc_html__('md: ≥768px', 'paint'),
                        'default' => 6,
                        'min' => 1,
                        'max' => 12,
                    ),

                    array(
                        'id' => 'lg',
                        'type' => 'slider',
                        'title' => esc_html__('lg: ≥992px', 'paint'),
                        'default' => 3,
                        'min' => 1,
                        'max' => 12,
                    ),

                    array(
                        'id' => 'xl',
                        'type' => 'slider',
                        'title' => esc_html__('xl: ≥1200px', 'paint'),
                        'default' => 3,
                        'min' => 1,
                        'max' => 12,
                    ),
                ),
                'dependency' => array('paint_opt_footer_columns', 'not-any', '0,1')
            ),

            // column width 3
            array(
                'id' => 'paint_opt_footer_column_width_3',
                'type' => 'fieldset',
                'title' => esc_html__('Column width 3', 'paint'),
                'fields' => array(
                    array(
                        'id' => 'sm',
                        'type' => 'slider',
                        'title' => esc_html__('sm: ≥576px', 'paint'),
                        'default' => 12,
                        'min' => 1,
                        'max' => 12,
                    ),

                    array(
                        'id' => 'md',
                        'type' => 'slider',
                        'title' => esc_html__('md: ≥768px', 'paint'),
                        'default' => 6,
                        'min' => 1,
                        'max' => 12,
                    ),

                    array(
                        'id' => 'lg',
                        'type' => 'slider',
                        'title' => esc_html__('lg: ≥992px', 'paint'),
                        'default' => 3,
                        'min' => 1,
                        'max' => 12,
                    ),

                    array(
                        'id' => 'xl',
                        'type' => 'slider',
                        'title' => esc_html__('xl: ≥1200px', 'paint'),
                        'default' => 3,
                        'min' => 1,
                        'max' => 12,
                    ),
                ),
                'dependency' => array('paint_opt_footer_columns', 'not-any', '0,1,2')
            ),

            // column width 4
            array(
                'id' => 'paint_opt_footer_column_width_4',
                'type' => 'fieldset',
                'title' => esc_html__('Column width 3', 'paint'),
                'fields' => array(
                    array(
                        'id' => 'sm',
                        'type' => 'slider',
                        'title' => esc_html__('sm: ≥576px', 'paint'),
                        'default' => 12,
                        'min' => 1,
                        'max' => 12,
                    ),

                    array(
                        'id' => 'md',
                        'type' => 'slider',
                        'title' => esc_html__('md: ≥768px', 'paint'),
                        'default' => 6,
                        'min' => 1,
                        'max' => 12,
                    ),

                    array(
                        'id' => 'lg',
                        'type' => 'slider',
                        'title' => esc_html__('lg: ≥992px', 'paint'),
                        'default' => 3,
                        'min' => 1,
                        'max' => 12,
                    ),

                    array(
                        'id' => 'xl',
                        'type' => 'slider',
                        'title' => esc_html__('xl: ≥1200px', 'paint'),
                        'default' => 3,
                        'min' => 1,
                        'max' => 12,
                    ),
                ),
                'dependency' => array('paint_opt_footer_columns', 'not-any', '0,1,2,3')
            ),
        )
    ));

    // -> End create a section footer

}


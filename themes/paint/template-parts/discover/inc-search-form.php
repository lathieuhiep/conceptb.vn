<?php
$paint_unique_id = esc_attr( uniqid( 'search-form-' ) );


$cat = ! empty( $_GET['cat'] ) ? (int) $_GET['cat'] : '';

if ( is_singular( 'paint_discover' ) ) {
	$get_terms_post = wp_get_post_terms( get_the_ID(), 'paint_discover_cat', array( 'fields' => 'slugs' ) );

	if ( $get_terms_post ) {
		$cat = $get_terms_post[0];
	}
}
?>

<form role="search" method="get"
      class="form-search-box <?php echo esc_attr( ! is_singular( 'paint_discover' ) ? 'search-form-discover' : 'search-form-single-discover' ); ?>"
      action="<?php echo esc_url( home_url( '/' ) ); ?>"
>
    <input type="hidden" readonly name="post_type" value="paint_discover">

    <div class="group-control">
        <input type="search" id="<?php echo $paint_unique_id; ?>" class="search-field"
               placeholder="<?php echo esc_attr_x( 'Nhập từ khóa...', 'placeholder', 'paint' ); ?>"
               value="<?php echo get_search_query(); ?>" name="s" aria-label=""/>

        <button type="submit" class="search-submit">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </div>
</form>
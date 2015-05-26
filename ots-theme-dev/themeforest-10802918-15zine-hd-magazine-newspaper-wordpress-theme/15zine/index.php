<?php
    get_header();
    $cb_module_type = ot_get_option( 'cb_hp_gridslider', 'cb_full_off' );
    $cb_blog_style = ot_get_option( 'cb_blog_style', 'a' );
    $cb_hp_ad = ot_get_option( 'cb_hp_ad', NULL );
    $cb_module_type_cats = ot_get_option( 'cb_gridslider_category', '' );
    $cb_full_site_width = $cb_grid_3 = false;
    $cb_title = $cb_module_style = $cb_offset = $cb_order = $cb_orderby = $cb_filter = $cb_tag_id = $cb_post_ids = NULL;
    $j = 0;
    if ( is_rtl() ) {
        $cb_slider_ltr_rtl = ' style="direction:ltr;"';
    } else {
        $cb_slider_ltr_rtl = NULL;
    }

    if ( $cb_module_type_cats == NULL ) {
         $cb_module_type_cats =  get_terms( 'category', array('fields' => 'ids') );
    }
    $cb_cat_id = implode( ',', $cb_module_type_cats );

    if ( ( $cb_module_type == 'grid-3' ) || ( $cb_module_type == 'grid-4' ) || ( $cb_module_type == 'grid-5' ) || ( $cb_module_type == 'grid-6' ) ) {
        $cb_ppp = substr( $cb_module_type, -1 );
        if ( $cb_module_type == 'grid-3' ) {
            $cb_grid_3 = true;
        }
        $cb_module_type = 'grid-x';
    }

    if ( $cb_module_type == 's-2' ) {
        $cb_section = 'b';
    } else {
        $cb_section = 'a';
    }

    if ( $cb_module_type == 's-1fw' ) {

        $cb_module_type = 's-1';
        $cb_full_site_width = true;
        $cb_section = 'f';
        echo '<section id="cb-section-f" class="clearfix">';
        include( locate_template( 'library/modules/cb-' . $cb_module_type . '.php' ) );
        echo '</section>';
    }

?>

<div id="cb-content" class="wrap clearfix">

<?php 

    if ( ( ( $cb_module_type == 'grid-x' ) && ( $cb_grid_3 == false ) ) || ( ( $cb_full_site_width == false ) && ( $cb_module_type == 's-1' )) || ( $cb_module_type == 's-3' ) || ( $cb_module_type == 's-5' ) ) {
        include( locate_template( 'library/modules/cb-' . $cb_module_type . '.php' ) );
    }


    if ( ( $cb_module_type == 's-3' ) || ( $cb_module_type == 's-1' ) || ( $cb_module_type == 'cb_full_off' ) || ( ( $cb_module_type == 'grid-x' ) && ( $cb_grid_3 == false ) ) || ( $cb_module_type == 's-5' ) ) {
        echo '<div id="main" class="cb-main clearfix cb-module-block cb-blog-style-roll" role="main">';
    } else {
        echo '<div id="main" class="cb-main clearfix cb-module-block cb-blog-style-roll" role="main">';
        include( locate_template( 'library/modules/cb-' . $cb_module_type . '.php' ) );
    }

    if ( $cb_hp_ad != NULL ) {
        echo '<div class="cb-category-top">' . do_shortcode( $cb_hp_ad ) . '</div>';
    }
    
    get_template_part( 'blog-style', $cb_blog_style ); 

?>

    </div> <!-- end #main -->

    <?php if ( ( $cb_blog_style != 'i' ) && ( $cb_blog_style != 'c' ) ) { get_sidebar(); } ?>

</div> <!-- end #cb-content -->

<?php get_footer(); ?>
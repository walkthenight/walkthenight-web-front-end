<?php
        get_header();
        $cb_cats = get_the_category();
        $cb_cat_id = get_query_var( 'cat' );
        $cb_blog_style = cb_get_blog_style();
        $cb_full_site_width = $cb_grid_3 = false;
        $cb_title = $cb_module_style = $cb_offset = $cb_order = $cb_orderby = $cb_filter = $cb_tag_id = $cb_post_ids = NULL;
        $j = 0;
        $cb_category_ad = NULL;
        $cb_featured_option = 'Off';
        if ( is_rtl() ) {
            $cb_slider_ltr_rtl = ' style="direction:ltr;"';
        } else {
            $cb_slider_ltr_rtl = NULL;
        }

        if ( function_exists( 'get_tax_meta' ) ) {

            $cb_category_color_style = get_tax_meta( $cb_cat_id, 'cb_cat_style_color' );
            $cb_featured_option = get_tax_meta( $cb_cat_id, 'cb_cat_featured_op' );
            $cb_module_type = $cb_featured_option;
            $cb_category_ad = get_tax_meta_strip( $cb_cat_id, 'cb_cat_ad' );
 
        }
        if ( $cb_featured_option == NULL ) {
            $cb_featured_option = 'Off';
        }

        if ( ( $cb_featured_option == 'grid-3' ) || ( $cb_featured_option == 'grid-4' ) || ( $cb_featured_option == 'grid-5' ) || ( $cb_featured_option == 'grid-6' ) ) {
            $cb_ppp = substr( $cb_featured_option, -1 );
            if ( $cb_featured_option == 'grid-3' ) {
                $cb_grid_3 = true;
            }
            $cb_featured_option = 'grid-x';
        }

        if ( $cb_featured_option == 's-2' ) {
            $cb_section = 'b';
        } else {
            $cb_section = 'a';
        }


        if ( $cb_featured_option == 's-1fw' ) {

            $cb_featured_option = 's-1';
            $cb_full_site_width = true;
            $cb_section = 'f';
            echo '<section id="cb-section-f" class="clearfix">';
            include( locate_template( 'library/modules/cb-' . $cb_featured_option . '.php' ) );
            echo '</section>';
        }

?>

<div id="cb-content" class="wrap clearfix">

<?php 
            
        if ( ( ( $cb_featured_option == 'grid-x' ) && ( $cb_grid_3 == false ) ) || ( ( $cb_full_site_width == false ) && ( $cb_featured_option == 's-1' )) || ( $cb_featured_option == 's-3' ) || ( $cb_featured_option == 's-5' ) ) {

            include( locate_template( 'library/modules/cb-' . $cb_featured_option . '.php' ) );
        }

        if ( ( $cb_featured_option == 's-3' ) || ( $cb_featured_option == 's-1' ) || ( $cb_featured_option == 'cb_full_off' ) || ( $cb_featured_option == 'Off' ) || ( ( $cb_featured_option == 'grid-x' ) && ( $cb_grid_3 == false ) ) || ( $cb_featured_option == 's-5' ) ) {
            echo '<div id="main" class="cb-main clearfix cb-module-block cb-blog-style-roll" role="main">';
        } else {
            echo '<div id="main" class="cb-main clearfix cb-module-block cb-blog-style-roll" role="main">';
            include( locate_template( 'library/modules/cb-' . $cb_featured_option . '.php' ) );
        }

         if ( $cb_category_ad != NULL ) {
            echo '<div class="cb-category-top cb-box">' . do_shortcode( $cb_category_ad ) . '</div>';
        }
    
        cb_breadcrumbs(); 
?> 
        <div class="cb-module-header cb-category-header">
               <h1 class="cb-module-title"><?php echo get_category( get_query_var( 'cat' ) )->name; ?></h1>
               <?php echo category_description( $cb_cat_id ); ?>
        </div>

        <?php include( locate_template( 'blog-style-' . $cb_blog_style . '.php' ) ); ?>

    </div> <!-- /main -->

    <?php if ( ( $cb_blog_style != 'i' ) && ( $cb_blog_style != 'c' ) ) { get_sidebar(); } ?>

</div> <!-- end /#cb-content -->

<?php get_footer(); ?>
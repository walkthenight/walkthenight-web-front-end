<?php
	get_header();
	$cb_blog_style = cb_get_blog_style();

?>

<div id="cb-content" class="wrap clearfix">
    
    <div id="main" class="cb-main clearfix cb-module-block" role="main">
        
        <?php cb_breadcrumbs(); ?> 
        <div class="cb-module-header cb-category-header">
            <h1 class="cb-module-title">
                <?php 
                    if ( is_day() == true) { 

                        the_date();

                    } elseif ( is_month() == true ) {

                        the_date( 'F Y' );

                    } elseif ( is_year() == true ) {

                        the_date( 'Y' );
                    }
                ?>
            </h1>                
        </div>
        
        <?php

            include( locate_template( 'blog-style-' . $cb_blog_style . '.php') );

        ?>

    </div> <!-- /main -->

    <?php if ( $cb_blog_style != 'style-c' ) { get_sidebar(); } ?>

</div> <!-- end /#cb-content -->

<?php get_footer(); ?>
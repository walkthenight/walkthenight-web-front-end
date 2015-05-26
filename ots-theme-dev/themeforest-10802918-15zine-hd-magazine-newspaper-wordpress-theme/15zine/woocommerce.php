<?php
        get_header();
        $cb_woocommerce_comments_onoff = ot_get_option('cb_woocommerce_comments_onoff', 'cb_comments_off');
        $cb_sidebar = ot_get_option( 'cb_woocommerce_sidebar', 'sidebar' );
?>
        <div id="cb-content" class="wrap clearfix">

            <div id="main" class="cb-main" role="main">
                
                <?php cb_breadcrumbs(); ?>
                <div class="cb-module-header cb-category-header">
                   <h1 class="cb-module-title">
                        <?php  if ( is_shop() ) {
                            woocommerce_page_title();
                        } elseif ( ( is_product_category() ) || ( is_product_tag() ) ) {

                            global $wp_query;
                            $cb_current_object = $wp_query->get_queried_object();
                            echo $cb_current_object->name;

                        } else {
                            the_title();
                        } ?>
                    </h1>
                </div>

                <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

                    <section class="cb-entry-content clearfix" itemprop="articleBody">
                        <?php woocommerce_content(); ?>                      
                    </section> <!-- end article section -->

                </article> <!-- end article -->

            </div> <!-- end #main -->

            <?php if ( $cb_sidebar != 'nosidebar' ) { get_sidebar(); } ?>

        </div> <!-- end #cb-content -->

<?php get_footer(); ?>
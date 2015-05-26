<?php
        get_header();
        $cb_page_id = get_the_ID();
        $cb_breadcrumbs = ot_get_option('cb_breadcrumbs', 'on');
        $cb_page_comments = get_post_meta( $cb_page_id, 'cb_page_comments', true );
        $cb_featured_image_style = get_post_meta( $cb_page_id, 'cb_featured_image_style', true );
        $cb_sidebar = get_post_meta( $cb_page_id, 'cb_full_width_post', true );
        $cb_page_title = get_post_meta( $cb_page_id, 'cb_page_title', true );

        if ( $cb_featured_image_style == NULL ) {
		    $cb_featured_image_style = 'standard';
		}
		if ( cb_is_woocommerce() == true ) {
			$cb_featured_image_style = 'off';
		}
        if ( $cb_featured_image_style == 'standard-uncrop' ) {
			$cb_featured_image_style = 'standard';
		}

        if ( cb_is_woocommerce() ) {
        	$cb_sidebar = ot_get_option('cb_woocommerce_sidebar', 'sidebar');
        }


		if ( ( $cb_featured_image_style != 'off' ) && ( $cb_featured_image_style != 'standard' ) && ( $cb_featured_image_style != 'site-width' ) ) { do_shortcode ( cb_featured_image_style( $cb_featured_image_style, $post, 'page-overlay' ) ); };

?>
        <div id="cb-content" class="wrap clearfix">
			
			<?php if ( $cb_featured_image_style == 'site-width' ) { do_shortcode ( cb_featured_image_style( $cb_featured_image_style, $post, 'page' ) ); }; ?>
	        

	        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<div id="main" class="cb-main" role="main">
				
				<?php cb_breadcrumbs(); ?>
				<?php if ( ( $cb_featured_image_style != 'full-background' ) && ( $cb_featured_image_style != 'parallax' ) && ( $cb_featured_image_style != 'background-slideshow' ) &&  ( $cb_page_title != 'off' ) ) {  ?>
			        <div class="cb-module-header cb-category-header">
			           <h1 class="cb-module-title"><?php the_title(); ?></h1>
				    </div>
			    <?php } ?>


				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

					<?php if ( ( ( $cb_featured_image_style == 'off' ) || ( $cb_featured_image_style == 'standard' ) ) && ( cb_is_woocommerce() == NULL ) ) { cb_featured_image_style( $cb_featured_image_style, $post, 'page' ); }; ?>

					<section class="cb-entry-content clearfix" itemprop="articleBody">
						<?php the_content(); ?>
			     	</section> <!-- end article section -->

					<footer class="article-footer">

                        <?php                                            

							wp_link_pages('before=<div class="cb-post-pagination clearfix">&after=</div>&next_or_number=number&pagelink=<span class="wp-link-pages-number">%</span>');
							the_tags('<p class="cb-tags"><span class="tags-title">' . __('Tags:', 'cubell') . '</span> ', '', '</p>');
							if ( $cb_page_comments == 'on' ) { comments_template(); } 

                        ?>

					</footer> <!-- end article footer -->

					<?php   ?>

				</article> <!-- end article -->

				<?php endwhile; endif; ?>

			</div> <!-- end #main -->

			<?php if ( ( $cb_sidebar != 'nosidebar' ) && ( $cb_sidebar != 'nosidebar-fw' ) ) { get_sidebar(); } ?>

		</div> <!-- end #cb-content -->

<?php get_footer(); ?>
<?php

get_header();
$cb_post_id = $post->ID;
$cb_featured_image_style_override_onoff = ot_get_option('cb_post_style_override_onoff', 'off');
$cb_featured_image_style_override_style = ot_get_option('cb_post_style_override', 'standard');
$cb_post_format = get_post_format();
$cb_video_post_select = get_post_meta( $cb_post_id, 'cb_video_post_select', true );
$cb_audio_post_select = get_post_meta( $cb_post_id, 'cb_audio_post_style', true );
$cb_featured_image_style = get_post_meta( $cb_post_id, 'cb_featured_image_style', true );
$cb_featured_image_style_override_post_onoff = get_post_meta( $cb_post_id, 'cb_featured_image_style_override', true );
$cb_sidebar_position = cb_get_sidebar_setting();
$cb_featured_image_style_cache = NULL;
$cb_parallax = false;
$cb_review_checkbox = get_post_meta( $cb_post_id, 'cb_review_checkbox', true );

if ( ( $cb_featured_image_style_override_onoff == 'on' ) && ( $cb_featured_image_style_override_post_onoff != 'on') ) {
   $cb_featured_image_style = $cb_featured_image_style_override_style;
}

if ( $cb_featured_image_style == NULL ) {
     $cb_featured_image_style = 'standard';
}
if ( $cb_featured_image_style == 'standard-uncrop' ) {
	$cb_featured_image_style = 'standard';
}

if ( $cb_featured_image_style == 'parallax' ) {
	$cb_parallax = true;
}

if ( ( $cb_post_format == 'video') || ( $cb_post_format == 'audio') ) {
	$cb_featured_image_style_cache = $cb_featured_image_style;
	$cb_featured_image_style = $cb_post_format;

	if ( ( ( $cb_post_format == 'video') && ( $cb_video_post_select == 1 ) ) || ( ( $cb_post_format == 'audio') && ( $cb_audio_post_select == 1 ) ) ) {
		$cb_parallax = false;
	}
}
if ( $cb_post_format == 'gallery' ) {
	$cb_gallery_post_images = get_post_meta( $cb_post_id, 'cb_gallery_post_images', true );
        
    if ( $cb_gallery_post_images != NULL ) {

		$cb_featured_image_style = $cb_post_format;
	}
}
if ( ( $cb_featured_image_style != 'off' ) && ( $cb_featured_image_style_cache != 'off' ) && ( $cb_featured_image_style != 'standard' ) && ( $cb_featured_image_style_cache != 'standard' )  ) { do_shortcode ( cb_featured_image_style( $cb_featured_image_style, $post ) ); } 

?>

<div id="cb-content" class="<?php if ( $cb_parallax == false ) { echo 'wrap '; } ?>clearfix">

	<?php if ( ( $cb_parallax == true ) && ( $cb_sidebar_position != 'nosidebar' ) && ( $cb_sidebar_position != 'nosidebar-fw' )  ) { echo '<div class="wrap clearfix cb-par-sidebar cb-site-padding">'; } ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<div id="main" class="cb-main" role="main">

			<?php cb_breadcrumbs(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

				<?php if ( ( $cb_featured_image_style == 'off' ) || ( $cb_featured_image_style == 'standard' ) || ( $cb_featured_image_style_cache == 'standard' ) || ( $cb_featured_image_style_cache == 'off' )  ) { cb_featured_image_style( $cb_featured_image_style, $post ); }; ?>

				<section class="cb-entry-content clearfix" <?php if ( ( $cb_review_checkbox == 'on' ) || ( $cb_review_checkbox == '1' )) { echo 'itemprop="reviewBody"'; } ?>>

					<?php the_content(); ?>
					<?php wp_link_pages('before=<div class="cb-pagination clearfix">&after=</div>&next_or_number=number&pagelink=<span class="cb-page">%</span>'); ?>

				</section> <!-- end article section -->

				<footer class="cb-article-footer">
					<?php
						if ( ot_get_option('cb_tags_onoff', 'on') != 'off' ) { the_tags('<p class="cb-tags cb-post-footer-block"> ', '', '</p>'); }
						echo cb_sharing_block( $post ); 
						echo cb_post_footer_ad();
						if ( $post->post_type != 'attachment' ) { cb_previous_next_links(); }
						echo cb_about_author( $post );
						cb_related_posts(); 
						comments_template(); 
                     ?>
				</footer> <!-- end article footer -->

			</article> <!-- end article -->

		</div> <!-- end #main -->

	<?php endwhile; ?>

	<?php endif; ?>

	<?php 
		if ( ( $cb_sidebar_position != 'nosidebar' )  && ( $cb_sidebar_position != 'nosidebar-fw' ) ) { 
			get_sidebar(); 
			if ( $cb_parallax == true ) { echo '</div>'; }
		} 
	?>


</div> <!-- end #cb-content -->

<?php get_footer(); ?>
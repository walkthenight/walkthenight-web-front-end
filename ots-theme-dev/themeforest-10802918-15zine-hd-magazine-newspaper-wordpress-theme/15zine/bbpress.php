<?php
    get_header();
    $cb_bbpress_sidebar = ot_get_option('cb_bbpress_sidebar', 'sidebar');
    $cb_forum_id =  bbp_get_forum_id();

?>
    <div id="cb-content" class="wrap clearfix">

	<div id="main" class="cb-main" role="main">

        <div class="cb-module-header cb-category-header">
           <h1 class="cb-module-title"><?php the_title(); ?></h1>
           <p><?php if ( ( $cb_forum_id != 0 ) &&  ( bbp_is_single_topic() == false ) && ( bbp_is_single_reply() == false )  ) { bbp_forum_content(); } ?></p>
        </div>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

			<section class="entry-content clearfix" itemprop="articleBody">
				<?php the_content(); ?>
	     	</section> <!-- end article section -->

		</article> <!-- end article -->

		<?php endwhile; endif; ?>

	</div> <!-- end #main -->

    <?php if ( ( $cb_bbpress_sidebar != 'nosidebar' ) ) {  get_sidebar(); } ?>

	</div> <!-- end #cb-content -->

<?php get_footer(); ?>
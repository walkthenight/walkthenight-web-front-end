<?php /* Template Name: 15Zine Meet The Team */

        get_header(); 
        $cb_page_id = get_the_ID();
        $cb_page_base_color = get_post_meta($cb_page_id , 'cb_overall_color_post', true );
        if ( ( $cb_page_base_color == '#' ) || ( $cb_page_base_color == NULL ) ) {
            $cb_page_base_color = ot_get_option('cb_base_color', '#eb9812'); 
        }  
?>
        
	<div id="cb-content" class="wrap clearfix">
	  
	    <div id="main" class="cb-main cb-module-block cb-about-page clearfix" role="main">
	      	<?php cb_breadcrumbs(); ?> 
	        <div class="cb-module-header cb-category-header">
	               <h1 class="cb-module-title"><?php the_title(); ?></h1>
	        </div>
<?php 				
			while ( have_posts() ) : the_post(); the_content(); endwhile; 
			echo cb_author_list(); 
?>
	    </div> <!-- end #main -->

	    <?php get_sidebar(); ?>
	    
	</div> <!-- end #cb-inner-content -->
            
<?php get_footer(); ?>
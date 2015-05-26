<?php 
    get_header(); 
?>  
    
	<div id="cb-content" class="wrap cb-404-page clearfix">
	    
         <div id="main" class="cb-main cb-full-width clearfix" role="main">

         	<div class="cb-404-header">
		        <h1 class="cb-module-title"><?php _e( 'Page not found... Oops!', 'cubell' ) ?></h1>
		        <p><?php _e( 'Page not found. Please try using the search box below.', 'cubell' ) ?></p>              
		    </div>
	
			<article id="post-not-found" class="clearfix">

				<section class="widget_search cb-search">
	
				    <p><?php get_search_form(); ?></p>
	
				</section> <!-- end search section -->
					
			</article> <!-- end article -->
	
		</div> <!-- end #main -->
		
	</div> <!-- end #cb-content -->
    
<?php get_footer(); ?>

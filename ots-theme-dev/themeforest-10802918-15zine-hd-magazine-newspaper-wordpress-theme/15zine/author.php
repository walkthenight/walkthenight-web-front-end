<?php
		get_header();
        if ( $post == NULL ) {
            $cb_author_id = $author;
        } else {
            $cb_author = get_user_by( 'slug', get_query_var( 'author_name' ) );
            $cb_author_id = $cb_author->ID;
        }
        $cb_blog_style = cb_get_blog_style();
?>

<div id="cb-content" class="wrap cb-author-page clearfix">

    <div id="main" class="cb-main clearfix cb-module-block" role="main">
        
    <div class="cb-module-header cb-category-header">
       <h1 class="cb-module-title"><?php echo get_the_author_meta( 'display_name', $cb_author_id ); ?></h1>
    </div>

        <?php include( locate_template( 'blog-style-' . $cb_blog_style . '.php') ); ?>

	</div> <!-- end #main -->

    <?php  

        if ( ot_get_option('cb_sticky_sb', 'on') == 'on' ) {
            echo '<div class="cb-sticky-sidebar">';
        }
        echo cb_author_details( $cb_author_id );  

        if ( ot_get_option('cb_sticky_sb', 'on') == 'on' ) { echo '</div>'; }
    ?>

</div> <!-- end #cb-content -->

<?php get_footer(); ?>
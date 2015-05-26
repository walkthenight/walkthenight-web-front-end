<?php /* Module: C */

$cb_cpt_output = cb_get_custom_post_types();
$i = 0 ;
$cb_wrap = 'cb-module-c cb-module-block';
$cb_qry = $cb_title_header = NULL;
$cb_qry = new WP_Query( array( 'posts_per_page' => $cb_amount, 'cat' => $cb_cat_id, 'tag__in' => $cb_tag_id, 'post__in' => $cb_post_ids, 'no_found_rows' => true, 'post_type' => $cb_cpt_output, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'offset' => $cb_offset, 'order' => $cb_order, 'orderby' => $cb_orderby ) );

if ( $cb_qry->have_posts() ) {

    while ( $cb_qry->have_posts() ) : $cb_qry->the_post();
        
        $cb_post_id = $post->ID;
        if  ( $cb_title != NULL ) { $cb_title_header = '<div class="cb-module-header"><h2 class="cb-module-title" >' . $cb_title . '</h2>' . $cb_subtitle . '</div>'; }

        $i++;
        if ( $i == 1 ) {
            echo '<div class="' . $cb_wrap . ' clearfix">' . $cb_title_header;
?>
            <article <?php post_class('cb-article cb-article-row cb-img-above-meta cb-no-1 cb-big clearfix'); ?> role="article">

                <div class="cb-mask cb-img-fw" <?php cb_img_bg_color( $cb_post_id ); ?>>
                    <?php cb_thumbnail( '360', '240' ); ?>
                    <?php cb_review_ext_box( $cb_post_id ); ?>
                </div>

                <div class="cb-meta clearfix">

                    <h2 class="cb-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                    <?php cb_byline( $cb_post_id ); ?>

                    <div class="cb-excerpt"><?php echo cb_clean_excerpt( 140 ); ?></div>
                    
                    <?php cb_post_meta( $cb_post_id ); ?>

                </div>

            </article>

            <div class="cb-article-row cb-no-2 ">

       <?php } else { ?>

           <article class="cb-article-small cb-separated clearfix" role="article">

                <div class="cb-mask cb-img-fw" <?php cb_img_bg_color( $cb_post_id ); ?>>
                    <?php cb_thumbnail( '100', '65' ); ?>
                    <?php cb_review_ext_box( $cb_post_id, true ); ?>
                </div>

                <div class="cb-meta">

                    <h2 class="cb-post-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                    <?php echo cb_get_byline_date( $cb_post_id ); ?>
                </div>

            </article>

<?php 	}

    endwhile;

    echo '</div></div>';

} // endif

wp_reset_postdata();
?>
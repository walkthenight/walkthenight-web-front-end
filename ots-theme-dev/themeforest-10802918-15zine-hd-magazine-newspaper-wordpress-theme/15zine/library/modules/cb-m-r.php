<?php /* Module: Reviews Half-Width */

$cb_cpt_output = cb_get_custom_post_types();
$i = 0 ;
$cb_qry = $cb_title_header = NULL;
$cb_qry = new WP_Query( array( 'posts_per_page' => $cb_amount, 'cat' => $cb_cat_id, 'tag__in' => $cb_tag_id, 'post__in' => $cb_post_ids, 'no_found_rows' => true, 'post_type' => $cb_cpt_output, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'offset' => $cb_offset, 'order' => $cb_order, 'orderby' => $cb_orderby, 'meta_key' => 'cb_final_score' ) );

if ( $cb_qry->have_posts() ) {

    while ($cb_qry->have_posts()) : $cb_qry->the_post();
        $cb_post_id = $post->ID;

        if ($cb_title != NULL) {
            $cb_title_header = '<div class="cb-module-header"><h2 class="cb-module-title" >' . $cb_title . '</h2>' . $cb_subtitle . '</div>';
        }

        $i++;
        if ( $i == 1 ) {
            echo '<div class="cb-module-r cb-module-block cb-module-half clearfix">' . $cb_title_header;
        }

?>
            <article class="cb-article-small cb-article-small-review cb-separated clearfix" role="article">

                <div class="cb-meta">

                    <h2 class="cb-post-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                    <?php cb_review_byline( $cb_post_id ); ?>  

                </div>

            </article>

            <?php 

        endwhile;

        echo '</div>';

}

wp_reset_postdata();
?>
 <?php /* Module: A */

 $cb_cpt_output = cb_get_custom_post_types();

 if ( ( $cb_section == 'c' ) || ( $cb_section == 'a' ) ) {
    $cb_wrap = 'cb-module-a cb-module-block cb-module-fw';
    $cb_column_size = 'cb-article-row-3';
} else {
    $cb_wrap = 'cb-module-a cb-module-block ';
    $cb_column_size = 'cb-article-row-2';
}

$cb_qry = $cb_title_header = NULL;
$cb_qry_args = array( 'posts_per_page' => $cb_amount, 'cat' => $cb_cat_id, 'tag__in' => $cb_tag_id, 'post__in' => $cb_post_ids, 'no_found_rows' => true, 'post_type' => $cb_cpt_output, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'offset' => $cb_offset, 'order' => $cb_order, 'orderby' => $cb_orderby );
$cb_qry = new WP_Query( $cb_qry_args );
$j++;
$cb_count = 1;
$i = 1;


if ( $cb_qry->have_posts() ) {

    while ( $cb_qry->have_posts() ) {
        $cb_sep = NULL;
        if ( $cb_amount > 3 ) {


             if ( ( $cb_section == 'c' ) || ( $cb_section == 'a' ) ) {
                if ( ( $cb_amount - $i ) > 2 ) {
                    $cb_sep = ' cb-separated';
                }
                
            } else {
                if ( ( $cb_amount - $i ) > 1 ) {
                    $cb_sep = ' cb-separated';
                }
            }
            
        }

        $cb_qry->the_post();
        $cb_post_id = $post->ID;

        if  ( $cb_title != NULL ) { $cb_title_header = '<div class="cb-module-header"><h2 class="cb-module-title" >' . $cb_title . '</h2>' . $cb_subtitle . '</div>'; }

        if ( $cb_count == 1 ) {  echo '<div class="' . $cb_wrap . ' clearfix">' . $cb_title_header;  }
        if ( ( $cb_section == 'c' ) || ( $cb_section == 'a' ) ) {
            if ( $cb_count == 4 ) { $cb_count = 1; }
        } else {
            if ( $cb_count == 3 ) { $cb_count = 1; }
        }

?>
        <article <?php post_class('cb-article cb-img-above-meta cb-article-row cb-no-' . $cb_count . ' ' . $cb_column_size . $cb_sep . ' clearfix'); ?> role="article">

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
<?php
        $cb_count++;
        $i++;
    }

    echo '</div>';

}
wp_reset_postdata();
?>
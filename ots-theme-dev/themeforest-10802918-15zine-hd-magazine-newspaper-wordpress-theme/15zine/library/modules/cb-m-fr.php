<?php /* Module: Reviews Full-width */

if ( ( $cb_section == 'c' ) || ( $cb_section == 'a' ) ) {
    $cb_wrap = 'cb-module-fr cb-all-big cb-module-block cb-module-fw';
} else {
    $cb_wrap = 'cb-module-fr cb-module-block ';
}

$cb_cpt_output = cb_get_custom_post_types();
$i = 1;
$j = 1;
$cb_qry = $cb_title_header = NULL;

$cb_qry = new WP_Query( array( 'posts_per_page' => $cb_amount, 'cat' => $cb_cat_id, 'tag__in' => $cb_tag_id, 'post__in' => $cb_post_ids, 'no_found_rows' => true, 'post_type' => $cb_cpt_output, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'offset' => $cb_offset, 'order' => $cb_order, 'orderby' => $cb_orderby, 'meta_key' => 'cb_final_score' ) );

if ( $cb_qry->have_posts() ) {

    while ($cb_qry->have_posts()) : $cb_qry->the_post();
        
        $cb_post_id = $post->ID;

        if ( $cb_title != NULL ) {
            $cb_title_header = '<div class="cb-module-header"><h2 class="cb-module-title" >' . $cb_title . '</h2>' . $cb_subtitle . '</div>';
        }
        $cb_width = 100;
        $cb_height = 65;
        $cb_style = 'cb-article-small cb-separated clearfix';
        $cb_small_box = true;
       
        if ( $i == 1 ) {
            echo '<div class="' . $cb_wrap . ' clearfix">' . $cb_title_header;
            $cb_width = 360;
            $cb_height = 490;
            $cb_style = 'cb-article-big cb-meta-style-2 cb-article-review cb-article cb-article-row cb-no-1 clearfix cb-article-row-2';
            $cb_small_box =  false;
        }

        if ( ( $cb_section == 'c' ) || ( $cb_section == 'a' ) ) {
            $cb_width = 360;
            $cb_height = 490;
            $cb_style = 'cb-article-big cb-article-review cb-article cb-meta-style-2 cb-article-row cb-no-' . $j . ' clearfix cb-article-row-3';
            $cb_small_box = false;
        }
?>
            <article class="<?php echo esc_attr($cb_style); ?>" role="article">

                <?php if ( ( $cb_section == 'c' ) || ( $cb_section == 'a' ) || ( $i == 1 ) ) { ?>
                    <div class="cb-mask cb-img-fw">
                        <?php cb_thumbnail( $cb_width, $cb_height, $cb_post_id ); ?> 
                        <?php echo cb_get_review_ext_box( $cb_post_id, $cb_small_box ); ?>
                    </div>
                <?php } ?>

                 <div class="cb-meta cb-article-meta">

                    <h2 class="cb-post-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                    <?php if ( ( $cb_section == 'c' ) || ( $cb_section == 'a' ) || ( $i == 1 ) ) {
                        echo cb_get_byline_date( $cb_post_id );
                    } else {
                        echo cb_get_review_byline( $cb_post_id );
                    } ?>

                </div>

            </article>

            <?php 
            if ( ( $i == 1 ) && ( $cb_section != 'c' ) && ( $cb_section != 'a' ) ) { echo '<div class="cb-article-row cb-no-2 ">'; }
            $i++;
            $j++;
            if ( $j == 4 ) {
                $j = 1;
            }
        endwhile;

        if ( ( $cb_section != 'c' ) && ( $cb_section != 'a' ) ) { echo '</div>'; }
        echo '</div>';

}

wp_reset_postdata();
?>
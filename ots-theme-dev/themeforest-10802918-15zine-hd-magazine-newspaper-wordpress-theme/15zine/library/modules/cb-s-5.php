 <?php /* Slider of Grid of 3 */

$i = 1;
$cb_cpt_output = cb_get_custom_post_types();
$cb_title_header = $cb_no_sidebar = $cb_slider_class = NULL;
$cb_flag = false;
if ( ! isset( $cb_amount ) ) {
    $cb_amount = 9;
} 

if ( $cb_amount > 3 ) {
    $cb_slider_class = ' cb-slider-grid-3';
} 


if ( is_home() == true ) {
    $cb_no_sidebar = ' cb-block-no-sb';
    $cb_qry = new WP_Query( array( 'posts_per_page' => $cb_amount, 'cat' => $cb_cat_id, 'no_found_rows' => true, 'post_type' => $cb_cpt_output, 'post_status' => 'publish', 'ignore_sticky_posts' => true )  );
    
} elseif ( is_category() ) {
    $cb_no_sidebar = ' cb-block-no-sb';
    $cb_title = NULL;
    $current_cat_id = get_query_var('cat');
    $cb_qry = new WP_Query(array( 'posts_per_page' => $cb_amount, 'no_found_rows' => true, 'post_type' => $cb_cpt_output, 'cat' => $current_cat_id, 'post_status' => 'publish', 'ignore_sticky_posts' => true )  );

} else {

    $cb_qry = new WP_Query( array( 'posts_per_page' => $cb_amount, 'cat' => $cb_cat_id, 'tag__in' => $cb_tag_id, 'post__in' => $cb_post_ids, 'no_found_rows' => true, 'post_type' => $cb_cpt_output, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'offset' => $cb_offset, 'order' => $cb_order, 'orderby' => $cb_orderby ) );
}

if ( $cb_qry->have_posts() ) : while ( $cb_qry->have_posts() ) : $cb_qry->the_post();

    $cb_post_id = $post->ID;
    $cb_category_color = cb_get_cat_color( $cb_post_id );

    if ( $cb_title != NULL ) {
        $cb_title_header = '<div class="cb-module-header"><h2 class="cb-module-title" >' . $cb_title . '</h2>' . $cb_subtitle . '</div>';
    }
    $cb_feature_width = '378';
    $cb_feature_height = '300';
    $cb_feature_tile_size = 'cb-s';

    if ( $i == 1 )  {
        $cb_feature_width = '759';
        $cb_feature_height = '600';
        $cb_feature_tile_size = 'cb-l';
        
    }
    if ( ( $i  == 1 ) && ( $cb_flag == false ) ) { 

        echo '<div class="cb-grid-block cb-module-block cb-' . $cb_module_type . $cb_no_sidebar . ' clearfix"' . $cb_slider_ltr_rtl . '>' . $cb_title_header . '<div class="cb-grid-x cb-grid-3 cb-arrows-tr  cb-relative clearfix' . $cb_slider_class . '"><ul class="slides cb-full-height clearfix cb-no-margin">';
    }

    if ( $i == 1 ) {
        echo '<li class="cb-full-height clearfix cb-no-margin"><ul class="cb-full-height clearfix cb-no-margin">';
    }
?>
    <li class="cb-grid-feature cb-feature-<?php echo esc_attr( $i ) . ' ' . esc_attr( $cb_feature_tile_size ); ?> cb-meta-style-4">

        <div class="cb-grid-img">
            <?php cb_thumbnail( $cb_feature_width, $cb_feature_height ); ?>
        </div>

        <div class="cb-article-meta">
            <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
            <?php cb_byline( $cb_post_id ); ?>
       </div>

       <a href="<?php the_permalink() ?>" class="cb-link"></a>

    </li>

<?php

    $i++;
    $cb_flag = true;
    if ( $i == 4 ) { echo '</ul>'; $i = 1; }
    endwhile;
    endif;
    echo '</ul></div></div>';
    wp_reset_postdata();  // Restore global post data

?>
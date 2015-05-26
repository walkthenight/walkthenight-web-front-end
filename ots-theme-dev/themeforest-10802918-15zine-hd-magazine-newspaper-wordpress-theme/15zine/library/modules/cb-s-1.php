 <?php /* Slider of 1 */

    $cb_cpt_output = cb_get_custom_post_types();

    if ( ! isset( $cb_ppp ) ) {
        if ( isset($cb_amount) ) {
            $cb_ppp = $cb_amount;
        } else {
            $cb_ppp = 4;
        }
    }
    
    $cb_no_sidebar = NULL;
    if ( is_home() == true ) {
        $cb_title = NULL;
        
        if ( ( $cb_section == 'c' ) || ( $cb_section == 'a' ) ) {
            $cb_no_sidebar = ' cb-block-no-sb';
        }
        $cb_qry = new WP_Query(array( 'posts_per_page' => $cb_ppp, 'cat' => $cb_cat_id, 'no_found_rows' => true, 'post_type' => $cb_cpt_output, 'post_status' => 'publish', 'ignore_sticky_posts' => true )  );

    } elseif ( is_category() ) {

        $cb_title = NULL;
        if ( ( $cb_section == 'c' ) || ( $cb_section == 'a' ) ) {
            $cb_no_sidebar = ' cb-block-no-sb';
        }
        $current_cat_id = get_query_var('cat');
        $cb_qry = new WP_Query(array( 'posts_per_page' => $cb_ppp, 'no_found_rows' => true, 'post_type' => $cb_cpt_output, 'cat' => $current_cat_id, 'post_status' => 'publish', 'ignore_sticky_posts' => true )  );

    } elseif ( is_tag() == true ) {

        $cb_title = NULL;
        if ( ( $cb_section == 'c' ) || ( $cb_section == 'a' ) ) {
            $cb_no_sidebar = ' cb-block-no-sb';
        }
        $cb_qry = new WP_Query(array( 'posts_per_page' => $cb_ppp, 'no_found_rows' => true, 'post_type' => $cb_cpt_output, 'tag_id' => $cb_tag_id, 'post_status' => 'publish', 'ignore_sticky_posts' => true )  );

    } else {
        $cb_no_sidebar = NULL;
        $cb_qry = new WP_Query( array( 'posts_per_page' => $cb_ppp, 'cat' => $cb_cat_id, 'tag__in' => $cb_tag_id, 'post__in' => $cb_post_ids, 'no_found_rows' => true, 'post_type' => $cb_cpt_output, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'offset' => $cb_offset, 'order' => $cb_order, 'orderby' => $cb_orderby ) );
    }

    $cb_img_width = '759';
    $cb_img_height = '500';

    $cb_module_block_type = 'cb-slider cb-module-block';
    $cb_slider_type = 'cb-slider-1';

    if ( ( $cb_section == 'c' ) || ( $cb_section == 'a' ) || ( $cb_section == 'f' ) ) {
        $cb_mobile = new Mobile_Detect;
        if ( $cb_mobile->isMobile() && !$cb_mobile->isTablet() ) {
            $cb_mobile_check = true;
        }

        if ( isset( $cb_mobile_check ) ) {
            $cb_img_width = '759';
            $cb_img_height = '300';
        } else {
            $cb_img_width = '1400';
            $cb_img_height = '600';
        }

        $cb_module_block_type .= ' cb-module-fw';
        $cb_slider_type .= ' cb-slider-1-fw';
    }

    $cb_title_header = NULL;
    $cb_count = 1;
    $j++;
    $cb_arrows = 'cb-arrows-tr';

    if ( $cb_qry->have_posts() ) {

         while ($cb_qry->have_posts()) : $cb_qry->the_post();

         $cb_post_id = $post->ID;
         $cb_category_color = cb_get_cat_color($cb_post_id);

         if ( $cb_section == 'f' ) {
            $cb_subtitle = NULL;
            $cb_arrows = 'cb-arrows-sides';
         }

         if ( $cb_title != NULL ) {
             $cb_title_header = '<div class="cb-module-header"><h2 class="cb-module-title" >' . $cb_title . '</h2>' . $cb_subtitle . '</div>';
          }

         if ( $cb_count == 1 ) { echo '<div class="' . $cb_module_block_type . $cb_no_sidebar . ' clearfix"' . $cb_slider_ltr_rtl . '>' . $cb_title_header . '<div class="' . $cb_slider_type . ' cb-relative ' . $cb_arrows . ' clearfix"><ul class="slides">'; }
?>
        <li class="cb-meta-style-2">
            <div class="cb-grid-img">
                <?php cb_thumbnail( $cb_img_width, $cb_img_height ); ?>
            </div>

            <div class="cb-article-meta">
                <h2 ><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                <?php cb_byline( $cb_post_id ); ?>
           </div>

           <a href="<?php the_permalink() ?>" class="cb-link"></a>
        </li>

<?php
        $cb_count++;
        endwhile;
        echo '</ul></div></div>';
    }

    wp_reset_postdata();
?>
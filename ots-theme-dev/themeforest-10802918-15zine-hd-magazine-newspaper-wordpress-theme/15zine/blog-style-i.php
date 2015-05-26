<?php /* Blog Style I (Grid Full-Width) */

$cb_qry = cb_get_qry();
$i = 1;        

if ( $cb_qry->have_posts() ) : 
    echo '<div class="cb-grid-x cb-grid-4 clearfix">';

    while ( $cb_qry->have_posts() ) : $cb_qry->the_post();

    $cb_post_id = $post->ID;
    $cb_feature_width = '378';
    $cb_feature_height = '300';
    $cb_feature_tile_size = 'cb-s';

    if ( ( $i == 1 ) || ( $i == 4 ) )  {

        $cb_feature_width = '759';
        $cb_feature_height = '300';
        $cb_feature_tile_size = 'cb-m';
    }
?>
    <div class="cb-grid-feature cb-meta-style-2 cb-feature-<?php echo esc_attr( $i ) . ' ' . esc_attr( $cb_feature_tile_size ) ; ?>">

        <div class="cb-grid-img">
            <?php cb_thumbnail( $cb_feature_width, $cb_feature_height ); ?>
        </div>

        <div class="cb-article-meta">
            <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
            <?php cb_byline( $cb_post_id ); ?>
       </div>

       <a href="<?php the_permalink() ?>" class="cb-link"></a>

    </div>

<?php
    $i++;
    if ( $i == 5 ) { $i = 1; }
    endwhile;
    echo '</div>';
    cb_page_navi( $cb_qry );
    endif;
    
    wp_reset_postdata();  // Restore global post data
?>
<?php /* Blog Style D */

$cb_qry = cb_get_qry();

if ( $cb_qry->have_posts() ) : while ( $cb_qry->have_posts() ) : $cb_qry->the_post();

  $cb_post_id = $post->ID;

  $cb_category_color = cb_get_cat_color( $cb_post_id );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('cb-blog-style-d cb-module-d cb-separated cb-img-above-meta clearfix'); ?> role="article">

    <div class="cb-mask cb-img-fw" <?php cb_img_bg_color( $cb_post_id ); ?>>
        <?php cb_thumbnail( '759', '500' ); ?>
        <?php cb_review_ext_box( $cb_post_id ); ?>
    </div>

    <div class="cb-meta clearfix">

        <h2 class="cb-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

        <?php cb_byline( $cb_post_id ); ?>

        <div class="cb-excerpt"><?php echo cb_clean_excerpt( 250 ); ?></div>

        <?php cb_post_meta( $cb_post_id ); ?>

    </div>

</article>

<?php

  endwhile;
  cb_page_navi( $cb_qry );
  endif;
  wp_reset_postdata();

?>
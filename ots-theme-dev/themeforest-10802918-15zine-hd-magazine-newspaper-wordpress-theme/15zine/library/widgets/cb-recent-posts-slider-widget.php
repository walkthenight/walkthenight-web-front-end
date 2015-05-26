<?php
/**
 * 15Zine Recent Posts Slider
 */

if ( ! class_exists( 'CB_widget_recent_posts_slider' ) ) {
    class CB_widget_recent_posts_slider extends WP_Widget {

    	function __construct() {
    		$widget_ops = array('classname' => 'widget-latest-articles-slider', 'description' =>  "Shows the latest posts with a Slider" );
    		parent::__construct('cb-recent-posts-slider', '15Zine Latest Slider', $widget_ops);
    		$this->alt_option_name = 'widget_recent_posts_slider';

    		add_action( 'save_post', array($this, 'flush_widget_cache') );
    		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
    		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    	}

    	function widget($args, $instance) {
    		$cache = wp_cache_get('widget_recent_posts_slider', 'widget');

    		if ( !is_array($cache) )
    			$cache = array();

    		if ( ! isset( $args['widget_id'] ) )
    			$args['widget_id'] = $this->id;

    		if ( isset( $cache[ $args['widget_id'] ] ) ) {
    			echo $cache[ $args['widget_id'] ];
    			return;
    		}

    		ob_start();
    		extract($args);

    		$cb_title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
    		$cb_category = apply_filters('widget_category', empty($instance['category']) ? '' : $instance['category'], $instance, $this->id_base);

    		if ( empty( $instance['number'] ) || ! $cb_number = absint( $instance['number'] ) ) {
                $cb_number = 6;
            }

            if ( $cb_category != 'cb-all' ) {
                $cb_cat_qry = $cb_category;
            } else {
                $cb_cat_qry = NULL;
            }

            $cb_cpt_output = cb_get_custom_post_types();

    		$cb_qry = new WP_Query( array( 'post_type' => $cb_cpt_output, 'posts_per_page' => $cb_number, 'no_found_rows' => true, 'category_name' => $cb_cat_qry, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) );
    		if ($cb_qry->have_posts()) :

            echo $before_widget;

    		if ( $cb_title ) {
                echo $before_title . esc_html( $cb_title ) . $after_title;
            }

?>

    		<div class="cb-slider cb-slider-1 cb-recent-slider cb-relative cb-arrows-tr clearfix">
        		<ul class="slides">

        		<?php  while ( $cb_qry->have_posts() ) : $cb_qry->the_post();
                        global $post;
                        $cb_cat_id = get_the_category();
                        $cb_current_cat_id = $cb_cat_id[0]->term_id;

                        $cb_post_id = $post->ID;
        		 ?>
                    <li <?php post_class( 'cb-article cb-style-1 clearfix' ); ?>>

                        <div class="cb-mask"><?php cb_thumbnail( '360', '240', $cb_post_id ); ?></div>

                        <div class="cb-meta">
                            <h4 class="cb-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            <?php echo cb_get_byline_date( $cb_post_id ); ?>
                        </div>

                    </li>
        		<?php endwhile; ?>
        		</ul>
    		</div>

    		<?php

            echo $after_widget;
    		wp_reset_postdata();

    		endif;

    		$cache[$args['widget_id']] = ob_get_flush();
    		wp_cache_set('widget_recent_posts_slider', $cache, 'widget');
    	}

    	function update( $new_instance, $old_instance ) {
    		$instance = $old_instance;
    		$instance['category'] =  strip_tags($new_instance['category']);
    		$instance['title'] = strip_tags($new_instance['title']);
    		$instance['number'] = (int) $new_instance['number'];
    		$this->flush_widget_cache();

    		$alloptions = wp_cache_get( 'alloptions', 'options' );
    		if ( isset($alloptions['widget_recent_posts_slider']) )
    			delete_option('widget_recent_posts_slider');

    		return $instance;
    	}

    	function flush_widget_cache() {
    		wp_cache_delete('widget_recent_posts_slider', 'widget');
    	}

    	function form( $instance ) {
    		$cb_title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
    		$cb_number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
    		$cb_category    = isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
            $cb_cats = get_categories();
    ?>
    		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'cubell' ); ?></label>
    		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $cb_title); ?>" /></p>

    		<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of posts to show:', 'cubell' ); ?></label>
    		<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr($cb_number); ?>" size="3" /></p>

         	<p><label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">Category</label>

    		 <select id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">


                <option value="cb-all" <?php if ($cb_category == 'all') echo 'selected="selected"'; ?>>All Categories</option>

                <?php foreach ($cb_cats as $cat) {
                    if ($cb_category == $cat->slug) { $selected = 'selected="selected"'; } else { $selected = NULL;}
                    echo '<option value="' . esc_attr( $cat->slug ) . '" ' . $selected . '>' . $cat->name . ' (' . $cat->count . ')</option>';

                } ?>

             </select></p>
<?php
    	}
    }
}

if ( ! function_exists( 'cb_recent_posts_slider_loader' ) ) {
    function cb_recent_posts_slider_loader () {
     register_widget( 'CB_widget_recent_posts_slider' );
    }
    add_action( 'widgets_init', 'cb_recent_posts_slider_loader' );
}
?>
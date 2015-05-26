<?php
/**
 * 15Zine Recent Posts
 */
if ( ! class_exists( 'CB_WP_Widget_Recent_Posts' ) ) {
    class CB_WP_Widget_Recent_Posts extends WP_Widget {

    	function __construct() {
    		$widget_ops = array('classname' => 'cb-widget-latest-articles', 'description' => "Shows the latest posts (Big/Small Styles)" );
    		parent::__construct('cb-recent-posts', '15Zine Latest Posts', $widget_ops);
    		$this->alt_option_name = 'widget_recent_posts';

    		add_action( 'save_post', array($this, 'flush_widget_cache') );
    		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
    		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    	}

    	function widget($args, $instance) {
    		$cache = wp_cache_get('widget_recent_posts', 'widget');

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

    		$cb_title = empty($instance['title']) ? '' : $instance['title'];
    		$cb_category = empty($instance['category']) ? '' : $instance['category'];
    		$cb_type = empty($instance['type']) ? 'cb-small' : $instance['type'];
    		if ( empty( $instance['number'] ) || ! $cb_number = absint( $instance['number'] ) )$cb_number = 5;
            if ($cb_category != 'cb-all') { $cb_cat_qry = $cb_category;} else {$cb_cat_qry = NULL;}

            $cb_cpt_output = cb_get_custom_post_types();

    		$cb_qry = new WP_Query( array( 'post_type' => $cb_cpt_output, 'posts_per_page' => $cb_number, 'no_found_rows' => true, 'category_name' => $cb_cat_qry, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) );
    		if ( $cb_qry->have_posts() ) :

            echo $before_widget;

    		if ( $cb_title ) echo $before_title . esc_html( $cb_title ) . $after_title; ?>

    		<div class="cb-module-block cb-small-margin">
    		<?php while ( $cb_qry->have_posts() ) : $cb_qry->the_post();

    				global $post;
                    $cb_post_id = $post->ID;
                    $cb_width = '100';
                    $cb_height = '65';
                    $cb_style = ' cb-separated';
                    $cb_bg_color = cb_get_img_bg_color( $cb_post_id );

                    if ( $cb_type == 'cb-article-big' ) {
                        $cb_width = '360';
                        $cb_height = '240';
                        $cb_style = ' cb-meta-style-2';
                        $cb_bg_color = NULL;
                    }
                    
    		?>
                <article <?php post_class( 'cb-article ' . esc_attr( $cb_type ) .  ' ' . esc_attr( $cb_style ) . ' clearfix' ); ?>>
                    <div class="cb-mask cb-img-fw" <?php $cb_bg_color ?>>
                        <?php cb_thumbnail( $cb_width, $cb_height ); ?>
                        <?php cb_review_ext_box( $cb_post_id, true ); ?>
                    </div>
                    <div class="cb-meta cb-article-meta">
                        <h4 class="cb-post-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
                        <?php echo cb_get_byline_date( $cb_post_id ); ?>
                    </div>
                    <?php if ( $cb_type == 'cb-article-big' ) { echo '<a href="' . get_the_permalink() . '" class="cb-link"></a>'; } ?>
                </article>
    		<?php endwhile; ?>
    		</div>
    		<?php echo $after_widget; ?>
    <?php
    		wp_reset_postdata();
    		endif;

    		$cache[$args['widget_id']] = ob_get_flush();
    		wp_cache_set('widget_recent_posts', $cache, 'widget');
    	}

    	function update( $new_instance, $old_instance ) {
    		$instance = $old_instance;
    		$instance['type'] =  strip_tags($new_instance['type']);
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['category'] = strip_tags($new_instance['category']);
    		$instance['number'] = (int) $new_instance['number'];
    		$this->flush_widget_cache();

    		$alloptions = wp_cache_get( 'alloptions', 'options' );
    		if ( isset($alloptions['widget_recent_posts']) )
    			delete_option('widget_recent_posts');

    		return $instance;
    	}

    	function flush_widget_cache() {
    		wp_cache_delete('widget_recent_posts', 'widget');
    	}

    	function form( $instance ) {
    		$cb_title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
            $cb_category     = isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
    		$cb_number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
    		$cb_type    = isset( $instance['type'] ) ? esc_attr( $instance['type'] ) : '';
            $cb_cats = get_categories();
    ?>
    		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'cubell' ); ?></label>
    		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $cb_title); ?>" /></p>

    		<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of posts to show:', 'cubell' ); ?></label>
    		<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $cb_number); ?>" size="3" /></p>

         	<p><label for="<?php echo esc_attr( $this->get_field_id( 'category' )); ?>"><?php  echo "Category:"; ?></label>
            <select id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
            <option value="cb-all" <?php if ($cb_category == 'all') echo 'selected="selected"'; ?>>All Categories</option>
            <?php foreach ( $cb_cats as $cat ) {
                    if ( $cb_category == $cat->slug ) { $selected = 'selected="selected"'; } else { $selected = NULL;}
                    echo '<option value="' . $cat->slug . '" ' . $selected . '>' . $cat->name . ' (' . $cat->count . ')</option>';

              } ?>
            </select></p>

         	<p><label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php  echo "Style:"; ?></label>

    		<select id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>">
               <option value="cb-article-small" <?php if ( $cb_type == 'cb-article-small') echo 'selected="selected"'; ?>>Small</option>
               <option value="cb-article-big" <?php if ( $cb_type == 'cb-article-big') echo 'selected="selected"'; ?>>Big</option>

            </select></p>
    <?php
    	}
    }
}

if ( ! function_exists( 'cb_recent_posts_loader' ) ) {
    function cb_recent_posts_loader () {
        register_widget( 'CB_WP_Widget_Recent_Posts' );
    }
    add_action( 'widgets_init', 'cb_recent_posts_loader' );
}
?>
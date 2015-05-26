<?php
/**
 * 15Zine Popular Posts
 */
if ( ! class_exists( 'CB_WP_Widget_Popular_Posts' ) ) {
    class CB_WP_Widget_Popular_Posts extends WP_Widget {

    	function __construct() {
    		$widget_ops = array('classname' => 'cb-widget-popular-posts', 'description' => "Shows the most popular posts (Big/Small Styles)" );
    		parent::__construct('cb-popular-posts', '15Zine Popular Posts', $widget_ops);
    		$this->alt_option_name = 'widget_popular_posts';

    		add_action( 'save_post', array( $this, 'flush_widget_cache') );
    		add_action( 'deleted_post', array( $this, 'flush_widget_cache') );
    		add_action( 'switch_theme', array( $this, 'flush_widget_cache') );
    	}

    	function widget( $args, $instance) {
    		$cache = wp_cache_get('widget_popular_posts', 'widget');

    		if ( !is_array( $cache) )
    			$cache = array();

    		if ( ! isset( $args['widget_id'] ) )
    			$args['widget_id'] = $this->id;

    		if ( isset( $cache[ $args['widget_id'] ] ) ) {
    			echo $cache[ $args['widget_id'] ];
    			return;
    		}

    		ob_start();
    		extract( $args);

    		$cb_title =  empty( $instance['cb_title'] ) ? '' : $instance['cb_title'];
    		$cb_category = empty( $instance['category']) ? '' : $instance['category'];
    		$cb_type = empty( $instance['cb_type']) ? 'cb-article-small' : $instance['cb_type'];
            $cb_filter_date = empty( $instance['cb_filter_date']) ? 'alltime' : $instance['cb_filter_date'];
            $cb_filter_by = empty( $instance['cb_filter_by']) ? 'cb-comments' : $instance['cb_filter_by'];
    		if ( empty( $instance['cb_number'] ) || ! $cb_number = absint( $instance['cb_number'] ) ) $cb_number = 5;
            if ( $cb_category != 'cb-all' ) { $cb_cat_qry = $cb_category; } else { $cb_cat_qry = NULL; }
            $cb_qry = NULL;
            $cb_c = 300;
            $i = 1;

            if ( $cb_filter_by == 'cb-visits' ) {

                if ( function_exists( 'stats_get_csv' ) ) {
                    if ( $cb_filter_date == 'week' ) {

                        $cb_weekly_qry = 'cb-week-pop';
                        if ( ( $cb_qry = get_transient( $cb_weekly_qry ) ) === false ) {
                            $cb_qry = stats_get_csv( 'postviews', 'days=8&limit=' . ( 6 + $cb_number ) );
                            set_transient($cb_weekly_qry, $cb_qry, $cb_c);  
                        }
                        
                    } elseif ( $cb_filter_date == 'month' ) {

                        $cb_monthly_qry = 'cb-month-pop';
                        if ( ( $cb_qry = get_transient( $cb_monthly_qry ) ) === false ) {
                            $cb_qry = stats_get_csv( 'postviews', 'period=week&days=4&limit=' . ( 6 + $cb_number ) );
                            set_transient($cb_monthly_qry, $cb_qry, $cb_c);  
                        }
                        
                    } elseif ( $cb_filter_date == 'alltime' ) {

                        $cb_alltime_qry = 'cb-alltime-pop';
                        if ( ( $cb_qry = get_transient( $cb_alltime_qry ) ) === false ) {
                            $cb_qry = stats_get_csv( 'postviews', 'days=-1&limit=' . ( 6 + $cb_number ) );
                            set_transient( $cb_alltime_qry, $cb_qry, $cb_c );  
                        }

                    }
                } else {
                    echo '<div class="cb-sidebar-widget">15Zine Popular Posts Widget: To use the "View Count" option You need to install Jetpack plugin and enable the "Stats" module.</div>';
                }

            } else {
                $cb_cpt_output = cb_get_custom_post_types();
                $cb_qry = new WP_Query( array( 'post_type' => $cb_cpt_output, 'posts_per_page' => $cb_number, 'category_name' => $cb_cat_qry, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'orderby' => 'comment_count'  ) );               
            }   		

            echo $before_widget;

            $cb_width = '100';
            $cb_height = '65';
            $cb_style = ' cb-separated';

            if ( $cb_type == 'cb-article-big' ) {
                $cb_width = '360';
                $cb_height = '240';
                $cb_style = ' cb-meta-style-2';
            }

            if ( $cb_title ) echo $before_title . esc_html( $cb_title ) . $after_title; 
            echo '<div class="cb-module-block">';
            
            if ( ( $cb_filter_by == 'cb-comments' ) && ( $cb_qry->have_posts() ) ) {

                while ( $cb_qry->have_posts() ) {

                    $cb_qry->the_post();
                    global $post;
                    $cb_post_id = $post->ID;

                 ?>
                    <article <?php post_class( 'cb-article ' . esc_attr( $cb_type ) .  ' ' . esc_attr( $cb_style ) . ' clearfix' ); ?>>
                        <div class="cb-mask cb-img-fw" <?php cb_img_bg_color( $cb_post_id ); ?>>
                            <?php cb_thumbnail( $cb_width, $cb_height ); ?>
                            <?php cb_review_ext_box( $cb_post_id, true ); ?>
                        </div>
                        <div class="cb-meta cb-article-meta">
                            <h4 class="cb-post-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
                            <div class="cb-byline cb-byline-short cb-comment-count">
                                <a href="<?php echo get_comments_link( $cb_post_id ); ?>">
                                    <?php echo number_format_i18n( get_comments_number( $cb_post_id ) ) . ' ' . __( 'Comments', 'cubell' ); ?>
                                </a>
                            </div>
                        </div>
                        <?php if ( $cb_type == 'cb-article-big' ) { echo '<a href="' . get_the_permalink() . '" class="cb-link"></a>'; } ?>
                    </article>

<?php 

                }
            wp_reset_postdata();
            }

            if ( ( $cb_filter_by == 'cb-visits' ) && ( ! empty( $cb_qry ) ) ) {

               foreach ( $cb_qry as $cb_post ) {
                    $cb_post_id = $cb_post['post_id'];
                    $cb_cats = wp_get_post_categories($cb_post_id);
                    if ( empty( $cb_cats ) ) {
                        continue;
                    }

                 ?>
                    <article class="cb-article <?php echo esc_attr( $cb_type ) . ' ' . esc_attr( $cb_style ); ?> clearfix">
                        <div class="cb-mask cb-img-fw">
                            <?php cb_thumbnail( $cb_width, $cb_height, $cb_post_id ); ?>
                        </div>
                        <div class="cb-meta cb-article-meta">
                            <h4 class="cb-post-title"><a href="<?php echo esc_url( $cb_post['post_permalink'] ); ?>"><?php echo esc_html( $cb_post['post_title'] ); ?></a></h4>
                            <div class="cb-byline cb-byline-short cb-comment-count"><?php echo intval( $cb_post['views'] ); ?> <?php _e( 'Views', 'cubell' ); ?></div>
                       </div>
                       <?php if ( $cb_type == 'cb-article-big' ) { echo '<a href="' . get_the_permalink() . '" class="cb-link"></a>'; } ?>
                    </article>
<?php               if ( $i == $cb_number ) {

                        break;
                    }
                    $i++;
                }

            }

            echo '</div>';
            echo $after_widget;

    		$cache[$args['widget_id']] = ob_get_flush();
    		wp_cache_set('widget_popular_posts', $cache, 'widget');
    	}

    	function update( $new_instance, $old_instance ) {
    		$instance = $old_instance;
    		$instance['cb_type'] =  strip_tags( $new_instance['cb_type']);
            $instance['cb_title'] = strip_tags( $new_instance['cb_title']);
            $instance['category'] = strip_tags( $new_instance['category']);
    		$instance['cb_number'] = (int) $new_instance['cb_number'];
            $instance['cb_filter_date'] = strip_tags( $new_instance['cb_filter_date']);
            $instance['cb_filter_by'] = strip_tags( $new_instance['cb_filter_by']);
    		$this->flush_widget_cache();

    		$alloptions = wp_cache_get( 'alloptions', 'options' );
    		if ( isset( $alloptions['widget_popular_posts']) )
    			delete_option('widget_popular_posts');

    		return $instance;
    	}

    	function flush_widget_cache() {
    		wp_cache_delete('widget_popular_posts', 'widget');
    	}

    	function form( $instance ) {
    		$cb_title  = isset( $instance['cb_title'] ) ? esc_attr( $instance['cb_title'] ) : '';
            $cb_category  = isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
    		$cb_number = isset( $instance['cb_number'] ) ? absint( $instance['cb_number'] ) : 5;
    		$cb_type = isset( $instance['cb_type'] ) ? esc_attr( $instance['cb_type'] ) : '';
            $cb_filter_date = isset( $instance['cb_filter_date'] ) ? esc_attr( $instance['cb_filter_date'] ) : '';
            $cb_filter_by = isset( $instance['cb_filter_by'] ) ? esc_attr( $instance['cb_filter_by'] ) : '';
            $cb_categories = get_categories();
    ?>
    		<p><label for="<?php echo esc_attr( $this->get_field_id( 'cb_title' ) ); ?>">Title:</label>
    		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cb_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cb_title' ) ); ?>" type="text" value="<?php echo esc_attr( $cb_title ); ?>" /></p>

    		<p><label for="<?php echo esc_attr( $this->get_field_id( 'cb_number' ) ); ?>">Number of posts to show:</label>
    		<input id="<?php echo esc_attr( $this->get_field_id( 'cb_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cb_number' ) ); ?>" type="text" value="<?php echo esc_attr( $cb_number ); ?>" size="3" /></p>

         	<p><label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">Category:</label>
            <select id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
            <option value="cb-all" <?php if ( $cb_category == 'all') echo 'selected="selected"'; ?>>All Categories</option>
            <?php
                foreach ( $cb_categories as $cb_cat) {

                    if ( $cb_category == $cb_cat->slug) {$selected = 'selected="selected"'; } else { $selected = NULL;}
                    echo '<option value="' . esc_attr( $cb_cat->slug ) . '" ' . $selected . '>' . $cb_cat->name . ' (' . $cb_cat->count . ')</option>';

                }
            ?>
            </select></p>

         	<p><label for="<?php echo esc_attr( $this->get_field_id( 'cb_type' ) ); ?>"><?php  echo "Style:"; ?></label>

    		 <select id="<?php echo esc_attr( $this->get_field_id( 'cb_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cb_type' ) ); ?>">
               <option value="cb-article-small" <?php if ( $cb_type == 'cb-article-small') echo 'selected="selected"'; ?>>Small</option>
               <option value="cb-article-big" <?php if ( $cb_type == 'cb-article-big') echo 'selected="selected"'; ?>>Big</option>

             </select></p>

             <p><label for="<?php echo esc_attr( $this->get_field_id( 'cb_filter_by' )); ?>"><?php  echo "Filter:"; ?></label>

             <select id="<?php echo esc_attr( $this->get_field_id( 'cb_filter_by' )); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cb_filter_by' )); ?>">
                <option value="cb-comments" <?php if ( $cb_filter_by == 'cb-comments') echo 'selected="selected"'; ?>>Number of  Comments</option>
               <option value="cb-visits" <?php if ( $cb_filter_by == 'cb-visits') echo 'selected="selected"'; ?>>Number of Views</option>
             </select></p>

             <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'cb_filter_date' )); ?>"><?php  echo "Date Filter:"; ?></label>
                <select id="<?php echo esc_attr( $this->get_field_id( 'cb_filter_date' )); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cb_filter_date' )); ?>">
                    <option value="alltime" <?php if ( $cb_filter_date == 'alltime' ) { echo 'selected="selected"'; } ?>>All-time</option>
                    <option value="month" <?php if ( $cb_filter_date == 'month' ) { echo 'selected="selected"'; } ?>>Last Month</option>
                    <option value="week" <?php if ( $cb_filter_date == 'week' ) { echo 'selected="selected"'; } ?>>Past 7 Days</option>
                </select>
            </p>
    <?php
    	}
    }
}

if ( ! function_exists( 'cb_popular_posts_loader' ) ) {
    function cb_popular_posts_loader () {
     register_widget( 'CB_WP_Widget_Popular_Posts' );
    }
     add_action( 'widgets_init', 'cb_popular_posts_loader' );
}
?>
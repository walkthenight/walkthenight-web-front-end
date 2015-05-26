<?php
/**
 * 15Zine Social Media widget
 */
if ( ! class_exists( 'cb_widget_social_media_icons' ) ) {
   class cb_widget_social_media_icons extends WP_Widget {

       function __construct() {
          $widget_ops = array('classname' => 'cb-widget-social-media clearfix', 'description' =>  "Social media icon widget" );
          parent::__construct('cb-social-media-widget', '15Zine Social Media Icons', $widget_ops);
          $this->alt_option_name = 'widget_social_media';

          add_action( 'save_post', array($this, 'flush_widget_cache') );
          add_action( 'deleted_post', array($this, 'flush_widget_cache') );
          add_action( 'switch_theme', array($this, 'flush_widget_cache') );
      }

        function widget($args, $instance) {
            $cache = wp_cache_get('widget_social_media', 'widget');

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
            $instagram = empty($instance['instagram']) ? '' : $instance['instagram'];
            $cb_facebook = empty($instance['facebook']) ? '' : $instance['facebook'];
            $cb_twitter = empty($instance['twitter']) ? '' : $instance['twitter'];
            $cb_youtube = empty($instance['youtube']) ? '' : $instance['youtube'];
            $cb_type = empty($instance['type']) ? '' : $instance['type'];
            $i = 0;

            echo $before_widget;

            if ( $cb_title ) { 
                echo $before_title . esc_html( $cb_title ) . $after_title; 
            }

            echo '<div class="cb-social-media-icons ' . $cb_type . '">';

            $cb_networks = array_filter( array( 'instagram' => $instagram, 'facebook' => $cb_facebook, 'twitter' => $cb_twitter, 'youtube' => $cb_youtube ) );

            foreach ( $cb_networks as $cb_key => $cb_network ) {

                $i++;
                echo '<a href="' . esc_url( $cb_network ) .'" target="_blank" class="cb-' . $cb_key . ' cb-icon-' . $i . '"></a>';

            }

            echo '</div>' . $after_widget;

            wp_reset_postdata();

            $cache[$args['widget_id']] = ob_get_flush();
            wp_cache_set('widget_social_media', $cache, 'widget');
        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['facebook'] = strip_tags($new_instance['facebook']);
            $instance['twitter'] = strip_tags($new_instance['twitter']);
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['youtube'] = strip_tags($new_instance['youtube']);
            $instance['rss'] = strip_tags($new_instance['rss']);
            $instance['instagram'] = strip_tags($new_instance['instagram']);
            $instance['type'] =  strip_tags($new_instance['type']);
            $this->flush_widget_cache();

            $alloptions = wp_cache_get( 'alloptions', 'options' );
            if ( isset($alloptions['widget_social_media']) )
            delete_option('widget_social_media');

            return $instance;
        }

        function flush_widget_cache() {
            wp_cache_delete('widget_social_media', 'widget');
        }

        function form( $instance ) {
            $cb_facebook = isset( $instance['facebook'] ) ? esc_attr( $instance['facebook'] ) : '';
            $cb_twitter = isset( $instance['twitter'] ) ? esc_attr( $instance['twitter'] ) : '';
            $cb_youtube = isset( $instance['youtube'] ) ? esc_attr( $instance['youtube'] ) : '';
            $cb_title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
            $instagram = isset( $instance['instagram'] ) ? esc_attr( $instance['instagram'] ) : '';
            $cb_type = isset( $instance['type'] ) ? esc_attr( $instance['type'] ) : '';
        ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'cubell' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $cb_title ); ?>" />
            </p>


            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php  echo "Icons Style:"; ?></label>
                <select id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>">
                    <option value="cb-colors" <?php if ( $cb_type == 'cb-colors' ) { echo 'selected="selected"'; } ?>>Color Logos</option>
                    <option value="cb-white" <?php if ( $cb_type == 'cb-white' ) { echo 'selected="selected"'; } ?>>White Logos</option>
                </select>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>">Twitter URL:</label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>" type="text" value="<?php echo esc_attr( $cb_twitter ); ?>" />
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>">Facebook URL:</label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>" type="text" value="<?php echo esc_attr( $cb_facebook ); ?>" />
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>">Instagram URL:</label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'instagram' ) ); ?>" type="text" value="<?php echo esc_attr( $instagram ); ?>" />
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>">YouTube URL:</label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'youtube' ) ); ?>" type="text" value="<?php echo esc_attr( $cb_youtube ); ?>" />
            </p>

<?php
        }
    }
}

if ( ! function_exists( 'cb_social_media_widget' ) ) {
    function cb_social_media_widget (){
       register_widget( 'cb_widget_social_media_icons' );
   }
   add_action( 'widgets_init', 'cb_social_media_widget' );
}
?>
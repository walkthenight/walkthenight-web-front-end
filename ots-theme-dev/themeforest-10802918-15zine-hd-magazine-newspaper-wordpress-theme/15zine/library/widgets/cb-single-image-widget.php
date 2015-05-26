<?php 
/**
 * 15Zine Single Image Widget
 */
 
if ( ! class_exists( 'cb_single_image_widget' ) ) {
    
    class cb_single_image_widget extends WP_Widget {
    
    	function __construct() {
    		$widget_ops = array('classname' => 'cb-single-image-widget clearfix', 'description' =>  "Displays a Retina Image. Useful to show logo as widget. See 15Zine documentation for details." );
    		parent::__construct('single-image', '15Zine Retina Image Widget', $widget_ops);
    		$this->alt_option_name = 'widget_single_image';
    
    		add_action( 'save_post', array($this, 'flush_widget_cache') );
    		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
    		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    	}
    
    	function widget($args, $instance) {
    		$cache = wp_cache_get('widget_single_image', 'widget');
    
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
            $cb_image = empty($instance['imgurl']) ? '' : $instance['imgurl'];
            $cb_retina_image = empty($instance['retimgurl']) ? '' : $instance['retimgurl'];
            		
            echo $before_widget; 
            if ( $cb_title ) echo $before_title . esc_html( $cb_title ) . $after_title;
    		
            if ( $cb_image != NULL ) {

                echo '<img src="'. $cb_image .'" alt=" " ';
                if ( $cb_retina_image != NULL ) {
                     echo ' data-at2x="'. $cb_retina_image .'"';
                }
                echo ' />';
            }
    
            echo $after_widget;   
    
    		$cache[$args['widget_id']] = ob_get_flush();
    		wp_cache_set('widget_single_image', $cache, 'widget');
    	}
    
    	function update( $new_instance, $old_instance ) {
    		$instance = $old_instance;
            $instance['imgurl'] = strip_tags($new_instance['imgurl']);
            $instance['retimgurl'] = strip_tags($new_instance['retimgurl']);
    		$instance['title'] = strip_tags($new_instance['title']);
    		$this->flush_widget_cache();
    
    		$alloptions = wp_cache_get( 'alloptions', 'options' );
    		if ( isset($alloptions['widget_single_image']) )
    			delete_option('widget_single_image');
    
    		return $instance;
    	}
    
    	function flush_widget_cache() {
    		wp_cache_delete('widget_single_image', 'widget');
    	}
    
    	function form( $instance ) {
    
            $cb_image     = isset( $instance['imgurl'] ) ? $instance['imgurl'] : '';
            $cb_retina_image     = isset( $instance['retimgurl'] ) ? $instance['retimgurl']  : '';
    		$cb_title     = isset( $instance['title'] ) ? $instance['title'] : '';
    ?>      
            
            <p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'cubell' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $cb_title ); ?>" /></p>
            
    		<p><label for="<?php echo esc_attr( $this->get_field_id( 'imgurl' ) ); ?>">Image URL:</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'imgurl' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'imgurl' ) ); ?>" type="text" value="<?php echo esc_url( $cb_image ); ?>" /></p>       
            
            <p><label for="<?php echo esc_attr( $this->get_field_id( 'retimgurl' )) ; ?>">Retina Image URL:</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'retimgurl' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'retimgurl' ) ); ?>" type="text" value="<?php echo esc_url( $cb_retina_image ); ?>" /></p>        
                   
    	
         <?php
    	}
    }
}

if ( ! function_exists( 'cb_single_image_widget' ) ) {
    function cb_single_image_widget () {
     register_widget( 'cb_single_image_widget' );
    }
     add_action( 'widgets_init', 'cb_single_image_widget' );
}
?>
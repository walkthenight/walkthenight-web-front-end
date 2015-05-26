 <?php /* Custom Code Module */ 
 
        $cb_global_color = ot_get_option('cb_base_color', '#eb9812'); 
        $cb_title_header = NULL;

        if ( $cb_title != NULL ) {
            $cb_title_header = '<div class="cb-module-header"><h2 class="cb-module-title" >' . $cb_title . '</h2>' . $cb_subtitle . '</div>';
        }
        
        echo '<div class="cb-module-custom cb-module-block cb-module-half clearfix">' . $cb_title_header . '<div class="cb-contents">' . do_shortcode( $cb_custom ) . '</div></div>';
?>
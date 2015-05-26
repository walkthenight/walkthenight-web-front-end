<?php
define( 'CB_VER', '1.2.0' );

/************* LOAD NEEDED FILES ***************/

require_once get_template_directory() . '/library/core.php';
require_once get_template_directory() . '/library/translation/translation.php';
add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_show_new_layout', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );
add_filter( 'ot_post_formats', '__return_true' );

load_template( get_template_directory() . '/option-tree/ot-loader.php' );
load_template( get_template_directory() . '/library/admin/cb-meta-boxes.php' );
load_template( get_template_directory() . '/library/admin/cb-to.php' );
require_once get_template_directory() . '/library/admin/cb-tgm.php'; 

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes with placeholders
add_image_size( 'cb-100-65', 100, 65, true ); // Widgets
add_image_size( 'cb-260-170', 260, 170, true ); // Megamenu
add_image_size( 'cb-360-490', 360, 490, true ); // Portrait thumbnails
add_image_size( 'cb-360-240', 360, 240, true ); // Blog Style A/Mega menu
add_image_size( 'cb-378-300', 378, 300, true ); // Slider C, Grid small thumbnails
add_image_size( 'cb-759-300', 759, 300, true ); // Grid Medium thumbnails, Grid 3 Static Big Thumbnail
add_image_size( 'cb-759-500', 759, 500, true ); // Slider B, Standard featured image, Blog Style D/F/G, Module D
add_image_size( 'cb-759-600', 759, 600, true ); // Grid big thumbnails
add_image_size( 'cb-1400-600', 1400, 600, true ); // Parallax/Full screen/Full screen slider

// Content Width
if ( ! isset( $content_width ) ) {
    $content_width = 800;
}

/*********************
SCRIPTS & ENQUEUEING
*********************/
add_action('after_setup_theme','cb_script_loaders', 15);

if ( ! function_exists( 'cb_script_loaders' ) ) {   
    function cb_script_loaders() {
        // enqueue base scripts and styles
        add_action('wp_enqueue_scripts', 'cb_scripts_and_styles', 999);
    	// enqueue admin scripts and styles
    	add_action('admin_enqueue_scripts', 'cb_post_admin_scripts_and_styles');
    	// ie conditional wrapper
        add_filter( 'style_loader_tag', 'cb_ie_conditional', 10, 2 );
        add_editor_style( 'library/admin/css/cb-editor.css' );
    }
}
if ( ! function_exists( 'cb_scripts_and_styles' ) ) {   
    function cb_scripts_and_styles() {        
        if ( !is_admin() ) {
            // Modernizr (without media query polyfill)
            wp_register_script( 'cb-modernizr',  get_template_directory_uri() . '/library/js/modernizr.custom.min.js', array(), '2.6.2', false );
        	wp_enqueue_script('cb-modernizr'); // enqueue it

            $cb_responsive_style = ot_get_option( 'cb_responsive_onoff', 'on' );

            if ( ot_get_option( 'cb_max_theme_width', 'default' ) == 'onesmaller') {
                $cb_site_size = '1020px';
            } else {
                $cb_site_size = NULL;
            }

            if ( $cb_responsive_style == 'on' ) {
                if ( is_rtl() ) {
                    $cb_style_name = 'style-rtl' . $cb_site_size;
                } else {
                    $cb_style_name = 'style' . $cb_site_size;
                }
            } else {
                if ( is_rtl() ) {
                    $cb_style_name = 'style-rtl-unres' . $cb_site_size;
                } else {
                    $cb_style_name = 'style-unres' . $cb_site_size;
                }
            }

            if ( is_singular() ) {
                global $post;
                $cb_post_id = $post->ID;
            } else {
                $cb_post_id = NULL;
            }

            // Register main stylesheet
            wp_register_style( 'cb-main-stylesheet',  cb_file_location( 'library/css/' . $cb_style_name . '.css' ), array(), CB_VER, 'all' );
            wp_enqueue_style('cb-main-stylesheet'); // enqueue it
            $cb_font = cb_fonts();
            wp_register_style( 'cb-font-stylesheet',  $cb_font[0], array(), CB_VER, 'all' );
            wp_enqueue_style('cb-font-stylesheet'); // enqueue it
            // ie-only stylesheet
            wp_register_style( 'cb-ie-only',  get_template_directory_uri() . '/library/css/ie.css', array(), CB_VER );
            wp_enqueue_style('cb-ie-only'); // enqueue it	
            // register font awesome stylesheet
            wp_register_style('fontawesome',  get_template_directory_uri() . '/library/css/font-awesome-4.3.0/css/font-awesome.min.css', array(), '4.3.0', 'all');
            wp_enqueue_style('fontawesome'); // enqueue it
            if ( class_exists('Woocommerce') ) {
                wp_register_style( 'cb-woocommerce-stylesheet',  get_template_directory_uri()  . '/woocommerce/css/woocommerce.css', array(), CB_VER, 'all' );
                wp_enqueue_style('cb-woocommerce-stylesheet'); // enqueue it
            }
            if ( is_single() ) {
                if ( get_post_meta( $cb_post_id, 'cb_review_checkbox', true ) != NULL ) {
                    wp_register_script( 'cb-cookie',  get_template_directory_uri()  . '/library/js/cookie.min.js', array( 'jquery' ), CB_VER, true );
                    wp_enqueue_script( 'cb-cookie' ); // enqueue it
                }
            }
            // comment reply script for threaded comments
            if ( is_singular() && comments_open() && ( get_option('thread_comments') == 1) ) { global $wp_scripts; $wp_scripts->add_data('comment-reply', 'group', 1 ); wp_enqueue_script( 'comment-reply' );}
            // Load lightbox
            $cb_lightbox_onoff = ot_get_option('cb_lightbox_onoff', 'on');
            if ( $cb_lightbox_onoff != 'off' ) {
                wp_register_script( 'cb-lightbox',  get_template_directory_uri()  . '/library/js/jquery.fs.boxer.min.js', array( 'jquery' ), CB_VER, true);
                wp_enqueue_script( 'cb-lightbox' ); // enqueue it
            }
        	// Load Extra Needed Javascript
            wp_register_script( 'cb-js-ext',  get_template_directory_uri()  . '/library/js/cb-ext.js', array( 'jquery' ), CB_VER, true);
            wp_enqueue_script( 'cb-js-ext' ); // enqueue it
            // Load scripts
            $cb_minify_js_onoff = ot_get_option('cb_minify_js_onoff', 'on');
            if ( $cb_minify_js_onoff != 'off' ) {
                wp_register_script( 'cb-js',  get_template_directory_uri()  . '/library/js/cb-scripts.min.js', array( 'jquery' ), CB_VER, true);
            } else {
                wp_register_script( 'cb-js',  get_template_directory_uri()  . '/library/js/cb-scripts.source.js', array( 'jquery' ), CB_VER, true);
            }
            
            wp_enqueue_script( 'cb-js' ); // enqueue it
            wp_localize_script( 'cb-js', 'cbScripts', array( 'cbUrl' => admin_url( 'admin-ajax.php' ), 'cbPostID' => $cb_post_id, 'cbFsClass' => 'cb-embed-fs' ) );

        }
    }
}
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

if ( ! function_exists( 'cb_post_admin_scripts_and_styles' ) ) {
    function cb_post_admin_scripts_and_styles($hook) {
    	if ( $hook == 'post.php' || $hook == 'post-new.php' || $hook == 'edit-tags.php' || $hook == 'profile.php' || $hook == 'appearance_page_ot-theme-options' || $hook == 'user-edit.php' || $hook == 'appearance_page_radium_demo_installer' || $hook == 'edit-tags.php' || $hook == 'widgets.php' ) {

			wp_register_script( 'admin-js',  get_template_directory_uri()  . '/library/admin/js/cb-admin.js', array(), CB_VER, true);
			wp_enqueue_script( 'admin-js' ); // enqueue it
            wp_register_style('fontawesome', get_template_directory_uri() . '/library/css/font-awesome-4.3.0/css/font-awesome.min.css', array(), '4.3.0', 'all');
            wp_enqueue_style('fontawesome'); // enqueue it
            wp_enqueue_script( 'suggest' ); // enqueue it
    	}

    }
}


// adding the conditional wrapper around ie8 stylesheet
// source: Gary Jones - http://code.garyjones.co.uk/ie-conditional-style-sheets-wordpress/ 
// GPLv2 or newer license
if ( ! function_exists( 'cb_ie_conditional' ) ) {    
    function cb_ie_conditional( $tag, $handle ) {
    	if ( ( 'cb-ie-only' == $handle ) || ( 'cb-select' == $handle ) ) {
    		$tag = '<!--[if lt IE 10]>' . "\n" . $tag . '<![endif]-->' . "\n";
        }
    	return $tag;
    }
}

// Sidebars & Widgetizes Areas
if ( ! function_exists( 'cb_register_sidebars' ) ) {
    function cb_register_sidebars() {
        $cb_footer_layout = ot_get_option('cb_footer_layout', 'cb-footer-a');     
        // Main Sidebar
        register_sidebar(array(
            'name' => 'Global Sidebar',
            'id' => 'sidebar-global',
            'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="cb-sidebar-widget-title cb-widget-title">',
            'after_title' => '</h3>'
        ));
        // Footer Widget 1
        register_sidebar(array(
            'name' => 'Footer 1',
            'id' => 'footer-1',
            'before_widget' => '<div id="%1$s" class="cb-footer-widget clearfix %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="cb-footer-widget-title cb-widget-title">',
            'after_title' => '</h3>'
        ));
        // Footer Widget 2
        register_sidebar(array(
            'name' => 'Footer 2',
            'id' => 'footer-2',
            'before_widget' => '<div id="%1$s" class="cb-footer-widget clearfix %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="cb-footer-widget-title cb-widget-title">',      
    		'after_title' => '</h3>'
        ));	
        // Footer Widget 3
        register_sidebar(array(
            'name' => 'Footer 3',
            'id' => 'footer-3',
            'before_widget' => '<div id="%1$s" class="cb-footer-widget clearfix %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="cb-footer-widget-title cb-widget-title">',
    		'after_title' => '</h3>'
        ));	 
        if ($cb_footer_layout == 'cb-footer-b') {
            // Footer Widget 4
            register_sidebar(array(
                'name' => 'Footer 4',
                'id' => 'footer-4',
                'before_widget' => '<div id="%1$s" class="cb-footer-widget clearfix %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="cb-footer-widget-title cb-widget-title">',
                'after_title' => '</h3>'
            ));     
        }
        register_sidebar(
            array(
                'name' => '15Zine Multi-Widgets Area',
                'id' => 'cb_multi_widgets',
                'description' => '1- Drag multiple widgets here 2- Drag the "15Zine Multi-Widget Widget" to the sidebar where you want to show the multi-widgets.',
                'before_widget' => '<div id="%1$s" class="widget cb-multi-widget tabbertab %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="cb-widget-title">',
                'after_title' => '</h3>'
            )
        );

        if ( class_exists( 'Woocommerce' ) ) {
            register_sidebar( array(
                'name' => '15Zine WooCommerce Sidebar',
                'id' => 'sidebar-woocommerce',
                'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="cb-sidebar-widget-title cb-widget-title">',
                'after_title' => '</h3>'
            ));
        }
        if ( class_exists( 'bbPress' ) ) {
            register_sidebar( array(
                'name' => '15Zine bbPress Sidebar',
                'id' => 'sidebar-bbpress',
                'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="cb-sidebar-widget-title cb-widget-title">',
                'after_title' => '</h3>'
            ));
        }


        $cb_pages = get_pages(array('post_status' =>  array('publish', 'pending', 'private', 'draft') ));
        foreach ( $cb_pages as $page ) {
    
            $cb_custom_fields = get_post_custom($page->ID);
            if ( isset($cb_custom_fields['cb_page_custom_sidebar'][0] ) ) { $cb_page_sidebar = $cb_custom_fields['cb_page_custom_sidebar'][0]; } else { $cb_page_sidebar = 'off';}
            if ( isset($cb_custom_fields['_wp_page_template'][0] ) ) { $cb_page_template = $cb_custom_fields['_wp_page_template'][0]; } else { $cb_page_template = 'off';}

                if ( $cb_page_sidebar == '2' ) { 
                    register_sidebar( array(
                        'name' => $page->post_title .' (Page)',
                        'id' => 'page-'.$page->ID . '-sidebar',
                        'description' => 'This is the ' . $page->post_title . ' sidebar',
                        'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
                        'after_widget' => '</div>',
                        'before_title' => '<h3 class="cb-sidebar-widget-title cb-widget-title">',
                      'after_title' => '</h3>'
                    ) );
                }

                if ( $cb_page_template == 'page-15zine-builder.php' ) {

                    // Homepage Section B Sidebar
                    register_sidebar(array(
                        'name' => 'Section B Sidebar ('.$page->post_title .' page)',
                        'id' => 'sidebar-hp-b-'.$page->ID,
                        'description' => 'Page: ' . $page->post_title,
                        'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
                        'after_widget' => '</div>',
                        'before_title' => '<h3 class="cb-sidebar-widget-title cb-widget-title">',
                        'after_title' => '</h3>'
                    ));        
                }
        }

		if ( function_exists('get_tax_meta') ) {
				$categories = get_categories( array( 'hide_empty'=> 0 ) );       

		    foreach ( $categories as $category ) {
		        $cat_onoff = get_tax_meta($category->cat_ID, 'cb_cat_sidebar');
		        if ($cat_onoff == 'on'){
                    register_sidebar( array(
                        'name' => $category->cat_name,
                        'id' => $category->category_nicename . '-sidebar',
                        'description' => 'This is the ' . $category->cat_name . ' sidebar',
                        'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
                        'after_widget' => '</div>',
                        'before_title' => '<h3 class="cb-sidebar-widget-title cb-widget-title">',
                      'after_title' => '</h3>'
                    ) );
		        }
		        
		   }
		}
    }
}
add_action( 'widgets_init', 'cb_register_sidebars' );


if ( class_exists( 'Cubell_Functionality' ) ) {
    
  function cb_outdated_plugin_notice() {
    
    echo '<div class="error"><p>' . __( '15Zine no longer requires Cubell Themes Functionality plugin, please delete it and instead install the new "15Zine Functionality" plugin, which can be done in Appearance -> Install Plugins.', 'cubell' ) . '</p></div>';
    
  }
  
  add_action( 'admin_notices', 'cb_outdated_plugin_notice' );
  
}

if ( ! function_exists( 'cb_widgets' ) ) {
    function cb_widgets() {

        require_once cb_file_location( 'library/widgets/cb-recent-posts-slider-widget.php' );
        require_once cb_file_location( 'library/widgets/cb-widget-social-media.php' );
        require_once cb_file_location( 'library/widgets/cb-single-image-widget.php' );
        require_once cb_file_location( 'library/widgets/cb-reviews-widget.php' );
        require_once cb_file_location( 'library/widgets/cb-facebook-like-widget.php' );
        require_once cb_file_location( 'library/widgets/cb-google-follow-widget.php' );
        require_once cb_file_location( 'library/widgets/cb-multi-widget.php' );
        require_once cb_file_location( 'library/widgets/cb-popular-posts-widget.php' );
        require_once cb_file_location( 'library/widgets/cb-recent-posts-widget.php' );
        require_once cb_file_location( 'library/widgets/cb-125-ads-widget.php' );
    }
}

add_action( 'after_setup_theme', 'cb_widgets' );

?>
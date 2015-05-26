<?php

// Ahoy! All engines ready, let's fire up!
if ( ! function_exists( 'cb_start' ) ) {
    function cb_start() {
        cb_theme_support();
    }
}
add_action('after_setup_theme','cb_start', 16);

/*********************
THEME SUPPORT
*********************/

// Adding Functions & Theme Support
if ( ! function_exists( 'cb_theme_support' ) ) {  
    function cb_theme_support() {
        // Title Tag
        add_theme_support( 'title-tag' );
        // Wp thumbnails 
        add_theme_support('post-thumbnails');
        // Default thumb size
        set_post_thumbnail_size(125, 125, true);
        // RSS 
        add_theme_support('automatic-feed-links');
        // Adding post format support
        add_theme_support( 'post-formats',
            array(
                'video',             
                'audio',            
                'gallery',          
            )
        );
        add_theme_support( 'woocommerce' );
        add_theme_support( 'custom-header' );
        add_theme_support( 'custom-background' );
        // wp menus
        add_theme_support( 'menus' );
        // registering menus
        register_nav_menus(
            array(
                    'top' => 'Top Navigation Menu',
                    'main' => 'Main Navigation Menu', 
                    'small' => '(Mobile Devices) Main Navigation Menu', 
                    'footer' => 'Footer Navigation Menu', 
            )
        );
    }
}

if ( ! function_exists( '_wp_render_title_tag' ) ) {
    function cb_pre_4_1_title() {
        ?>
        <title><?php wp_title( '|', true, 'right' ); ?></title>
        <?php
    }
   
    add_action( 'wp_head', 'cb_pre_4_1_title' );
}

/*********************
MENUS & NAVIGATION
*********************/

// Top Nav Left Side
if ( ! function_exists( 'cb_top_nav_left' ) ) {
    function cb_top_nav_left(){   
        if  ( has_nav_menu( 'top' ) ) {
            wp_nav_menu(
                array(
                    'theme_location'  => 'top',
                    'container' => FALSE,
                    'menu_class' => 'menu',
                    'items_wrap' => '<ul class="cb-top-nav cb-left-side">%3$s</ul>',
                )
            );
        }
    }
}

// Mobile
if ( ! function_exists( 'cb_mobile_nav' ) ) {
    function cb_mobile_nav(){   
        if  ( has_nav_menu( 'small' ) ) {

            wp_nav_menu(
                array(
                    'theme_location'  => 'small',
                    'container' => FALSE,
                    'menu_class' => 'menu',
                    'items_wrap' => '<ul class="cb-mobile-nav cb-top-nav">%3$s</ul>',
                )
            );

        }
    }
}

// Top Nav Right Side
if ( ! function_exists( 'cb_top_nav_right' ) ) {
    function cb_top_nav_right(){
        $cb_top_nav_search = ot_get_option('cb_top_nav_search', 'on');
        $cb_top_nav_login = ot_get_option('cb_top_nav_login', 'on');

        if ( ( $cb_top_nav_login != 'off' ) || ( $cb_top_nav_search != 'off' ) ) {

            $cb_login_space = '<i class="fa fa-user"></i>';
            $cb_login_class = '<li class="cb-icon-login">';

            if ( is_user_logged_in() == true ) {

                global $current_user;
                get_currentuserinfo();
                $cb_author_id = $current_user->ID;
                $cb_login_space = get_avatar( $cb_author_id, $size = '36' );
                $cb_login_class = '<li class="cb-icon-login cb-icon-logged-in">';
                $cb_login_title = '<span class="cb-login-join-title">' . $current_user->display_name . '</span>';

                if ( class_exists('buddypress') ) {

                    global $bp;
                    $cb_buddypress_current_user_id = $bp->loggedin_user->id;
                    $cb_login_space = bp_core_fetch_avatar( array( 'item_id' => $cb_buddypress_current_user_id, 'type' => 'thumb', 'width' => 36, 'height' => 36 ) );

                }

            } else {
                $cb_login_title = '<span class="cb-login-join-title">' . __('Log in / Join', 'cubell') . '</span>';
            }

            $cb_menu_output = '<ul class="cb-top-nav cb-right-side">';
            
            if ( $cb_top_nav_search == 'on' ) {
                $cb_menu_output .=  '<li class="cb-icon-search"><a href="#" title="' .  __('Search', 'cubell') . '" id="cb-s-trigger"><i class="fa fa-search"></i> <span class="cb-search-title">' .  __('Search', 'cubell')  . '</span></a></li>';
            }

            if ( function_exists('login_with_ajax') ) {
                 if ( $cb_top_nav_login == 'on' ) {
                    $cb_menu_output .= $cb_login_class . '<a href="#" title="' . esc_attr( $cb_login_title ) . '" id="cb-lwa-trigger">' . $cb_login_space . ' ' . $cb_login_title . '</a></li>';
                 }
            }

            $cb_menu_output .= '</ul>';

            return $cb_menu_output;

        }
    }
}


// Footer Nav
if ( ! function_exists( 'cb_footer_nav' ) ) {
    function cb_footer_nav(){
        wp_nav_menu(
            array(
                'container_class' => 'cb-footer-links clearfix',
                'menu' => 'Footer Links',
                'menu_class' => 'nav cb-footer-nav clearfix',
                'theme_location' => 'footer',
                'depth' => 0,
                'fallback_cb' => 'none'
            )
        );
    }
}

// Load Mobile Detection Class
require_once get_template_directory() . '/library/includes/mobile-detect-class.php';

/*********************
LOAD CUSTOM CODE
*********************/
if ( ! function_exists( 'cb_custom_code' ) ) {
    function cb_custom_code(){

            $cb_custom_css = ot_get_option('cb_custom_css', NULL);
            $cb_custom_a_css = ot_get_option('cb_link_color', NULL);
            $cb_custom_body_color_css = ot_get_option('cb_body_text_color', NULL);
            $cb_custom_header_bg = ot_get_option('cb_header_bg_image', NULL);
            $cb_bbp_sticky_background_color = ot_get_option('cb_bbp_sticky_background_color', NULL);
            $cb_logo_nav_left = ot_get_option( 'cb_logo_nav_left', '0' );
            $cb_logo_in_nav = ot_get_option('cb_logo_in_nav', 'off');
            $cb_mm_columns_color = ot_get_option('cb_mm_columns_color', '#f2c231');
            $cb_show_header = NULL;

            if ( $cb_logo_in_nav != 'off' ) {
                $cb_logo_in_nav_when = ot_get_option( 'cb_logo_in_nav_when', 'cb-logo-nav-sticky' );  
                if ( is_singular() ) {
                    $cb_show_header = cb_show_header();
                }
                if ( $cb_show_header == NULL ) {
                    $cb_show_header = 'on';
                }


                if ( ( $cb_logo_in_nav_when == 'cb-logo-nav-sticky' ) && ( $cb_show_header == 'on' ) ) {
                    $cb_custom_css .= ' .cb-stuck #cb-nav-bar .cb-main-nav #cb-nav-logo, #cb-nav-bar .cb-main-nav #cb-nav-logo img { width: ' . ot_get_option('cb_logo_nav_width', '150') . 'px; }';
                } else {
                    $cb_custom_css .= '  #cb-nav-bar .cb-main-nav #cb-nav-logo, #cb-nav-bar .cb-main-nav #cb-nav-logo img { width: ' . ot_get_option('cb_logo_nav_width', '150') . 'px; } #cb-nav-bar .cb-main-nav #cb-nav-logo { visibility: visible; filter: progid:DXImageTransform.Microsoft.Alpha(enabled=false); opacity: 1; -moz-transform: translate3d(0, 0, 0); -ms-transform: translate3d(0, 0, 0); -webkit-transform: translate3d(0,0,0); transform: translate3d(0, 0, 0); margin: 0 20px 0 12px; }';
                }
                
            }


            if ( $cb_custom_header_bg != NULL ) {
                $cb_custom_header_bg_output = NULL;

                if ( $cb_custom_header_bg['background-color'] != NULL ) {
                    $cb_custom_header_bg_output .= 'background-color: ' . $cb_custom_header_bg['background-color'] . ';';
                }

                if ( $cb_custom_header_bg['background-image'] != NULL ) {
                    $cb_custom_header_bg_output .= 'background-image: url(' . esc_url( $cb_custom_header_bg['background-image'] ) . ');';

                    if ( $cb_custom_header_bg['background-repeat'] != NULL ) {
                        $cb_custom_header_bg_output .= 'background-repeat: ' . $cb_custom_header_bg['background-repeat'] . ';';
                    }
                    if ( $cb_custom_header_bg['background-position'] != NULL ) {
                        $cb_custom_header_bg_output .= 'background-position: ' . $cb_custom_header_bg['background-position'] . ';';
                    }

                }

                if ( ( $cb_custom_header_bg['background-color'] == NULL ) && ( $cb_custom_header_bg['background-image'] == NULL ) ) {
                    $cb_custom_header_bg = NULL;
                }
            }
            
            if ( ot_get_option('cb_custom_head', NULL) != NULL ) { echo ot_get_option('cb_custom_head', NULL); }
            if ( $cb_mm_columns_color != NULL ) { $cb_custom_css .= '#cb-nav-bar .cb-mega-menu-columns .cb-sub-menu > li > a { color: ' . $cb_mm_columns_color . '; }'; }
            if ( $cb_bbp_sticky_background_color != NULL ) { $cb_custom_css .= '.bbp-topics-front ul.super-sticky, .bbp-topics ul.super-sticky, .bbp-topics ul.sticky, .bbp-forum-content ul.sticky {background-color: ' . $cb_bbp_sticky_background_color . '!important;}'; }
            if ( is_array( $cb_custom_a_css) ) {
                foreach ( $cb_custom_a_css as $cb_css => $cb_val ) {
                    if ( $cb_val == NULL ) { 
                        continue;
                    }
                    if ( $cb_css == 'link' ) {
                        $cb_custom_css .= ' .cb-entry-content a {color:' . $cb_val . '; }'; 
                    } else {
                        $cb_custom_css .= ' .cb-entry-content a:' . $cb_css . ' {color:' . $cb_val . '; }'; 
                    }
                }
            }
            if ( $cb_custom_body_color_css != NULL ) { $cb_custom_css .= 'body { color:' . $cb_custom_body_color_css . '; }'; }
            if ( $cb_custom_header_bg != NULL ) { $cb_custom_css .= '.cb-header { ' . $cb_custom_header_bg_output . ' }'; }
            if ( $cb_logo_nav_left != 0 ) {  $cb_custom_css .= '#cb-nav-logo { margin-right: ' . $cb_logo_nav_left . 'px!important; }'; }
            if ( $cb_custom_css != NULL ) { echo '<style type="text/css">' . $cb_custom_css . '</style><!-- end custom css -->'; }

    }
}
add_action('wp_head', 'cb_custom_code');

/*********************
LOAD USER FONT
*********************/
if ( ! function_exists( 'cb_fonts' ) ) {
    function cb_fonts() {

        $cb_header_font = ot_get_option('cb_header_font', "'Raleway', sans-serif;");
        $cb_user_header_font = ot_get_option('cb_user_header_font', NULL);
        $cb_body_font = ot_get_option('cb_body_font', "'Raleway', sans-serif;");
        $cb_user_body_font = ot_get_option('cb_user_body_font', NULL);
        $cb_font_latin = ot_get_option('cb_font_ext_lat', 'off');
        $cb_font_cyr = ot_get_option('cb_font_cyr', 'off');
        $cb_return = array();
        $cb_font_ext = $cb_font_cyr = $cb_p_font_output = $cb_user_fonts = $cb_woocommerce = NULL;

        if ( is_single() ) {
            global $post;
            $cb_p_font = get_post_meta( $post->ID, '_cb_post_font', true );
            if ( $cb_p_font == 'on' ) {
                $cb_p_header_font = get_post_meta( $post->ID, 'cb_header_font', true );
                $cb_p_user_header_font = get_post_meta( $post->ID, 'cb_user_header_font', true );
                $cb_p_body_font = get_post_meta( $post->ID, 'cb_body_font', true );
                $cb_p_user_body_font = get_post_meta( $post->ID, 'cb_user_body_font', true );

                if ( ( $cb_p_header_font == 'other' ) && ( $cb_p_user_header_font != NULL ) ) {
                    $cb_p_header_font = $cb_p_user_header_font;
                }

                if ( ( $cb_p_body_font == 'other' ) && ( $cb_p_user_body_font != NULL ) ) {
                    $cb_p_body_font = $cb_p_user_body_font;
                }

                $cb_p_font_output = '.cb-entry-content blockquote, .cb-entry-content h1, .cb-entry-content h2, .cb-entry-content h3, .cb-entry-content h4, .cb-entry-content h5, .cb-entry-content h6, #cb-featured-image h1, .cb-entry-content ul, .cb-entry-content ol { font-family:' . $cb_p_header_font . ' }';
                $cb_p_font_output .= '.cb-entry-content, #cb-featured-image .cb-byline { font-family:' . $cb_p_body_font . ' }';

                $cb_u_header_font_clean =  substr( $cb_p_header_font, 0, strpos($cb_p_header_font, ',' ) );
                $cb_u_header_font_clean = str_replace( "'", '', $cb_u_header_font_clean );
                $cb_u_header_font_clean = str_replace( " ", '+', $cb_u_header_font_clean );
                $cb_u_body_font_clean =  substr( $cb_p_body_font, 0, strpos( $cb_p_body_font, ',' ) );
                $cb_u_body_font_clean = str_replace( "'", '', $cb_u_body_font_clean );
                $cb_u_body_font_clean = str_replace( " ", '+', $cb_u_body_font_clean );

                $cb_user_fonts = '|' . $cb_u_header_font_clean .  ':400,700' . '|' . $cb_u_body_font_clean .  ':400,700';
            }
        }

        if ( ( $cb_header_font == 'other' ) && ( $cb_user_header_font != NULL ) ) {
            $cb_header_font = $cb_user_header_font;
        }

        if ( ( $cb_body_font == 'other' ) && ( $cb_user_body_font != NULL ) ) {
            $cb_body_font = $cb_user_body_font;
        }

        if ( ( $cb_font_latin == 'on' ) && ( $cb_font_cyr == 'on' ) ) {
            $cb_font_ext = '&subset=latin,latin-ext,cyrillic,cyrillic-ext';

        } elseif ( $cb_font_latin == 'on' ) {
            $cb_font_ext = '&subset=latin,latin-ext';

        } elseif ( $cb_font_cyr == 'on' ) {
            $cb_font_ext = '&subset=cyrillic,cyrillic-ext';
        }
        $cb_header_font_clean =  substr( $cb_header_font, 0, strpos($cb_header_font, ',' ) );
        $cb_header_font_clean = str_replace( "'", '', $cb_header_font_clean );
        $cb_header_font_clean = str_replace( " ", '+', $cb_header_font_clean );
        $cb_body_font_clean =  substr( $cb_body_font, 0, strpos( $cb_body_font, ',' ) );
        $cb_body_font_clean = str_replace( "'", '', $cb_body_font_clean );
        $cb_body_font_clean = str_replace( " ", '+', $cb_body_font_clean );

        if ( cb_is_woocommerce() ) {
            $cb_woocommerce = ', .product_meta, .price, .woocommerce-review-link, .cart_item, .cart-collaterals .cart_totals th';
        } 
        $cb_return[] = '//fonts.googleapis.com/css?family=' . $cb_header_font_clean . ':400,700' . $cb_font_ext . '|' . $cb_body_font_clean . ':400,700,400italic' . $cb_font_ext . $cb_user_fonts;
        $cb_return[] = '<style type="text/css">body, #respond, .cb-font-body { font-family: ' . $cb_body_font . ' } h1, h2, h3, h4, h5, h6, .cb-font-header, #bbp-user-navigation, .cb-byline' . $cb_woocommerce . '{ font-family:' . $cb_header_font . ' }' . $cb_p_font_output . '</style>';
        return $cb_return;
    }
}

if ( ! function_exists( 'cb_font_styler' ) ) {
    function cb_font_styler() {
       $cb_output = cb_fonts();

       echo $cb_output[1];
    }
}
add_action('wp_head', 'cb_font_styler');

/*********************
ADD SEARCH/LOGIN TO MAIN MENU
*********************/
if ( ! function_exists( 'cb_add_extras_main_menu' ) ) {
    function cb_add_extras_main_menu($content, $args) {

       
        $cb_logo_in_nav = ot_get_option('cb_logo_in_nav', 'off');
        $cb_trending = ot_get_option('cb_trending', 'on');
        $cb_menu_output = NULL;

        if ( $cb_logo_in_nav != 'off' ) {

            $cb_logo_in_nav_when = ot_get_option( 'cb_logo_in_nav_when', 'cb-logo-nav-sticky' );
            $cb_logo_nav_url = ot_get_option( 'cb_logo_nav_url', NULL );
            $cb_logo_nav_retina_url = ot_get_option( 'cb_logo_nav_retina_url', NULL );
            $cb_logo_nav_padding = ot_get_option( 'cb_logo_nav_padding', '10' );

            if ( $cb_logo_nav_url != NULL ) {
                $cb_menu_output .= '<li id="cb-nav-logo" class="' . esc_attr( $cb_logo_in_nav_when ) . '-type" style="padding-top: ' . intval( $cb_logo_nav_padding ) . 'px"><a href="' . esc_url( home_url() ) . '"><img src="' . esc_url( $cb_logo_nav_url ) . '" alt="site logo" data-at2x="' . esc_url( $cb_logo_nav_retina_url ) . '" ></a></li>';
            }
        }

        if ( $args->theme_location == 'main' ) {
            if ( $cb_trending != 'off' ) {

                $cb_trending_name = ot_get_option( 'cb_trending_title', NULL );
                if ( $cb_trending_name == NULL ) {
                    $cb_trending_name = __('Trending', 'cubell');
                }
                $cb_trending_icon = cb_get_trending_symbol();
                $cb_trending = '<li id="menu-item-trending" class="cb-trending"><a href="#" id="cb-trend-menu-item" class="cb-trending-item">';
                $cb_trending .= $cb_trending_icon . ' ' . esc_html( $cb_trending_name ) . '</a>';
                $cb_trending .= '<div class="cb-menu-drop cb-mega-menu  cb-bg cb-big-menu">';
                $cb_trending .= '<div id="cb-trending-block" class="cb-mega-trending cb-mega-posts cb-pre-load clearfix">';
                $cb_trending .= '<div class="cb-upper-title"><h2>' . $cb_trending_icon . ' ' . esc_html( $cb_trending_name )  . '</h2><span class="cb-see-all"><a href="#" data-cb-r="cb-1" class="cb-selected cb-trending-op">' . __( 'Now', 'cubell' ) . '</a><a href="#" data-cb-r="cb-2" class="cb-trending-op">' . __( 'Week', 'cubell' ) . '</a><a href="#" data-cb-r="cb-3" class="cb-trending-op">' . __( 'Month', 'cubell' ) . '</a></span></div><ul id="cb-trend-data" class="clearfix">';
                $cb_trending .= cb_get_trend_count();
                $cb_trending .= '</ul></div></div>';
                $cb_trending .= '</li>';
            }
                
            ob_start();
            if ( $cb_trending != 'off' ) {
                echo $cb_trending;
            }

            if ( $cb_logo_in_nav != 'off' )  {
                echo $cb_menu_output;
            }

            $content .=  ob_get_contents();
            ob_end_clean();
        }


        return $content;
    }
}
add_filter('wp_nav_menu_items','cb_add_extras_main_menu', 10, 2);

/*********************
GET TREND COUNT
*********************/
if ( ! function_exists( 'cb_get_trending_symbol' ) ) {
    function cb_get_trending_symbol( ) {

        $cb_symbol = ot_get_option( 'cb_trending_symbol', 'fa-bolt' );
        if ( ( $cb_symbol != 'off' ) && ( $cb_symbol != 'hashtag' ) ) {
            return '<i class="fa ' . ot_get_option( 'cb_trending_symbol', 'fa-bolt' ) . '"></i>';
        } elseif ( $cb_symbol == 'off' ) {
            return;
        } else {
            return '#';
        }
        
    }
}


/*********************
GET TREND COUNT
*********************/
if ( ! function_exists( 'cb_get_trend_count' ) ) {
    function cb_get_trend_count() {
        
        $cb_output = NULL; 
        $i = $j = 1;
                
        if ( function_exists( 'stats_get_csv' ) ) {

            $cb_trending_ca = 'cb-trending-pop';
            if ( ( $cb_qry = get_transient( $cb_trending_ca ) ) === false ) {
                $cb_qry = stats_get_csv( 'postviews', 'days=1&limit=10' );
                set_transient($cb_trending_ca, $cb_qry, 300);  
            }

            foreach ( $cb_qry as $cb_post ) {
                $cb_post_id = $cb_post['post_id'];
                $cb_cats = wp_get_post_categories($cb_post_id);
                if ( empty( $cb_cats ) ) {
                    continue;
                }

                $cb_img = cb_get_thumbnail( '360', '240', $cb_post_id );
                $cb_output .= ' <li class="cb-article-' . $j . ' clearfix"><div class="cb-mask">' . $cb_img . '</div><div class="cb-meta"><span class="cb-post-views">' . cb_get_trending_symbol() . ' ' . $cb_post['views'] . '</span><h2 class="cb-post-title"><a href="' . esc_url( $cb_post['post_permalink'] ) . '">' . $cb_post['post_title'] . '</a></h2></div><span class="cb-countdown">' . $j . '</span><a href="' . esc_url( $cb_post['post_permalink'] ) . '" class="cb-link-overlay"></a></li>';

                if ( $i == 3 ) {
                    break;
                }
                $i++;
                $j++;
            }
            if ( $cb_output == NULL ) {
                $cb_output = '<p>' . __( 'Not enough data yet, please check again later.', 'cubell' ) . '</p>';
            }
            return $cb_output;
            
        } else {
            return __( 'You need to install Jetpack plugin and enable the "Stats" module to be able to use this.', 'cubell' );
        }

        
    }
}

if ( ! function_exists( 'cb_t_a' ) ) {
    function cb_t_a() {
        
        if ( function_exists( 'stats_get_csv' ) ) {

            $cb_range = ( isset( $_GET['cbr'] ) ) ? sanitize_text_field( $_GET['cbr'] ) : 'cb-1';
            $cb_output = NULL; 
            $i = $j = 1;
                    
            if ( $cb_range == 'cb-2' ) {

                $cb_trending_week = 'cb-trending-w-pop';
                if ( ( $cb_qry = get_transient( $cb_trending_week ) ) === false ) {
                    $cb_qry = stats_get_csv( 'postviews', 'days=7&limit=10' );
                    set_transient($cb_trending_week, $cb_qry, 300);  
                }
                
            } elseif ( $cb_range == 'cb-3' ) {

                $cb_trending_month = 'cb-trending-m-pop';
                if ( ( $cb_qry = get_transient( $cb_trending_month ) ) === false ) {
                    $cb_qry = stats_get_csv( 'postviews', 'days=31&limit=10' );
                    set_transient($cb_trending_month, $cb_qry, 300);  
                }
                
            } elseif ( $cb_range == 'cb-1' ) {

                $cb_trending_ca = 'cb-trending-pop';
                if ( ( $cb_qry = get_transient( $cb_trending_ca ) ) === false ) {
                    $cb_qry = stats_get_csv( 'postviews', 'days=2&limit=10' );
                    set_transient($cb_trending_ca, $cb_qry, 300);  
                }

            }         

            foreach ( $cb_qry as $cb_post ) {
                $cb_post_id = $cb_post['post_id'];
                $cb_cats = wp_get_post_categories($cb_post_id);
                if ( empty( $cb_cats ) ) {
                    continue;
                }

                $cb_img = cb_get_thumbnail( '360', '240', $cb_post_id );
                $cb_output .= ' <li class="cb-article-' . $j . ' clearfix"><div class="cb-mask">' . $cb_img . '</div><div class="cb-meta"><span class="cb-post-views">' . cb_get_trending_symbol() . ' ' . $cb_post['views'] . '</span><h2 class="cb-post-title"><a href="' . esc_url( $cb_post['post_permalink'] ) . '">' . $cb_post['post_title'] . '</a></h2></div><span class="cb-countdown">' . $j . '</span><a href="' . esc_url( $cb_post['post_permalink'] ) . '" class="cb-link-overlay"></a></li>';

                if ( $i == 3 ) {
                    break;
                }
                $i++;
                $j++;
            }

            if ( $cb_output == NULL ) {
                $cb_output = '<p>' . __( 'Not enough data yet, please check again later.', 'cubell' ) . '</p>';
            }

            echo $cb_output;

        } else {
            $cb_output = '<span> ' . __( 'You need to install Jetpack plugin and enable the "Stats" module to be able to use this.', 'cubell' ) . '</span>';
            echo $cb_output;
        }

        die();
    }
}

add_action( 'wp_ajax_cb_t_a', 'cb_t_a' );
add_action( 'wp_ajax_nopriv_cb_t_a', 'cb_t_a' );

/*********************
SEARCH
*********************/
if ( ! function_exists( 'cb_s_a' ) ) {
    function cb_s_a() {

        $cb_s = ( isset( $_GET['cbi'] ) ) ? sanitize_text_field( $_GET['cbi'] ) : NULL;
        $cb_cpt_output = cb_get_custom_post_types();
        $cb_args = array( 's' => $cb_s,  'ignore_sticky_posts' => 1, 'post_status' => 'publish', 'post_type' => $cb_cpt_output );
        $cb_qry_latest = new WP_Query( $cb_args );
        $i = 1;

        $cb_mobile = new Mobile_Detect;

        if ( $cb_qry_latest->have_posts() ) {
            $cb_s_qry = 5;

            $cb_post_output = '<div class="cb-results-title cb-ta-center">' . sprintf( _n( 'Found %d result for:', 'Found %d results for:', $cb_qry_latest->found_posts, 'cubell' ), $cb_qry_latest->found_posts ) . ' <span class="cb-s-qry">' . $cb_s . '</span></div>';
            $cb_post_output .= '<ul class="cb-sub-posts clearfix">';
            while ( $cb_qry_latest->have_posts() ) {

                $cb_qry_latest->the_post();
                $cb_post_id = get_the_ID();
                
                
                if ( $cb_mobile->isMobile() && !$cb_mobile->isTablet() ) {
                    $cb_f_i = NULL;
                } else {
                    $cb_f_i = cb_get_thumbnail( '260', '170', $cb_post_id );
                }

                $cb_post_output .= ' <li class="cb-article cb-style-1 cb-article-' . $i . ' cb-img-above-meta clearfix"><div class="cb-mask">' . $cb_f_i . '</div><div class="cb-meta"><h2 class="cb-post-title"><a href="' . esc_url( get_permalink( $cb_post_id ) ) . '">' . get_the_title() . '</a></h2>' . cb_get_byline_date( $cb_post_id ) . '</div></li>';
                $i++;

                if ( $i == 4 ) {
                    break;
                }
            }

            $cb_post_output .= '</ul>';
            $cb_post_output .= '<div class="cb-info cb-ta-center"><a href="' . get_search_link( $cb_s ) . '" id="cb-s-all-results" class="cb-subm cb-submit-form">' . __('See all results', 'cubell') . '</a></div>';

        } else {
            $cb_post_output = '<div class="cb-info cb-ta-center">' . __( 'No results found for:', 'cubell' ) . ' ' . $cb_s . '</div>';
        }

        wp_reset_postdata();
        echo $cb_post_output;

        die();
    }
}

add_action( 'wp_ajax_cb_s_a', 'cb_s_a' );
add_action( 'wp_ajax_nopriv_cb_s_a', 'cb_s_a' );

/*********************
LOAD CUSTOM FOOTER CODE
*********************/
if ( ! function_exists( 'cb_custom_footer_code' ) ) {
    function cb_custom_footer_code() {

            if ( ot_get_option('cb_custom_footer', NULL) != NULL ) { echo ot_get_option('cb_custom_footer', NULL); }
    }
}
add_action('wp_footer', 'cb_custom_footer_code');

/*********************
AJAX PS
*********************/
if ( ! function_exists( 'cb_ajax_post_search' ) ) {
    function cb_ajax_post_search() {
        $args = NULL;
        if ( ! current_user_can( 'edit_post', $args ) ) {
            die();
        }

        global $wpdb;
        $cb_current_string = trim( stripslashes( sanitize_text_field( $_GET['q'] ) ) );
        $cb_cpt_output = cb_get_custom_post_types();

        $cb_featured_qry = array( 's' => $cb_current_string, 'post_type' => $cb_cpt_output, 'posts_per_page' => -1,  'post_status' => 'publish' );
        $cb_qry = new WP_Query( $cb_featured_qry );
        $cb_post_array = array();

        if ( $cb_qry->have_posts() ) {

            $cb_output = wp_list_pluck( $cb_qry->posts, 'post_title' );
            echo join( $cb_output, "\n" );
        }

        wp_die();
    }
}

add_action( 'wp_ajax_cb-ajax-post-search', 'cb_ajax_post_search' );

if ( ! function_exists( 'ot_type_text' ) ) {

  function ot_type_text( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* verify a description */
    $has_desc = $field_desc ? true : false;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-text ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';

      /* description */
      if ( $has_desc ) {
        echo '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>';
      } else {
        echo '';
      }

      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';


        if ( ( esc_attr( $field_class ) ) == 'cb-aj-input' ) {
            echo '<input type="text" name="' . esc_attr( $field_name ) . '" id="cbaj_' . esc_attr( $field_id ) . '" value="" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" placeholder="Add Post" />';
            echo '<input type="text" name="' . esc_attr( $field_name ) . '" id="cbraj_' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '" class="cb-pb-hidden widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" />';

        } else {
            echo '<input type="text" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" />';
        }

      echo '</div>';

    echo '</div>';

  }

}

/*********************
FILE LOCATION CHECK
*********************/
if ( ! function_exists( 'cb_file_location' ) ) {
    function cb_file_location( $cb_file_name ) {

        $cb_file_name_ext = substr( $cb_file_name, -3 );

        if ( $cb_file_name_ext == 'php' ) {

            $cb_get_stylesheet = get_stylesheet_directory();
            $cb_get_template = get_template_directory();

        } else {

            $cb_get_stylesheet = get_stylesheet_directory_uri();
            $cb_get_template = get_template_directory_uri();
        }

        if ( file_exists( trailingslashit( get_stylesheet_directory() ) . $cb_file_name ) ) {

            $cb_file_url = trailingslashit( $cb_get_stylesheet ) . $cb_file_name;
            return $cb_file_url;

        } elseif ( file_exists( trailingslashit( get_template_directory() ) . $cb_file_name ) ) {

            $cb_file_url = trailingslashit( $cb_get_template ) . $cb_file_name;
            return $cb_file_url;
        }        

    }
}

/*********************
VIDEO POST FORMAT OPTIONS
*********************/
if ( ! function_exists( 'cb_ot_meta_box_post_format_video' ) ) {
    function cb_ot_meta_box_post_format_video() { 
        return array(
            'id'        => 'ot-post-format-video',
            'title'     => '15Zine Post Format: Video',
            'desc'      => '',
            'pages'     => 'post',
            'context'   => 'side',
            'priority'  => 'low',
            'fields'    => array(
             array(
                'id'          => 'cb_video_post_select',
                'label'       => '',
                'desc'        => '',
                'std'         => '',
                'section'     => 'option_types',
                'type'        => 'select',
                'rows'        => '1',
                'post_type'   => '',
                'taxonomy'    => '',
                'min_max_step'=> '',
                'class'       => '',
                'condition'   => '',
                'operator'    => 'and',
                'choices'     => array(
                                    array(
                                        'value'       => '0',
                                        'label'       => '-- Video Style - Choose One --',
                                        'src'         => ''
                                      ),
                                      array(
                                        'value'       => '1',
                                        'label'       => 'Replace Featured Image',
                                        'src'         => ''
                                      ),
                                      array(
                                        'value'       => '2',
                                        'label'       => 'Overlay Featured Image with Play button',
                                        'src'         => ''
                                      ),
                                    ),
                ),

            array(
                'id'          => 'cb_video_embed_code_post',
                'label'       => 'Video Embed Code',
                'desc'        => 'Enter the full embed code.',
                'std'         => '',
                'section'     => 'option_types',
                'type'        => 'textarea-simple',
                'rows'        => '1',
                'post_type'   => '',
                'taxonomy'    => '',
                'min_max_step'=> '',
                'class'       => '',
                'condition'   => 'cb_video_post_select:not(0)',
                'operator'    => 'and'
                ),
            )
        );
    }
}
add_filter( 'ot_meta_box_post_format_video', 'cb_ot_meta_box_post_format_video' );

/*********************
GALLERY POST FORMAT OPTIONS
*********************/
if ( ! function_exists( 'cb_ot_meta_box_post_format_gallery' ) ) {
    function cb_ot_meta_box_post_format_gallery() { 
        return array(

            'id'        => 'ot-post-format-gallery',
            'title'     => '15Zine Post Format: Gallery',
            'desc'      => '',
            'pages'     => 'post',
            'context'   => 'side',
            'priority'  => 'low',
            'fields'    => array(

                array(
                    'id'          => 'cb_gallery_post_images',
                    'label'       => '',
                    'desc'        => 'Upload/set images for gallery',
                    'std'         => '',
                    'type'        => 'gallery',
                    'section'     => 'option_types',
                    'rows'        => '',
                    'post_type'   => '',
                    'taxonomy'    => '',
                    'min_max_step'=> '',
                    'class'       => '',
                    'condition'   => '',
                    'operator'    => 'and'
                    ),
                array(
                    'id'          => 'cb_post_gallery_fis_header',
                    'label'       => 'Site Header (Logo + Header Ad area)',
                    'desc'        => 'To maximise the screen for the gallery, you can disable the header for this gallery post (disables logo/header ad area).',
                    'std'         => 'on',
                    'type'        => 'on-off',
                    'section'     => 'option_types',
                    'rows'        => '',
                    'post_type'   => '',
                    'taxonomy'    => '',
                    'min_max_step'=> '',
                    'class'       => '',
                    'condition'   => '',
                    'operator'    => 'or'
                ),
              
            )
        );
    }
}
add_filter( 'ot_meta_box_post_format_gallery', 'cb_ot_meta_box_post_format_gallery' );

/*********************
AUDIO POST FORMAT OPTIONS
*********************/
if ( ! function_exists( 'cb_ot_meta_box_post_format_audio' ) ) {
    function cb_ot_meta_box_post_format_audio() { 

        return array(
            'id'        => 'ot-post-format-audio',
            'title'     => '15Zine Post Format: Audio',
            'desc'      => '',
            'pages'     => 'post',
            'context'   => 'side',
            'priority'  => 'low',
            'fields'    => array(
            array(
                'id'          => 'cb_audio_post_select',
                'label'       => '',
                'desc'        => '',
                'std'         => '',
                'section'     => 'option_types',
                'type'        => 'select',
                'rows'        => '1',
                'post_type'   => '',
                'taxonomy'    => '',
                'min_max_step'=> '',
                'class'       => '',
                'condition'   => '',
                'operator'    => 'and',
                'choices'     => array(
                    array(
                        'value'       => '',
                        'label'       => '-- Choose One --',
                        'src'         => ''
                      ),
                      array(
                        'value'       => 'external',
                        'label'       => 'External',
                        'src'         => ''
                      ),
                      array(
                        'value'       => 'selfhosted',
                        'label'       => 'Self-Hosted',
                        'src'         => ''
                      ),
                    ),
                ),
                array(
                'id'          => 'cb_audio_post_style',
                'label'       => '',
                'desc'        => '',
                'std'         => '',
                'section'     => 'option_types',
                'type'        => 'select',
                'rows'        => '1',
                'post_type'   => '',
                'taxonomy'    => '',
                'min_max_step'=> '',
                'class'       => '',
                'condition'   => '',
                'operator'    => 'and',
                'choices'     => array(
                       array(
                        'value'       => '0',
                        'label'       => '-- Audio Style - Choose One --',
                        'src'         => ''
                      ),
                      array(
                        'value'       => '1',
                        'label'       => 'Replace Featured Image',
                        'src'         => ''
                      ),
                      array(
                        'value'       => '2',
                        'label'       => 'Overlay Featured Image with Play button',
                        'src'         => ''
                      ),
                    ),
                ),
                array(
                    'id'          => 'cb_audio_post_url',
                    'label'       => 'Audio Embed Code',
                    'desc'        => 'To add an audio embed to overlay the featured image, paste the audio embed code here. ',
                    'std'         => '',
                    'section'     => 'option_types',
                    'type'        => 'textarea-simple',
                    'rows'        => '3',
                    'post_type'   => '',
                    'taxonomy'    => '',
                    'min_max_step'=> '',
                    'class'       => '',
                    'condition'   => 'cb_audio_post_select:is(external)',
                    'operator'    => 'and'
                    ),
                array(
                    'id'          => 'cb_audio_post_selfhosted_mp3',
                    'label'       => 'Self Hosted Mp3',
                    'desc'        => 'To add a .mp3 audio file use this option (most compatible filetype)',
                    'std'         => '',
                    'section'     => 'option_types',
                    'type'        => 'upload',
                    'rows'        => '1',
                    'post_type'   => '',
                    'taxonomy'    => '',
                    'min_max_step'=> '',
                    'class'       => '',
                    'condition'   => 'cb_audio_post_select:is(selfhosted)',
                    'operator'    => 'and'
                    ),
                array(
                    'id'          => 'cb_audio_post_selfhosted_ogg',
                    'label'       => 'Self Hosted OGG file',
                    'desc'        => 'To add a .ogg audio file use this option',
                    'std'         => '',
                    'section'     => 'option_types',
                    'type'        => 'upload',
                    'rows'        => '1',
                    'post_type'   => '',
                    'taxonomy'    => '',
                    'min_max_step'=> '',
                    'class'       => '',
                    'condition'   => 'cb_audio_post_select:is(selfhosted)',
                    'operator'    => 'and'
                    ),
            )
        );
    }
}
add_filter( 'ot_meta_box_post_format_audio', 'cb_ot_meta_box_post_format_audio' );

/*********************
ADMIN IMAGES URL
*********************/
if ( ! function_exists( 'cb_ot_type_radio_image_src' ) ) {
    function cb_ot_type_radio_image_src( $src ) { 
        return   get_template_directory_uri()  . '/library/admin/images' . $src; 
    }
}
add_filter( 'ot_type_radio_image_src', 'cb_ot_type_radio_image_src' );

/*********************
INSERT TEXT
*********************/
if ( ! function_exists( 'cb_ot_upload_text' ) ) {
    function cb_ot_upload_text() { 
        return 'Insert'; 
    }
}
add_filter( 'ot_upload_text', 'cb_ot_upload_text' );

/*********************
OT VERSION
*********************/
if ( ! function_exists( 'cb_ot_header_version_text' ) ) {
    function cb_ot_header_version_text() { 
        return ''; 
    }
}
add_filter( 'ot_header_version_text', 'cb_ot_header_version_text' );

/*********************
ADMIN LOGO
*********************/
if ( ! function_exists( 'cb_ot_header_logo_link' ) ) {
    function cb_ot_header_logo_link() { 
        return '<img src="' .  get_template_directory_uri()  . '/library/admin/images/logo.png">';
    }
}
add_filter( 'ot_header_logo_link', 'cb_ot_header_logo_link' );

/*********************
ADMIN OT CSS
*********************/
if ( ! function_exists( 'cb_ot_css' ) ) {
    function cb_ot_css($hook) {

        global $wp_styles;
        wp_register_style( 'cb-admin-css',   get_template_directory_uri() . '/library/admin/css/cb-admin.css', array(), '' );
        wp_enqueue_style('cb-admin-css'); // enqueue it
        $wp_styles->add_data( 'cb-admin-css', 'rtl', true );
    }
}

add_action( 'ot_admin_styles_after', 'cb_ot_css' );

/*********************
GET CUSTOM POST TYPES
*********************/
if ( ! function_exists( 'cb_get_custom_post_types' ) ) {

    function cb_get_custom_post_types() {

        $cb_cpt_list = ot_get_option( 'cb_cpt', NULL );

        $cb_cpt_output = array( 'post' );

        if ( $cb_cpt_list != NULL ) {
            $cb_cpt = explode(',', str_replace(' ', '', $cb_cpt_list ) );

            foreach ( $cb_cpt as $cb_cpt_single ) {
                $cb_cpt_output[] = $cb_cpt_single;
            }
        }

        return $cb_cpt_output;
    }

}

/*********************
DROPCAP
*********************/
if ( ! function_exists( 'cb_get_dropcap' ) ) {
    function cb_get_dropcap( $cb_post_id ) {
        if ( get_post_meta( $cb_post_id, '_cb_first_dropcap', true ) == 'on' ) {
            return ' cb-first-drop';
        } else {
            return NULL;
        }
    }
}

/*********************
GET CATEGORY COLOR
*********************/
if ( ! function_exists( 'cb_get_cat_color' ) ) {
    function cb_get_cat_color( $cb_post_id ) {

        $cb_cat_id_current = get_the_category( $cb_post_id );
        $cb_cat_parent = $cb_cat_id_current[0]->category_parent;
        $cb_category_color = NULL;

        if ( function_exists( 'get_tax_meta' ) ) {
            $cb_cat_id_current =$cb_cat_id_current[0]->term_id;
            $cb_category_color = get_tax_meta( $cb_cat_id_current, 'cb_color_field_id' );
        }

        if ( ( $cb_category_color == NULL ) || ( $cb_category_color == '#' ) ) {
            if ( $cb_cat_parent != '0' ) {
                
                if ( function_exists( 'get_tax_meta' ) ) {
                    $cb_category_color = get_tax_meta( $cb_cat_parent, 'cb_color_field_id' );

                }
            }
        }

        if ( ( $cb_category_color == NULL ) ||  ( $cb_category_color == '#' ) ) {
            $cb_category_color =  ot_get_option( 'cb_base_color', '#222' );
        }

        return $cb_category_color;
    }
}

/*********************
IMG BG COLOR
*********************/
if ( ! function_exists( 'cb_img_bg_color' ) ) {
    function cb_img_bg_color( $cb_post_id ) {

        echo cb_get_img_bg_color( $cb_post_id );
    }
}

/*********************
GET IMG BG COLOR
*********************/
if ( ! function_exists( 'cb_get_img_bg_color' ) ) {
    function cb_get_img_bg_color( $cb_post_id ) {

        return 'style="background-color: ' . cb_get_cat_color( $cb_post_id ) . ';"';
    }
}

/*********************
FEATURED IMAGE THUMBNAILS
*********************/
if ( ! function_exists( 'cb_thumbnail' ) ) {
    function cb_thumbnail( $width, $height, $cb_post_id = NULL ) {
        echo cb_get_thumbnail( $width, $height, $cb_post_id );
    }
}

/*********************
GET FEATURED IMAGE THUMBNAILS
*********************/
if ( ! function_exists( 'cb_get_thumbnail' ) ) {
    function cb_get_thumbnail( $width, $height, $cb_post_id = NULL, $cb_link = true ) {

        $cb_output = NULL;

        if  ( ( has_post_thumbnail( $cb_post_id ) ) && ( get_the_post_thumbnail( $cb_post_id ) != NULL ) ) {
            if ( $cb_link == true ) {
                $cb_output = '<a href="' . get_permalink( $cb_post_id ) . '">';
            }
            
            $cb_output .= get_the_post_thumbnail( $cb_post_id, 'cb-' . $width . '-' . $height ); 

            if ( $cb_link == true ) {
                $cb_output .= '</a>';
            }          

        } else {

            if ( $cb_link == true ) {
                $cb_output = '<a href="' . get_permalink( $cb_post_id ) . '">';
            }
            $cb_thumbnail = cb_file_location( 'library/images/placeholders/placeholder-' . $width . 'x' . $height . '.png' );
            $cb_retina_thumbnail = cb_file_location( 'library/images/placeholders/placeholder-' . $width . 'x' . $height . '@2x.png' );
            $cb_output .= '<img src="' . esc_url( $cb_thumbnail ) . '" alt="article placeholder" data-at2x="' . esc_url( $cb_retina_thumbnail ) . '" class="cb-placeholder-img">';
            if ( $cb_link == true ) {
                $cb_output .= '</a>';
            }
        }
        
        return $cb_output;
    }
}

/*********************
FEATURED IMAGE THUMBNAILS URL
*********************/
if ( ! function_exists( 'cb_thumbnail_url' ) ) {
    function cb_thumbnail_url( $width, $height, $cb_post_id = NULL ) {
        echo cb_get_thumbnail_url( $width, $height, $cb_post_id );
    }
}

/*********************
GET FEATURED IMAGE THUMBNAILS URL
*********************/
if ( ! function_exists( 'cb_get_thumbnail_url' ) ) {
    function cb_get_thumbnail_url( $width, $height, $cb_post_id = NULL ) {

        $cb_output = NULL;

        if  ( has_post_thumbnail( $cb_post_id ) ) {
            if ( $width == 'full' ) {
                $cb_dimensions = 'full';
            } else {
                $cb_dimensions = 'cb-' . $width . '-' . $height;
            }

            $cb_output = wp_get_attachment_image_src( get_post_thumbnail_id( $cb_post_id ), $cb_dimensions );

        } else {
            if ( $width == 'full' ) {
                $width = 1400;
                $height = 600;
            }
            $cb_thumbnail = cb_file_location( 'library/images/placeholders/placeholder-' . $width . 'x' . $height . '.png' );
            $cb_retina_thumbnail = cb_file_location( 'library/images/placeholders/placeholder-' . $width . 'x' . $height . '@2x.png' );
            $cb_output = array( '0' => esc_url( $cb_thumbnail ), 'featured_image_url' => esc_url( $cb_thumbnail ), 'featured_image_url_retina' => esc_url( $cb_retina_thumbnail ) );
        }
        
        return $cb_output;
    }
}


/*********************
CLEAN BYLINE
*********************/
if ( ! function_exists( 'cb_byline' ) ) {
    function cb_byline( $cb_post_id, $cb_cat = NULL, $cb_is_post = NULL, $cb_views_on = NULL ) {
        echo cb_get_byline( $cb_post_id, $cb_cat = NULL, $cb_is_post = NULL, $cb_views_on = NULL );
    }
}

/*********************
CLEAN BYLINE
*********************/
if ( ! function_exists( 'cb_get_byline' ) ) {
    function cb_get_byline( $cb_post_id, $cb_cat = NULL, $cb_is_post = NULL, $cb_views_on = NULL ) {

        $cb_meta_onoff = ot_get_option('cb_meta_onoff', 'on');
        $cb_byline_author = ot_get_option('cb_byline_author', 'on');
        $cb_byline_date = ot_get_option('cb_byline_date', 'on');
        $cb_post_meta_views = ot_get_option('cb_byline_postviews', 'on');
        $cb_byline_sep = '<span class="cb-separator">' . ot_get_option('cb_byline_separator', '<i class="fa fa-times"></i>') . '</span>';
        $cb_byline = $cb_date = $cb_author = $cb_cat_output = $cb_author_avatar = $cb_views_output = NULL;
        $cb_post_meta_category = ot_get_option('cb_byline_category', 'on');
        
        if ( $cb_byline_author != 'off' ) {

            if ( $cb_is_post == true ) {
                $cb_author_avatar = apply_filters( 'cb_byline_avatar', get_avatar( get_post_field( 'post_author', $cb_post_id ), 20  ), $cb_post_id );
            }

            if ( function_exists( 'coauthors_posts_links' ) ) {
                $cb_author = apply_filters( 'cb_byline_coauthors', '<span class="cb-author"> ' . coauthors_posts_links( null, null, $cb_author_avatar, null, false ) . '</span>', $cb_author_avatar );
            } else {
               $cb_author =  apply_filters( 'cb_byline_author', '<span class="cb-author"> <a href="' . esc_url( get_author_posts_url( get_post_field( 'post_author', $cb_post_id ) ) ) . '">' . $cb_author_avatar . get_the_author_meta( 'display_name', get_post_field( 'post_author', $cb_post_id ) ) . '</a></span>', $cb_post_id, $cb_author_avatar );
            }

            if ( $cb_byline_date != 'off' ) {
                $cb_author .= $cb_byline_sep;
            }
        }

        if ( $cb_byline_date != 'off' ) {

            $cb_date = apply_filters( 'cb_byline_date', '<span class="cb-date"><time class="updated" datetime="' . get_the_time('Y-m-d', $cb_post_id) . '">' . date_i18n( get_option('date_format'), strtotime(get_the_time("Y-m-d", $cb_post_id )) ) . '</time></span>', $cb_post_id );

        }

        if  ( $cb_cat != NULL ) {

             if ( $cb_post_meta_category != 'off' ) {

                $cb_cats = get_the_category( $cb_post_id );

                if ( isset( $cb_cats ) ) {

                    foreach( $cb_cats as $cb_cat => $cb_current_cat ) {

                        if ( ( $cb_byline_date != 'off' ) || ( $cb_byline_author != 'off' ) ) {
                            $cb_cat_output .= $cb_byline_sep;
                        }

                        $cb_cat_output .= apply_filters( 'cb_byline_category', '<span class="cb-category cb-element"><a href="' .  esc_url( get_category_link( $cb_current_cat->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", "cubell" ), $cb_current_cat->name ) ) . '">' . $cb_current_cat->cat_name . '</a></span>', $cb_current_cat );
                    }
                }

            }
        }

        if ( $cb_views_on != NULL ) {
            if ( $cb_post_meta_views != 'off' ) {
                $cb_view_count = cb_get_post_viewcount( $cb_post_id );
                
                if ( $cb_view_count != NULL ) {
                    if ( ( $cb_byline_date != 'off' ) || ( $cb_byline_author != 'off' ) || ( $cb_post_meta_category != 'off' ) ) {
                        $cb_views_output .= $cb_byline_sep;
                    }
                    $cb_views_output .=  apply_filters( 'cb_byline_views', '<span class="cb-views cb-element">' . $cb_view_count . '</span>', $cb_view_count );
                }
               
            }    
        }

        if ( ( $cb_meta_onoff == 'on' ) || ( $cb_meta_onoff == 'on_posts' ) ) {
            $cb_byline = '<div class="cb-byline">' . $cb_author . $cb_date . $cb_cat_output . $cb_views_output . '</div>';
        }

        return $cb_byline;
    }
}

/*********************
POST DATE
*********************/
if ( ! function_exists( 'cb_get_byline_date' ) ) {
    function cb_get_byline_date( $cb_post_id ) {

        $cb_date = NULL;
        $cb_byline_date = ot_get_option('cb_byline_date', 'on');
        if ( $cb_byline_date != 'off' ) {

            $cb_date = '<div class="cb-byline cb-byline-short cb-byline-date"><span class="cb-date"><time class="updated" datetime="' . get_the_time('Y-m-d', $cb_post_id) . '">' . date_i18n( get_option('date_format'), strtotime( get_the_time('Y-m-d', $cb_post_id ) ) ) . '</time></span></div>';

        }

        return $cb_date;
    }
}


/*********************
REVIEW META
*********************/
if ( ! function_exists( 'cb_review_byline' ) ) {
    function cb_review_byline( $cb_post_id ) {
        echo cb_get_review_byline( $cb_post_id );
    }
}

/*********************
REVIEW META
*********************/
if ( ! function_exists( 'cb_get_review_byline' ) ) {
    function cb_get_review_byline( $cb_post_id ) {        

        $cb_output = '<div class="cb-byline cb-byline-short cb-byline-review cb-byline-date">';
        $cb_byline_date = ot_get_option('cb_byline_date', 'on');
        $cb_review_final_score = $cb_category_color = NULL;

        if ( $cb_byline_date != 'off' ) {

            $cb_output .= '<span class="cb-date"><time class="updated" datetime="' . get_the_time('Y-m-d', $cb_post_id) . '">' . date_i18n( get_option('date_format'), strtotime( get_the_time('Y-m-d', $cb_post_id ) ) ) . '</time></span>';

        }

        $cb_review_checkbox = get_post_meta( $cb_post_id, 'cb_review_checkbox', true );

        if ( ( $cb_review_checkbox == 'on' ) || ( $cb_review_checkbox == '1' ) ) {

            $cb_category_color = cb_get_cat_color( $cb_post_id );
            $cb_review_type = get_post_meta($cb_post_id, 'cb_user_score', 'cb-both' );
            $cb_score_display_type = get_post_meta($cb_post_id, 'cb_score_display_type', true );
            $cb_user_score = get_post_meta( $cb_post_id, 'cb_user_score_output', true);
            $cb_final_score = get_post_meta($cb_post_id, 'cb_final_score', true );
            $cb_final_score_override = get_post_meta($cb_post_id, 'cb_final_score_override', true );

            if ( $cb_final_score_override != NULL ) {
               $cb_final_score = $cb_final_score_override;
            }
            
            if ( $cb_review_type == 'cb-readers' ) {
                $cb_final_score = $cb_user_score;
            }

            $cb_review_final_score = intval($cb_final_score);

            if ( $cb_score_display_type == 'percentage' ) {
                $cb_score_output = $cb_review_final_score . '<span class="cb-percent-sign">%</span>';
            }

            if ( $cb_score_display_type == 'points' ) {
                $cb_score_output = $cb_review_final_score / 10;
            }

            if ( $cb_score_display_type == 'stars' ) {
                $cb_score_output = number_format( ( $cb_review_final_score / 20 ), 1);
            }


            $cb_output .= '<span class="cb-score">' . $cb_score_output . '</span>';
        }

        $cb_output .= '<div class="cb-score-bar"><span class="cb-score-overlay" style="width: ' . $cb_review_final_score .'%; background: ' . $cb_category_color . ';"></span></div>';

        $cb_output .= '</div>';

        return $cb_output;
    }
}

/*********************
POST META
*********************/
if ( ! function_exists( 'cb_post_meta' ) ) {
    function cb_post_meta( $cb_post_id ) {
        echo cb_get_post_meta( $cb_post_id );
    }
}

/*********************
GET POST META 
*********************/
if ( ! function_exists( 'cb_get_post_meta' ) ) {
    function cb_get_post_meta( $cb_post_id ) {

        $cb_comments = $cb_views = $cb_cat_output = NULL;
        $cb_meta_onoff = ot_get_option('cb_meta_onoff', 'on');
        
        if ( $cb_meta_onoff == 'off' ) {
            return;
        }

        $cb_post_meta_category = ot_get_option('cb_byline_category', 'on');
        $cb_post_meta_views = ot_get_option('cb_byline_postviews', 'on');
        $cb_post_meta_comments = ot_get_option('cb_byline_comments', 'on');
        $cb_disqus_code = ot_get_option( 'cb_disqus_shortname', NULL );

        if ( $cb_post_meta_category != 'off' ) {

            $cb_cats = get_the_category($cb_post_id);

            if ( isset( $cb_cats ) ) {

                foreach( $cb_cats as $cb_cat => $cb_val ) {

                    $cb_cat_output .= '<span class="cb-category cb-element"><a href="' .  esc_url( get_category_link( $cb_val->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", "cubell" ), $cb_val->name ) ) . '">' . $cb_val->cat_name . '</a></span>';
                }
            }

        }  

        if ( $cb_post_meta_comments != 'off' ) {
            if ( $cb_disqus_code == NULL ) {
           
               $cb_comments = '<span class="cb-comments cb-element"><a href="' . get_comments_link( $cb_post_id ) . '">' . get_comments_number_text( __( '0 Comments', 'cubell') ) . '</a></span>'; 

            } else {

                $cb_comments = '<span class="cb-comments cb-element"><a href="' . get_permalink( $cb_post_id ) . '#disqus_thread"></a></span>';

            }
        }


        if ( $cb_post_meta_views != 'off' ) {
            $cb_view_count = cb_get_post_viewcount( $cb_post_id );
            if ($cb_view_count != NULL ) {
                $cb_views = '<span class="cb-views cb-element">' . $cb_view_count . '</span>';
            }
           
        }
        

        return '<div class="cb-post-meta">' . $cb_cat_output . $cb_comments . $cb_views . '</div>';

    }
}

/*********************
GET POST VIEW COUNT IN POST
*********************/
if ( ! function_exists( 'cb_get_post_viewcount' ) ) {
    function cb_get_post_viewcount( $cb_post_id, $cb_args = NULL ) {
        
        if ( function_exists( 'stats_get_csv' ) ) {

            if ( $cb_args == NULL ) {
                $cb_args = 'period=month&days=104&post_id=' . $cb_post_id;
                $cb_args = 'days=-1&post_id=' . $cb_post_id; /* CBTEMP */
            }

            $cb_post_stats = 'cb-post-views-t-' . $cb_post_id;

            if ( ( $cb_post_view_count = get_transient( $cb_post_stats ) ) === false ) {
                $cb_post_view_count = stats_get_csv( 'postviews', $cb_args );
                set_transient( $cb_post_stats, $cb_post_view_count, 180 );  
            }

            if ( $cb_post_view_count[0]['views'] != NULL ) {
                return $cb_post_view_count[0]['views'] . ' views';
            } else {
                return '0 views';
            }
            
        } else {
            return NULL;
        }
    }
}

/*********************
BACKEND WALKER
*********************/
if ( ! class_exists( 'cb_walker_backend' ) ) {
    class cb_walker_backend extends Walker_Nav_Menu {

        function start_lvl( &$output, $depth = 0, $args = array() ) {}
        function end_lvl( &$output, $depth = 0, $args = array() ) {}

        function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
            global $_wp_nav_menu_max_depth;
            $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;
  

            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

            ob_start();
            $item_id = esc_attr( $item->ID );
            if ( empty( $item->cbmegamenu[0]) ) {
                $cb_item_megamenu = NULL;
            } else {
                $cb_item_megamenu = esc_attr ( $item->cbmegamenu[0] );
            }
            $removed_args = array(
                'action',
                'customlink-tab',
                'edit-menu-item',
                'menu-item',
                'page-tab',
                '_wpnonce',
            );

            $original_title = '';
            if ( 'taxonomy' == $item->type ) {
                $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
                if ( is_wp_error( $original_title ) )
                    $original_title = false;
            } elseif ( 'post_type' == $item->type ) {
                $original_object = get_post( $item->object_id );
                $original_title = get_the_title( $original_object->ID );
            }

            $classes = array(
                'menu-item menu-item-depth-' . $depth,
                'menu-item-' . esc_attr( $item->object ),
                'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
            );

            $title = $item->title;

            if ( ! empty( $item->_invalid ) ) {
                $classes[] = 'menu-item-invalid';
                /* translators: %s: title of menu item which is invalid */
                $title = sprintf( __( '%s (Invalid)' , 'cubell' ), $item->title );
            } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
                $classes[] = 'pending';
                /* translators: %s: title of menu item in draft status */
                $title = sprintf( __('%s (Pending)' , 'cubell'), $item->title );
            }

            $title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

            $submenu_text = '';
            if ( 0 == $depth )
                $submenu_text = 'style="display: none;"';

            ?>
            <li id="menu-item-<?php echo esc_attr( $item_id ); ?>" class="<?php echo implode(' ', $classes ); ?>">
                <dl class="menu-item-bar">
                    <dt class="menu-item-handle">
                        <span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo esc_attr( $submenu_text ); ?>>sub item</span></span>
                        <span class="item-controls">
                            <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                            <span class="item-order hide-if-js">
                                <a href="<?php
                                    echo wp_nonce_url(
                                        add_query_arg(
                                            array(
                                                'action' => 'move-up-menu-item',
                                                'menu-item' => $item_id,
                                            ),
                                            remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                        ),
                                        'move-menu_item'
                                    );
                                ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up'); ?>">&#8593;</abbr></a>
                                |
                                <a href="<?php
                                    echo wp_nonce_url(
                                        add_query_arg(
                                            array(
                                                'action' => 'move-down-menu-item',
                                                'menu-item' => $item_id,
                                            ),
                                            remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                        ),
                                        'move-menu_item'
                                    );
                                ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down'); ?>">&#8595;</abbr></a>
                            </span>
                            <a class="item-edit" id="edit-<?php echo esc_attr( $item_id ); ?>" title="<?php esc_attr_e('Edit Menu Item'); ?>" href="<?php
                                echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
                            ?>"><?php _e( 'Edit Menu Item', 'cubell' ); ?></a>
                        </span>
                    </dt>
                </dl>

                <div class="menu-item-settings" id="menu-item-settings-<?php echo esc_attr( $item_id ); ?>">
                    <?php if( 'custom' == $item->type ) : ?>
                        <p class="field-url description description-wide">
                            <label for="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>">
                                <?php _e( 'URL', 'cubell' ); ?><br />
                                <input type="text" id="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                            </label>
                        </p>
                    <?php endif; ?>
                    <p class="description description-thin">
                        <label for="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>">
                            <?php _e( 'Navigation Label', 'cubell' ); ?><br />
                            <input type="text" id="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                        </label>
                    </p>
                    <p class="description description-thin">
                        <label for="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>">
                            <?php _e( 'Title Attribute', 'cubell' ); ?><br />
                            <input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                        </label>
                    </p>
                    <p class="field-link-target description">
                        <label for="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>">
                            <input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr( $item_id ); ?>]"<?php checked( $item->target, '_blank' ); ?> />
                            <?php _e( 'Open link in a new window/tab', 'cubell' ); ?>
                        </label>
                    </p>
                    <p class="field-css-classes description description-thin">
                        <label for="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>">
                            <?php _e( 'CSS Classes (optional)', 'cubell' ); ?><br />
                            <input type="text" id="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                        </label>
                    </p>
                    <p class="field-xfn description description-thin">
                        <label for="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>">
                            <?php _e( 'Link Relationship (XFN)', 'cubell' ); ?><br />
                            <input type="text" id="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                        </label>
                    </p>
                    <p class="field-cbmegamenu description description-thin">
                         <label for="edit-menu-item-cbmegamenu-<?php echo esc_attr( $item_id ); ?>">15Zine Megamenu Type</label>
                         <select id="edit-menu-item-cbmegamenu-<?php echo esc_attr( $item_id ); ?>" name="menu-item-cbmegamenu[<?php echo esc_attr( $item_id ); ?>]">
                            <option value="1" <?php if ( ( $cb_item_megamenu == '1' ) || ( $cb_item_megamenu == NULL ) ) echo 'selected="selected"'; ?>>Normal Menu</option>
                            <?php if ( $item->object == 'category' ) { ?>
                                <option value="3" <?php if ( $cb_item_megamenu == '3' ) echo 'selected="selected"'; ?>>15Zine Category/Posts Megamenu</option>
                           <?php } ?>
                           <option value="2" <?php if ( $cb_item_megamenu == '2' ) echo 'selected="selected"'; ?>>15Zine Text Columns Megamenu</option>
                         </select>
                    </p>
                    <p class="field-description description description-wide">
                        <label for="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>">
                            <?php _e( 'Description', 'cubell' ); ?><br />
                            <textarea id="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr( $item_id ); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                            <span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it. ', 'cubell'); ?></span>
                        </label>
                    </p>

                    <p class="field-move hide-if-no-js description description-wide">
                        <label>
                            <span><?php _e( 'Move', 'cubell' ); ?></span>
                            <a href="#" class="menus-move-up"><?php _e( 'Up one', 'cubell' ); ?></a>
                            <a href="#" class="menus-move-down"><?php _e( 'Down one', 'cubell' ); ?></a>
                            <a href="#" class="menus-move-left"></a>
                            <a href="#" class="menus-move-right"></a>
                            <a href="#" class="menus-move-top"><?php _e( 'To the top', 'cubell' ); ?></a>
                        </label>
                    </p>

                    <div class="menu-item-actions description-wide submitbox">
                        <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
                            <p class="link-to-original">
                                <?php printf( __('Original: %s', 'cubell'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                            </p>
                        <?php endif; ?>
                        <a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr( $item_id ); ?>" href="<?php
                        echo wp_nonce_url(
                            add_query_arg(
                                array(
                                    'action' => 'delete-menu-item',
                                    'menu-item' => $item_id,
                                ),
                                admin_url( 'nav-menus.php' )
                            ),
                            'delete-menu_item_' . $item_id
                        ); ?>"><?php _e( 'Remove', 'cubell' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo esc_attr( $item_id ); ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
                            ?>#menu-item-settings-<?php echo esc_attr( $item_id ); ?>"><?php _e('Cancel' , 'cubell'); ?></a>
                    </div>

                    <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item_id ); ?>" />
                    <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
                    <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
                    <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
                    <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
                    <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
                </div><!-- .menu-item-settings-->
                <ul class="menu-item-transport"></ul>
            <?php
            $output .= ob_get_clean();
        }


    }
}

if ( ! function_exists( 'cb_megamenu_walker' ) ) {
    function cb_megamenu_walker($walker) {
        if ( $walker === 'Walker_Nav_Menu_Edit' ) {
            $walker = 'cb_walker_backend';
        }
       return $walker;
    }
}
add_filter( 'wp_edit_nav_menu_walker', 'cb_megamenu_walker');

if ( ! function_exists( 'cb_megamenu_walker_save' ) ) {
    function cb_megamenu_walker_save($menu_id, $menu_item_db_id) {

        if  ( isset($_POST['menu-item-cbmegamenu'][$menu_item_db_id]) ) {
                update_post_meta( $menu_item_db_id, '_menu_item_cbmegamenu', $_POST['menu-item-cbmegamenu'][$menu_item_db_id]);
        } else {
            update_post_meta( $menu_item_db_id, '_menu_item_cbmegamenu', '1' );
        }
    }
}
add_action( 'wp_update_nav_menu_item', 'cb_megamenu_walker_save', 10, 2 );

if ( ! function_exists( 'cb_megamenu_walker_loader' ) ) {
    function cb_megamenu_walker_loader($menu_item) {
            $menu_item->cbmegamenu = get_post_meta($menu_item->ID, '_menu_item_cbmegamenu', true);
            return $menu_item;
     }
}
add_filter( 'wp_setup_nav_menu_item', 'cb_megamenu_walker_loader' );

/*********************
MEGA WALKER CLASS
*********************/
if ( ! function_exists( 'cb_menu_children' ) ) {
    function cb_menu_children ($object){

        $cb_with_children = array();

        foreach ( $object as $menu ) {

            $cb_current_obj = $menu->menu_item_parent;

            if ( $cb_current_obj != '0' ) {
                $cb_with_children[] .= $menu->menu_item_parent;
            }
        }

        foreach ( $object as $menu ) {

            $cb_current_obj = $menu->ID;

            if ( in_array( $cb_current_obj, $cb_with_children ) ) {
                $menu->classes[] = "cb-has-children";
            }
        }
        return $object;
    }
}
add_filter( 'wp_nav_menu_objects', 'cb_menu_children' );

if ( ! class_exists( 'cb_mega_walker' ) ) {
    class cb_mega_walker extends Walker_Nav_Menu {
        protected $cb_menu_css = array();

        function start_el( &$output, $object, $depth = 0, $args = array(), $id = 0 ) {

            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
            $classes = empty( $object->classes ) ? array() : (array) $object->classes;
            $classes[] = 'menu-item-' . $object->ID;
            /**
             * Filter the CSS class(es) applied to a menu item's <li>.
             *
             * @since 3.0.0
             *
             * @see wp_nav_menu()
             *
             * @param array  $classes The CSS classes that are applied to the menu item's <li>.
             * @param object $item    The current menu item.
             * @param array  $args    An array of wp_nav_menu() arguments.
             */
            $class_names = join( ' ', (array) apply_filters( 'nav_menu_css_class', array_filter( $classes ), $object, $args ) );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
            /**
             * Filter the ID applied to a menu item's <li>.
             *
             * @since 3.0.1
             *
             * @see wp_nav_menu()
             *
             * @param string $menu_id The ID that is applied to the menu item's <li>.
             * @param object $object    The current menu item.
             * @param array  $args    An array of wp_nav_menu() arguments.
             */
            $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $object->ID, $object, $args );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
            $output .= $indent . '<li' . $id . $class_names .'>';
            $atts = array();
            $atts['title']  = ! empty( $object->attr_title ) ? $object->attr_title : '';
            $atts['target'] = ! empty( $object->target )     ? $object->target     : '';
            $atts['rel']    = ! empty( $object->xfn )        ? $object->xfn        : '';
            $atts['href']   = ! empty( $object->url )        ? $object->url        : '';
            /**
             * Filter the HTML attributes applied to a menu item's <a>.
             *
             * @since 3.6.0
             *
             * @see wp_nav_menu()
             *
             * @param array $atts {
             *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
             *
             *     @type string $title  Title attribute.
             *     @type string $target Target attribute.
             *     @type string $rel    The rel attribute.
             *     @type string $href   The href attribute.
             * }
             * @param object $item The current menu item.
             * @param array  $args An array of wp_nav_menu() arguments.
             */
            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $object, $args );
            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( ! empty( $value ) ) {
                    $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }       

            $cb_cat_menu = $object->cbmegamenu;
            if ( $depth > 0 ) {

                if ( ot_get_option( 'cb_ajax_mm', 'on' ) == 'on' ) {
                    $attributes .= ' data-cb-c="' . $object->object_id . '" class="cb-c-l"';
                }
                
            }

            if ( $cb_cat_menu == NULL ) {
                $cb_cat_menu = '2';
            }

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before . apply_filters( 'the_title', $object->title, $object->ID ) . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $object, $depth, $args );

            $cb_base_color = ot_get_option('cb_base_color', '#f2c231');
            
            if ( function_exists( 'get_tax_meta' ) ) {
                $cb_use_color = get_tax_meta( $object->object_id,'cb_color_field_id' );
            } else {
                $cb_use_color = $cb_base_color;
            }

            $cb_output = $cb_featured_plus_four = $cb_posts = $cb_menu_featured = $cb_slider_output = $cb_has_children = NULL;
            $cb_current_type = $object->object;
            $cb_current_classes = $object->classes;

            if ( in_array('cb-has-children', $cb_current_classes) ) { 
                $cb_has_children = ' cb-with-sub'; 
            }

            if ( ( ( $cb_cat_menu == 3 ) || ( $cb_cat_menu == 4 ) ) && ( $object->menu_item_parent == '0' ) ) { $output .= '<div class="cb-menu-drop cb-bg cb-mega-menu cb-big-menu clearfix">'; }
            if ( ( $cb_cat_menu == 1 ) && ( $depth == 0 ) && ( $object->menu_item_parent == '0' ) && ( in_array('cb-has-children', $cb_current_classes) ) ) { $output .= '<div class="cb-links-menu cb-menu-drop">'; }
            if ( ( $cb_cat_menu == 2 ) && ( $object->menu_item_parent == '0' ) ) { $output .= '<div class="cb-menu-drop cb-bg cb-mega-menu cb-mega-menu-columns">'; }
            if ( ( $cb_cat_menu == 3 ) && ( $object->menu_item_parent == '0' ) ) {

                $cb_cat_id = $object->object_id;
                $cb_category_color =  NULL;

                $cb_posts .= '<div class="cb-upper-title"><h2>' . $object->title . '</h2><a href="' . $object->url . '" class="cb-see-all">' . __( 'See all', 'cubell' ) . '</a></div><ul class="cb-sub-posts">';

                if ( function_exists( 'get_tax_meta' ) ) { $cb_category_color = get_tax_meta( $cb_cat_id, 'cb_color_field_id' ); }
                if ( ( $cb_category_color == NULL ) || ( $cb_category_color == '#' ) ) { $cb_category_color = $cb_base_color; }

                $cb_cpt_output = cb_get_custom_post_types();

                if ( $cb_has_children == NULL ) {
                    $cb_mega_classes = 'cb-mega-three cb-mega-posts ';
                    $cb_width = '360';
                    $cb_height = '240';
                    $cb_closer = '</div>';
                    
                } else {
                    $cb_mega_classes = 'cb-sub-mega-three cb-pre-load cb-mega-posts ';
                    $cb_width = '260';
                    $cb_height = '170';
                    $cb_closer = NULL;
                }

                $cb_args = array( 'cat' => $cb_cat_id,  'post_status' => 'publish',  'posts_per_page' => 3,  'ignore_sticky_posts'=> 1 );
                $cb_qry_latest = new WP_Query($cb_args);
                $i = 1;
                $cb_post_output = NULL;

                while ( $cb_qry_latest->have_posts() ) {

                    $cb_qry_latest->the_post();
                    $cb_post_id = get_the_ID();

                    $cb_posts .= ' <li class="' . implode( " ", get_post_class( "cb-article-" . $i . " cb-style-1 clearfix" ) ) . '"><div class="cb-mask cb-img-fw" ' . cb_get_img_bg_color( $cb_post_id ) . '>' . cb_get_thumbnail( $cb_width, $cb_height, $cb_post_id) . '</div><div class="cb-meta"><h2 class="cb-post-title"><a href="' . esc_url( get_permalink( $cb_post_id ) ) . '">' . get_the_title() . '</a></h2>' . cb_get_byline_date( $cb_post_id ) . '</div></li>';
                    $i++;
                }
                wp_reset_postdata();

                $cb_posts .= '</ul>';
            }

            if ( $object->menu_item_parent == '0' ) {

                if ( $cb_current_type == 'category' ) {

                    if ( $cb_use_color != NULL ) {
                        $this->cb_menu_css[] .= '.cb-mm-on #cb-nav-bar .cb-main-nav .menu-item-' . $object->ID . ':hover, .cb-mm-on #cb-nav-bar .cb-main-nav .menu-item-' . $object->ID . ':focus { background:' . $cb_use_color . ' !important ; }';
                        $this->cb_menu_css[] .= '.cb-mm-on #cb-nav-bar .cb-main-nav .menu-item-' . $object->ID . ' .cb-big-menu { border-top-color: ' . $cb_use_color . '; }';
                    }
                } else {

                    $cb_page_color = get_post_meta( $object->object_id, 'cb_overall_color_post' );
                    if ( ( $cb_page_color != NULL ) && ( $cb_page_color[0] != '#' ) ) {  
                        $this->cb_menu_css[] .= '.cb-mm-on #cb-nav-bar .cb-main-nav .menu-item-' . $object->ID . ':hover, .cb-mm-on #cb-nav-bar .cb-main-nav .menu-item-' . $object->ID . ':focus { background:' . $cb_page_color[0] . ' !important  ; }';
                    }
                   
                }
            }

            if ( $cb_posts != NULL ) {
                    
                $output .= '<div class="' . $cb_mega_classes . ' clearfix">' . $cb_posts . '</div>' . $cb_closer;
            }

            add_action( 'wp_head', array( $this, 'cb_menu_css' ) );

        }

        public function cb_menu_css() {
            echo '<style>' . join( "\n", $this->cb_menu_css ) . '</style>';
        }

        function start_lvl( &$output, $depth=0, $args = array() ) {

            if ( $depth > 3 ) { return; }
            if ( $depth == 2 )  { $output .= '<ul class="cb-grandchild-menu cb-great-grandchild-menu cb-sub-bg">'; }
            if ( $depth == 1 )  { $output .= '<ul class="cb-grandchild-menu cb-sub-bg">'; }
            if ( $depth == 0 )  { $output .= '<ul class="cb-sub-menu cb-sub-bg">'; }
        }

        function end_lvl( &$output, $depth=0, $args = array() ) {

            if ( $depth > 3 ) { return; }
            if ( $depth == 0 ) { $output .= '</ul></div>'; }
            if ( $depth == 1 ) { $output .= '</ul>'; }
            if ( $depth == 2 ) { $output .= '</ul>'; }

        }
    }
}

/*********************
BLOG HOMEPAGE PAGINATION WITH OFFSET
*********************/
if ( ! function_exists( 'cb_get_bloghome_offset' ) ) {
    function cb_get_bloghome_offset() {

        $cb_return = NULL;
        $cb_offset = ot_get_option( 'cb_hp_offset', 'off' );

        if ( $cb_offset == 'on' ) {

            $cb_grid_onoff = ot_get_option( 'cb_hp_gridslider', 'cb_full_off' );
            $cb_grid_size = substr( $cb_grid_onoff, - 1);

            if ( is_numeric( $cb_grid_size ) == true ) {
                $cb_return = $cb_grid_size;
            }

            if ( ( $cb_grid_onoff == 's-1' ) || ( $cb_grid_onoff == 's-1fw' ) ) {
                $cb_return = 4;
            }

            if ( $cb_grid_onoff == 's-2' ) {
                $cb_return = 6;
            }

            if ( ( $cb_grid_onoff == 's-3' ) || ( $cb_grid_onoff == 's-5' ) ) {
                $cb_return = 9;
            }
            
        }

        return $cb_return;
    }
}

/*********************
CATEGORY PAGINATION WITH OFFSET
*********************/
if ( ! function_exists( 'cb_category_offset' ) ) {
    function cb_get_category_offset() {

        $cb_return = NULL;

        if ( function_exists( 'get_tax_meta' ) ) {

            $cb_cat_id = get_query_var('cat');
            $cb_offset = get_tax_meta( $cb_cat_id, 'cb_cat_offset' );

            if ( $cb_offset == 'on' ) {

                $cb_grid_onoff = get_tax_meta( $cb_cat_id, 'cb_cat_featured_op' );
                $cb_grid_size = substr( $cb_grid_onoff, - 1);

                if ( is_numeric( $cb_grid_size ) == true ) {
                    $cb_return = $cb_grid_size;
                }

                if ( ( $cb_grid_onoff == 's-1' ) || ( $cb_grid_onoff == 's-2' ) || ( $cb_grid_onoff == 's-1fw' ) ) {
                    $cb_return = 6;
                }

                if ( ( $cb_grid_onoff == 's-3' ) || ( $cb_grid_onoff == 's-5' ) ) {
                    $cb_return = 9;
                }

            }
        }

        return $cb_return;
    }
}


/*********************
PAGINATION WITH OFFSET
*********************/
if ( ! function_exists( 'cb_pagination_offset' ) ) {
    function cb_pagination_offset($found_posts, $query) {

        if ( is_category() ) {

            $cb_grid_size = cb_get_category_offset();
            $found_posts = $found_posts - $cb_grid_size;

        }

        if ( is_home() ) {

            $cb_grid_size = cb_get_bloghome_offset();
            $found_posts = $found_posts - $cb_grid_size;

        }

        return $found_posts ;
    }
}
add_filter('found_posts', 'cb_pagination_offset', 1, 2 );

/*********************
OFFSETTING QUERY VARIABLE['cb_offset_loop']
*********************/
if ( ! function_exists( 'cb_offset_loop_pre_get_posts' ) ) {
    function cb_offset_loop_pre_get_posts( $query ){

        if ( isset( $query->query_vars['cb_offset_loop'] ) && ( $query->query_vars['cb_offset_loop'] == 'on' ) ) {

            if ( is_category() ) { $cb_grid_size = cb_get_category_offset(); }
            if ( is_home() ) { $cb_grid_size = cb_get_bloghome_offset(); }

            $cb_posts_per_page = get_option('posts_per_page');

            if ( $query->is_paged == true ) {

                $cb_page_offset = $cb_grid_size + ( ( $query->query_vars['paged'] - 1 ) * $cb_posts_per_page );
                $query->set( 'offset', $cb_page_offset );

            } else {

                $query->set( 'offset', $cb_grid_size );

            }
        }

         if ( ( is_category() || is_tag() || is_home() ) && $query->is_main_query() && ( ! is_admin() ) ) {

            $cb_cpt_output = cb_get_custom_post_types();
            $query->set( 'post_type', $cb_cpt_output );

        }

        return $query;
    }
}
add_action( 'pre_get_posts', 'cb_offset_loop_pre_get_posts' );

/*********************
ADD QUERY VAR FOR OFFSET WP_QUERY
*********************/
if ( ! function_exists( 'cb_add_query_variable' ) ) {
    function cb_add_query_variable( $query_vars ){

        array_push( $query_vars, 'cb_offset_loop' );
        return $query_vars;

    }
}

add_filter( 'query_vars', 'cb_add_query_variable' );

/*********************
POST FORMAT CHECK
*********************/
if ( ! function_exists( 'cb_post_format_check' ) ) {
    function cb_post_format_check( $cb_post_id ){

        $cb_post_format = get_post_format($cb_post_id);
        $cb_review_checkbox = get_post_meta( $cb_post_id, 'cb_review_checkbox', true );

        if ( $cb_post_format == 'video' ) {

            $cb_post_format_icon = '<div class="cb-media-icon"><a href="' . get_permalink($cb_post_id) . '"><i class="fa fa-play"></i></a></div>';

        } elseif ( $cb_post_format == 'audio' ) {

            $cb_post_format_icon = '<div class="cb-media-icon"><a href="' . get_permalink($cb_post_id) . '"><i class="fa fa-headphones"></i></a></div>';

        } else  {

            $cb_post_format_icon = NULL;

        }

        if ( $cb_review_checkbox == '1' ) {
             $cb_post_format_icon = NULL;
        }

        return $cb_post_format_icon;
    }
}

/*********************
CLEAN EXCERPT
*********************/
if ( ! function_exists( 'cb_clean_excerpt' ) ) {
    function cb_clean_excerpt ($cb_characters, $cb_read_more = false) {
        global $post;
        $cb_excerpt_output = $post->post_excerpt;

        if ( $cb_excerpt_output == NULL ) {

            $cb_excerpt_output = get_the_content();
            $cb_excerpt_output = preg_replace( ' (\[.*?\])', '', $cb_excerpt_output );
            $cb_excerpt_output = strip_shortcodes( $cb_excerpt_output );
            $cb_excerpt_output = strip_tags( $cb_excerpt_output );
            $cb_characters = intval($cb_characters);
            $cb_excerpt_output = substr( $cb_excerpt_output, 0, $cb_characters );
            $cb_excerpt_output = substr( $cb_excerpt_output, 0, strripos( $cb_excerpt_output, ' ' ) );
            $cb_excerpt_output = trim( preg_replace( '/\s+/', ' ', $cb_excerpt_output) );

            if ( $cb_read_more != false ) {
                $cb_excerpt_output = $cb_excerpt_output . '... <a href="' . get_permalink() . '"><span class="cb-read-more"> ' . __( "Read more", "cubell"). '</span></a>';
            } else {
                $cb_excerpt_output = $cb_excerpt_output . '...';
            }
        }

        return $cb_excerpt_output;
    }
}

/*********************
NUMERIC PAGE NAVI
*********************/
if ( ! function_exists( 'cb_page_navi' ) ) {
    function cb_page_navi( $cb_qry = NULL ) {

        $cb_no_more_articles = __( 'No more articles', 'cubell' );
        $cb_load_more_text = __( 'Load More', 'cubell' );
        $cb_pagination_type = 'numbered';

        if ( is_category() ) {
            if ( function_exists('get_tax_meta') ) {
                $cb_cat_id = get_query_var('cat');
                $cb_pagination_type = get_tax_meta( $cb_cat_id, 'cb_cat_infinite' );
            }
        }

        if ( is_home() ) {
            $cb_pagination_type = ot_get_option( 'cb_hp_infinite', 'infinite-load' );
        }

        if ( is_tag() ) {
            if ( function_exists('get_tax_meta') ) {
                $cb_tag_id = get_query_var('tag');
                $cb_pagination_type = get_tax_meta( $cb_tag_id, 'cb_cat_infinite' );
            }
        }

         if ( $cb_qry == NULL ) {
            global $wp_query;
            $cb_total = $GLOBALS['wp_query']->max_num_pages;
            $cb_paged = get_query_var('paged');
        } else {
        
            if ( is_page() ) {
                $cb_total = $cb_qry->max_num_pages;
                $cb_pagination_type = 'n';
                $cb_paged = get_query_var('page');
            } else {
                global $wp_query;
                $cb_paged = get_query_var('paged');
                $cb_total = $GLOBALS['wp_query']->max_num_pages;
            }
            
        }

        if ( $cb_pagination_type == 'infinite-load' ) {

            if ( get_next_posts_link() != NULL ) {
                echo '<nav id="cb-blog-infinite-load" class="cb-pagination-button cb-infinite-scroll cb-infinite-load">' . get_next_posts_link( $cb_load_more_text ) . '</nav>';
            } else {
                echo '<div class="cb-no-more-posts cb-pagination-button cb-infinite-load"><span>' . $cb_no_more_articles . '</span></div>';
            }

        } elseif ( $cb_pagination_type == 'infinite-scroll' ) {

            if (  get_next_posts_link() != NULL ) {

                echo '<nav id="cb-blog-infinite-scroll" class="cb-pagination-button cb-infinite-scroll cb-hidden">' . get_next_posts_link() . '</nav>';
            } else {
                echo '<div class="cb-no-more-posts cb-pagination-button cb-infinite-load"><span>' . $cb_no_more_articles . '</span></div>';
            }

        } else {

            $cb_pagination = paginate_links( array(
                'base'     => str_replace( 99999, '%#%', esc_url( get_pagenum_link(99999) ) ),
                'format'   => '',
                'total'    => $cb_total,
                'current'  => max( 1, $cb_paged ),
                'mid_size' => 2,
                'prev_text' => '<i class="fa fa-long-arrow-left"></i>',
                'next_text' => '<i class="fa fa-long-arrow-right"></i>',
                'type' => 'list',
            ) );

            echo '<nav class="cb-pagination">' . $cb_pagination . '</nav>';
        }
    }
}

/*********************
BLOG STLYE LOOP
*********************/
if ( ! function_exists( 'cb_get_qry' ) ) {

    function cb_get_qry() {

        if ( is_home() || is_category() ) {

            $cb_cpt_output = cb_get_custom_post_types();
            $cb_paged = get_query_var('paged');
            $cb_grid_size = $cb_current_cat = NULL;

            if ( $cb_paged == false ) {
                $cb_paged = 1;
            }

            if ( is_category() ) {
                $cb_current_cat = get_query_var('cat');
                $cb_grid_size = cb_get_category_offset();
            } elseif ( is_home() ) {
                $cb_grid_size = cb_get_bloghome_offset();
            }

            if ( $cb_grid_size != NULL ) {
                $cb_offset_loop = 'on';
            } else {
                $cb_offset_loop = NULL;
            }

            $cb_featured_qry = array( 'post_type' => $cb_cpt_output, 'cat' => $cb_current_cat, 'offset' => $cb_grid_size, 'orderby' => 'date', 'order' => 'DESC',  'post_status' => 'publish', 'cb_offset_loop' => $cb_offset_loop, 'paged' => $cb_paged );
            $cb_qry = new WP_Query( $cb_featured_qry );

        } elseif ( is_page() ) {

            $cb_paged = get_query_var('page');

            if ( $cb_paged == false ) {
                $cb_paged = 1;
            }

            $cb_cpt_output = cb_get_custom_post_types();
            $cb_qry = new WP_Query( array( 'post_type' => $cb_cpt_output, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'paged' => $cb_paged  ) );

        } else {

            global $wp_query;
            $cb_qry = $wp_query;

        }

        return $cb_qry;
    }
}

/*********************
BREADCRUMBS
*********************/
if ( ! function_exists( 'cb_breadcrumbs' ) ) {

    function cb_breadcrumbs() {

        echo cb_get_breadcrumbs();
    }
}

/*********************
BREADCRUMBS
*********************/
if ( ! function_exists( 'cb_get_breadcrumbs' ) ) {

    function cb_get_breadcrumbs() {

        if ( ot_get_option('cb_breadcrumbs', 'on') == 'off' ) {
            return;
        }

        $cb_breadcrumb = NULL;
        $cb_post_type = get_post_type();
        $cb_cpt = cb_get_custom_post_types();

        if ( is_page() ) {

            global $post;
            if ( $post->post_parent == 0 ) {
                return;
            }
        }
        
        
        $cb_breadcrumb = '<div class="cb-breadcrumbs">';
        $cb_icon = '<i class="fa fa-angle-right"></i>';
        $cb_breadcrumb .= '<a href="' . esc_url( home_url() ) . '">' . __("Home", "cubell").'</a>' . $cb_icon;

        if ( is_category() ) {

            $cb_cat_id = get_query_var('cat');
            $cb_current_category = get_category( $cb_cat_id );

            if ( $cb_current_category->category_parent == '0' ) {

                 $cb_breadcrumb .=  '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . get_category_link( $cb_current_category->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", "cubell" ), $cb_current_category->name ) ) . '" itemprop="url"><span itemprop="title">' . $cb_current_category->name . '</span></a></div>';

            } else {

                $cb_breadcrumb .=  '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . get_category_link( $cb_current_category->category_parent ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", "cubell" ), get_the_category_by_ID( $cb_current_category->category_parent ) ) ) . '"><span itemprop="title">' . get_the_category_by_ID( $cb_current_category->category_parent ) . '</span></a></div>' . $cb_icon;
                $cb_breadcrumb .= '<div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . get_category_link( $cb_current_category->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", "cubell" ), $cb_current_category->name ) ) . '" itemprop="url"><span itemprop="title">' . $cb_current_category->name . '</span></a></div>';

            }

        } elseif ( function_exists('buddypress') && ( is_buddypress() ) )  {
            global $bp;
            $cb_bp_output = NULL;
            $cb_bp_current_component = bp_current_component();
            $cb_bp_current_action = bp_current_action();

            if ( ( $cb_bp_current_action != 'my-groups' ) && ( $cb_bp_current_component == 'groups' ) ) {

                $cb_bp_group = $bp->groups->current_group;

                if ( ! is_numeric( $cb_bp_group ) ) {
                    $cb_bp_group_id = $cb_bp_group->id;
                    $cb_bp_group_name = $cb_bp_group->name;
                    $cb_bp_group_link = bp_get_group_permalink($cb_bp_group);
                    $cb_bp_output = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . trailingslashit( bp_get_root_domain() . '/' . bp_get_groups_root_slug() ) . '" itemprop="url"><span itemprop="title">' . __('Groups', 'cubell') . '</span></a></div>' . $cb_icon . $cb_bp_group_name;
                } else {
                    $cb_bp_output =  __('Groups', 'cubell');
                }

                $cb_breadcrumb .=  $cb_bp_output;
            }

            if ( ( $cb_bp_current_component == 'activity' ) || ( $cb_bp_current_action == 'my-groups' ) || ( $cb_bp_current_action == 'public' ) || ( $cb_bp_current_component == 'settings' ) || ( $cb_bp_current_component == 'forums' ) || ( $cb_bp_current_component == 'friends' ) ) {

                if ( isset( $bp->activity->current_id ) ) {
                    $cb_bp_activity = $bp->activity->current_id;
                } else {
                    $cb_bp_activity = NULL;
                }

                $cb_activity_title = get_the_title();
                $cb_bp_activity_link = bp_get_members_directory_permalink();
                $cb_bp_output .=  '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . esc_url( $cb_bp_activity_link ) . '" itemprop="url"><span itemprop="title">' . __('Members', 'cubell') . '</span></a></div>' . $cb_icon . $cb_activity_title;

                if ( $cb_bp_activity != NULL ) {

                    $cb_bp_output .=  __('Members', 'cubell');
                }

                $cb_breadcrumb .=  $cb_bp_output;
            }

            if ( $cb_bp_current_component == 'messages' ) {

                $cb_breadcrumb .=  __('Messages', 'cubell');
            }

            if ( $cb_bp_current_component == 'register' ) {

                $cb_breadcrumb .=  __('Register', 'cubell');
            }

            if ( bp_is_directory() ) {
                $cb_breadcrumb = '<div>';
            }

        } elseif ( ( in_array( $cb_post_type, $cb_cpt ) == true ) || ( $cb_post_type == 'post' ) ) {

            $cb_categories =  get_the_category();

           if ( $cb_categories[0]->category_parent == '0' ) {

               $cb_breadcrumb .=  '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . get_category_link($cb_categories[0]->term_id) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", "cubell" ), $cb_categories[0]->name ) ) . '" itemprop="url"><span itemprop="title">' . $cb_categories[0]->name.'</span></a></div>';

           } else {

                $cb_breadcrumb_output = '<a href="' . get_category_link($cb_categories[0]->category_parent) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", "cubell" ), get_the_category_by_ID($cb_categories[0]->category_parent) ) ) . '" itemprop="url"><span itemprop="title">' . get_the_category_by_ID($cb_categories[0]->category_parent) . '</span></a>' . $cb_icon;

                $cb_breadcrumb_output .= '<a href="' . get_category_link($cb_categories[0]->term_id) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", "cubell" ), $cb_categories[0]->name ) ) . '" itemprop="url"><span itemprop="title">' . $cb_categories[0]->name . '</span></a>';

                $cb_current_cat = get_category($cb_categories[0]->category_parent);

                if ( $cb_current_cat->category_parent != '0' ) {

                    $cb_breadcrumb_output = '<a href="' . get_category_link($cb_current_cat->category_parent) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", "cubell" ), get_the_category_by_ID($cb_current_cat->category_parent) ) ) . '" itemprop="url"><span itemprop="title">' . get_the_category_by_ID($cb_current_cat->category_parent) . '</span></a>' . $cb_icon . $cb_breadcrumb_output;

                    $cb_current_cat = get_category( $cb_current_cat->category_parent );

                    if ( $cb_current_cat->category_parent != '0' ) {

                        $cb_breadcrumb_output = '<a href="' . get_category_link($cb_current_cat->category_parent) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", "cubell" ), get_the_category_by_ID($cb_current_cat->category_parent) ) ) . '" itemprop="url"><span itemprop="title">' . get_the_category_by_ID($cb_current_cat->category_parent) . '</span></a>' . $cb_icon . $cb_breadcrumb_output;

                        $cb_current_cat = get_category( $cb_current_cat->category_parent );

                        if ( $cb_current_cat->category_parent != '0' ) {

                            $cb_breadcrumb_output = '<a href="' . get_category_link($cb_current_cat->category_parent) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", "cubell" ), get_the_category_by_ID($cb_current_cat->category_parent) ) ) . '" itemprop="url"><span itemprop="title">' . get_the_category_by_ID($cb_current_cat->category_parent) . '</span></a>' . $cb_icon . $cb_breadcrumb_output;
                        }
                    }

                }       

                $cb_breadcrumb .=  '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">' . $cb_breadcrumb_output . '</div>';

            }

        } elseif  ( ( class_exists('Woocommerce') )  &&  ( is_woocommerce() ) )  {
            $cb_breadcrumb = NULL;

            woocommerce_breadcrumb( array(
                'delimiter'   =>  $cb_icon,
                'wrap_before' => '<div class="cb-breadcrumbs wrap" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>',
                'wrap_after'  => ' ',
                'before'      => '',
                'after'       => '',
                'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
             ));
        } elseif ( is_page() ) {
            $cb_parent_page = get_post( $post->post_parent );

            $cb_parent_page_title = $cb_parent_page->post_title;
            $cb_breadcrumb .=  '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . get_permalink( $cb_parent_page->ID ) . '"><span itemprop="title">' . $cb_parent_page_title . '</span></a></div>';
        }

        $cb_breadcrumb .= apply_filters( 'cb_breadcrumbs_output', '' );

        $cb_breadcrumb .= '</div>';
        

        return $cb_breadcrumb ;
    }
}

/*********************
BBPRESS BREADCRUMBS
*********************/
if ( ! function_exists( 'cb_bbpress_breadcrumbs' ) ) {
    function cb_bbpress_breadcrumbs () {

        if ( ot_get_option('cb_bbpress_breadcrumbs', 'on') == 'on' ) {
            return false;
        } else {
           return true; 
        }

    }
}
add_filter ('bbp_no_breadcrumb', 'cb_bbpress_breadcrumbs');

/*********************
POST FOOTER AD
*********************/
if ( ! function_exists( 'cb_post_footer_ad' ) ) {
    function cb_post_footer_ad() {

        $cb_ad = ot_get_option('cb_post_footer_ad', NULL);
        if ( $cb_ad != NULL ) {
            echo '<div class="cb-post-large cb-post-footer-block clearfix">' . $cb_ad . '</div>';
        }
        

    }
}


/*********************
SOCIAL SHARING
*********************/
if ( ! function_exists( 'cb_sharing_block' ) ) {
    function cb_sharing_block( $post ) {

        $cb_style = ot_get_option('cb_social_sharing', 'on');

        if ( $cb_style == 'off' ) {
            return;
        }

        $cb_output = $cb_google_flag = $cb_top_bottom = NULL;
        $cb_o_twitter = 'horizontal';
        $cb_o_google = 'medium';
        $cb_o_stumble = '1';
        $cb_o_pinterest = 'beside';
        $cb_o_facebook = 'button_count';
        $cb_title = '<div class="cb-title cb-font-header">' . __('Share On', 'cubell') . '</div>';
        $cb_twitter_url = 'https://twitter.com/share';
        $cb_social_fb = ot_get_option( 'cb_social_fb', 'on' );
        $cb_social_fb_sh = ot_get_option( 'cb_social_fb_share', 'off' );
        $cb_social_tw = ot_get_option( 'cb_social_tw', 'on' );
        $cb_social_go = ot_get_option( 'cb_social_go', 'on' );
        $cb_social_pi = ot_get_option( 'cb_social_pi', 'on' );
        $cb_social_st = ot_get_option( 'cb_social_st', 'off' );

        if ( $cb_style == 'on-big' ) {
            $cb_o_twitter = 'vertical';
            $cb_o_google = 'tall';
            $cb_o_pinterest = 'above';
            $cb_o_facebook = 'box_count';
            $cb_o_stumble = '5';
            $cb_google_flag = 'cb-tall';
            $cb_top_bottom = ' cb-social-top';
        }

        $cb_featured_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
        $cb_encoded_img = urlencode( $cb_featured_image_url[0] );
        $cb_encoded_url = urlencode( get_permalink($post->ID) );
        $cb_encoded_desc = urlencode( get_the_title($post->ID) );
        $cb_site_locale = get_locale();
        $cb_output .= '<div class="cb-social-sharing cb-post-block-bg cb-post-footer-block' . $cb_top_bottom . ' cb-' . $cb_style .' clearfix">';
        $cb_output .= $cb_title . '<div class="cb-sharing-buttons">';

        // Facebook Like Button
        if ( ( $cb_social_fb != 'off' ) || ( $cb_social_fb_sh != 'off' ) ) {

            $cb_output .=  '<div id="fb-root"></div> <script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/' . $cb_site_locale . '/sdk.js#xfbml=1&version=v2.0"; fjs.parentNode.insertBefore(js, fjs); }(document, "script", "facebook-jssdk"));</script>';

            if ( $cb_social_fb_sh != 'off' ) {
                $cb_output .= '<div class="cb-facebook cb-sharing-button"><div class="fb-share-button" data-href="' . get_permalink($post->ID) . '"  data-layout="' . $cb_o_facebook . '"></div></div>';
            }

            if ( $cb_social_fb != 'off' ) {
                $cb_output .= '<div class="cb-facebook cb-sharing-button"><div class="fb-like" data-href="' . get_permalink($post->ID) . '" data-layout="' . $cb_o_facebook . '" data-action="like" data-show-faces="false" data-share="false"></div></div>';
            }
            
        }

        // Pinterest Button
        if ( $cb_social_pi != 'off' ) {
            $cb_output .= '<div class="cb-pinterest cb-sharing-button"><a href="//pinterest.com/pin/create/button/?url=' . $cb_encoded_url . '&media=' . $cb_encoded_img . '&description=' . $cb_encoded_desc . '" data-pin-do="buttonPin" data-pin-config="' . $cb_o_pinterest . '" target="_blank"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_20.png" /></a><script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script></div>';
        }

        // Google+ Button
        if ( $cb_social_go != 'off' ) {
            $cb_output .= '<div class="cb-google cb-sharing-button ' . $cb_google_flag . '"> <div class="g-plusone" data-size="' . $cb_o_google . '"></div> <script type="text/javascript"> (function() {var po = document.createElement("script"); po.type = "text/javascript"; po.async = true; po.src = "https://apis.google.com/js/plusone.js"; var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s); })(); </script></div>';
        }

        // Twitter Button
        if ( $cb_social_tw != 'off' ) {
            $cb_output .= '<div class="cb-twitter cb-sharing-button"><a href="' . esc_url( $cb_twitter_url ) . '" class="twitter-share-button" data-dnt="true"  data-count="' . $cb_o_twitter . '">Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document, "script", "twitter-wjs");</script></div>';
        }

        // StumbleUpon Button
        if ( $cb_social_st != 'off' ) {
            $cb_output .= '<div class="cb-stumbleupon"><su:badge layout="' . $cb_o_stumble . '"></su:badge> <script type="text/javascript"> (function() {var li = document.createElement("script"); li.type = "text/javascript"; li.async = true; li.src = ("https:" == document.location.protocol ? "https:" : "http:") + "//platform.stumbleupon.com/1/widgets.js"; var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(li, s); })(); </script></div>';
        }

        $cb_output .= '</div></div>';

        return $cb_output;
    }
}

/*********************
NEXT/PREVIOUS POST SLIDE IN
*********************/
if ( ! function_exists( 'cb_previous_next_links' ) ) {
    function cb_previous_next_links() {

        if ( ot_get_option('cb_previous_next_onoff', 'on') == 'off' ) {
            return;
        }

        $cb_next_post = get_next_post();
        $cb_previous_post = get_previous_post();

        $cb_next_post_output = $cb_previous_post_output = $cb_output = NULL;

        if ( ( $cb_previous_post != NULL ) || ( $cb_next_post != NULL ) ) {

            $cb_output = '<div id="cb-next-previous-posts" class="cb-next-previous cb-post-block-bg cb-underline-h cb-post-footer-block cb-font-header clearfix">';

            if ( $cb_next_post != NULL ) {

                $cb_next_id = $cb_next_post->ID;
                $cb_next_title = $cb_next_post->post_title;
                $cb_next_permalink = get_permalink( $cb_next_id );
                $cb_next_post_output = '<div class="cb-next-post cb-meta cb-next-previous-block">';
                $cb_next_post_output .= '<div class="cb-arrow"><i class="fa fa-angle-right"></i></div>';
                $cb_next_post_output .= '<span class="cb-read-next-title cb-read-title"><a href="' . esc_url( $cb_next_permalink ) . '">' . __( 'Next Article', 'cubell' ) . '</a></span>';
                $cb_next_post_output .= '<a href="' . esc_url( $cb_next_permalink ) . '" class="cb-next-title cb-title">' . $cb_next_title . '</a>';
                $cb_next_post_output .= '</div>';

            } else {
                $cb_next_post_output = '<div class="cb-next-post cb-next-previous-block cb-empty"><span class="cb-read-previous-title cb-read-title">' . __('No Newer Articles', 'cubell') . '</span></div>';
            }

            if ( $cb_previous_post != NULL ) {

                $cb_previous_id = $cb_previous_post->ID;
                $cb_previous_title = $cb_previous_post->post_title;
                $cb_previous_permalink = get_permalink( $cb_previous_id );
                $cb_previous_post_output = '<div class="cb-previous-post cb-meta cb-next-previous-block">';
                $cb_previous_post_output .= '<div class="cb-arrow"><i class="fa fa-angle-left"></i></div>';
                $cb_previous_post_output .= '<span class="cb-read-previous-title cb-read-title"><a href="' . esc_url( $cb_previous_permalink ) . '">' . __( 'Previous Article', 'cubell' ) . '</a></span>';
                $cb_previous_post_output .= '<a href="' . esc_url( $cb_previous_permalink ) . '" class="cb-previous-title cb-title">' . $cb_previous_title . '</a>';

                $cb_previous_post_output .= '</div>';
            } else {
                $cb_previous_post_output = '<div class="cb-previous-post cb-next-previous-block cb-empty"><span class="cb-read-previous-title cb-read-title">' . __('No Older Articles', 'cubell') . '</span></div>';
            }

            $cb_output .= $cb_previous_post_output . $cb_next_post_output;

            $cb_output .= '</div>';

        }

        echo $cb_output;

    }
}

/*********************
RELATED POSTS FUNCTION
*********************/
if ( ! function_exists( 'cb_related_posts' ) ) {
    function cb_related_posts() {

        if ( ot_get_option( 'cb_related_onoff', 'on' ) == 'off' ) {
            return;
        }

        global $post;
        $cb_post_id = $post->ID;
        $i = 1;
        $cb_slide_el = $cb_slide_el_cl = $cb_stop_at_2 = NULL;
        $cb_related_posts_show = ot_get_option( 'cb_related_posts_show', 'both' );
        $cb_related_posts_order = ot_get_option( 'cb_related_posts_order', 'rand' );
        $cb_related_posts_style = ot_get_option( 'cb_related_posts_style', 'cb_related_posts_slider' );

        if ( $cb_related_posts_style == 'cb_related_posts_slider' ) {
            $cb_related_posts_amount = 8;
            $cb_slide_el = '<div id="cb-related-posts" class="cb-slider-2 cb-slider cb-meta-below">';
            $cb_slide_el_cl = '</div>';
        } else {
            $cb_related_posts_amount = floatval( ot_get_option( 'cb_related_posts_amount', '1' ) * 2 );
        }

        $cb_tags = wp_get_post_tags( $cb_post_id );
        $cb_tag_check = $cb_all_cats = $cb_related_args = $cb_related_posts = NULL;

        if ( ( $cb_related_posts_show == 'both' ) || ( $cb_related_posts_show == 'tags' ) ) {

            if ( $cb_tags != NULL ) {
                foreach ( $cb_tags as $cb_tag ) { $cb_tag_check .= $cb_tag->slug . ','; }
                $cb_related_args = array( 'numberposts' => $cb_related_posts_amount, 'tag' => $cb_tag_check, 'exclude' => $cb_post_id, 'post_status' => 'publish','orderby' => $cb_related_posts_order );
                $cb_related_posts = get_posts( $cb_related_args );
            }

        }          

        if ( ( $cb_related_posts_show == 'both' ) || ( $cb_related_posts_show == 'cats' ) ) {

            if ( $cb_related_posts == NULL ) {
                $cb_categories = get_the_category();
                foreach ( $cb_categories as $cb_category ) { $cb_all_cats .= $cb_category->term_id  . ','; }
                $cb_related_args = array( 'numberposts' => $cb_related_posts_amount, 'category' => $cb_all_cats, 'exclude' => $cb_post_id, 'post_status' => 'publish', 'orderby' => $cb_related_posts_order );
                $cb_related_posts = get_posts( $cb_related_args );
            }

        }  

        if ( $cb_related_posts != NULL ) {
            if ( count( $cb_related_posts ) < 4 ) {
                $cb_slide_el = $cb_slide_el_cl = NULL;
                $cb_stop_at_2 = true;
            }
            echo '<div id="cb-related-posts-block" class="cb-post-footer-block cb-arrows-tr cb-module-block clearfix"><h3 class="cb-title cb-title-header">' . __('Related Posts', 'cubell') . '</h3>' . $cb_slide_el . '<ul class="slides clearfix">';
            foreach ( $cb_related_posts as $post ) {

                if ( $i == 3 ) { 
                    $i = 1; 
                    if ( $cb_stop_at_2 == true ) {
                        break;
                    }
                }

                $cb_post_id = $post->ID;
                setup_postdata( $post );
?>
                <li <?php post_class( 'cb-style-1 clearfix cb-no-' . $i ); ?>>
                    <div class="cb-mask"><?php cb_thumbnail( '360', '240', $post->ID );?></div>
                    <div class="cb-meta">
                        <h4 class="cb-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <?php cb_byline( $cb_post_id ); ?>
                    </div>
                </li>
<?php
                $i++;
            }

            echo '</ul></div>';
            echo $cb_slide_el_cl;
            wp_reset_postdata();
        }
    }
}

/*********************
COMMENTS
*********************/
if ( ! function_exists( 'cb_comments' ) ) {
    function cb_comments($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment; ?>

        <li <?php comment_class(); ?> >

            <article id="comment-<?php comment_ID(); ?>" class="clearfix">

                <div class="cb-comment-body clearfix">

                    <header class="comment-author vcard">
                        <div class="cb-gravatar-image">
                            <?php echo get_avatar( $comment, 70 ); ?>
                        </div>
                        <time datetime="<?php comment_date(); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_date(); ?> </a></time>
                        <?php echo "<cite class='fn'>" . get_comment_author_link() . "</cite>"; ?>
                        <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                    </header>
                    <?php edit_comment_link(__('(Edit)', 'cubell'),'  ','') ?>
                    <?php if ( $comment->comment_approved == '0' ) { ?>
                        <div class="alert info">
                            <p><?php _e('Your comment is awaiting moderation.', 'cubell') ?></p>
                        </div>
                    <?php } ?>
                    <section class="comment_content clearfix">
                        <?php comment_text(); ?>
                    </section>
                </div>

            </article>
<?php
    }
}

/*********************
AUTHOR SOCIAL MEDIA
*********************/
if ( ! function_exists( 'cb_contact_data' ) ) {
    function cb_contact_data($contactmethods) {

        if ( is_admin() == true ) {
            $contactmethods['publicemail'] = '15Zine: Public Email';
            $contactmethods['twitter'] = '15Zine: Twitter Username';
            $contactmethods['instagram'] = '15Zine: Instagram (Entire URL)';
            $contactmethods['position'] = '15Zine: Job Title';
        }      

        return $contactmethods;
    }
}
add_filter('user_contactmethods', 'cb_contact_data');


/*********************
GET FEATURED IMAGE STYLE
*********************/
if ( ! function_exists( 'cb_get_post_fis' ) ) {
    function cb_get_post_fis( $cb_post_id ) {

        if ( is_single() ) {
            $cb_post_format = get_post_format($cb_post_id);
            if ( $cb_post_format != NULL ) {
                $cb_post_format = ' cb-b-' . $cb_post_format;
                $cb_video_post_select = get_post_meta( $cb_post_id, 'cb_video_post_select', true );
            }
        } else {
            $cb_post_format = $cb_video_post_select = NULL;
        }

        $cb_featured_image_style_override_onoff = ot_get_option('cb_post_style_override_onoff', 'off');
        $cb_featured_image_style_override_style = ot_get_option('cb_post_style_override', 'standard');
        $cb_featured_image_style = get_post_meta( $cb_post_id, 'cb_featured_image_style', true );
        $cb_featured_image_style_override_post_onoff = get_post_meta( $cb_post_id, 'cb_featured_image_style_override', true );

        $cb_mobile = new Mobile_Detect;
        $cb_phone = $cb_mobile->isMobile();
        $cb_tablet = $cb_mobile->isTablet();
        if ( ( $cb_tablet == true ) || ( $cb_phone == true ) ) {
            $cb_is_mobile = true;
        } else {
            $cb_is_mobile = false;
        }

        if ( ( $cb_is_mobile == true ) && ( $cb_featured_image_style == 'parallax' ) ) {
            $cb_featured_image_style = 'full-background';
        }

        if ( ( $cb_featured_image_style_override_onoff == 'on' ) && ( $cb_featured_image_style_override_post_onoff != 'on') ) {
            $cb_featured_image_style = $cb_featured_image_style_override_style;
        }

        if ( $cb_featured_image_style == NULL ) {
            $cb_featured_image_style = 'standard';
        }

        if ( ( $cb_featured_image_style == 'full-background' ) || ( $cb_featured_image_style == 'parallax' ) || ( $cb_featured_image_style == 'background-slideshow' ) ) {
            $cb_featured_image_style = $cb_featured_image_style . ' cb-fis-big-block cb-fis-big-border';
        }

        if ( ( ( $cb_featured_image_style == 'site-width' ) || ( $cb_featured_image_style == 'screen-width' ) || ( $cb_post_format == ' cb-b-gallery' ) ) || ( ( $cb_post_format == 'video') && ( $cb_video_post_select != 1 ) ) ) {
            $cb_featured_image_style = $cb_featured_image_style . ' cb-fis-big-border';
        }

        return ' cb-fis-b-' . $cb_featured_image_style . $cb_post_format;
    }
}

/*********************
GET FEATURED IMAGE STYLE
*********************/
if ( ! function_exists( 'cb_get_featured_block' ) ) {
    function cb_get_featured_block() {

        $cb_output = NULL;
        if ( is_category() ) {
            $cb_cat_id = get_query_var( 'cat' );
            if ( function_exists( 'get_tax_meta' ) ) {
                $cb_featured_option = get_tax_meta( $cb_cat_id, 'cb_cat_featured_op' );
                if ( $cb_featured_option == 's-1fw' ) {
                    $cb_output = ' cb-fis-big-border';
                }
            }
        }

        if ( is_home() ) {

            $cb_featured_option = ot_get_option( 'cb_hp_gridslider', 'cb_full_off' );
            if ( $cb_featured_option == 's-1fw' ) {
                $cb_output = ' cb-fis-big-border';
            }
        }
        

        return $cb_output;
        
    }
}


/*********************
GET SINGULAR FS SETTING
*********************/
if ( ! function_exists( 'cb_get_singular_fs' ) ) {
    function cb_get_singular_fs( $cb_post_id ) {

        $cb_sb = cb_get_sidebar_setting();
        $cb_fs = get_post_meta( $cb_post_id, '_cb_embed_fs', true );
        $cb_out = get_post_meta( $cb_post_id, '_cb_embed_out', true );
        $cb_output = NULL;

        if ( ( $cb_sb == 'nosidebar-fw' ) || ( $cb_sb == 'nosidebar' ) ) {

            if ( $cb_fs == 'on' ) {
                $cb_output = ' cb-embed-fs';
            }

            if ( $cb_out == 'on' ) {
                $cb_output .= ' cb-embed-out';
            }
            
        }

        return $cb_output;
    }
}
/*********************
GET SINGULAR FS SETTING
*********************/
if ( ! function_exists( 'cb_get_site_border' ) ) {
    function cb_get_site_border() {

        $cb_output = NULL;
        if ( is_single() ) {
            global $post;
            $cb_featured_image_style = get_post_meta( $post->ID, 'cb_featured_image_style', true );

            $cb_featured_image_style_override_onoff = ot_get_option('cb_post_style_override_onoff', 'off');
            $cb_featured_image_style_override_style = ot_get_option('cb_post_style_override', 'standard');
            $cb_featured_image_style_override_post_onoff = get_post_meta( $post->ID, 'cb_featured_image_style_override', true );
            if ( ( $cb_featured_image_style_override_onoff == 'on' ) && ( $cb_featured_image_style_override_post_onoff != 'on') ) {
                $cb_featured_image_style = $cb_featured_image_style_override_style;
            }
            if ( $cb_featured_image_style == 'parallax' ) {
                return;
            }


        }
        if ( ot_get_option( 'cb_background_border', 'off' ) != 'off' ) {
            $cb_output = ' ' . ot_get_option( 'cb_background_border', 'off' );
        }

        return $cb_output;
    }
}

/*********************
GET BODY CLASSES
*********************/
if ( ! function_exists( 'cb_get_body_classes' ) ) {
    function cb_get_body_classes() {

        return cb_get_post_sidebar_position() . cb_get_sticky_option() . cb_get_skin() . cb_get_blog_style_full() . cb_get_logo_vis() . cb_get_site_border();
    }
}


/*********************
GET SIDEBAR POSITION
*********************/
if ( ! function_exists( 'cb_get_post_sidebar_position' ) ) {
    function cb_get_post_sidebar_position() {
        
        $cb_sidebar = NULL;
        $cb_output = ' cb-sidebar-right';

        if ( ( function_exists('is_bbpress') ) && ( is_bbpress() ) ) {
            $cb_sidebar = ot_get_option('cb_bbpress_sidebar', NULL );
        } elseif ( class_exists('Woocommerce') &&  cb_is_woocommerce() ) {
            $cb_sidebar = ot_get_option('cb_woocommerce_sidebar', NULL );
        } elseif ( is_singular() ) {
            global $post;
            $cb_sidebar = get_post_meta( $post->ID, 'cb_full_width_post', true );
        } elseif ( is_page_template( 'page-meet-the-team-full.php' ) == true ) {
            $cb_sidebar = 'nosidebar'; 
        } elseif ( is_author() ) {
            $cb_sidebar = 'sidebar_left';
        }

        if ( ot_get_option( 'cb_post_sidebar_override_onoff', 'off' ) == 'on' ) {
            
            if ( is_single() && ( ! cb_is_woocommerce() ) ) {
                global $post;
                if ( get_post_meta( $post->ID, 'cb_sidebar_override', true ) == 'on' ) {
                    $cb_sidebar = get_post_meta( $post->ID, 'cb_full_width_post', true );
                } else {
                    $cb_sidebar = ot_get_option( 'cb_post_sidebar_override', 'sidebar' );
                }
            }
        }

        if ( ( $cb_sidebar == NULL ) || ( $cb_sidebar == 'sidebar' ) ) {
            $cb_output = ' cb-sidebar-right';
        } elseif ( $cb_sidebar == 'sidebar_left' ) {
            $cb_output = ' cb-sidebar-left';
        } elseif ( $cb_sidebar == 'nosidebar' ) {
            $cb_output = ' cb-sidebar-none';
        } elseif ( $cb_sidebar == 'nosidebar-fw' ) {
            $cb_output = ' cb-sidebar-none cb-sidebar-none-fw';
        }

        return $cb_output;
    }
}

/*********************
GET SIDEBAR POSITION
*********************/
if ( ! function_exists( 'cb_get_sidebar_setting' ) ) {
    function cb_get_sidebar_setting() {
        
        $cb_sidebar = NULL;

        if ( ( function_exists('is_bbpress') ) && ( is_bbpress() ) ) {
            $cb_sidebar = ot_get_option('cb_bbpress_sidebar', NULL );
        } elseif ( class_exists('Woocommerce') &&  cb_is_woocommerce() ) {
            $cb_sidebar = ot_get_option('cb_woocommerce_sidebar', NULL );
        } elseif ( is_singular() ) {
            global $post;
            $cb_sidebar = get_post_meta( $post->ID, 'cb_full_width_post', true );
        } elseif ( is_page_template( 'page-meet-the-team-full.php' ) == true ) {
            $cb_sidebar = 'nosidebar'; 
        } elseif ( is_author() ) {
            $cb_sidebar = 'sidebar_left';
        }

        if ( ot_get_option( 'cb_post_sidebar_override_onoff', 'off' ) == 'on' ) {
            
            if ( is_single() && ( ! cb_is_woocommerce() ) ) {
                global $post;
                if ( get_post_meta( $post->ID, 'cb_sidebar_override', true ) == 'on' ) {
                    $cb_sidebar = get_post_meta( $post->ID, 'cb_full_width_post', true );
                } else {
                    $cb_sidebar = ot_get_option( 'cb_post_sidebar_override', 'sidebar' );
                }
            }
        }

        if ( $cb_sidebar == NULL ) {
            $cb_sidebar = 'sidebar';
        }

        return $cb_sidebar;
    }
}


/*********************
GET BLOG STYLE
*********************/
if ( ! function_exists( 'cb_get_blog_style' ) ) {
    function cb_get_blog_style() {
        
        $cb_output = NULL;

        if ( is_search() ) {
            $cb_output = ot_get_option('cb_misc_search_pl', 'a');
        }

        if ( is_home() ) {
            $cb_output = ot_get_option( 'cb_blog_style', 'a' );
        }

        if ( is_date() ) {
            $cb_output = ot_get_option('cb_misc_archives_pl', 'a');
        }

        if ( is_category() ) {
            $cb_cat_id = get_query_var( 'cat' );
            if ( function_exists( 'get_tax_meta' ) ) {
                $cb_output = get_tax_meta( $cb_cat_id, 'cb_cat_style_field_id' );
            }
        }

        if ( is_author() ) {
            $cb_output = ot_get_option('cb_misc_author_pl', 'a');
        }

        if ( is_tag() ) {
            $cb_tag_id = get_query_var('tag_id');

            if ( function_exists('get_tax_meta') ) {

                $cb_output = get_tax_meta( $cb_tag_id, 'cb_cat_style_field_id' ); 
              
            }
        }

        if ( $cb_output == NULL ) {
            $cb_output = 'a';
        }

        if ( strlen( $cb_output ) > 1 ) {
            $cb_output = substr( $cb_output, -1 );
        }

        return $cb_output;
    }
}

/*********************
GET BLOG STYLE
*********************/
if ( ! function_exists( 'cb_get_blog_style_full' ) ) {
    function cb_get_blog_style_full() {

        if ( is_404() || is_page_template( 'page-meet-the-team-full.php' ) || cb_get_blog_style() == 'c' || cb_get_blog_style() == 'i' ) {
            return ' cb-fw-bs';
        }

    }
}

/*********************
GET STICKY
*********************/
if ( ! function_exists( 'cb_get_sticky_option' ) ) {
    function cb_get_sticky_option() {
        
        $cb_output = NULL;
        
        if ( ot_get_option('cb_sticky_nav', 'on' ) == 'on' ) {
            $cb_output = ' cb-sticky-mm';
            if ( ot_get_option('cb_nav_when_sticky', 'cb-sticky-menu' ) == 'cb-sticky-menu-up' ) {
                $cb_output .= ' cb-sticky-menu-up';
            }
        }

        if ( ot_get_option('cb_logo_in_nav', 'off') == 'on' ) {
            $cb_logo_in_nav_when = ot_get_option( 'cb_logo_in_nav_when', 'cb-logo-nav-sticky' );
            $cb_output .= ' cb-nav-logo-on ' . $cb_logo_in_nav_when;

            $cb_show_header = NULL;
            if ( is_single() ) {

                if ( cb_show_header() == 'on' ) {
                    $cb_output .= ' cb-logo-nav-always';
                }
               
            }

        }

        if ( ot_get_option('cb_sticky_sb', 'on') == 'on' ) {
            $cb_output .= ' cb-sticky-sb-on';
        }     

        return $cb_output;
    }
}


/*********************
GET LOGO OPTIONS
*********************/
if ( ! function_exists( 'cb_get_logo_vis' ) ) {
    function cb_get_logo_vis() {
        
        $cb_output = NULL;
        // Logo vis
        if ( ot_get_option( 'cb_m_logo_mobile', 'on' ) == 'off' ) {
            $cb_output .= ' cb-m-logo-off';
        }
        if ( ot_get_option( 'cb_sticky_m_nav', 'on' ) == 'on' ) {
            $cb_output .= ' cb-m-sticky';
        }

        // Site Width
        if ( ot_get_option( 'cb_sw_tm', 'fw' ) == 'fw' ) {
            $cb_output .= ' cb-sw-tm-fw';
        } else {
            $cb_output .= ' cb-sw-tm-box';
        }

        if ( ot_get_option( 'cb_sw_hd', 'fw' ) == 'fw' ) {
            $cb_output .= ' cb-sw-header-fw';
        } else {
            $cb_output .= ' cb-sw-header-box';
        }

        if ( ot_get_option( 'cb_sw_menu', 'fw' ) == 'fw' ) {
            $cb_output .= ' cb-sw-menu-fw';
        } else {
            $cb_output .= ' cb-sw-menu-box';
        }

        if ( ot_get_option( 'cb_sw_footer', 'fw' ) == 'fw' ) {
            $cb_output .= ' cb-sw-footer-fw';
        } else {
            $cb_output .= ' cb-sw-footer-box';
        }

        return $cb_output;
    }
}

/*********************
GET SKIN
*********************/
if ( ! function_exists( 'cb_get_skin' ) ) {
    function cb_get_skin() {
        
        $cb_output = NULL;

        $cb_output .= ' ' . ot_get_option( 'cb_tm_skin', 'cb-tm-dark' );
        $cb_output .= ' ' . ot_get_option( 'cb_body_skin', 'cb-body-light' );
        $cb_output .= ' ' . ot_get_option( 'cb_menu_style', 'cb-menu-light' );
        $cb_output .= ' ' . ot_get_option( 'cb_mm_skin', 'cb-mm-light' );
        $cb_output .= ' ' . ot_get_option( 'cb_footer_skin', 'cb-footer-light' );

        return $cb_output;
    }
}


/*********************
FEATURED IMAGE STYLES
*********************/
if ( ! function_exists( 'cb_get_featured_image_style' ) ) {
    function cb_get_featured_image_style( $cb_featured_image_style, $post, $cb_page = NULL ) {

        $cb_mobile = new Mobile_Detect;
        $cb_post_id = $post->ID;
        $cb_post_format_media = $cb_media_data = $cb_title_closer = NULL;
        $cb_phone = $cb_mobile->isMobile();
        $cb_tablet = $cb_mobile->isTablet();
        if ( ( $cb_tablet == true ) || ( $cb_phone == true ) ) {
            $cb_is_mobile = true;
        } else {
            $cb_is_mobile = false;
        }

        $cb_post_format = get_post_format($cb_post_id);
        $cb_video_post_select = get_post_meta( $cb_post_id, 'cb_video_post_select', true );
        $cb_audio_post_style = get_post_meta( $cb_post_id, 'cb_audio_post_style', true );
        $cb_featured_image_style = get_post_meta( $cb_post_id, 'cb_featured_image_style', true );
        $cb_review_checkbox = get_post_meta( $cb_post_id, 'cb_review_checkbox', true );
        $cb_audio_url = get_post_meta( $cb_post_id, 'cb_soundcloud_embed_code_post', true );
        $cb_credit_line = get_post_meta( $cb_post_id, 'cb_image_credit', true );

        if ( $cb_featured_image_style == NULL ) {
            $cb_featured_image_style = 'standard';
        }

        $cb_featured_image_style_override_onoff = ot_get_option('cb_post_style_override_onoff', 'off');
        $cb_featured_image_style_override_style = ot_get_option('cb_post_style_override', 'standard');
        $cb_featured_image_style_override_post_onoff = get_post_meta( $post->ID, 'cb_featured_image_style_override', true );
        if ( ( $cb_featured_image_style_override_onoff == 'on' ) && ( $cb_featured_image_style_override_post_onoff != 'on') ) {
            $cb_featured_image_style = $cb_featured_image_style_override_style;
        }

        if ( is_attachment() ) {
            $cb_featured_image_style = 'off';
        }

        if ( $cb_credit_line != NULL ) { $cb_credit_line = '<span class="cb-credit-line">' . $cb_credit_line . '</span>'; }
        if ( ( $cb_review_checkbox == 'on' ) || ( $cb_review_checkbox == 'on' ) ) { $cb_item_type = 'itemprop="itemReviewed"'; } else { $cb_item_type = 'itemprop="headline"'; }
        $cb_output = $cb_title = $cb_featured_image_url = $cb_image = NULL;

        if ( $cb_page == NULL ) {

            $cb_title .= '<div class="cb-entry-header cb-meta clearfix">';
            $cb_title .= '<h1 class="entry-title cb-entry-title cb-title" ' . $cb_item_type . '>' . get_the_title() . '</h1>';

            if ( ( ( $cb_featured_image_style != 'standard' ) && ( $cb_featured_image_style != 'standard-uncrop' ) && ( $cb_featured_image_style != 'off' ) && ( $cb_featured_image_style != NULL ) ) || ( $cb_post_format == 'gallery' ) ) {
                $cb_title .= cb_get_byline( $cb_post_id, true, true, true );
            } else {
                $cb_title .= cb_get_byline( $cb_post_id );
            }
            

            if ( ( $cb_featured_image_style == 'standard' ) || ( $cb_featured_image_style == 'standard-uncrop' ) || ( $cb_featured_image_style == 'off' ) ) {
                $cb_title .= cb_get_post_meta( $cb_post_id );
            }

            if ( ( ( $cb_post_format == 'video' ) && ( $cb_video_post_select == '2' ) ) || ( ( $cb_post_format == 'audio' ) && ( $cb_audio_post_style == '2' ) ) ) {
                $cb_media_data = '<div id="cb-video-data" class="cb-media-icon"><a href="#cb-video-overlay" id="cb-media-play" class="cb-video-overlay-icon cb-circle"><i class="fa fa-play"></i></a></div>';
            }
            $cb_title_closer .= '</div>';

        } elseif ( $cb_page == 'page-overlay' ) {
            $cb_page_title = get_post_meta( $cb_post_id, 'cb_page_title', true );
            if ( $cb_page_title != 'off' ) {
                $cb_title .= '<div class="cb-entry-header cb-meta clearfix">';
                $cb_title .= '<h1 class="entry-title cb-entry-title cb-title" ' . $cb_item_type . '>' . get_the_title() . '</h1>';
                $cb_title .= '</div>';
            }
        }

        $cb_gallery_post_images = get_post_meta( $cb_post_id, 'cb_gallery_post_images', true );
        
        if ( ( $cb_post_format == 'gallery' ) && ( $cb_gallery_post_images != NULL ) ) {

             $cb_output .= cb_get_post_format_data( $cb_post_id, $cb_post_format );

        } elseif ( ( ( $cb_post_format == 'video' ) && ( $cb_video_post_select == '1' ) ) || ( ( $cb_post_format == 'audio' ) && ( $cb_audio_post_style == '1' ) ) )  {

            $cb_responsive = NULL;
            $cb_video_url = get_post_meta( $cb_post_id, 'cb_video_embed_code_post', true );

            if ( ( strpos( $cb_video_url, 'vime' ) !== false ) || ( strpos( $cb_video_url, 'yout' ) !== false )) {
                $cb_responsive = ' cb-video-frame';
            }
            if ( ( $cb_featured_image_style == 'standard' ) || ( $cb_featured_image_style == 'off' )  || ( $cb_featured_image_style == 'standard-uncrop' ) ) {
                $cb_output .= '<div id="cb-featured-image" class="cb-fis cb-fis-block-video' . $cb_responsive . '">' .   $cb_title . $cb_title_closer . cb_get_post_format_data( $cb_post_id,  $cb_post_format ) . '</div>';
            } else {
                $cb_output .= '<div id="cb-featured-image" class="cb-fis wrap cb-site-padding cb-fis-block-video' . $cb_responsive . '">' .   $cb_title . $cb_title_closer . cb_get_post_format_data( $cb_post_id,  $cb_post_format ) . '</div>';
            }
            

        } elseif ( $cb_featured_image_style == 'off' ) {

            $cb_output .= $cb_title . $cb_title_closer;

        } elseif ( $cb_featured_image_style == 'standard' ) {

            $cb_output .= '<div id="cb-featured-image" class="cb-fis cb-fis-block-standard"><div class="cb-mask">' . cb_get_thumbnail( 759, 500, $cb_post_id, false ) . $cb_media_data . $cb_credit_line . '</div>' . $cb_title . $cb_title_closer . '</div>';

        } elseif ( $cb_featured_image_style == 'standard-uncrop' ) {

            $cb_output .= '<div id="cb-featured-image" class="cb-fis cb-fis-block-standard"><div class="cb-mask">' . cb_get_thumbnail( 'full', 'full', $cb_post_id, false ) . $cb_media_data . $cb_credit_line . '</div>' . $cb_title . $cb_title_closer . '</div>';

        } elseif ( ( $cb_featured_image_style == 'site-width' ) || ( $cb_featured_image_style == 'screen-width' ) ) {

               $cb_featured_image_url = cb_get_thumbnail_url( 1400, 600, $cb_post_id );

            if ( $cb_featured_image_url != NULL ) {

                 if ( $cb_featured_image_style == 'screen-width' ) {
                    $cb_class = ' cb-fis-block-screen-width';
                } else { 
                    $cb_class = ' wrap';
                }

                $cb_output = '<div id="cb-featured-image" class="cb-fis cb-fis-big cb-fis-block-site-width' . $cb_class . ' cb-fis-block-background">';
                $cb_output .= $cb_title . $cb_media_data . $cb_title_closer . $cb_credit_line;
                $cb_output .= '<script type="text/javascript">jQuery(document).ready(function($){
                            $("#cb-featured-image").backstretch("' . esc_url( $cb_featured_image_url[0] ) . '", {fade: 1200});
                            });  </script>';
                $cb_output .= '</div>';
            }

        } elseif ( ( $cb_featured_image_style == 'full-background' ) || ( ( $cb_featured_image_style == 'parallax' ) && ( $cb_is_mobile == true ) ) ) {

            $cb_featured_image_url = cb_get_thumbnail_url( 'full', 'full', $cb_post_id );
            if ( $cb_featured_image_url != NULL ) {

                $cb_output = '<div id="cb-featured-image" class="cb-fis cb-fis-fs cb-fis-big cb-fis-block-background">';
                $cb_output .= $cb_title . $cb_media_data . $cb_title_closer . $cb_credit_line;
                $cb_output .= cb_get_arrow_down();
                $cb_output .= $cb_credit_line;
                $cb_output .= '<script type="text/javascript">jQuery(document).ready(function($){
                            $.backstretch("' . esc_url( $cb_featured_image_url[0] ) . '", {fade: 1200});
                            $(window).resize(function() { $.backstretch("resize");});
                            });  </script>';
                $cb_output .= '</div>';
            }

        } elseif ( $cb_featured_image_style == 'background-slideshow' ) {

            $cb_gallery_post_images = get_post_meta( $cb_post_id, 'cb_post_background_slideshow', true );

            if ( $cb_gallery_post_images != NULL ) {

                $cb_gallery_images = cb_get_gallery_images( $cb_post_id, $cb_gallery_post_images );
                $cb_output = '<div id="cb-featured-image" class="cb-fis cb-fis-fs cb-fis-big cb-fis-block-background cb-fis-block-slideshow cb-background-preload">';
                $cb_output .= $cb_title . $cb_media_data . $cb_title_closer;
                $cb_output .= cb_get_arrow_down();
                $cb_output .= $cb_credit_line;
                $cb_output .= '<script type="text/javascript">jQuery(document).ready(function($){
                            $.backstretch(';
                $cb_output .= '[';
                foreach ( $cb_gallery_images as $cb_slide ) {
                    $cb_output .= '"' . esc_url( $cb_slide['cb-url'] ) . '", ';
                }
                $cb_output .= '],  {fade: 1000, duration: 3500});
                        });  </script>';
                $cb_output .= '</div>';
            }

        } elseif ( $cb_featured_image_style == 'parallax' ) {

            $cb_featured_image_url = cb_get_thumbnail_url( 'full', 'full', $cb_post_id );

            if ( $cb_featured_image_url != NULL ) {
                $cb_output .= '<div id="cb-featured-image" class="cb-fis cb-fis-fs cb-fis-big cb-fis-block-parallax clearfix">';
                $cb_output .= $cb_title . $cb_media_data . $cb_title_closer;
                $cb_output .= cb_get_arrow_down();
                $cb_output .= $cb_credit_line;
                $cb_output .= '</div>';
                $cb_output .= '<div id="cb-par-wrap"><img class="cb-image" src="' . $cb_featured_image_url[0] .'" alt=""></div>';
            }

        }

     return $cb_output;

    }
}

/*********************
FEATURED IMAGE STYLES
*********************/
if ( ! function_exists( 'cb_featured_image_style' ) ) {
    function cb_featured_image_style( $cb_style, $post, $cb_page = NULL ) {

        echo cb_get_featured_image_style( $cb_style, $post, $cb_page );

    }
}

/*********************
ARROW SCROLL DOWN
*********************/
if ( ! function_exists( 'cb_get_arrow_down' ) ) {
    function cb_get_arrow_down() {

        $cb_output = '<a href="#" class="cb-vertical-down"><i class="fa fa-angle-down"></i></a>';

        return $cb_output;
    }
}

/*********************
POST FORMAT DATA
*********************/
if ( ! function_exists( 'cb_get_post_format_data' ) ) {
    function cb_get_post_format_data( $cb_post_id, $cb_post_format_type = NULL ) {

        $cb_output = $cb_audio_source = $cb_byline = NULL;

        if ( $cb_post_format_type == 'gallery' ) {

            $cb_gallery_post_images = get_post_meta( $cb_post_id, 'cb_gallery_post_images', true );
            $cb_post_gallery = cb_get_gallery_images( $cb_post_id, $cb_gallery_post_images, 'full', $cb_captions = true );

            if ( $cb_post_gallery != NULL ) {

                $cb_byline = cb_get_byline( $cb_post_id );

                $cb_output = '<div id="cb-featured-image" class="cb-fis cb-fis-big cb-fis-fs cb-fis-block-background cb-gallery-post-wrap clearfix"><div id="cb-gallery-post" class="cb-arrows-sides cb-background-preload"><ul class="slides">';

                foreach ( $cb_post_gallery as $cb_image ) {

                     if ( trim( $cb_image['cb-caption'] ) != '' ) {
                        $cb_image['cb-caption'] = '<span class="cb-caption cb-credit-line">' . $cb_image['cb-caption'] . '</span>';
                    }

                    $cb_output .= '<li><img src="' . esc_url( $cb_image['cb-url'] ) . '">' .  $cb_image['cb-caption'] . '</li>';

                }

                $cb_output .= '</ul>';
                $cb_output .= '<span class="cb-link-overlay"><div class="cb-entry-header cb-meta">';
                $cb_output .= '<h1 class="entry-title cb-entry-title cb-title">' . get_the_title() . '</h1>' . $cb_byline;
                $cb_output .= '</div></span>';

                $cb_output .= '</div></div>';

            }

        }

        if ( $cb_post_format_type == 'video' ) {

            $cb_output .= get_post_meta( $cb_post_id, 'cb_video_embed_code_post', true );

        }

        if ( $cb_post_format_type == 'audio' ) {

            $cb_audio_post_select = get_post_meta( $cb_post_id, 'cb_audio_post_select', true );

            if ( $cb_audio_post_select == 'external' ) {

                $cb_output .= '<div id="cb-media-embed-url" class="clearfix cb-audio-embed">' . get_post_meta( $cb_post_id, 'cb_audio_post_url', true ) . '</div>';

            } elseif ( $cb_audio_post_select == 'selfhosted' ) {

                $cb_audio_source_mp3 = get_post_meta( $cb_post_id, 'cb_audio_post_selfhosted_mp3', true );
                $cb_audio_source_ogg = get_post_meta( $cb_post_id, 'cb_audio_post_selfhosted_ogg', true );

                if ( ( $cb_audio_source_mp3 != NULL ) || ( $cb_audio_source_mp3 != NULL ) ) {

                    $cb_audio_source = '<audio controls="controls">';

                    if ( $cb_audio_source_mp3 != NULL ) {
                        $cb_audio_source .= '<source src="' . esc_url( $cb_audio_source_mp3 ) . '" type="audio/mpeg" />';
                    }

                    if ( $cb_audio_source_ogg != NULL ) {
                        $cb_audio_source .= '<source src="' . esc_url( $cb_audio_source_ogg ) . '" type="audio/ogg" />';
                    }

                    $cb_audio_source .= '</audio>';

                }

                $cb_output .= '<div id="cb-media-embed-url" class="clearfix cb-audio-embed">' . $cb_audio_source . '</div>';
            }
        }
        return $cb_output;
    }
}

/*********************
GALLERY POST FORMAT
*********************/
if ( ! function_exists( 'cb_get_gallery_images' ) ) {
    function cb_get_gallery_images( $cb_post_id, $cb_gallery_post_images, $cb_image_size = 'cb-1400-600', $cb_captions = false ) {

        $cb_gallery_post_images = explode( ',', $cb_gallery_post_images );

        $cb_output = array();
        $cb_caption = NULL;

        foreach ( $cb_gallery_post_images as $cb_each_image ) {
            $cb_image = wp_get_attachment_image_src( $cb_each_image, $cb_image_size );
            
            if ( $cb_captions == true ) {
                $cb_caption = get_post($cb_each_image)->post_excerpt;
            }

            $cb_output[] = array( 'cb-url' => $cb_image[0], 'cb-caption' => $cb_caption );
        }

        return $cb_output;
    }
}

/*********************
MMA
*********************/
if ( ! function_exists( 'cb_mm_a' ) ) {
    function cb_mm_a() {
       
        $cb_cat_id = isset( $_GET['cid'] ) && $_GET['cid'] ? intval( $_GET['cid'] ) : 0;
        $cb_a = isset( $_GET['acall'] ) ? 1 : 0;
        $cb_args = array( 'cat' => $cb_cat_id,  'post_status' => 'publish',  'posts_per_page' => 3,  'ignore_sticky_posts'=> 1 );
        $cb_qry_latest = new WP_Query($cb_args);
        $i = 1;
        $cb_post_output = NULL;

        while ( $cb_qry_latest->have_posts() ) {

            $cb_qry_latest->the_post();
            $cb_post_id = get_the_ID();
            $cb_post_output .= ' <li class="cb-article-' . esc_attr( $i ) . ' cb-style-1 clearfix"><div class="cb-mask cb-img-fw"' . cb_get_img_bg_color( $cb_post_id ) . '>' . cb_get_thumbnail( '260', '170', $cb_post_id) . cb_get_review_ext_box( $cb_post_id, true ) . '</div><div class="cb-meta"><h2 class="cb-post-title"><a href="' . esc_url( get_permalink( $cb_post_id ) ) . '">' . get_the_title() . '</a></h2>' . cb_get_byline_date( $cb_post_id ) . '</div></li>';
            $i++;
        }

        wp_reset_postdata();
        
        if ( $cb_a == 1 ) {
            echo $cb_post_output;
        } else {
            return $cb_post_output;
        }

        die();
    }
}

add_action( 'wp_ajax_cb_mm_a', 'cb_mm_a' );
add_action( 'wp_ajax_nopriv_cb_mm_a', 'cb_mm_a' );


/*********************
 REVIEW SCORE BOXES PREPEND
*********************/
if ( ! function_exists( 'cb_review_prepend' ) ) {
    function cb_review_prepend( $content ) {

        global $post, $multipage, $numpages, $page;
        $cb_post_id = $post->ID;
        $cb_post_types = get_post_type();
        $cb_review_placement = get_post_meta( $cb_post_id, 'cb_placement', true );

        if ( $multipage == true ) {

            if ( $page == $numpages ) {

                if ( $cb_review_placement == 'bottom' ){
                    $content .= cb_review_boxes($post);
                }
            }

            if ( $page == '1' ) {

                if ( ( $cb_review_placement == 'top' ) || ( $cb_review_placement == 'top-half' ) ){

                    $content = cb_review_boxes($post) . $content;

                }
            }

        } else {

            if ( ( $cb_review_placement == 'top' ) || ( $cb_review_placement == 'top-half' ) ){

                $content = cb_review_boxes($post) . $content;

            } elseif ( $cb_review_placement == 'bottom' ){
                $content .= cb_review_boxes($post);
            }
        }

        return $content;
    }
}
add_filter( 'the_content', 'cb_review_prepend' );

/*********************
 REVIEW SCORE BOXES
*********************/
if ( ! function_exists( 'cb_review_boxes' ) ) {
    function cb_review_boxes( $post ){

        $cb_post_id = $post->ID;
        $cb_custom_fields = get_post_custom();
        $cb_rating_short_summary = $cb_score_subtitle = NULL;
        $cb_review_checkbox = get_post_meta( $cb_post_id, 'cb_review_checkbox', true );
        if ( $cb_review_checkbox == '1' ) { $cb_review_checkbox = 'on'; }

        if ( $cb_review_checkbox == 'on' ) {

            $cb_star_overlay = $cb_star_bar = $cb_review_placement_ret = $cb_class = $cb_tip_title = $cb_tip_class = $cb_criterias = $cb_cons = $cb_pros = $cb_score_box = $cb_pro_cons = $cb_reader_rating = NULL;
            $cb_review_type = get_post_meta( $cb_post_id, 'cb_user_score', 'cb-both' );
            $cb_score_display_type = get_post_meta( $cb_post_id, 'cb_score_display_type', true );
            $cb_user_score = get_post_meta( $cb_post_id, 'cb_user_score_output', true);
            $cb_final_score = get_post_meta( $cb_post_id, 'cb_final_score', true );
            $cb_final_score_override = get_post_meta( $cb_post_id, 'cb_final_score_override', true );
            $cb_rating_short_summary = get_post_meta( $cb_post_id, 'cb_rating_short_summary', true );
            $cb_rating_short_summary_in = get_post_meta( $cb_post_id, 'cb_rating_short_summary_in', true );
            $cb_review_placement = get_post_meta( $cb_post_id, 'cb_placement', true );
            $cb_5_stars = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>';
            $cb_ratings = array();
            if ( $cb_final_score_override != NULL ) { $cb_final_score = $cb_final_score_override; }
            if ( isset ( $cb_custom_fields['cb_ct1'][0] ) ) { $cb_rating_1_title = $cb_custom_fields['cb_ct1'][0]; }
            if ( isset ( $cb_custom_fields['cb_cs1'][0] ) ) { $cb_rating_1_score = $cb_custom_fields['cb_cs1'][0]; }
            if ( isset ( $cb_custom_fields['cb_ct2'][0] ) ) { $cb_rating_2_title = $cb_custom_fields['cb_ct2'][0]; }
            if ( isset ( $cb_custom_fields['cb_cs2'][0] ) ) { $cb_rating_2_score = $cb_custom_fields['cb_cs2'][0]; }
            if ( isset ( $cb_custom_fields['cb_ct3'][0] ) ) { $cb_rating_3_title = $cb_custom_fields['cb_ct3'][0]; }
            if ( isset ( $cb_custom_fields['cb_cs3'][0] ) ) { $cb_rating_3_score = $cb_custom_fields['cb_cs3'][0]; }
            if ( isset ( $cb_custom_fields['cb_ct4'][0] ) ) { $cb_rating_4_title = $cb_custom_fields['cb_ct4'][0]; }
            if ( isset ( $cb_custom_fields['cb_cs4'][0] ) ) { $cb_rating_4_score = $cb_custom_fields['cb_cs4'][0]; }
            if ( isset ( $cb_custom_fields['cb_ct5'][0] ) ) { $cb_rating_5_title = $cb_custom_fields['cb_ct5'][0]; }
            if ( isset ( $cb_custom_fields['cb_cs5'][0] ) ) { $cb_rating_5_score = $cb_custom_fields['cb_cs5'][0]; }
            if ( isset ( $cb_custom_fields['cb_ct6'][0] ) ) { $cb_rating_6_title = $cb_custom_fields['cb_ct6'][0]; }
            if ( isset ( $cb_custom_fields['cb_cs6'][0] ) ) { $cb_rating_6_score = $cb_custom_fields['cb_cs6'][0]; }
            
            $cb_pros_ar = array_filter(array(
                get_post_meta( $cb_post_id, 'cb_pro_1', true),
                get_post_meta( $cb_post_id, 'cb_pro_2', true),
                get_post_meta( $cb_post_id, 'cb_pro_3', true), 
            ));

            $cb_pros_list = get_post_meta( $cb_post_id, 'cb_pros', true);
            $cb_cons_list = get_post_meta( $cb_post_id, 'cb_cons', true);

            if ( $cb_pros_list != NULL ) {

                $cb_pros = '<div class="cb-pros-cons cb-font-header cb-pros-list">';

                foreach ( $cb_pros_list as $cb_pro ) {

                    $cb_pros .= '<span class="cb-pro">' . $cb_pro['title'] . '</span>';
                }
                $cb_pros .= '</div>';
            } elseif ( ! empty($cb_pros_ar) ) {

                $cb_pros = '<div class="cb-pros-cons cb-font-header cb-pros-list">';

                foreach ( $cb_pros_ar as $cb_ind_pro ) {
                   $cb_pros .= '<span class="cb-pro">' . $cb_ind_pro . '</span>';
                }
                
                $cb_pros .= '</ul></div>';
            }

            $cb_cons_ar = array_filter(array(
                get_post_meta( $cb_post_id, 'cb_con_1', true),
                get_post_meta( $cb_post_id, 'cb_con_2', true),
                get_post_meta( $cb_post_id, 'cb_con_3', true), 
            ));

            if ( $cb_cons_list != NULL ) {

                $cb_cons = '<div class="cb-pros-cons cb-font-header cb-pros-list">';

                foreach ( $cb_cons_list as $cb_con ) {

                    $cb_cons .= '<span class="cb-con">' . $cb_con['title'] . '</span>';
                }
                $cb_cons .= '</div>';

            } elseif ( ! empty($cb_cons_ar) ) {

                $cb_cons = '<div class="cb-pros-cons cb-font-header cb-cons-list">';

                foreach ( $cb_cons_ar as $cb_ind_con ) {
                   $cb_cons .= '<span class="cb-con">' . $cb_ind_con . '</span>';
                }
                
                $cb_cons .= '</div>';

            }

            if ( $cb_review_placement == 'top-half' ) {
                $cb_review_placement_ret = ' cb-review-top cb-half';
            }  elseif ( $cb_review_placement == 'top' ) {
                $cb_review_placement_ret = ' cb-review-top cb-top-review-box';
            }

            $cb_review_final_score = intval($cb_final_score);           

            if ( $cb_score_display_type == 'percentage' ) {

                 $cb_best_rating = '100';
                 $cb_score_output = $cb_review_final_score . '<span>%</span>';
                 $cb_user_score_output =  $cb_user_score . '<span>%</span>';

                 for( $i = 1; $i < 7; $i++ ) {
                    if (isset( ${"cb_rating_" . $i . "_score"} )) { $cb_ratings[] =  ${"cb_rating_" . $i. "_score"} . '%';}
                }
            } elseif ( $cb_score_display_type == 'points' ) {

                $cb_best_rating = '10';
                $cb_score_output = $cb_review_final_score / 10;
                $cb_user_score_output = $cb_user_score / 10;
                
                for ( $i = 1; $i < 7; $i++ ) {
                    if ( isset(${"cb_rating_" . $i . "_score"}) ) { $cb_ratings[] =  ${"cb_rating_" . $i . "_score"} / 10;}
                }
            } else {

                $cb_star_overlay = '-stars';
                $cb_star_bar = ' cb-stars';
                $cb_best_rating = '5';
                $cb_review_final_score =  number_format( ( $cb_review_final_score / 20), 1 );
                $cb_user_score_output =  number_format( ( $cb_user_score / 20), 1 );
                $cb_score_output = $cb_review_final_score;
                for ( $i = 1; $i < 7; $i++ ) {
                    
                    if ( isset(${"cb_rating_" . $i . "_score"}) ) {
                        $cb_ratings[] = ${"cb_rating_" . $i . "_score"};
                    }
                }
            }

            if ( $cb_rating_short_summary_in == NULL ) {
                $cb_rating_short_summary_in = __( 'Overall Score', 'cubell' );
            }

            if ( $cb_review_type == 'cb-readers' ) {
                $cb_final_score = $cb_user_score;
            }

            $cb_score_subtitle = '<span class="score-title">' .  $cb_rating_short_summary_in  . '</span>';

            if ( $cb_score_display_type == 'stars' ) { 
                $cb_score_subtitle .= '<span class="cb-overlay' . $cb_star_overlay . '">' . $cb_5_stars . '<span class="cb-opacity cb-zero-stars-trigger" style="width:' . (100 - $cb_final_score ) . '%"></span></span>'; 
            }

            if ( ($cb_cons != NULL ) || ( $cb_pros != NULL ) ) {
                $cb_pro_cons = '<div class="cb-pros-cons-wrap">' . $cb_pros . $cb_cons . '</div>';
            }

            $cb_opener = '<div id="cb-review-container" class="cb-review-box' . $cb_review_placement_ret . ' ' . $cb_review_type . ' cb-' . $cb_score_display_type . '-container clearfix">';

            $cb_review_title = '<div class="cb-review-title entry-title">' . $post->post_title . '</div>';
            $cb_rev_crits = get_post_meta( $cb_post_id, 'cb_review_crits', true);

            if ( $cb_review_type != 'cb-readers' )  {
                $cb_criterias = '<div class="cb-criteria-area cb-review-area clearfix">';

                if ( $cb_rev_crits != NULL ) {

                    foreach ( $cb_rev_crits as $cb_rev_crit ) {

                        $cb_criterias .= '<div class="cb-bar cb-font-header' . $cb_star_bar . '"><span class="cb-criteria">' . $cb_rev_crit['title'] . '</span>';
                        if ( $cb_score_display_type == 'points' ) {
                            $cb_rev_score = $cb_rev_crit['cb_cs'] / 10;
                        } elseif ( $cb_score_display_type == 'percentage' ) { 
                            $cb_rev_score = $cb_rev_crit['cb_cs']  . '%';;
                        }
                         if ( $cb_score_display_type != 'stars' ) {
                            $cb_criterias .=  '<span class="cb-criteria-score">' . $cb_rev_score . '</span>';
                            $cb_criterias .= '<span class="cb-overlay"><span style="width:' . ( $cb_rev_crit['cb_cs']) . '%"></span></span></div>';
                        } else {
                            $cb_criterias .= '<span class="cb-overlay' . $cb_star_overlay . '">' . $cb_5_stars . '<span class="cb-opacity cb-zero-stars-trigger" style="width:' . ( 100 - $cb_rev_crit['cb_cs'] ) . '%"></span></span></div>';
                        }
                    }


                } else {
                    for ( $j = 1; $j < 7; $j++ ) {
                    
                        $k = ( $j - 1 );

                        if ( ( isset( ${"cb_rating_". $j . "_title"}) ) && ( isset( ${"cb_rating_". $j . "_score"}) ) ) {

                            $cb_criterias .= '<div class="cb-bar cb-font-header' . $cb_star_bar . '"><span class="cb-criteria">' . ${"cb_rating_" . $j . "_title"} . '</span>';

                            if ( $cb_score_display_type != 'stars' ) {
                                $cb_criterias .=  '<span class="cb-criteria-score">' . $cb_ratings[$k] . '</span>';
                                $cb_criterias .= '<span class="cb-overlay"><span style="width:' . ( ${"cb_rating_". $j . "_score"}) . '%"></span></span></div>';
                            } else {
                                $cb_criterias .= '<span class="cb-overlay' . $cb_star_overlay . '">' . $cb_5_stars.'<span class="cb-opacity cb-zero-stars-trigger" style="width:' . ( 100 - ${"cb_rating_". $j . "_score"}) . '%"></span></span></div>';
                            }
                        }
                    }
                }

                $cb_criterias .= '</div>';

                $cb_score_box = '<div class="cb-score-box' . $cb_star_bar . ' clearfix" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating"><meta itemprop="worstRating" content="0"><meta itemprop="bestRating" content="' . $cb_best_rating . '"><span class="score" itemprop="ratingValue">' . $cb_score_output . '</span>' . $cb_score_subtitle . '</div>';

                if ( $cb_review_type == 'cb-readers' ) {

                    $cb_score_box = '<div class="cb-score-box' . $cb_star_bar . ' cb-readers-only clearfix" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"><meta itemprop="worstRating" content="0"><meta itemprop="bestRating" content="' . $cb_best_rating . '"><meta itemprop="reviewCount" content="' . $cb_number_votes . '"><span class="score" itemprop="ratingValue">' . $cb_user_score_output . '</span>' . $cb_score_subtitle . '</div>';
                }
            }

            if ( $cb_criterias == '<div class="cb-criteria-area cb-review-area clearfix"></div>' ) {
                $cb_criterias = NULL;
            }
            
            if (  ( $cb_review_type == 'cb-both' ) || ( $cb_review_type == 'cb-readers' ) || ( $cb_review_type == 'on' ) ) {

                $cb_number_votes = get_post_meta( $cb_post_id, 'cb_votes', true );
                if ( $cb_number_votes == NULL) { $cb_number_votes = 0; }
                if ( $cb_user_score == NULL) { $cb_user_score = 0; }
                if ( $cb_score_display_type == "points" ) { $cb_average_score = '<div class="cb-criteria-score cb-average-score">' .  number_format(floatval($cb_user_score / 10 ), 1) . '</div>';  }
                if ( $cb_score_display_type == "percentage" ) { $cb_average_score = '<div class="cb-criteria-score cb-average-score">' . $cb_user_score . '%</div>'; }

                if ( isset( $_COOKIE["cb_post_left_rating"] ) ) {
                    $cb_class = " cb-voted";
                    $cb_tip_class = ' cb-tip-bot';
                    $cb_tip_title = 'data-cb-tip="' . __('You have already rated', 'cubell') . '"';
                }

                if ( $cb_number_votes == '1' ) {
                    $cb_vote_votes = __( 'Vote', 'cubell' );
                } else {
                    $cb_vote_votes = __( 'Votes', 'cubell' );
                }

                $cb_rating_text = __('Leave rating', 'cubell' );
                $cb_voted_text = __( 'You have already rated', 'cubell' );
                $cb_reader_rating = '<div class="cb-bar cb-font-header cb-review-area clearfix cb-user-rating' . $cb_star_bar . '"><div id="cb-vote" class="' . $cb_star_bar. ' ' . $cb_score_display_type . $cb_class . $cb_tip_class . '" data-cb-tip="' . $cb_voted_text . '" ' . $cb_tip_title . ' data-cb-nonce="' . wp_create_nonce( 'cburNonce' ) . '"><span class="cb-criteria" data-cb-text="' . $cb_rating_text . '">' . __( "Reader Rating", "cubell" ) . ' <span class="cb-votes-count">' . $cb_number_votes . ' ' . $cb_vote_votes . '</span></span>';

                if ( $cb_score_display_type == 'stars' ) {
                    $cb_reader_rating .= '<span class="cb-overlay' . $cb_star_overlay . ' cb' . $cb_star_overlay . '">' . $cb_5_stars . '<span class="cb-opacity" style="width:' . ( 100 - $cb_user_score).'%"></span></span></div></div>';
                } else {
                    $cb_reader_rating .= $cb_average_score. '<span class="cb-overlay"><span style="width:' . $cb_user_score . '%"></span></span></div></div>';
                }
            }

            $cb_closer = '</div><!-- /cb-review-box -->';
            $cb_output = $cb_opener . '<div class="cb-summary-area cb-review-area clearfix">' . $cb_review_title . $cb_pro_cons . $cb_score_box . '</div>' . $cb_criterias  . $cb_reader_rating . $cb_closer;

            return $cb_output;
        }
    }
}


/*********************
 REVIEW SCORE BOXES EXTERNAL
*********************/
if ( ! function_exists( 'cb_get_review_ext_box' ) ) {
    function cb_get_review_ext_box( $cb_post_id = NULL, $cb_small_box = false ) {

        $cb_output = $cb_small_box_output = NULL;
        $cb_category_color = cb_get_cat_color( $cb_post_id );
        $cb_review_checkbox = get_post_meta( $cb_post_id, 'cb_review_checkbox', true );

        if ( ( $cb_review_checkbox == 'on' ) || ( $cb_review_checkbox == '1' ) ) {

            $cb_review_type = get_post_meta($cb_post_id, 'cb_user_score', 'cb-both' );
            $cb_score_display_type = get_post_meta($cb_post_id, 'cb_score_display_type', true );
            $cb_user_score = get_post_meta( $cb_post_id, 'cb_user_score_output', true);
            $cb_final_score = get_post_meta($cb_post_id, 'cb_final_score', true );
            $cb_final_score_override = get_post_meta($cb_post_id, 'cb_final_score_override', true );

            if ( $cb_final_score_override != NULL ) {
               $cb_final_score = $cb_final_score_override;
            }
            
            if ( $cb_review_type == 'cb-readers' ) {
                $cb_final_score = $cb_user_score;
            }

            $cb_review_final_score = intval($cb_final_score);

            if ( $cb_score_display_type == 'percentage' ) {
                $cb_score_output = $cb_review_final_score . '<span class="cb-percent-sign">%</span>';
            }

            if ( $cb_score_display_type == 'points' ) {
                $cb_score_output = $cb_review_final_score / 10;
            }

            if ( $cb_score_display_type == 'stars' ) {
                $cb_review_final_score =  $cb_review_final_score / 20;
                $cb_score_output = number_format($cb_review_final_score, 1);
            }

            if ( $cb_small_box == true ) { $cb_small_box_output = ' cb-small-box'; }

            $cb_output = '<div class="cb-review-ext-box cb-font-header' . $cb_small_box_output . '"><span class="cb-bg" style="background:' . $cb_category_color . ';"></span><span class="cb-score">' . $cb_score_output . '</span></div>';
       }

       return $cb_output;

    }
}
/*********************
 REVIEW SCORE BOXES EXTERNAL
*********************/
if ( ! function_exists( 'cb_review_ext_box' ) ) {
    function cb_review_ext_box( $cb_post_id = NULL, $cb_small_box = false ) {

        echo cb_get_review_ext_box( $cb_post_id, $cb_small_box );
    }
}

/*********************
AUTHOR PAGE BOX
*********************/
if ( ! function_exists( 'cb_author_details' ) ) {
    function cb_author_details( $cb_author_id, $cb_class = NULL ) {

        $cb_author_email = get_the_author_meta('publicemail', $cb_author_id);
        $cb_author_name = get_the_author_meta('display_name', $cb_author_id);
        $cb_author_position = get_the_author_meta('position', $cb_author_id);
        $cb_author_tw = get_the_author_meta('twitter', $cb_author_id);
        $cb_author_instagram = get_the_author_meta('instagram', $cb_author_id);
        $cb_author_www = get_the_author_meta('url', $cb_author_id);
        $cb_author_desc = get_the_author_meta('description', $cb_author_id);

        $cb_author_output = NULL;
        $cb_author_output .= '<div class="cb-author-details cb-sidebar clearfix ' . $cb_class . '"><div class="cb-mask"><a href="' . get_author_posts_url($cb_author_id) . '">' . get_avatar($cb_author_id, '150') . '</a></div><div class="cb-meta"><h3 class="cb-font-header"><a href="' . get_author_posts_url($cb_author_id) . '">' . $cb_author_name . '</a></h3>';

        if ( $cb_author_position != NULL ) { $cb_author_output .= '<div class="cb-author-position cb-font-header">' . $cb_author_position . '</div>';}
       
        if ( $cb_author_desc != NULL ) { $cb_author_output .= '<p class="cb-author-bio">' . $cb_author_desc . '</p>'; }

        if ( ( $cb_author_email != NULL ) || ( $cb_author_www != NULL ) || ( $cb_author_tw != NULL ) || ( $cb_author_instagram != NULL ) ) { $cb_author_output .= '<div class="cb-author-page-contact">'; }
        if ( $cb_author_email != NULL ) { $cb_author_output .= '<a href="mailto:' . sanitize_email( $cb_author_email ) . '" class="cb-contact-icon cb-tip-bot" data-cb-tip="' . __('Email', 'cubell') . '"><i class="fa fa-envelope-o"></i></a>'; }
        if ( $cb_author_www != NULL ) { $cb_author_output .= ' <a href="' . esc_url( $cb_author_www ) . '" target="_blank" class="cb-contact-icon cb-tip-bot" data-cb-tip="'. __('Website', 'cubell') . '"><i class="fa fa-link"></i></a> '; }
        if ( $cb_author_tw != NULL ) { $cb_author_output .= ' <a href="//www.twitter.com/' . $cb_author_tw . '" target="_blank" class="cb-contact-icon cb-tip-bot" data-cb-tip="Twitter"><i class="fa fa-twitter"></i></a>'; }
        if ( $cb_author_instagram != NULL ) { $cb_author_output .= ' <a href="' . esc_url( $cb_author_instagram ) . '" target="_top" class="cb-contact-icon cb-tip-bot" data-cb-tip="Instagram"><i class="fa fa-instagram"></i></a>'; }
        if ( ( $cb_author_email != NULL ) || ( $cb_author_www != NULL ) || ( $cb_author_instagram != NULL ) || ( $cb_author_tw != NULL ) ) {$cb_author_output .= '</div>';}

        $cb_author_output .= '</div></div>';

        return $cb_author_output;
    }
}

if ( ! function_exists( 'cb_author_box' ) ) {
    function cb_author_box( $post, $cb_author_id_sc = NULL, $cb_block_title = NULL ) {

        return cb_about_author( $post, $cb_author_id_sc );
    }
}

/*********************
ABOUT THE AUTHOR BLOCK
*********************/
if ( ! function_exists( 'cb_about_author' ) ) {
    function cb_about_author( $post, $cb_author_id_sc = NULL ) {

        if ( ot_get_option( 'cb_author_box_onoff', 'on' ) == 'off' ) {
            return;
        }

        if ( $cb_author_id_sc == NULL ) {
            $cb_author_id = $post->post_author;
        } else {
            $cb_author_id = $cb_author_id_sc;
        }

        $cb_author_email = get_the_author_meta('publicemail', $cb_author_id);
        $cb_author_name = get_the_author_meta('display_name', $cb_author_id);
        $cb_author_position = get_the_author_meta('position', $cb_author_id);
        $cb_author_tw = get_the_author_meta('twitter', $cb_author_id);
        $cb_author_instagram = get_the_author_meta('instagram', $cb_author_id);
        $cb_author_www = get_the_author_meta('url', $cb_author_id);
        $cb_author_desc = get_the_author_meta('description', $cb_author_id);
        $cb_author_output = NULL;

        $cb_author_output .= '<div id="cb-author-box" class="cb-post-footer-block cb-post-block-bg clearfix"><div class="cb-mask"><a href="' . get_author_posts_url( $cb_author_id ) . '">' . get_avatar( $cb_author_id, '100' ) . '</a>';
        $cb_author_output .= '</div><div class="cb-meta">';

        $cb_author_output .= '<div class="cb-title cb-font-header vcard" itemprop="author"><a href="' . get_author_posts_url( $cb_author_id ) . '"><span class="fn">' . $cb_author_name . '</span></a>';
        $cb_author_output .= '</div>';
        if ( $cb_author_position != NULL ) { $cb_author_output .= '<div class="cb-author-position cb-font-header">' . $cb_author_position . '</div>';}
       
        if ( $cb_author_desc != NULL ) { $cb_author_output .= '<p class="cb-author-bio">' . $cb_author_desc . '</p>'; }

        if ( ( $cb_author_email != NULL ) || ( $cb_author_www != NULL ) || ( $cb_author_tw != NULL ) || ( $cb_author_instagram != NULL ) ) { $cb_author_output .= '<div class="cb-author-page-contact">'; }
        if ( $cb_author_email != NULL ) { $cb_author_output .= '<a href="mailto:' . sanitize_email( $cb_author_email ) . '" class="cb-contact-icon cb-tip-bot" data-cb-tip="' . __('Email', 'cubell') . '"><i class="fa fa-envelope-o"></i></a>'; }
        if ( $cb_author_www != NULL ) { $cb_author_output .= ' <a href="' . esc_url( $cb_author_www ) . '" target="_blank" class="cb-contact-icon cb-tip-bot" data-cb-tip="'. __('Website', 'cubell') . '"><i class="fa fa-link"></i></a> '; }
        if ( $cb_author_tw != NULL ) { $cb_author_output .= ' <a href="//www.twitter.com/' . $cb_author_tw . '" target="_blank" class="cb-contact-icon cb-tip-bot" data-cb-tip="Twitter"><i class="fa fa-twitter"></i></a>'; }
        if ( $cb_author_instagram != NULL ) { $cb_author_output .= ' <a href="' . esc_url( $cb_author_instagram ) . '" target="_top" class="cb-contact-icon cb-tip-bot" data-cb-tip="Instagram"><i class="fa fa-instagram"></i></a>'; }
        if ( ( $cb_author_email != NULL ) || ( $cb_author_www != NULL ) || ( $cb_author_instagram != NULL ) || ( $cb_author_tw != NULL ) ) {$cb_author_output .= '</div>';}
        $cb_author_output .= '</div>';

        $cb_author_output .= '</div>';

        return $cb_author_output;
    }
}


/*********************
AUTHOR FILTER
*********************/
if ( ! function_exists( 'cb_authors_filter' ) ) {
    function cb_authors_filter() {

        $cb_all_authors = array_merge( get_users( 'role=editor' ), get_users( 'role=administrator' ), get_users( 'role=author' ), get_users( 'role=contributor' ) );
        $cb_filtered = $cb_filtered_1 = $cb_filtered_2 = $cb_filtered_3 = $cb_filtered_4 = $cb_filtered_5 = array();

        foreach( $cb_all_authors as $cb_author )  {
            $cb_author_onoff = get_the_author_meta( 'cb_show_author', $cb_author->ID );
            $cb_author_order = get_the_author_meta( 'cb_order', $cb_author->ID );

              if ( ( $cb_author_onoff == 'true' ) && ( $cb_author_order == '0' ) ) {
                    array_push( $cb_filtered, $cb_author );
                }

              for( $i = 1; $i < 6; $i++ ) {

                   if ( ( $cb_author_onoff == 'true' ) && ( $cb_author_order == $i ) ) {
                       array_push( ${"cb_filtered_". $i.""}, $cb_author );
                   }
               }
        }

        $cb_filtered_authors = array_merge( $cb_filtered_1, $cb_filtered_2, $cb_filtered_3, $cb_filtered_4, $cb_filtered_5, $cb_filtered );
        return $cb_filtered_authors;
    }
}

/*********************
AUTHOR LIST
*********************/
if ( ! function_exists( 'cb_author_list' ) ) {
    function cb_author_list( $cb_full_width = false ) {

        $cb_authors = cb_authors_filter();
        $cb_authors_list = NULL;
        $i = 0;
        $x = 1;

        if ( $cb_full_width == true ) {
            $cb_line_amount = 3;
        } else {
            $cb_line_amount = 2;
        }

        if ( count( $cb_authors ) > 0) {

            $cb_authors_list .= '<div class="cb-author-line clearfix">';
            foreach ( $cb_authors as $cb_author ) {

                
                if ( ( $i % $cb_line_amount == 0 ) && ( $i != 0 ) ) {
                    $cb_authors_list .= '</div><div class="cb-author-line clearfix">';
                }

                if ( $cb_full_width == true ) {
                    if ( $x == 4 ) {
                        $x = 1;
                    }
                    $cb_class = 'cb-article-row-3 cb-article-row cb-no-' . $x;
                } else {
                    if ( $x == 3 ) {
                        $x = 1;
                    }
                    $cb_class = 'cb-article-row-2 cb-article-row cb-no-' . $x;
                }

                $cb_authors_list .=  cb_author_details( $cb_author->ID, $cb_class );
                $i++;
                $x++;

            }

            $cb_authors_list .= '</div>';

        }  else {

            $cb_authors_list .= '<h2>No Authors Are Currently Enabled</h2><p>Tick the "Show On About Us Page Template" checkbox on each author profile you wish to showcase here.</p>';
        }

       return $cb_authors_list;
    }
}

/*********************
AUTHOR FUNCTIONS
*********************/
if ( ! function_exists( 'cb_extra_profile_about_us' ) ) {
    function cb_extra_profile_about_us( $cb_user ) {

        $cb_saved = get_the_author_meta( 'cb_order', $cb_user->ID );
        $cb_current_user = get_current_user_id();
        $cb_user_info = get_userdata( $cb_current_user );

        if ( ( $cb_user_info->user_level ) > 8  && ( is_admin() == true ) ) {
?>
            <h3 class="cb-about-options-title">Meet The Team Page Template Options</h3>
            <table class="form-table cb-about-options">
                <tr>
                    <th><label>Show User On Template</label></th>
                    <td>
                        <input type="checkbox" name="cb_show_author" id="cb_show_author" value="true" <?php if (esc_attr( get_the_author_meta( "cb_show_author", $cb_user->ID )) == "true") echo "checked"; ?> />
                    </td>
                </tr>
                <tr>
                    <th><label for="dropdown">Template Order Override</label></th>
                    <td>
                        <select name="cb_order" id="cb_order">
                            <option value="0" <?php if ($cb_saved == "0") { echo  'selected="selected"'; } ?>>Alphabetical</option>
                            <option value="1" <?php if ($cb_saved == "1") { echo  'selected="selected"'; } ?>>1</option>
                            <option value="2" <?php if ($cb_saved == "2") { echo  'selected="selected"'; } ?>>2</option>
                            <option value="3" <?php if ($cb_saved == "3") { echo  'selected="selected"'; } ?>>3</option>
                            <option value="4" <?php if ($cb_saved == "4") { echo  'selected="selected"'; } ?>>4</option>
                            <option value="5" <?php if ($cb_saved == "5") { echo  'selected="selected"'; } ?>>5</option>
                        </select>
                    </td>
                </tr>
            </table>
<?php   }
    }
}
add_action( 'show_user_profile', 'cb_extra_profile_about_us' );
add_action( 'edit_user_profile', 'cb_extra_profile_about_us' );

if ( ! function_exists( 'cb_extra_profile_about_us_save' ) ) {
    function cb_extra_profile_about_us_save( $cb_user ) {

        $cb_current_user = get_current_user_id();
        $cb_user_info = get_userdata($cb_current_user);

        if ( ( $cb_user_info->user_level ) > 8 && ( is_admin() == true ) ) {

            if ( !current_user_can( 'edit_user', $cb_user ) ) { return false; }
            if ( isset( $_POST['cb_show_author'] ) ) {
                update_user_meta( $cb_user, 'cb_show_author', $_POST['cb_show_author'] );
            }
            
            update_user_meta( $cb_user, 'cb_order', $_POST['cb_order'] );
        }
    }
}

add_action( 'personal_options_update', 'cb_extra_profile_about_us_save' );
add_action( 'edit_user_profile_update', 'cb_extra_profile_about_us_save' );

/*********************
META FOR FEATURED IMAGE
*********************/
if ( ! function_exists( 'cb_meta_image_head' ) ) {
    function cb_meta_image_head() {

        if ( ( is_single() ) && ( ! class_exists( 'WPSEO_Admin' ) ) ) {
            global $post;
            $cb_post_id = $post->ID;
            if ( has_post_thumbnail( $cb_post_id ) ) {
                
                $cb_featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $cb_post_id ), 'full' );
                echo '<meta property="og:image" content="' . $cb_featured_image[0] . '">';

            }
        }
    }
}
add_action('wp_head', 'cb_meta_image_head');

/*********************
CHECK IF ON WOOCOMMERCE PAGE
*********************/
if ( ! function_exists( 'cb_is_woocommerce' ) ) {
    function cb_is_woocommerce() {
        if ( ( class_exists('Woocommerce') )  && ( ( is_woocommerce() ) || ( is_cart() ) || ( is_account_page() ) || ( is_order_received_page() ) || ( is_checkout() ) ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/*********************
POST BODY FONTS
*********************/
if ( ! function_exists( 'cb_ot_recognized_font_families' ) ) {
    function cb_ot_recognized_font_families() { 
        return array(
              'off'  => 'Use "General Body text font" option',
              '\'Merriweather\', serif;'     => 'Merriweather',
              '\'Open Sans\', sans-serif;'   => 'Open Sans',
              '\'Oswald\', sans-serif;' => 'Oswald',
              'other'  => 'Other Google Font',
            );
    }
}
add_filter( 'ot_recognized_font_families', 'cb_ot_recognized_font_families' );

/*********************
FONT VARIANTS
*********************/
if ( ! function_exists( 'cb_ot_recognized_font_variants' ) ) {
    function cb_ot_recognized_font_variants() { 
        return array(
              'justify'  => 'Justify',
              'left'     => 'Align Left',
              'center'   => 'Align Center',
            );
    }
}
add_filter( 'ot_recognized_font_variants', 'cb_ot_recognized_font_variants' );

/*********************
BACKGROUND VARIANTS
*********************/
if ( ! function_exists( 'cb_ot_bg_fields' ) ) {
    function cb_ot_bg_fields() { 
        return array( 
          'background-color',
          'background-repeat', 
          'background-position',
          'background-image'
        );
    }
}
add_filter( 'ot_recognized_background_fields', 'cb_ot_bg_fields' );

if ( ! function_exists( 'ot_recognized_background_repeat' ) ) {
  
  function ot_recognized_background_repeat( $field_id = '' ) {

    return apply_filters( 'ot_recognized_background_repeat', array(

      'stretch' => 'Stretch to fit',
      'no-repeat' => 'No Repeat',
      'repeat'    => 'Repeat All',
      'repeat-x'  => 'Repeat Horizontally',
      'repeat-y'  => 'Repeat Vertically',
      'inherit'   => 'Inherit'
    ), $field_id );
    
  }
  
}

/*********************
BACKGROUNDS
*********************/
if ( ! function_exists( 'cb_backgrounds' ) ) {
    function cb_backgrounds() {

        $cb_output = $cb_post_type = $cb_bg_img = $cb_bg_color =  $cb_body_bg_repeat = NULL;

        if ( is_single() ) {
            global $post;
            $cb_post_type = get_post_type();
        }

        $cb_mobile = new Mobile_Detect;
        $cb_phone = $cb_mobile->isMobile();
        $cb_tablet = $cb_mobile->isTablet();

        if ( ( $cb_tablet == true ) || ( $cb_phone == true ) ) {
            $cb_is_mobile = true;
        } else {
            $cb_is_mobile = false;
        }

        $cb_background_image = ot_get_option('cb_background_image', NULL );

        if ( is_singular() ) {
            global $post;

            $cb_post_background_image = get_post_meta( $post->ID, 'cb_background_image', true );
            $cb_featured_image_style = get_post_meta( $post->ID, 'cb_featured_image_style', true );

            if ( $cb_featured_image_style == 'standard-uncrop' ) {
                $cb_featured_image_style = 'standard';
            }

            if ( ( $cb_featured_image_style != 'standard' ) && ( $cb_featured_image_style != 'site-width' ) && ( $cb_featured_image_style != 'off' ) && ( $cb_featured_image_style != NULL ) ) {
                 $cb_background_image = NULL;
            }

            if ( $cb_post_background_image != NULL ) {
                $cb_background_image = $cb_post_background_image;
            }
        }

        if ( ( class_exists('bbPress') ) && ( is_bbpress() ) ) {
            $cb_background_image = ot_get_option('cb_bbpress_background_image', NULL );
        }

        if ( cb_is_woocommerce() ) {
            $cb_background_image = ot_get_option('cb_woocommerce_background_image', NULL );
        }

        if ( $cb_background_image != NULL ) {
            if ( array_key_exists( 'background-color', $cb_background_image ) && ( $cb_background_image['background-color'] != NULL ) ) {
                $cb_bg_color = ' background-color: ' . $cb_background_image['background-color'] . ';';
            }
            if ( array_key_exists( 'background-repeat', $cb_background_image ) ) {

                if ( ( $cb_background_image['background-repeat'] == NULL ) || ( $cb_background_image['background-repeat'] == 'stretch' )) {

                } else {

                    if ( array_key_exists( 'background-image', $cb_background_image ) ) {
                        $cb_bg_img = ' background-image: url(' . esc_url( $cb_background_image['background-image'] ) . ');';
                    }

                    $cb_body_bg_repeat = ' background-repeat: ' . $cb_background_image['background-repeat'] . '; }';
                }
            }
        }

        if ( ( $cb_bg_color != NULL ) || ( $cb_bg_img != NULL ) ) {
            $cb_output .= '<!-- Body BG --><style>@media only screen and (min-width: 1200px) { body {' . $cb_bg_img . $cb_bg_color  . $cb_body_bg_repeat . '} }</style>';
        }

        echo $cb_output;
    }
}

add_action('wp_head', 'cb_backgrounds');


/*********************
BACKGROUND IMAGE/COLOR
*********************/
if ( ! function_exists( 'cb_background_image' ) ) {
    function cb_background_image() {

        $cb_bg_to = ot_get_option( 'cb_bg_to', 'off' );

        if ( ( $cb_bg_to == 'off' ) || ( ( $cb_bg_to == 'only-hp' ) && ( ! is_front_page() ) ) ) {

            $cb_mobile = new Mobile_Detect;
            $cb_phone = $cb_mobile->isMobile();
            $cb_tablet = $cb_mobile->isTablet();
            if ( ( $cb_tablet == true ) || ( $cb_phone == true ) ) {
                $cb_is_mobile = true;
            } else {
                $cb_is_mobile = false;
            }

            $cb_override = NULL;

            if ( $cb_is_mobile == false ) {


                $cb_output = $cb_featured_image_style = NULL;

                $cb_background_image = ot_get_option('cb_background_image', array() );

                if ( is_singular() ) {
                    global $post;

                    $cb_post_background_image = get_post_meta( $post->ID, 'cb_background_image', true );
                    $cb_featured_image_style = get_post_meta( $post->ID, 'cb_featured_image_style', true );

                    if ( $cb_post_background_image != NULL ) {
                        $cb_background_image = $cb_post_background_image;
                        $cb_override = true;
                    }
                    
                }

                if ( ( class_exists('bbPress') ) && ( is_bbpress() ) ) {
                    $cb_bbpress_background_image = ot_get_option('cb_bbpress_background_image', array() );

                    if ( array_key_exists( 'background-image', $cb_bbpress_background_image ) ) {
                        $cb_background_image = $cb_bbpress_background_image;
                    }
                }

                if ( cb_is_woocommerce() ) {
                    $cb_woocommerce_background_image = ot_get_option('cb_woocommerce_background_image', array() );

                    if ( array_key_exists( 'background-image', $cb_woocommerce_background_image ) ) {
                        $cb_background_image = $cb_woocommerce_background_image;
                    }
                }


                if ( array_key_exists( 'background-repeat', $cb_background_image ) ) {

                    if ( ( $cb_background_image['background-repeat'] == NULL ) || ( $cb_background_image['background-repeat'] == 'stretch' )) {

                        $cb_output = $cb_background_image['background-image'];
                    }
                }

                if ( ( ( $cb_featured_image_style == 'parallax' ) || ( $cb_featured_image_style == 'full-background' ) || ( $cb_featured_image_style == 'screen-width' ) ) && ( $cb_override == NULL ) ) {
                    $cb_output = NULL;
                }

                if ( is_category() ) {
                    if ( function_exists( 'get_tax_meta' ) ) {
                        $cb_cat_id = get_query_var( 'cat' );
                        $cb_category_bg = get_tax_meta( $cb_cat_id, 'cb_bg_image_field_id' );
                        if ( ( $cb_category_bg != NULL ) && ( isset( $cb_category_bg['url'] ) ) ) {
                            $cb_output = $cb_category_bg['url'];
                        }
                    }
                }

                if ( $cb_output != NULL ) {
                    echo '<script type="text/javascript">jQuery(document).ready(function($){
                            $("body").backstretch("' . esc_url( $cb_output ) . '", {fade: 1000});
                        });  </script>';
                }
            }
        }

    }
}

add_action( 'wp_footer', 'cb_background_image' );


/*********************
POSTS IN FRONTEND SEARCHES
*********************/
if ( ! function_exists( 'cb_clean_search' ) ) {
    function cb_clean_search($cb_query) {

        if ( ! is_admin() && ( $cb_query->is_search == true ) ) {

            if ( class_exists( 'bbPress') && ( is_bbpress() == true ) ) {
            } elseif ( cb_is_woocommerce() ) {
            } else {
                $cb_cpt_output = cb_get_custom_post_types();
                $cb_query->set( 'post_type', $cb_cpt_output );
            }

        }
        return $cb_query;
    }
}
add_filter('pre_get_posts','cb_clean_search');

/*********************
HEADER BANNER
*********************/
if ( ! function_exists( 'cb_header_banner' ) ) {
    function cb_header_banner() {
        $cb_banner = ot_get_option( 'cb_banner_selection', NULL );
        $cb_banner_code = ot_get_option( 'cb_banner_code', NULL );
        $cb_output = NULL;

        if ( is_home() || is_category() || is_tag() || is_singular() || is_archive() ) {

            if ( $cb_banner == 'cb_banner_468' ) {

                $cb_output = '<div class="cb-medium cb-block">' . do_shortcode( $cb_banner_code ) . '</div>';

            } elseif ( $cb_banner == 'cb_banner_728' ) {

                $cb_output =  '<div class="cb-large cb-block">'. do_shortcode( $cb_banner_code ) . '</div>';

            }
        }

        return $cb_output;
    }
}

/*********************
LOGO
*********************/
if ( ! function_exists( 'cb_logo' ) ) {
    function cb_logo() {

        $cb_logo = ot_get_option( 'cb_logo_url', NULL );
        $cb_retina_logo = ot_get_option( 'cb_logo_retina_url', NULL );

        if ( $cb_logo != NULL ) {

            ?>
                <div id="logo">
                    <a href="<?php echo esc_url( home_url() );?>">
                        <img src="<?php  echo esc_url( $cb_logo ); ?>" alt="<?php esc_html( get_bloginfo( 'name' ) );  ?> logo" <?php if ( $cb_retina_logo != NULL ) { echo 'data-at2x="' . esc_url( $cb_retina_logo ) . '"'; } ?>>
                    </a>
                </div>
            <?php
        }
    }
}

/*********************
LOGO
*********************/
if ( ! function_exists( 'cb_mob_logo' ) ) {
    function cb_mob_logo() {

        if ( ot_get_option( 'cb_m_logo_mobile', 'off' ) == 'off' ) {
            return;
        }

        $cb_logo = ot_get_option( 'cb_logo_nav_m_url', NULL );
        $cb_retina_logo = ot_get_option( 'cb_logo_nav_m_retina_url', NULL );

        if ( $cb_logo != NULL ) {

            ?>
                <div id="mob-logo" class="cb-top-logo">
                    <a href="<?php echo esc_url( home_url() );?>">
                        <img src="<?php  echo esc_url( $cb_logo ); ?>" alt="<?php esc_html( get_bloginfo( 'name' ) );  ?> logo" <?php if ( $cb_retina_logo != NULL ) { echo 'data-at2x="' . esc_url( $cb_retina_logo ) . '"'; } ?>>
                    </a>
                </div>
            <?php
        }
    }
}


/*********************
WOOCOMMERCE
*********************/
if ( ! function_exists( 'cb_disqus_woocommerce' ) ) {
    function cb_disqus_woocommerce( $post ) {

        $cb_post_id = $post->ID;
        $cb_post_title = $post->post_title;
        $cb_disqus_forum_shortname = ot_get_option('cb_disqus_shortname', NULL);

        wp_enqueue_script( 'cb_disqus', '//' . $cb_disqus_forum_shortname . '.disqus.com/embed.js' );
        echo '<div id="disqus_thread"></div>
        <script type="text/javascript">
            var disqus_shortname = "' . $cb_disqus_forum_shortname . '";
            var disqus_title = "' . $cb_post_title . '";
            var disqus_url = "' . get_permalink( $cb_post_id ) . '";
            var disqus_identifier = "' . $cb_disqus_forum_shortname . '-' . $cb_post_id . '";
        </script>';
    }
}

if ( ! function_exists( 'woocommerce_template_single_title' ) ) {

    function woocommerce_template_single_title() {
       return;
    }
}

if ( ! function_exists( 'cb_woocommerce_show_page_title' ) ) {

    function cb_woocommerce_show_page_title() {
       return false;
    }
}
add_filter( 'woocommerce_show_page_title', 'cb_woocommerce_show_page_title' );


if ( ! function_exists( 'cb_Woocommerce_pagi' ) ) {

    function cb_Woocommerce_pagi() {

       return  array(
            'prev_text'     => '<i class="fa fa-long-arrow-left"></i>',
            'next_text'     => '<i class="fa fa-long-arrow-right"></i>',
        );
    }
}
add_filter( 'woocommerce_pagination_args', 'cb_Woocommerce_pagi' );


if ( ! function_exists( 'cb_woocommerce_loop_count' ) ) {
    function cb_woocommerce_loop_count() {
        if ( ot_get_option('cb_woocommerce_sidebar', NULL ) == 'nosidebar' ) {
            return 4;
        } else {
            return 3;
        }
        
    }
}
add_filter( 'loop_shop_columns', 'cb_woocommerce_loop_count' );

if ( ! function_exists( 'cb_woocommerce_add_cart_button' ) ) {
    function cb_woocommerce_add_cart_button() {
        global $product;
        return sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s product_type_%s">%s</a>',
                    esc_url( $product->add_to_cart_url() ),
                    esc_attr( $product->id ),
                    esc_attr( $product->get_sku() ),
                    esc_attr( isset( $quantity ) ? $quantity : 1 ),
                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                    esc_attr( $product->product_type ),
                    esc_html( $product->add_to_cart_text() )
                );
    }
}
add_filter( 'woocommerce_loop_add_to_cart_link', 'cb_woocommerce_add_cart_button', 10, 2 );


if ( ! function_exists( 'cb_modals' ) ) {
    function cb_modals() {

        if ( function_exists( 'login_with_ajax' ) ) {  
            echo '<div id="cb-lwa" class="cb-lwa-modal cb-modal">'; 
            login_with_ajax(); 
            echo '</div>';  
        }

        if ( is_single() ) {
            global $post;
            $cb_post_id = $post->ID;
            $cb_post_format = get_post_format($cb_post_id);
            $cb_video_post_select = get_post_meta( $cb_post_id, 'cb_video_post_select', true );
            $cb_audio_post_style = get_post_meta( $cb_post_id, 'cb_audio_post_style', true );

            if ( ( ( $cb_post_format == 'video' ) && ( $cb_video_post_select == '2' ) ) || ( ( $cb_post_format == 'audio' ) && ( $cb_audio_post_style == '2' ) ) ) {
                echo '<div id="cb-media-overlay" class="cb-modal cb-m-modal"><div class="cb-m-modal-inner"><div class="cb-close-m cb-ta-right"><i class="fa cb-times"></i></div>' .  cb_get_post_format_data( $cb_post_id,  $cb_post_format ) . '</div></div>';
            }
        }
        
        echo '<div id="cb-menu-search" class="cb-s-modal cb-modal"><div class="cb-close-m cb-ta-right"><i class="fa cb-times"></i></div><div class="cb-s-modal-inner cb-pre-load cb-light-loader cb-modal-inner cb-font-header cb-mega-three cb-mega-posts clearfix">' . get_search_form( false ) .'<div id="cb-s-results"></div></div></div>';
    }
}

if ( ! function_exists( 'cb_modal_logo' ) ) {
    function cb_modal_logo() {
        $cb_logo = ot_get_option('cb_lwa_logo', NULL ); 
        $cb_logo_retina = ot_get_option('cb_lwa_logo_retina', NULL ); 

        if  ( $cb_logo != NULL ) {

?>
            <div class="cb-lwa-logo cb-ta-center">
                <img src="<?php echo esc_url( $cb_logo ); ?>" alt="<?php esc_html( get_bloginfo( 'name' ) ); ?> logo" <?php if ( $cb_logo_retina != NULL ) { echo 'data-at2x="' . $cb_logo_retina . '"'; } ?>>
            </div>
<?php 
        }
    }
}


if ( ! function_exists( 'cb_bbp_breadcrumb_args' ) ) {

    function cb_bbp_breadcrumb_args() {

       return  array(
            'before' => '<div class="bbp-breadcrumb cb-breadcrumbs"><p>',
        );
    }
}

add_filter( 'bbp_before_get_breadcrumb_parse_args', 'cb_bbp_breadcrumb_args' );

if ( ! function_exists( 'cb_bbp_subscribe_be_af' ) ) {

    function cb_bbp_subscribe_be_af() {

       return  array(
            'before'      => '<span class="cb-font-header">',
            'after'       => '</span>'
        );
    }
}

add_filter( 'bbp_before_get_user_subscribe_link_parse_args', 'cb_bbp_subscribe_be_af' );


if ( ! function_exists( 'cb_admin_fonts' ) ) {
    function cb_admin_fonts(){

        wp_register_style( 'cb-admin-font',  '//fonts.googleapis.com/css?family=Raleway:400,700', array(), '1.0', 'all' );
        wp_enqueue_style('cb-admin-font');

    }
}
add_action('admin_enqueue_scripts', 'cb_admin_fonts' );


if ( ! function_exists( 'cb_a_s' ) ) {
    function cb_a_s() {

        if ( ! wp_verify_nonce( $_POST['cburNonce'], 'cburNonce' ) ) {
            die();
        }

        $cb_post_id = intval($_POST['cbPostID']);
        $cb_latest_score = intval($_POST['cbNewScore']);
        $cb_current_votes = get_post_meta( $cb_post_id, 'cb_votes', true );
        $current_score = get_post_meta( $cb_post_id, 'cb_user_score_output', true );
        $cb_score_type = get_post_meta( $cb_post_id, 'cb_score_display_type', true );
        
        if ( $cb_current_votes == NULL ) { $cb_current_votes = 0; }

        $cb_current_votes = intval( $cb_current_votes );
        $cb_new_votes = intval( $cb_current_votes + 1 );
        $current_score = intval( $current_score );

        if ( $cb_current_votes == 0 ) {
            $cb_new_score = intval( $cb_latest_score );
        } elseif ( $cb_current_votes == 1 ) {
            $cb_new_score = (intval( $current_score + $cb_latest_score ) ) / 2;
        } elseif ( $cb_current_votes > 1 ) {
            $current_score_total = ( $current_score * $cb_current_votes );
            $cb_new_score = intval( ( $current_score_total + $cb_latest_score ) / $cb_new_votes );
        }

        if ( $cb_score_type == 'percentage' ) { $cb_new_score  = round($cb_new_score); }
        
        update_post_meta( $cb_post_id, 'cb_user_score_output', $cb_new_score );
        update_post_meta( $cb_post_id, 'cb_votes', $cb_new_votes );

        if ( $cb_new_votes == 1 ) {
            $cb_votes_text = $cb_new_votes . ' ' . __( 'Vote', 'cubell' );
        } else {
            $cb_votes_text = $cb_new_votes . ' ' . __( 'Votes', 'cubell' );
        }

        $cb_output = json_encode( array( $cb_new_score, $cb_new_votes, $cb_votes_text ) );

        die( $cb_output );
    }
}
add_action('wp_ajax_cb_a_s', 'cb_a_s');
add_action('wp_ajax_nopriv_cb_a_s', 'cb_a_s');

if ( ! function_exists( 'cb_show_header' ) ) {
    function cb_show_header() {

        global $post;
        if ( is_single() ) {
             $cb_post_format = get_post_format( $post->ID );
         } else {
             $cb_post_format = NULL;
         }
       
        $cb_featured_image_style  = get_post_meta( $post->ID, 'cb_featured_image_style', true );

        if ( ( $cb_post_format != 'gallery' ) && ( ( $cb_featured_image_style == 'parallax' ) || ( $cb_featured_image_style == 'background-slideshow' ) ||  ( $cb_featured_image_style == 'full-background' ) ||  ( $cb_featured_image_style == 'screen-width' ) ) ) {
            if ( get_post_meta( $post->ID, 'cb_post_fis_header', true ) == 'off' ) {
                return 'off';
            }
            
        }
        if ( $cb_post_format == 'gallery' ) {
            if ( get_post_meta( $post->ID, 'cb_post_gallery_fis_header', true ) == 'off' ) {
                return 'off';
            }
        }
    }
}
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 14 );

?>
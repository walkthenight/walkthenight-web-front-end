<?php /* Template Name: 15Zine Drag & Drop Builder */

get_header();
$cb_page_id = get_the_ID();
$cb_section_a = get_post_meta( $cb_page_id, 'cb_section_a', true );
$cb_section_b = get_post_meta( $cb_page_id, 'cb_section_b', true );
$cb_section_c = get_post_meta( $cb_page_id, 'cb_section_c', true );
$cb_section_f = get_post_meta( $cb_page_id, 'cb_section_f', true );
$cb_pb_onoff = get_post_meta( $cb_page_id, 'cb_pb_onoff', true );
$cb_extra_padding = NULL;

if ( $cb_section_f != NULL ) {
    $cb_extra_padding = ' cb-xtra-pad';
}
while ( have_posts() ) {

    the_post();
    $cb_classes = implode( ' ', get_post_class( 'clearfix', $cb_page_id ) );

    if ( get_the_content() != NULL) {
    echo '<div id="cb-content" class="wrap cb-pb clearfix"><div class="cb-full-width clearfix" role="main"><article id="post-' . $cb_page_id . '" class="' . $cb_classes . ' cb-entry-content">' . do_shortcode( get_the_content() ) . '</article></div></div>';
    }
}

$cb_paged = get_query_var('page');

if ( $cb_paged == NULL ) {
    for ( $cb_section_count = 1; $cb_section_count < 5; $cb_section_count++ ) {

        if ( $cb_section_count == 1 ) { $cb_x = 'a'; $cb_flag_a = true; }
        if ( $cb_section_count == 2 ) { $cb_x = 'f'; }
        if ( $cb_section_count == 3 ) { $cb_x = 'b'; }
        if ( $cb_section_count == 4 ) { $cb_x = 'c'; }

        if ( ${'cb_section_' . $cb_x} != NULL ) {

            if ( $cb_x == 'b' ) {
                if ( $cb_section_a == NULL ) { $cb_section_spacing = ' cb-section-top'; } else { $cb_section_spacing = NULL; }
                $j = 0;
                $cb_section = NULL;
                echo '<section id="cb-section-b" class="cb-site-padding wrap cb-hp-section clearfix' . $cb_section_spacing . $cb_extra_padding . '"><div class="cb-main">';
            } elseif ( $cb_x == 'c' ) {
                if ( ( $cb_section_b == NULL ) && ( $cb_section_f != NULL ) ) {
                    $cb_extra_padding = ' cb-xtra-pad';
                }
                $cb_section = 'c';
                $j = 0;
                echo '<section id="cb-section-c" class="cb-site-padding wrap cb-hp-section clearfix' . $cb_extra_padding . '">';
            } elseif ( $cb_x == 'f' ) {
                $cb_section = 'f';
                $j = 0;
                echo '<section id="cb-section-f" class="clearfix">';
            }

            foreach ( ${'cb_section_' . $cb_x} as $cb_module ) {

                if ( $cb_x == 'a' ) {
                    $cb_section = 'a';
                    $g = $j = $x = 0;
                    if ( $cb_flag_a == true ) {

                        if ( ( $x == 0 ) && ( ( 0 === strpos($cb_module['cb_a_module_style'], 'grid') ) || ( $cb_module['cb_a_module_style'] == 's-5a' ) ) ) {
                            echo '<section id="cb-section-a" class="cb-site-padding wrap cb-hp-section clearfix">';
                        } elseif ( $x == 0 ) {
                            echo '<section id="cb-section-a" class="cb-site-padding wrap cb-hp-section clearfix' . $cb_extra_padding . '">';
                        }
                        $cb_flag_a = false;
                    }
                }

                $cb_offset = $cb_order = $cb_orderby = $cb_filter = $cb_cat_id = $cb_tag_id = $cb_post_ids = NULL;

                if ( isset($cb_module['cb_order']) ) {

                    if ( $cb_module['cb_order'] == 'cb_latest' ) {
                        $cb_order = 'DESC';
                        $cb_orderby = 'date';
                    } elseif ( $cb_module['cb_order'] == 'cb_random' ) {
                        $cb_order = 'DESC';
                        $cb_orderby = 'rand';
                    } elseif ( $cb_module['cb_order'] == 'cb_oldest' ) {
                        $cb_order = 'ASC';
                        $cb_orderby = 'date';
                    }

                }

                if ( isset($cb_module['cb_filter']) ) {

                    $cb_filter = $cb_module['cb_filter'];

                    if ( ( $cb_filter == 'cb_filter_category' ) && isset( $cb_module['cb_' . $cb_x . '_latest_posts'] ) ) {
                        $cb_cat_id_selection = $cb_module['cb_' . $cb_x . '_latest_posts'];

                        $cb_cat_id = implode(',', $cb_cat_id_selection);

                    } elseif ( ( $cb_filter == 'cb_filter_postid' ) && isset( $cb_module['ids_posts_cb'] ) ) {

                        $cb_post_names = array_filter( explode( '<cb>', $cb_module['ids_posts_cb'] ) );
                        $cb_post_ids = array();

                        foreach ( $cb_post_names as $cb_post_single ) {
                            $cb_post_single_term = get_page_by_title( $cb_post_single, OBJECT, 'post' );
                            if ( $cb_post_single_term != NULL ) {
                                $cb_post_ids[] = $cb_post_single_term->ID;
                            }
                            
                        }

                    } elseif ( ( $cb_filter == 'cb_filter_tags' )  && isset( $cb_module['tags_cb'] ) ) {

                        $cb_tag_names = array_filter( explode( ',', $cb_module['tags_cb'] ) );
                        $cb_tag_id = array();

                        foreach ( $cb_tag_names as $cb_tag ) {
                            $cb_tag_term = get_term_by( 'name', $cb_tag, 'post_tag' );
                            $cb_tag_id[] = $cb_tag_term->term_id;
                        }
                    }

                } else {

                    if ( isset($cb_module['cb_' . $cb_x . '_latest_posts']) ) {
                        $cb_cat_id_selection = $cb_module['cb_' . $cb_x . '_latest_posts'];
                        $cb_cat_id = implode(',', $cb_cat_id_selection);
                        $cb_cat_name = get_category($cb_cat_id)->name;
                        $cb_cat_url = get_category_link($cb_cat_id);
                    } else {
                        $cb_cat_id_selection = get_terms( 'category', array('fields' => 'ids') );
                        $cb_cat_id = implode(',', $cb_cat_id_selection);
                        $cb_cat_name = get_category($cb_cat_id)->name;
                        $cb_cat_url = get_category_link($cb_cat_id);
                    }
                }

                if ( isset($cb_module['cb_offset']) ) {
                    $cb_offset = $cb_module['cb_offset'];
                }

                $cb_amount = $cb_module['cb_slider_' . $cb_x];

                $cb_title = $cb_module['title'];
                if ( $cb_section != 'f' ) {
                    $cb_ad_code = $cb_module['cb_ad_code_' . $cb_x];
                     $cb_subtitle = $cb_module['cb_subtitle_' . $cb_x];

                    if ( $cb_subtitle != NULL ) {
                        $cb_subtitle = '<p>' . $cb_subtitle . '</p>';
                    }
                }
                $cb_custom = $cb_module['cb_custom_' . $cb_x];
               

                if ( is_rtl() ) {
                    $cb_slider_ltr_rtl = ' style="direction:ltr;"';
                } else {
                    $cb_slider_ltr_rtl = NULL;
                }

                $cb_module_type = substr_replace( $cb_module['cb_' . $cb_x . '_module_style'] , '', -1 );

                if ( ( $cb_module_type == 'grid-3' ) || ( $cb_module_type == 'grid-4' ) || ( $cb_module_type == 'grid-5' ) || ( $cb_module_type == 'grid-6' ) ) {
                    $cb_ppp = substr( $cb_module_type, -1 );
                    $cb_module_type = 'grid-x';
                } else {
                    $cb_ppp = NULL;
                }

                if ( ( function_exists( 'get_tax_meta' ) ) && ( $cb_cat_id != NULL ) ) {
                    $cb_category_color = get_tax_meta( $cb_cat_id, 'cb_color_field_id' );
                } else {
                    $cb_category_color = NULL;
                }

                include( locate_template('library/modules/cb-' . $cb_module_type . '.php') );

                if ( $cb_x == 'a' ) {

                    $j++;
                    $g++;
                    $x++;

                } elseif ( $cb_x == 'c' ) {

                    $j++;
                }
            }

            if ( $cb_x == 'b' ) {

                echo '</div>';

                $cb_sidebar_select =  get_post_meta( $cb_page_id, 'cb_sidebar_select', true );
                if ( $cb_sidebar_select == NULL ) {
                    

                    if ( is_active_sidebar( 'sidebar-hp-' . $cb_x . '-' . $cb_page_id ) ) {
                        /*if ( ot_get_option('cb_sticky_hp_sb', 'on') == 'on' ) {
                            echo '<div class="cb-sticky-sidebar-b">';
                        }*/
                        echo '<aside id="cb-sidebar-' . $cb_x . '" class="cb-sidebar clearfix' . $cb_section_spacing . '" role="complementary">';
                        dynamic_sidebar( 'sidebar-hp-' . $cb_x . '-' . $cb_page_id );
                        echo '</aside>';
                        /*if ( ot_get_option('cb_sticky_hp_sb', 'on') == 'on' ) {
                            echo '</div>';
                        }*/
                    }
                } else {

                    $cb_sidebar_id = $cb_sidebar_select;
                    if ( is_active_sidebar( $cb_sidebar_id ) == true ) {
                        if ( ( $cb_pb_onoff != 'on' ) && ( ot_get_option('cb_sticky_sb', 'on') == 'on' ) ) {
                            echo '<div class="cb-sticky-sidebar">';
                        }
                        echo '<aside class="cb-sidebar clearfix" role="complementary">';
                        dynamic_sidebar( $cb_sidebar_id );
                        echo '</aside>';
                        if ( ( $cb_pb_onoff != 'on' ) && ( ot_get_option('cb_sticky_sb', 'on') == 'on' ) ) {
                            echo '</div>';
                        }
                    }
                }
                
            }
            
            echo '</section>';

        }

    }
}

if ( $cb_pb_onoff == 'on' ) {
        $cb_pb_bs = get_post_meta( $cb_page_id, 'cb_pb_bs', true );
        $cb_pb_infinite = get_post_meta( $cb_page_id, 'cb_pb_infinite', true );
        $cb_title = get_post_meta( $cb_page_id, 'cb_pb_title', true );
        $cb_subtitle = get_post_meta( $cb_page_id, 'cb_pb_subtitle', true );
        if ( $cb_pb_bs == 'i' ) {
            echo '<section id="cb-section-lp" class="cb-site-padding wrap cb-hp-section cb-fw-bs clearfix">';
        } else {
            echo '<section id="cb-section-lp" class="cb-site-padding wrap cb-hp-section clearfix">';
        }
        
        echo '<div id="main" class="cb-main clearfix cb-module-block" role="main">';
        if ( $cb_title != NULL ) {
            echo '<div class="cb-module-header"><h2 class="cb-module-title" >' . $cb_title . '</h2><p>' . $cb_subtitle . '</p></div>';
        }
        include( locate_template( 'blog-style-' . $cb_pb_bs . '.php') );
        echo '</div> <!-- /main -->';

        if ( is_active_sidebar( 'sidebar-global' ) && ( $cb_pb_bs != 'i' ) ) {
            if ( ot_get_option('cb_sticky_hp_sb', 'on') == 'on' ) {
                echo '<div class="cb-sticky-sidebar">';
            }
            echo '<aside class="cb-sidebar clearfix" role="complementary">';
            dynamic_sidebar( 'sidebar-global' );
            echo '</aside>';
            if ( ot_get_option('cb_sticky_hp_sb', 'on') == 'on' ) {
                echo '</div>';
            }
        }
        echo '</section>';

    }

?>

<?php get_footer(); ?>
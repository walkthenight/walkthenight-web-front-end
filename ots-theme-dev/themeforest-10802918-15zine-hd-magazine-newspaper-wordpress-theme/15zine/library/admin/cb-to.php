<?php
/**
 * Initialize the custom theme options.
 */
add_action( 'admin_init', 'cb_to' );

/**
 * Build the custom settings & update OptionTree.
 */
function cb_to() {
  /**
   * Get a copy of the saved settings array.
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  $cb_docs_url = 'http://docs.cubellthemes.com/15zine/';
  $cb_support_url = 'http://support.cubellthemes.com';
  /**
   * Custom settings array that will eventually be
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array(
    'contextual_help' => array(
      'sidebar'       => 'Get help here'
    ),
    'sections'        => array(
      array(
        'id'          => 'ot_general',
        'title'       => '<i class="fa fa-pencil-square-o"></i> Logos'
      ),
      array(
        'id'          => 'ot_styling',
        'title'       => '<i class="fa fa-eyedropper"></i> Design'
      ),
      array(
        'id'          => 'ot_sitewidth',
        'title'       => '<i class="fa fa-arrows-h"></i> Site Width'
      ),
      array(
        'id'          => 'ot_stickies',
        'title'       => '<i class="fa fa-magic"></i></i> Stickies'
      ),
      array(
        'id'          => 'ot_homepage',
        'title'       => '<i class="fa fa-home"></i> Homepage'
      ),
      array(
        'id'          => 'ot_menus',
        'title'       => '<i class="fa fa-bars"></i> Menus'
      ),
      array(
        'id'          => 'ot_post_settings',
        'title'       => '<i class="fa fa-newspaper-o"></i> Posts'
      ),
      array(
        'id'          => 'ot_footer',
        'title'       => '<i class="fa fa-th"></i> Footer'
      ),
      array(
        'id'          => 'ot_typography',
        'title'       => '<i class="fa fa-pencil"></i> Typography'
      ),
      array(
        'id'          => 'ot_advertising',
        'title'       => '<i class="fa fa-bullhorn"></i> Advertisement'
      ),
      array(
        'id'          => 'ot_custom_code',
        'title'       => '<i class="fa fa-code"></i> Custom Code'
      ),
      array(
        'id'          => 'ot_bbpress',
        'title'       => '<i class="fa fa-comment-o"></i> bbPress'
      ),
      array(
        'id'          => 'ot_woocommerce',
        'title'       => '<i class="fa fa-shopping-cart"></i> WooCommerce'
      ),
      array(
        'id'          => 'ot_extras',
        'title'       => '<i class="fa fa-plus"></i> Extras'
      ),
      array(
        'id'          => 'ot_theme_help',
        'title'       => '<i class="fa fa-question"></i> Theme Help'
      )
    ),
    'settings'        => array(
     
       array(
        'id'          => 'cb_l_1',
        'label'       => 'Header Logo',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'   => 'cb-big-title',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_logo_url',
        'label'       => 'Header Logo',
        'desc'        => 'Upload your logo for the Header area (Recommended size: 220px by 80px).',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub'
      ),
      array(
        'id'          => 'cb_logo_retina_url',
        'label'       => 'Header Logo (Retina Version)',
        'desc'        => 'Upload your logo (Retina version) for the Header menu - Size must be exactly double the size of the original logo set above.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub'
      ),
      array(
        'id'          => 'cb_logo_position',
        'label'       => 'Header Logo Position',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'choices'     => array(
          array(
            'value'       => 'left',
            'label'       => 'Left',
            'src'         => ''
          ),
          array(
            'value'       => 'center',
            'label'       => 'Centered',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_l_4',
        'label'       => 'Navigation Menu Logo',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'   => 'cb-big-title',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_logo_in_nav',
        'label'       => 'Logo in Main Navigation Menu',
        'desc'        => '',
        'type'        => 'on-off',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'std'         => 'off',
      ),
      array(
        'id'          => 'cb_logo_in_nav_when',
        'label'       => 'Logo in Navigation Menu Visibility',
        'desc'        => '',
        'std'         => 'cb-logo-nav-sticky',
        'type'        => 'select',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'condition'   => 'cb_logo_in_nav:is(on)',
        'class'       => 'cb-sub-sub',
        'choices'     => array(
           array(
            'value'       => 'cb-logo-nav-sticky',
            'label'       => 'Only when menu is sticky',
            'src'         => ''
          ),
          array(
            'value'       => 'cb-logo-nav-always',
            'label'       => 'Always visible',
            'src'         => ''
          ),
           
         
        ),
      ),
      array(
        'id'          => 'cb_logo_nav_url',
        'label'       => 'Logo to show in Navigation Bar',
        'desc'        => 'Upload your logo (Recommended size: 110px width by 25px height).',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub-sub',
        'condition'   => 'cb_logo_in_nav:is(on)',
      ),
      array(
        'id'          => 'cb_logo_nav_width',
        'label'       => 'Width of logo',
        'desc'        => 'Set the desired width the logo should appear with. Default: 110px',
        'std'         => '110',
        'type'        => 'numeric-slider',
        'min_max_step'=> '50,300,1',
        'section'     => 'ot_general',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => 'cb-sub-sub',
        'condition'   => 'cb_logo_in_nav:is(on)',
      ),
      array(
        'id'          => 'cb_logo_nav_padding',
        'label'       => 'Padding above navigation logo',
        'desc'        => 'How many pixels to push the logo down, this is to center it inside navigation menu',
        'std'         => '10',
        'type'        => 'numeric-slider',
        'min_max_step'=> '0,20,1',
        'section'     => 'ot_general',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => 'cb-sub-sub',
        'condition'   => 'cb_logo_in_nav:is(on)',
      ),
      array(
        'id'          => 'cb_logo_nav_retina_url',
        'label'       => 'Logo to show in Navigation Bar (Retina version)',
        'desc'        => 'Upload your logo (Retina version).',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub-sub',
        'condition'   => 'cb_logo_in_nav:is(on)',
      ),
      array(
        'id'          => 'cb_l_2',
        'label'       => 'Logos on Small Screen Devices',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'   => 'cb-big-title',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_h_logo_mobile',
        'label'       => 'Show Header Area on Small Screen devices',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
      ),
      array(
        'id'          => 'cb_m_logo_mobile',
        'label'       => 'Show Logo in Menu on Small Screen devices',
        'desc'        => '',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
      ),
       array(
        'id'          => 'cb_logo_nav_m_url',
        'label'       => 'Logo to show in Mobile Menu',
        'desc'        => 'Upload your logo (Recommended size: 110px width by 25px height).',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub-sub',
        'condition'   => 'cb_m_logo_mobile:is(on)',
      ),
       array(
        'id'          => 'cb_logo_nav_m_retina_url',
        'label'       => 'Logo to show in Mobile Menu (Retina Version)',
        'desc'        => 'Upload your logo (Retina version) for the mobile menu - Size must be exactly double the size of the original logo set above.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub-sub',
        'condition'   => 'cb_m_logo_mobile:is(on)',
      ),
      array(
        'id'          => 'cb_l_3',
        'label'       => 'Logo in Login With Ajax Modal',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'   => 'cb-big-title',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_lwa_logo',
        'label'       => 'Logo In Login With Ajax Modal (If installed)',
        'desc'        => 'Upload a logo to show inside the Login With Ajax modal',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub'
      ),
      array(
        'id'          => 'cb_lwa_logo_retina',
        'label'       => 'Logo In Login With Ajax Modal (Retina Version)',
        'desc'        => 'Upload your logo (Retina version) to show inside the Login With Ajax Modal - Size must be exactly double the size of the original logo set above.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub-sub'
      ),
      
       array(
        'id'          => 'cb_hp_title',
        'label'       => 'Homepage Settings',
        'desc'        => 'The settings below only apply to homepages that are set to "Your latest posts" in the "Wordpress Settings -> Reading" section. To create a homepage with modules please read the documentation section "15Zine Homepage Builder',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'ot_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_blog_style',
        'label'       => 'Blog Style',
        'desc'        => '',
        'std'         => 'a',
        'type'        => 'radio-image',
        'section'     => 'ot_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'a',
            'label'       => 'Style A',
            'src'         => '/blog_style_a.png'
          ),
          array(
            'value'       => 'b',
            'label'       => 'Style B',
            'src'         => '/blog_style_b.png'
          ),
          array(
            'value'       => 'c',
            'label'       => 'Style C',
            'src'         => '/blog_style_c.png'
          ),
          array(
            'value'       => 'd',
            'label'       => 'Style D',
            'src'         => '/blog_style_d.png'
          ),
          array(
            'value'       => 'e',
            'label'       => 'Style E',
            'src'         => '/blog_style_e.png'
          ),
          array(
            'value'       => 'f',
            'label'       => 'Style F',
            'src'         => '/blog_style_f.png'
          ),
          array(
            'value'       => 'g',
            'label'       => 'Style G',
            'src'         => '/blog_style_g.png'
          ),
          array(
            'value'       => 'h',
            'label'       => 'Style H',
            'src'         => '/blog_style_h.png'
          ),
          array(
            'value'       => 'i',
            'label'       => 'Style I',
            'src'         => '/blog_style_i.png'
          ),

        ),
      ),
    array(
        'id'          => 'cb_hp_infinite',
        'label'       => 'Pagination Type',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'off',
            'label'       => 'Number Pagination',
            'src'         => ''
          ),
          array(
            'value'       => 'infinite-scroll',
            'label'       => 'Infinite Scroll',
            'src'         => ''
          ),
          array(
            'value'       => 'infinite-load',
            'label'       => 'Infinite Scroll With Load More Button',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_hp_gridslider',
        'label'       => 'Featured Posts',
        'desc'        => 'Show a grid or slider above your homepage\'s "Latest Posts" content. Important note: Grid 3 requires a sidebar, so only use this option if the blog style chosen above has a sidebar. ',
        'std'         => 'cb_full_off',
        'type'        => 'radio-image',
        'section'     => 'ot_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
            array(
                'value'       => 'cb_full_off',
                'label'       => 'Off',
                'src'         => '/off.png'
              ),
            array(
                'value'       => 'grid-3',
                'label'       => 'Grid 3',
                'src'         => '/grid_3.png'
              ),
            array(
                'value'       => 'grid-4',
                'label'       => 'Grid 4',
                'src'         => '/grid_4.png'
              ),
              array(
                'value'       => 'grid-5',
                'label'       => 'Grid 5',
                'src'         => '/grid_5.png'
              ),
              array(
                'value'       => 'grid-6',
                'label'       => 'Grid 6',
                'src'         => '/grid_6.png'
              ),
              array(
              'value'       => 's-5',
              'label'       => 'Slider of Grid of 3',
              'src'         => '/grid_3s.png'
              ),
              array(
                'value'       => 's-1',
                'label'       => 'Slider A',
                'src'         => '/module_slider_a.png'
                ),
              array(
                'value'       => 's-2',
                'label'       => 'Slider B',
                'src'         => '/module_slider_b.png'
                ),
              array(
                'value'       => 's-3',
                'label'       => 'Slider C',
                'src'         => '/module_slider_c.png'
                ),
              array(
                'value'       => 's-1fw',
                'label'       => 'Slider A',
                'src'         => '/module_f_b.png'
              ),
        ),
      ),
      array(
        'id'          => 'cb_hp_offset',
        'label'       => 'Posts Offset',
        'desc'        => 'This option will offset the posts so you do not have duplicate posts in the grid + blog list below.',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_hp_gridslider:not(cb_full_off)',
      ),
      array(
        'id'          => 'cb_gridslider_category',
        'label'       => 'Grid/Slider Category Filter',
        'desc'        => 'Optional category filter for featured posts Grid/Slider (if no categories are checked, featured will show all categories)',
        'std'         => '',
        'type'        => 'category-checkbox',
        'section'     => 'ot_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_hp_gridslider:not(cb_full_off)',
      ),
      array(
        'id'          => 'cb_hp_ad',
        'label'       => 'Advertising Block Above Posts',
        'desc'        => 'Add an advertising block above the list of posts (appears under grid/slider if enabled)',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_homepage',
        'rows'        => '6',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
      ),     
      array(
        'id'          => 'cb_top_nav_search',
        'label'       => 'Show Search Icon In Top navigation menu',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'ot_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),      
      array(
        'id'          => 'cb_top_nav_login',
        'label'       => 'Show Login Icon In Top navigation menu',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'ot_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
       array(
        'id'          => 'cb_ajax_mm',
        'label'       => 'Ajax Megamenu Sub-Menu items',
        'desc'        => 'Enable ajax megamenu on sub-menu item hover',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_trending',
        'label'       => 'Add Most Popular Megamenu to Main Navigation Menu',
        'desc'        => '',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'ot_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_trending_title',
        'label'       => 'Word to use in menu',
        'desc'        => 'Default is "Trending".',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'ot_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'condition'   => 'cb_trending:is(on)',
        'class'       => 'cb-sub',
      ),
       array(
        'id'          => 'cb_trending_symbol',
        'label'       => 'Symbol',
        'desc'        => '',
        'std'         => 'fa-bolt',
        'type'        => 'radio-image',
        'section'     => 'ot_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_trending:is(on)',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'fa-bolt',
            'label'       => 'Bolt',
            'src'         => '/cb-bolt.png'
          ),
          array(
            'value'       => 'fa-heart',
            'label'       => 'Heart',
            'src'         => '/cb-heart.png'
          ),
          array(
            'value'       => 'fa-fire',
            'label'       => 'Fire',
            'src'         => '/cb-fire.png'
          ),
          array(
            'value'       => 'hashtag',
            'label'       => 'Fire',
            'src'         => '/cb-hashtag.png'
          ),
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => '/off.png'
          ),
          
        )
      ),
    
       array(
        'id'          => 'cb_sticky_nav',
        'label'       => 'Sticky Main Navigation Bar',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_stickies',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
       array(
        'id'          => 'cb_nav_when_sticky',
        'label'       => 'When to show sticky menu',
        'desc'        => '',
        'std'         => 'cb-sticky-menu',
        'type'        => 'select',
        'section'     => 'ot_stickies',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'condition'   => 'cb_sticky_nav:is(on)',
        'class'       => 'cb-sub',
        'choices'     => array(
          array(
            'value'       => 'cb-sticky-menu',
            'label'       => 'Always (if scrolled past menu)',
            'src'         => ''
          ),
          array(
            'value'       => 'cb-sticky-menu-up',
            'label'       => 'Only when scrolling upwards',
            'src'         => ''
          )
        ),
      ),
       array(
        'id'          => 'cb_sticky_m_nav',
        'label'       => 'Sticky Menu on Mobile',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_stickies',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
       array(
        'id'          => 'cb_sticky_sb',
        'label'       => 'Sticky Sidebars',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_stickies',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
       array(
        'id'          => 'cb_post_style_override_onoff',
        'label'       => 'Global Featured Image Style Override',
        'desc'        => 'For maximum flexibility and control, inside each post there is an option to ignore this override.',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'ot_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',

      ),
      array(
            'id'          => 'cb_post_style_override',
            'label'       => 'Global Featured Image Style',
            'desc'        => '',
            'std'         => 'standard',
            'type'        => 'radio-image',
            'section'     => 'ot_post_settings',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => 'cb-sub',
            'condition'   => 'cb_post_style_override_onoff:is(on)',
            'choices'     => array(
               array(
                'value'       => 'standard',
                'label'       => 'Standard',
                'src'         => '/img_st.png'
                ),
             array(
                'value'       => 'site-width',
                'label'       => 'Site Width',
                'src'         => '/img_fw.png'
                ),
              array(
                'value'       => 'screen-width',
                'label'       => 'Screen Width',
                'src'         => '/img_sw.png'
                ),
              
             array(
                'value'       => 'full-background',
                'label'       => 'Full Screen',
                'src'         => '/img_fs.png'
                ),
             array(
                'value'       => 'parallax',
                'label'       => 'Parallax',
                'src'         => '/img_pa.png'
                ),

             array(
                'value'       => 'off',
                'label'       => 'Do not show featured image',
                'src'         => '/img_off.png'
                ),
            ),
      ),
      array(
        'id'          => 'cb_post_sidebar_override_onoff',
        'label'       => 'Global Post Sidebar Style Override',
        'desc'        => 'For maximum flexibility and control, inside each post there is an option to ignore this override.',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'ot_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',

      ),
      array(
            'id'          => 'cb_post_sidebar_override',
            'label'       => 'Global Sidebar Style',
            'desc'        => '',
            'std'         => 'sidebar',
            'type'        => 'radio-image',
            'section'     => 'ot_post_settings',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => 'cb-sub',
            'condition'   => 'cb_post_sidebar_override_onoff:is(on)',
            'choices'     => array(
               array(
                'value'       => 'sidebar',
                'label'       => 'With Sidebar',
                'src'         => '/post_sidebar.png'
              ),
              array(
                'value'       => 'sidebar_left',
                'label'       => 'With Left Sidebar',
                'src'         => '/post_sidebar_left.png'
              ),
              array(
                'value'       => 'nosidebar',
                'label'       => 'No Sidebar',
                'src'         => '/post_nosidebar.png'
              ),
               array(
                  'value'       => 'nosidebar-fw',
                  'label'       => 'No Sidebar Full-Width',
                  'src'         => '/post_nosidebar_fw.png'
              ),
            ),
      ),
      array(
        'id'          => 'cb_social_sharing',
        'label'       => 'Social Sharing',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'on',
            'label'       => 'On - Normal',
            'src'         => ''
          ),
          array(
            'value'       => 'on-big',
            'label'       => 'On - Big',
            'src'         => ''
          ),
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_social_fb',
        'label'       => 'Facebook Like button',
        'desc'        => '',
        'type'        => 'on-off',
        'section'     => 'ot_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'std'         => 'on',
        'condition'   => 'cb_social_sharing:not(off)',
      ),
      array(
        'id'          => 'cb_social_fb_share',
        'label'       => 'Facebook Share button',
        'desc'        => '',
        'type'        => 'on-off',
        'section'     => 'ot_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_social_sharing:not(off)',
        'std'         => 'off',
      ),
      array(
        'id'          => 'cb_social_st',
        'label'       => 'StumbleUpon button',
        'desc'        => '',
        'type'        => 'on-off',
        'section'     => 'ot_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'std'         => 'off',
        'condition'   => 'cb_social_sharing:not(off)',
      ),
      array(
        'id'          => 'cb_social_tw',
        'label'       => 'Twitter button',
        'desc'        => '',
        'type'        => 'on-off',
        'section'     => 'ot_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'std'         => 'on',
        'condition'   => 'cb_social_sharing:not(off)',
      ),
      array(
        'id'          => 'cb_social_go',
        'label'       => 'Google+ button',
        'desc'        => '',
        'type'        => 'on-off',
        'section'     => 'ot_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'std'         => 'on',
        'condition'   => 'cb_social_sharing:not(off)',
      ),
      array(
        'id'          => 'cb_social_pi',
        'label'       => 'Pinterest button',
        'desc'        => '',
        'type'        => 'on-off',
        'section'     => 'ot_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'std'         => 'on',
        'condition'   => 'cb_social_sharing:not(off)',
      ),
      array(
        'id'          => 'cb_post_footer_ad',
        'label'       => 'Post Footer Banner Code',
        'desc'        => 'Enter your ad code. This ad will appear at the end of the post content.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_post_settings',
        'rows'        => '4',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_comments_onoff',
        'label'       => 'Comments',
        'desc'        => '',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'ot_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_author_box_onoff',
        'label'       => 'Show author box in articles',
        'desc'        => '',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'ot_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_previous_next_onoff',
        'label'       => 'Show Next/Previous in articles',
        'desc'        => '',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'ot_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_tags_onoff',
        'label'       => 'Show Tags',
        'desc'        => '',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'ot_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_related_onoff',
        'label'       => 'Show related posts',
        'desc'        => '',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'ot_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_related_posts_style',
        'label'       => 'Slider or static posts',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_related_onoff:not(off)',
        'choices'     => array(
          array(
            'value'       => 'cb_related_posts_slider',
            'label'       => 'Slider',
            'src'         => ''
          ),
          array(
            'value'       => 'cb_related_posts_static',
            'label'       => 'Static Lines',
            'src'         => ''
          ),
        ),
      ),
      array(
            'id'          => 'cb_related_posts_amount',
            'label'       => 'Lines Of Related Posts',
            'desc'        => 'Each line shows two related posts',
            'std'         => '1',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'section'     => 'ot_post_settings',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,10,1',
            'condition'   => 'cb_related_posts_style:is(cb_related_posts_static)',
            'class'       => 'cb-sub-sub'
      ),
      array(
        'id'          => 'cb_related_posts_show',
        'label'       => 'Where to look for related posts',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_related_onoff:not(off)',
        'choices'     => array(
          array(
            'value'       => 'both',
            'label'       => 'Related by tags and if no posts found, show related by category',
            'src'         => ''
          ),
          array(
            'value'       => 'tags',
            'label'       => 'Only related by tags',
            'src'         => ''
          ),
          array(
            'value'       => 'cats',
            'label'       => 'Only related by category',
            'src'         => ''
          ),

        ),
      ),
      array(
        'id'          => 'cb_related_posts_order',
        'label'       => 'Related Posts Order',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_related_onoff:not(off)',
        'choices'     => array(
          array(
            'value'       => 'rand',
            'label'       => 'Random',
            'src'         => ''
          ),
          array(
            'value'       => 'date',
            'label'       => 'Date (Latest Published)',
            'src'         => ''
          ),

        ),
      ),
      array(
        'id'          => 'cb_tm_skin',
        'label'       => 'Top Navigation Menu Scheme',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
           array(
            'value'       => 'cb-tm-dark',
            'label'       => 'Dark',
            'src'         => ''
          ),
           array(
            'value'       => 'cb-tm-light',
            'label'       => 'Light',
            'src'         => ''
          ),
         
          
        ),
      ),
      array(
        'id'          => 'cb_header_bg_image',
        'label'       => 'Header Background Color/Image',
        'desc'        => 'Set a background color or image for the header block (behind logo + optional ad)',
        'std'         => '',
        'type'        => 'background',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_menu_style',
        'label'       => 'Main Navigation Bar Scheme',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
           array(
            'value'       => 'cb-menu-light',
            'label'       => 'Light',
            'src'         => ''
          ),
          array(
            'value'       => 'cb-menu-dark',
            'label'       => 'Dark',
            'src'         => ''
          ),
          
        ),
      ),
      array(
        'id'          => 'cb_mm_skin',
        'label'       => 'Megamenu Color Scheme',
        'desc'        => '',
        'std'         => 'cb-mm-dark',
        'type'        => 'select',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
           array(
            'value'       => 'cb-mm-light',
            'label'       => 'Light',
            'src'         => ''
          ),
          array(
            'value'       => 'cb-mm-dark',
            'label'       => 'Dark',
            'src'         => ''
          ),
          
        ),
      ),
       array(
        'id'          => 'cb_mm_columns_color',
        'label'       => 'Columns Megamenu main title Color',
        'desc'        => 'Color of the first menu item in each column',
        'std'         => '#f2c231',
        'type'        => 'colorpicker',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_body_skin',
        'label'       => 'Body Area Skin',
        'desc'        => 'Affects main content area and sidebars.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'choices'     => array(
          array(
            'value'       => 'cb-body-light',
            'label'       => 'Light',
            'src'         => ''
          ),
          array(
            'value'       => 'cb-body-dark',
            'label'       => 'Dark',
            'src'         => ''
          ),

        ),
      ),
      array(
        'id'          => 'cb_footer_skin',
        'label'       => 'Footer Skin',
        'desc'        => 'Affects Footer and Copyright area.',
        'std'         => 'cb-footer-dark',
        'type'        => 'select',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'choices'     => array(
          array(
            'value'       => 'cb-footer-light',
            'label'       => 'Light',
            'src'         => ''
          ),
          array(
            'value'       => 'cb-footer-dark',
            'label'       => 'Dark',
            'src'         => ''
          ),

        ),
      ),
       
      array(
        'id'          => 'cb_base_color',
        'label'       => 'Global Color',
        'desc'        => 'Color to show on menu, hovers, borders, etc if a page, post, category, etc doesn\'t have their own specific color set',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      
      array(
        'id'          => 'cb_body_text_color',
        'label'       => 'Body Text Color',
        'desc'        => 'Change the body text color to something specific',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_link_color',
        'label'       => 'Hyperlink text Color',
        'desc'        => 'Overrides the default color for text links within posts/page body text',
        'std'         => '',
        'type'        => 'link-color',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_background_image',
        'label'       => 'Global Background Image',
        'desc'        => 'Upload a background image. Can be overriden by category/post/page background settings',
        'std'         => '',
        'type'        => 'background',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_background_border',
        'label'       => 'Site Side Borders',
        'desc'        => 'Add a border to the sides of the site area.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
          ),
          array(
            'value'       => 'cb-box-light',
            'label'       => 'Light Border',
            'src'         => ''
          ),
          array(
            'value'       => 'cb-box-heavy',
            'label'       => 'Dark border',
            'src'         => ''
          ),

        ),
      ),
      array(
        'id'          => 'cb_header_font',
        'label'       => 'Font for Headings',
        'desc'        => 'Select the font of Headings (h1, h2, h3, h4, h5) and other important titles. Demo uses Raleway.',
        'std'         => '\'Montserrat\', sans-serif;',
        'type'        => 'select',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '\'Montserrat\', sans-serif;',
            'label'       => 'Montserrat',
            'src'         => ''
          ),
          array(
            'value'       => '\'Raleway\', sans-serif;',
            'label'       => 'Raleway',
            'src'         => ''
          ),
          array(
            'value'       => '\'Josefin Slab\', serif;',
            'label'       => 'Josefin Slab',
            'src'         => ''
          ),
          array(
            'value'       => '\'Lato\', sans-serif;',
            'label'       => 'Lato',
            'src'         => ''
          ),
          array(
            'value'       => '\'Arvo\', serif;',
            'label'       => 'Arvo',
            'src'         => ''
          ),
          array(
            'value'       => '\'Open Sans\', sans-serif;',
            'label'       => 'Open Sans',
            'src'         => ''
          ),
          array(
            'value'       => '\'Oswald\', sans-serif;',
            'label'       => 'Oswald',
            'src'         => ''
          ),
          
          array(
            'value'       => 'other',
            'label'       => 'Other Google Font',
            'src'         => ''
          )
        )
      ),
      array(
        'id'          => 'cb_user_header_font',
        'label'       => 'Other Google Font/Custom Font',
        'desc'        => 'Enter any Google Font Code from http://www.google.com/fonts for Headings. Example of code that should be entered: \'Noto Sans\', sans-serif;',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_header_font:is(other)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_body_font',
        'label'       => 'General body text font',
        'desc'        => 'Select the font to be used for general body text. Demo uses Raleway.',
        'std'         => '\'Open Sans\', sans-serif;',
        'type'        => 'select',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '\'Open Sans\', sans-serif;',
            'label'       => 'Open Sans',
            'src'         => ''
          ),
          array(
            'value'       => '\'Raleway\', sans-serif;',
            'label'       => 'Raleway',
            'src'         => ''
          ),
          
          array(
            'value'       => '\'Montserrat\', sans-serif;',
            'label'       => 'Montserrat',
            'src'         => ''
          ),
          array(
            'value'       => '\'Droid Sans\', sans-serif;',
            'label'       => 'Droid Sans',
            'src'         => ''
          ),
          array(
            'value'       => '\'PT Serif\', serif;',
            'label'       => 'PT Serif',
            'src'         => ''
          ),
          array(
            'value'       => '\'PT Sans\', sans-serif;',
            'label'       => 'PT Sans',
            'src'         => ''
          ),
          array(
            'value'       => '\'Vollkorn\', serif;',
            'label'       => 'Vollkorn',
            'src'         => ''
          ),
          array(
            'value'       => 'other',
            'label'       => 'Other Google Font',
            'src'         => ''
          )
        )
      ),      
    array(
        'id'          => 'cb_user_body_font',
        'label'       => 'Other Google Font',
        'desc'        => 'Enter any Google Font Code from http://www.google.com/fonts. Example of code that should be entered: \'Noto Sans\', sans-serif;',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_body_font:is(other)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_font_ext_lat',
        'label'       => 'Use Latin Extended Charset (Needed in some languages)',
        'desc'        => 'Some languages use special characters that require extra marking. Enable this to also load the Latin Extended character font set.',
        'type'        => 'on-off',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'std'         => 'off',

      ),
      array(
        'id'          => 'cb_font_cyr',
        'label'       => 'Use Cyrillic Extended Charset (Needed in some languages)',
        'desc'        => 'Some languages use special characters that require extra marking. Enable this to also load the Cyrillic Extended character font set.',
        'type'        => 'on-off',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',        
        'std'         => 'off',

      ),
      array(
        'id'          => 'cb_font_greek',
        'label'       => 'Use Greek Charset',
        'desc'        => 'Some languages use special characters that require extra marking. Enable this to also load the Greek Extended character font set.',
        'type'        => 'on-off',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',        
        'std'         => 'off',

      ),

      array(
        'id'          => 'cb_max_theme_width',
        'label'       => 'Content Max Width',
        'std'         => 'default',
        'type'        => 'select',
        'section'     => 'ot_sitewidth',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'default',
            'label'       => '1200px (Default)',
            'src'         => ''
          ),
          array(
            'value'       => 'onesmaller',
            'label'       => '1020px',
            'src'         => ''
          )
        ),
      ),

      array(
        'id'          => 'cb_sw_tm',
        'label'       => 'Top Menu Width',
        'desc'        => 'Width of top menu',
        'std'         => '',
        'section'     => 'ot_sitewidth',
        'type'        => 'select',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'box',
            'label'       => 'Boxed',
          ),
          array(
            'value'       => 'fw',
            'label'       => 'Full-Site Width',
          ),
          
        ),
      ),  
      array(
        'id'          => 'cb_sw_hd',
        'label'       => 'Header Width',
        'desc'        => 'Width of header area (Logo + Header Ad)',
        'std'         => '',
        'section'     => 'ot_sitewidth',
        'type'        => 'select',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'box',
            'label'       => 'Boxed',
          ),
          array(
            'value'       => 'fw',
            'label'       => 'Full-Site Width',
          ),
          
        ),
      ),  
      array(
        'id'          => 'cb_sw_menu',
        'label'       => 'Sticky Menu Width',
        'desc'        => 'Width of main navigation menu when it becomes sticky.',
        'std'         => '',
        'section'     => 'ot_sitewidth',
        'type'        => 'select',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'box',
            'label'       => 'Boxed',
          ),
          array(
            'value'       => 'fw',
            'label'       => 'Full-Site Width',
          ),
          
        ),
      ),  
      array(
        'id'          => 'cb_sw_footer',
        'label'       => 'Footer Width',
        'desc'        => 'Width of Footer area',
        'std'         => '',
        'section'     => 'ot_sitewidth',
        'type'        => 'select',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'box',
            'label'       => 'Boxed',
          ),
          array(
            'value'       => 'fw',
            'label'       => 'Full-Site Width',
          ),
          
        ),
      ),      
      
      array(
        'id'          => 'cb_footer_logo',
        'label'       => 'Logo In Footer',
        'desc'        => 'Upload a logo to show above the copyright line.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_footer_logo_retina',
        'label'       => 'Logo In Footer (Retina Version)',
        'desc'        => 'Upload your logo (Retina version) for the Footer - Size must be exactly double the size of the original logo set above.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_footer_copyright',
        'label'       => 'Footer Copyright',
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_footer',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_footer_to_top',
        'label'       => 'To Top Button In Footer',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_footer_layout',
        'label'       => 'Footer Layout',
        'desc'        => '',
        'std'         => 'cb-footer-a',
        'type'        => 'radio-image',
        'section'     => 'ot_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'cb-footer-a',
            'label'       => '3 Columns',
            'src'         => '/footer_style_a.png'
          ),
          array(
            'value'       => 'cb-footer-c',
            'label'       => '3 Columns Style B',
            'src'         => '/footer_style_c.png'
          ),
          array(
            'value'       => 'cb-footer-d',
            'label'       => '3 Columns Style C',
            'src'         => '/footer_style_d.png'
          ),
          array(
            'value'       => 'cb-footer-b',
            'label'       => '4 Columns',
            'src'         => '/footer_style_b.png'
          ),
          
        ),
      ),
      array(
        'id'          => 'cb_banner_selection',
        'label'       => 'Header Banner Selection',
        'desc'        => 'Type of ad to appear in the site\'s header (Next to the logo)',
        'std'         => 'cb_banner_off',
        'type'        => 'radio-image',
        'section'     => 'ot_advertising',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'cb_banner_off',
            'label'       => 'Off',
            'src'         => '/off.png'
          ),
          array(
            'value'       => 'cb_banner_468',
            'label'       => 'Banner 468x60',
            'src'         => '/ada.png'
          ),
          array(
            'value'       => 'cb_banner_728',
            'label'       => 'Banner 728x90',
            'src'         => '/adb.png'
          )
        ),
      ),
      array(
        'id'          => 'cb_banner_code',
        'label'       => 'Banner Code',
        'desc'        => 'Enter your ad code.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_advertising',
        'rows'        => '4',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'cb_banner_selection:not(cb_banner_off)'
      ),
      array(
        'id'          => 'cb_bg_to',
        'label'       => 'Clickable Background Advertising Takeover',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_advertising',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
          ),
          array(
            'value'       => 'global',
            'label'       => 'Global',
            'src'         => ''
          ),
          array(
            'value'       => 'only-hp',
            'label'       => 'Only Homepage',
            'src'         => ''
          ),
        ),
      ),
      array(
        'id'          => 'cb_bg_to_img',
        'label'       => 'Background Takeover Ad Image',
        'desc'        => 'Uploade/Select the background ad image.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_advertising',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_bg_to:not(off)'
      ),
      array(
        'id'          => 'cb_bg_to_url',
        'label'       => 'Background Takeover Ad Link',
        'desc'        => 'Enter the URL that clicking the background ad image should open.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_advertising',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_bg_to:not(off)'
      ),
      array(
        'id'          => 'cb_bg_to_margin_top',
        'label'       => 'Top Margin Of Content',
        'desc'        => 'If your background ad needs to be visible at the top, enter a number and select the appropiate measurement and the content of your site will move down. It is recommended to use pixels (px)',
        'std'         => '',
        'type'        => 'measurement',
        'section'     => 'ot_advertising',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_bg_to:not(off)'
      ),
      array(
        'id'          => 'cb_custom_css',
        'label'       => 'Custom CSS',
        'desc'        => 'No need to hard-edit style.css anymore. All your CSS modifications can be done here so you do not lose them in future theme updates. (It is still recommended to save a backup of this custom CSS to a separate .txt file)',
        'std'         => '',
        'type'        => 'css',
        'section'     => 'ot_custom_code',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_custom_head',
        'label'       => 'Code For &lt;head&gt; section',
        'desc'        => 'No need to hard-edit files anymore to add custom Javascript/code to your head. Code in this box will appear before the closing head tag.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_custom_code',
        'rows'        => '10',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_custom_footer',
        'label'       => 'Code For &lt;footer&gt; section',
        'desc'        => 'No need to hard-edit files anymore to add custom Javascript/code to your footer. Code in this box will appear right before the closing body tag.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_custom_code',
        'rows'        => '10',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_disqus_shortname',
        'label'       => 'Disqus Forum Shortname',
        'desc'        => 'If you are using Disqus commenting system, you must enter the forum shortname here to be able to show the comment number everywhere.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_custom_code',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_cpt',
        'label'       => 'Custom Post Type Names',
        'desc'        => 'If you want your custom post types to have meta boxes and appear in the pagebuilder, enter the names of them here (Separated by comma, example: books, movies)',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_custom_code',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_bbpress_global_color',
        'label'       => 'bbPress Color',
        'desc'        => 'Set a color to be used in menu hovers.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'ot_bbpress',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_bbp_sticky_background_color',
        'label'       => 'bbPress Sticky Posts Background Color',
        'desc'        => 'Set a color to be used on the backgrounds of sticky posts (Light tones are recommended).',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'ot_bbpress',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_bbpress_breadcrumbs',
        'label'       => 'bbPress Breadcrumbs',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_bbpress',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_bbpress_sidebar',
        'label'       => 'Sidebar Style',
        'desc'        => '',
        'std'         => 'sidebar',
        'type'        => 'radio-image',
        'section'     => 'ot_bbpress',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'sidebar',
            'label'       => 'With Sidebar',
            'src'         => '/post_sidebar.png'
          ),
          array(
            'value'       => 'sidebar_left',
            'label'       => 'With Left Sidebar',
            'src'         => '/post_sidebar_left.png'
          ),
          array(
            'value'       => 'nosidebar',
            'label'       => 'No Sidebar',
            'src'         => '/post_nosidebar.png'
          ),
           array(
              'value'       => 'nosidebar-fw',
              'label'       => 'No Sidebar Full-Width',
              'src'         => '/post_nosidebar_fw.png'
          ),
        ),
      ),
      array(
        'id'          => 'cb_bbpress_background_image',
        'label'       => 'Background Image',
        'desc'        => 'Upload a background image for bbPress pages',
        'std'         => '',
        'type'        => 'background',
        'section'     => 'ot_bbpress',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
       array(
        'id'          => 'cb_woocommerce_sidebar',
        'label'       => 'Sidebar Style',
        'desc'        => '',
        'std'         => 'sidebar',
        'type'        => 'radio-image',
        'section'     => 'ot_woocommerce',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'sidebar',
            'label'       => 'With Sidebar',
            'src'         => '/post_sidebar.png'
          ),
          array(
            'value'       => 'sidebar_left',
            'label'       => 'With Left Sidebar',
            'src'         => '/post_sidebar_left.png'
          ),
           array(
              'value'       => 'nosidebar-fw',
              'label'       => 'No Sidebar Full-Width',
              'src'         => '/post_nosidebar_fw.png'
          ),
        ),
      ),
       array(
        'id'          => 'cb_woocommerce_background_image',
        'label'       => 'Background Image',
        'desc'        => 'Upload a background image for WooCommerce pages',
        'std'         => '',
        'type'        => 'background',
        'section'     => 'ot_woocommerce',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
       array(
        'id'          => 'cb_favicon_url',
        'label'       => 'Favicon',
        'desc'        => 'Upload your favicon.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_minify_js_onoff',
        'label'       => 'Minify Javascript',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_lightbox_onoff',
        'label'       => 'Lightbox',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_responsive_onoff',
        'label'       => 'Responsive Theme',
        'desc'        => 'If set to "off" mobile devices will load the desktop version always (full-site)',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_breadcrumbs',
        'label'       => 'Breadcrumbs',
        'desc'        => '',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_meta_onoff',
        'label'       => 'Show "By line" (By x on 01/01/01 in category)',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'on',
            'label'       => 'On',
            'src'         => ''
          ),
          array(
            'value'       => 'on_posts',
            'label'       => 'Only under post titles',
            'src'         => ''
          ),
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_byline_author',
        'label'       => 'By Line: Show Author',
        'desc'        => 'Show user icon and author name in By Line',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_meta_onoff:not(off)',

      ),
      array(
        'id'          => 'cb_byline_date',
        'label'       => 'By Line: Show Date',
        'desc'        => 'Show clock icon and date in By Line',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_meta_onoff:not(off)',

      ),
      array(
        'id'          => 'cb_byline_category',
        'label'       => 'By Line: Show Categories',
        'desc'        => 'Show category icon and list all categories',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'condition'   => 'cb_meta_onoff:not(off)',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
      ),
      array(
        'id'          => 'cb_byline_comments',
        'label'       => 'By Line: Show Comments',
        'desc'        => 'Show comments icon and number of comments in By Line',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'condition'   => 'cb_meta_onoff:not(off)',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
      ),
      array(
        'id'          => 'cb_byline_postviews',
        'label'       => 'By Line: Show Post View Count',
        'desc'        => 'Show post view count icon and number of post views in By Line',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'condition'   => 'cb_meta_onoff:not(off)',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
      ),
      array(
        'id'          => 'cb_misc_search_pl',
        'label'       => 'Search Results Pages Post Layout',
        'desc'        => '',
        'std'         => 'a',
        'type'        => 'radio-image',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'a',
            'label'       => 'Style A',
            'src'         => '/blog_style_a.png'
          ),
          array(
            'value'       => 'b',
            'label'       => 'Style B',
            'src'         => '/blog_style_b.png'
          ),
          array(
            'value'       => 'c',
            'label'       => 'Style C',
            'src'         => '/blog_style_c.png'
          ),
          array(
            'value'       => 'd',
            'label'       => 'Style D',
            'src'         => '/blog_style_d.png'
          ),
          array(
            'value'       => 'e',
            'label'       => 'Style E',
            'src'         => '/blog_style_e.png'
          ),
          array(
            'value'       => 'f',
            'label'       => 'Style F',
            'src'         => '/blog_style_f.png'
          ),
          array(
            'value'       => 'g',
            'label'       => 'Style G',
            'src'         => '/blog_style_g.png'
          ),
          array(
            'value'       => 'h',
            'label'       => 'Style H',
            'src'         => '/blog_style_h.png'
          ),
          array(
            'value'       => 'i',
            'label'       => 'Style I',
            'src'         => '/blog_style_i.png'
          ),
        )
      ),
      array(
        'id'          => 'cb_misc_archives_pl',
        'label'       => 'Archives Post Layout',
        'desc'        => '',
        'std'         => 'a',
        'type'        => 'radio-image',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'a',
            'label'       => 'Style A',
            'src'         => '/blog_style_a.png'
          ),
          array(
            'value'       => 'b',
            'label'       => 'Style B',
            'src'         => '/blog_style_b.png'
          ),
          array(
            'value'       => 'c',
            'label'       => 'Style C',
            'src'         => '/blog_style_c.png'
          ),
          array(
            'value'       => 'd',
            'label'       => 'Style D',
            'src'         => '/blog_style_d.png'
          ),
          array(
            'value'       => 'e',
            'label'       => 'Style E',
            'src'         => '/blog_style_e.png'
          ),
          array(
            'value'       => 'f',
            'label'       => 'Style F',
            'src'         => '/blog_style_f.png'
          ),
          array(
            'value'       => 'g',
            'label'       => 'Style G',
            'src'         => '/blog_style_g.png'
          ),
          array(
            'value'       => 'h',
            'label'       => 'Style H',
            'src'         => '/blog_style_h.png'
          ),
          array(
            'value'       => 'i',
            'label'       => 'Style I',
            'src'         => '/blog_style_i.png'
          ),
        )
      ),
      array(
        'id'          => 'cb_misc_author_pl',
        'label'       => 'Author Archives Post Layout',
        'desc'        => '',
        'std'         => 'a',
        'type'        => 'radio-image',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'a',
            'label'       => 'Style A',
            'src'         => '/blog_style_a.png'
          ),
          array(
            'value'       => 'b',
            'label'       => 'Style B',
            'src'         => '/blog_style_b.png'
          ),
          array(
            'value'       => 'd',
            'label'       => 'Style D',
            'src'         => '/blog_style_d.png'
          ),
          array(
            'value'       => 'e',
            'label'       => 'Style E',
            'src'         => '/blog_style_e.png'
          ),
          array(
            'value'       => 'f',
            'label'       => 'Style F',
            'src'         => '/blog_style_f.png'
          ),
          array(
            'value'       => 'g',
            'label'       => 'Style G',
            'src'         => '/blog_style_g.png'
          ),
          array(
            'value'       => 'h',
            'label'       => 'Style H',
            'src'         => '/blog_style_h.png'
          ),
          array(
            'value'       => 'i',
            'label'       => 'Style I',
            'src'         => '/blog_style_i.png'
          ),
        )
      ),
      array(
        'id'          => 'cb_help_title',
        'label'       => 'Having trouble setting up 15Zine?',
        'desc'        => '15Zine comes with extensive documentation that covers almost every aspect of the theme, therefore, most answers can be found there. The documentation can also be read online, <a href="' .  esc_url( $cb_docs_url ) . '" target="_new">click here to see it</a>. If an answer for your issue is not there try these steps:<ol><li>Disable all your plugins to see if the issues persists.</li><li>Check if you are using the latest version of the theme (Documentation has instructions on how to update theme)</li><li>Check the comments section of the theme in Themeforest, other users may have asked the same question already</li></ol> If none of that helps, you can submit a ticket in the support system for quickest response. Make your ticket as short as possible and include screenshots/urls if possible to make it easy to understand and get a fast response. <a href="' . esc_url( $cb_support_url ) . '" target="_new">Click here</a> to visit the support system',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'ot_theme_help',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
    )
  );

  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( 'option_tree_settings_args', $custom_settings );

  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings );
  }

}
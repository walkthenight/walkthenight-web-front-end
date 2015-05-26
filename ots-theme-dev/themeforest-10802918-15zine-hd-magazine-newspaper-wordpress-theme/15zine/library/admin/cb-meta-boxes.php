<?php
function _cb_meta() {

  $cb_cpt_list = ot_get_option( 'cb_cpt', NULL );
  $cb_cpt_output = array('post');
  if ( $cb_cpt_list != NULL ) {
    $cb_cpt = explode(',', str_replace(' ', '', $cb_cpt_list ) );

    foreach ( $cb_cpt as $cb_cpt_single ) {
      $cb_cpt_output[] = $cb_cpt_single;
  }
}

$cb_go = array(
    'id'          => 'cb_go',
    'title'       => '15Zine Post Options',
    'desc'        => '',
    'pages'       => $cb_cpt_output,
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
        array(
        'label'       =>  'Featured Image Options',
        'id'          => 'cb_tab_fi',
        'type'        => 'tab'
        ),
        array(
        'id'          => 'cb_featured_image_style',
        'label'       => 'Featured Image Style',
        'desc'        => '',
        'std'         => 'standard',
        'type'        => 'radio-image',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
            array(
              'value'       => 'standard',
              'label'       => 'Standard',
              'src'         => '/img_st.png'
              ),
            array(
              'value'       => 'standard-uncrop',
              'label'       => 'Standard Uncropped',
              'src'         => '/img_stun.png'
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
              'value'       => 'background-slideshow',
              'label'       => 'Background Slideshow',
              'src'         => '/img_bs.png'
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
            'id'          => 'cb_post_fis_header',
            'label'       => 'Site Header (Logo + Header Ad area)',
            'desc'        => 'To maximise the screen for this featured image style, you can disable the header for this post (disables logo/header ad area).',
            'std'         => 'on',
            'type'        => 'on-off',
            'section'     => 'option_types',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => 'cb-sub',
            'condition'   => 'cb_featured_image_style:is(parallax),cb_featured_image_style:is(background-slideshow),cb_featured_image_style:is(full-background),cb_featured_image_style:is(screen-width)',
            'operator'    => 'or'
        ),
        array(
            'id'          => 'cb_post_background_slideshow',
            'label'       => 'Background Slideshow Images',
            'desc'        => 'Upload/set images to show as a Slideshow',
            'std'         => '',
            'type'        => 'gallery',
            'section'     => 'option_types',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => 'cb-sub',
            'condition'   => 'cb_featured_image_style:is(background-slideshow)',
            'operator'    => 'and'
        ),
        array(
        'id'          => 'cb_featured_image_style_override',
        'label'       => 'Ignore Global Override Featured Image Style Setting',
        'desc'        => 'Enable this to ignore the "Theme Options -> Posts -> Global Featured Image Style Override" option if it is set.',
        'std'         => '',
        'type'        => 'select',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'off',
            'label'       => '-',
            'src'         => ''
            ),
          array(
            'value'       => 'on',
            'label'       => 'Ignore Global Override',
            'src'         => ''
            )
          ),
        ),
        array(
            'label'       => 'Featured Image Credit Line',
            'id'          => 'cb_image_credit',
            'type'        => 'text',
            'desc'        => 'Optional Photograph credit line',
            'std'         => '',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'condition'   => 'cb_featured_image_style:not(off)',
        ),
        array(
            'label'       =>  'Layout Options',
            'id'          => 'cb_tab_sidebar',
            'type'        => 'tab'
        ),
        array(
        'id'          => 'cb_sidebar_override',
        'label'       => 'Ignore Global Override Sidebar Setting',
        'desc'        => 'Enable this to ignore the "Theme Options -> Posts -> Global Sidebar Style Override" option if it is set.',
        'std'         => '',
        'type'        => 'select',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'off',
            'label'       => '-',
            'src'         => ''
            ),
          array(
            'value'       => 'on',
            'label'       => 'Ignore Global Override',
            'src'         => ''
            )
          ),
        ),
        array(
            'id'          => 'cb_full_width_post',
            'label'       => 'Post Style',
            'desc'        => '',
            'std'         => 'sidebar',
            'type'        => 'radio-image',
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
            'id'          => 'cb_post_sidebar',
            'label'       => 'Use default Sidebar',
            'desc'        => 'If the post\'s category has a custom sidebar, this post will use that, if not it will use the global sidebar. Set to Off to select specific sidebar.',
            'std'         => 'on',
            'type'        => 'on-off',
            'section'     => 'option_types',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => 'cb-sub',
            'condition'   => 'cb_full_width_post:not(nosidebar),cb_full_width_post:not(nosidebar-fw)',
            'operator'    => 'and'
        ),
      array(
        'id'          => 'cb_sidebar_select',
        'label'       => __( 'Sidebar Select', 'cubell_admin' ),
        'desc'        => 'Use a sidebar that already exists.',
        'std'         => '',
        'type'        => 'sidebar-select',
        'section'     => 'option_types',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_full_width_post:not(nosidebar),cb_post_sidebar:is(off),cb_full_width_post:not(nosidebar-fw)',
        'operator'    => 'and'
      ),
        array(
            'id'          => '_cb_embed_fs',
            'label'       => 'Full-screen width image embeds',
            'desc'        => 'Make all image embeds with "align: none" + "size: Full-size" be full-screen images.',
            'std'         => 'on',
            'type'        => 'on-off',
            'rows'        => '',
            'post_type'   => '',
            'class'       => 'cb-sub',
            'operator'    => 'or',
            'condition'   => 'cb_full_width_post:is(nosidebar),cb_full_width_post:is(nosidebar-fw)',
        ),
        array(
            'id'          => '_cb_embed_out',
            'label'       => 'Embeds bigger than content area',
            'desc'        => 'Make "Align: Left", "Align: Right" and "Align: Center" embeds spill outside the content area.',
            'std'         => 'on',
            'type'        => 'on-off',
            'rows'        => '',
            'post_type'   => '',
            'class'       => 'cb-sub',
            'operator'    => 'or',
            'condition'   => 'cb_full_width_post:is(nosidebar),cb_full_width_post:is(nosidebar-fw)',
        ),
        array(
            'id'          => '_cb_first_dropcap',
            'label'       => 'Dropcap',
            'desc'        => 'Make first letter of the article be a dropcap (6 times bigger than the rest of the text).',
            'std'         => 'off',
            'type'        => 'on-off',
            'rows'        => '',
            'post_type'   => '',
            'class'       => '',
            'condition'   => '',
        ),
        array(
            'id'          => '_cb_post_font',
            'label'       => 'Load specific fonts for article',
            'desc'        => 'Change fonts used in the article area of the post',
            'std'         => 'off',
            'type'        => 'on-off',
            'rows'        => '',
            'post_type'   => '',
            'class'       => '',
            'condition'   => '',
        ),
        array(
        'id'          => 'cb_header_font',
        'label'       => 'Font for Headings',
        'desc'        => 'Select the font of the article\'s Headings (h1, h2, h3, h4, h5) and other important titles.',
        'std'         => '',
        'type'        => 'select',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => '_cb_post_font:is(on)',
        'operator'    => 'and',
        'choices'     => array( 
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
            'value'       => '\'Montserrat\', sans-serif;',
            'label'       => 'Montserrat',
            'src'         => ''
          ),
          array(
            'value'       => 'other',
            'label'       => 'Other Google Font/Custom Font',
            'src'         => ''
          )
        )
      ),
      array(
        'id'          => 'cb_user_header_font',
        'label'       => 'Other Google Font/Custom Font',
        'desc'        => 'Enter any Google Font Code from http://www.google.com/fonts. Example of code that should be entered: \'Noto Sans\', sans-serif; or if you want to use your own font, after adding the @import code to the custom CSS box, enter the family name here using the same format as Google Fonts: \'Noto Sans\', sans-serif;',
        'std'         => '',
        'type'        => 'text',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub-sub',
        'condition'   => 'cb_header_font:is(other)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_body_font',
        'label'       => 'General body text font',
        'desc'        => 'Select the font to be used for general body text.',
        'std'         => '',
        'type'        => 'select',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => '_cb_post_font:is(on)',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '\'Raleway\', sans-serif;',
            'label'       => 'Raleway',
            'src'         => ''
          ),
          array(
            'value'       => '\'Open Sans\', sans-serif;',
            'label'       => 'Open Sans',
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
            'label'       => 'Other Google Font/Custom Font',
            'src'         => ''
          )
        )
      ),      
    array(
        'id'          => 'cb_user_body_font',
        'label'       => 'Other Google Font',
        'desc'        => 'Enter any Google Font Code from http://www.google.com/fonts. Example of code that should be entered: \'Noto Sans\', sans-serif; or if you want to use your own font, after adding the @import code to the custom CSS box, enter the family name here using the same format as Google Fonts: \'Noto Sans\', sans-serif;',
        'type'        => 'text',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub-sub',
        'condition'   => 'cb_body_font:is(other)',
        'operator'    => 'and'
      ),
        array(
            'label'       =>  'Review Options',
            'id'          => 'cb_tab_review',
            'type'        => 'tab'
        ),
        array(
            'id'          => 'cb_review_checkbox',
            'label'       => 'Enable Review',
            'desc'        => '',
            'std'         => 'off',
            'type'        => 'on-off',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => '',
        ),
         array(
            'id'          => 'cb_score_display_type',
            'label'       => 'Score style',
            'desc'        => '',
            'std'         => 'percentage',
            'type'        => 'radio-image',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'condition'   => 'cb_review_checkbox:is(on)',
            'class'       => 'cb-sub',
            'choices'     => array(
              array(
                'value'       => 'percentage',
                'label'       => 'Percentage',
                'src'         => '/percent.png'
              ),
              
              array(
                'value'       => 'points',
                'label'       => 'Points',
                'src'         => '/points.png'
              ),
              array(
                'value'       => 'stars',
                'label'       => 'Stars',
                'src'         => '/stars.png'
              ),
            ),
          ),
        array(
            'id'          => 'cb_placement',
            'label'       => 'Location',
            'desc'        => '',
            'std'         => 'top',
            'type'        => 'radio-image',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'condition'   => 'cb_review_checkbox:is(on)',
            'class'       => 'cb-sub',
            'choices'     => array(
              array(
                'value'       => 'top',
                'label'       => 'Top',
                'src'         => '/top.png'
              ),
              array(
                'value'       => 'top-half',
                'label'       => 'Top Half-Width',
                'src'         => '/top-hw.png'
              ),
              array(
                'value'       => 'bottom',
                'label'       => 'Bottom',
                'src'         => '/bottom.png'
              ),
            ),
          ),

            array(
                'id'          => 'cb_user_score',
                'label'       => 'Type of review',
                'desc'        => '',
                'std'         => 'cb-both',
                'type'        => 'select',
                'rows'        => '',
                'post_type'   => '',
                'taxonomy'    => '',
                'class'       => 'cb-sub',
                'min_max_step'=> '',
                'condition'   => 'cb_review_checkbox:is(on)',
                'choices'     => array(
                  array(
                    'value'       => 'cb-both',
                    'label'       => 'Editor Review + Visitor Ratings',
                    'src'         => ''
                  ),
                  array(
                    'value'       => 'cb-editor',
                    'label'       => 'Editor Review Only',
                    'src'         => ''
                  ),
                  array(
                    'value'       => 'cb-readers',
                    'label'       => 'Visitor ratings only',
                    'src'         => ''
                  ),
                ),
              ),
        array(
            'id'          => 'cb_rating_short_summary_in',
            'label'       => 'Score short sub-title',
            'desc'        => 'Enter a word or two to appear under the final score.',
            'std'         => '',
            'type'        => 'text',
            'rows'        => '1',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => 'cb-sub',
             'condition'   => 'cb_review_checkbox:is(on),cb_user_score:not(cb-readers)',
          ),
        array(
            'id'          => 'cb_review_crits',
            'label'       => 'Criterias',
            'desc'        => '',
            'std'         => '',
            'type'        => 'list-item',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => 'cb-sub',
            'condition'   => 'cb_review_checkbox:is(on),cb_user_score:not(cb-readers)',
            'settings'    => array(
                array(
                    'id'          => 'cb_cs',
                    'label'       => 'Criteria Score',
                    'desc'        => '',
                    'std'         => '0',
                    'type'        => 'numeric-slider',
                    'min_max_step'=> '0,100,1',
                    'rows'        => '1',
                    'post_type'   => '',
                    'taxonomy'    => '',
                    'class'       => 'cb-crit-half',
                ),
            )
          ),
         array(
            'id'          => 'cb_final_score',
            'label'       => 'Final Score',
            'desc'        => 'This is the average score of all your criterias. You can override it if you wish.',
            'std'         => '',
            'type'        => 'text',
            'rows'        => '1',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => 'cb-final-score cb-sub',
            'condition'   => 'cb_review_checkbox:is(on),cb_user_score:not(cb-readers)',
          ),
          array(
            'id'          => 'cb_pros',
            'label'       => 'Positives',
            'desc'        => '',
            'std'         => '',
            'type'        => 'list-item',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => 'cb-sub',
            'condition'   => 'cb_review_checkbox:is(on),cb_user_score:not(cb-readers)',
            'settings'    => array(
                array(
                'id'          => 'cb_pro_text',
                'label'       => 'Positive',
                'desc'        => '',
                'std'         => '',
                'type'        => 'text',
                'rows'        => '1',
                'post_type'   => '',
                'taxonomy'    => '',
                'min_max_step'=> '',
                'class'       => '',
                'condition'   => 'turnoff:is(on)',
              ),
            )
          ),
          array(
            'id'          => 'cb_cons',
            'label'       => 'Negatives',
            'desc'        => '',
            'std'         => '',
            'type'        => 'list-item',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => 'cb-sub',
            'condition'   => 'cb_review_checkbox:is(on),cb_user_score:not(cb-readers)',
            'settings'    => array(
                 array(
                'id'          => 'cb_con_text',
                'label'       => 'Negative',
                'desc'        => '',
                'std'         => '',
                'type'        => 'text',
                'rows'        => '1',
                'post_type'   => '',
                'taxonomy'    => '',
                'min_max_step'=> '',
                'class'       => '',
                'condition'   => 'turnoff:is(on)',
              ),
            )
          ),
        array(
            'label'       =>  'Background Image Options',
            'id'          => 'cb_tab_bg',
            'type'        => 'tab'
        ),
        array(
        'id'          => 'cb_background_image',
        'label'       => 'Post Background Image',
        'desc'        => 'Set a background color or image for this post',
        'std'         => '',
        'type'        => 'background',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
)
);

ot_register_meta_box( $cb_go );

$cb_po = array(
    'id'          => 'cb_po',
    'title'       => '15Zine Page Options',
    'desc'        => '',
    'pages'       => 'page',
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
    
        array(
        'label'       =>  'Featured Image Options',
        'id'          => 'cb_tab_fi',
        'type'        => 'tab'
        ),
        array(
        'id'          => 'cb_featured_image_style',
        'label'       => 'Featured Image Style',
        'desc'        => '',
        'std'         => 'standard',
        'type'        => 'radio-image',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
           array(
              'value'       => 'standard',
              'label'       => 'Standard',
              'src'         => '/img_st.png'
              ),
           array(
              'value'       => 'standard-uncrop',
              'label'       => 'Standard Uncropped',
              'src'         => '/img_stun.png'
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
              'value'       => 'background-slideshow',
              'label'       => 'Background Slideshow',
              'src'         => '/img_bs.png'
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
            'id'          => 'cb_post_background_slideshow',
            'label'       => 'Background Slideshow Images',
            'desc'        => 'Upload/set images to show as a Slideshow',
            'std'         => '',
            'type'        => 'gallery',
            'section'     => 'option_types',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => '',
            'condition'   => 'cb_featured_image_style:is(background-slideshow)',
            'operator'    => 'and'
        ),
         array(
            'id'          => 'cb_post_fis_header',
            'label'       => 'Show Site Header (Logo + Header Ad area)',
            'desc'        => 'If you have a logo set to appear inside the navigation menu, you can disable the header to make a post feel even more special.',
            'std'         => 'on',
            'type'        => 'on-off',
            'section'     => 'option_types',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => 'cb-sub',
            'condition'   => 'cb_featured_image_style:is(parallax),cb_featured_image_style:is(background-slideshow),cb_featured_image_style:is(full-background),cb_featured_image_style:is(screen-width)',
            'operator'    => 'or'
        ),
        array(
            'label'       => 'Featured Image Credit Line',
            'id'          => 'cb_image_credit',
            'type'        => 'text',
            'desc'        => 'Optional Photograph credit line',
            'std'         => '',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'condition'   => 'cb_featured_image_style:not(off)',
        ),
        array(
            'id'          => 'cb_page_title',
            'label'       => 'Show Page Title',
            'desc'        => 'This option allows you to turn the page title off if desired.',
            'std'         => 'on',
            'type'        => 'on-off',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
        ),
        array(
            'label'       =>  'Sidebar Options',
            'id'          => 'cb_tab_sidebar',
            'type'        => 'tab'
        ),
        array(
            'id'          => 'cb_full_width_post',
            'label'       => 'Sidebar Style',
            'desc'        => '',
            'std'         => 'sidebar',
            'type'        => 'radio-image',
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
            'id'          => 'cb_page_custom_sidebar',
            'label'       => 'Custom Sidebar For Page',
            'desc'        => 'Enable to add a new sidebar for this page. If enabled, you can add widgets in Appearance -> Widgets.',
            'std'         => 'off',
            'type'        => 'on-off',
            'section'     => 'option_types',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => 'cb-sub',
            'condition'   => 'cb_full_width_post:not(nosidebar),cb_full_width_post:not(nosidebar-fw)',
            'operator'    => 'and'
        ),
          array(
        'id'          => 'cb_sidebar_select',
        'label'       => __( 'Sidebar Select', 'cubell_admin' ),
        'desc'        => 'Use a sidebar that already exists.',
        'std'         => '',
        'type'        => 'sidebar-select',
        'section'     => 'option_types',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_full_width_post:not(nosidebar),cb_page_custom_sidebar:is(on),cb_full_width_post:not(nosidebar-fw)',
        'operator'    => 'and'
      ),
        array(
            'label'       =>  'Background Image Options',
            'id'          => 'cb_tab_bg',
            'type'        => 'tab'
        ),
        array(
        'id'          => 'cb_background_image',
        'label'       => 'Page Background Image',
        'desc'        => 'Set a background color or image for this page.',
        'std'         => '',
        'type'        => 'background',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
)
);

ot_register_meta_box( $cb_po );

$cb_hpb = array(
  'id'          => 'cb_hpb',
  'title'       => '15Zine Drag & Drop Builder',
  'desc'        => '',
  'pages'       => array( 'page' ),
  'context'     => 'normal',
  'priority'    => 'high',
  'fields'      => array(
    array(
      'id'          => 'cb_section_a',
      'label'       => 'Section A (Full-Width)',
      'desc'        => '',
      'std'         => '',
      'type'        => 'list-item',
      'section'     => 'cb_homepage',
      'rows'        => '',
      'post_type'   => '',
      'taxonomy'    => '',
      'class'       => '',
      'settings'    => array(
        array(
          'id'          => 'cb_a_module_style',
          'label'       => 'Module Block',
          'desc'        => '',
          'std'         => 'm-aa',
          'type'        => 'radio-image',
          'rows'        => '',
          'post_type'   => '',
          'taxonomy'    => '',
          'class'       => 'cb-modules',
          'choices'     => array(
                                array(
                                  'value'       => 'm-aa',
                                  'label'       => 'Module A',
                                  'src'         => '/module_a_fw.png'
                                  ),
                                array(
                                  'value'       => 'm-fra',
                                  'label'       => 'Module Reviews',
                                  'src'         => '/module_fr_fw.png'
                                ),
                                array(
                                  'value'       => 's-5a',
                                  'label'       => 'Slider of Grid of 3',
                                  'src'         => '/grid_3s.png'
                                  ),
                                array(
                                  'value'       => 'grid-4a',
                                  'label'       => 'Grid 4',
                                  'src'         => '/grid_4.png'
                                  ),
                                array(
                                  'value'       => 'grid-5a',
                                  'label'       => 'Grid 5',
                                  'src'         => '/grid_5.png'
                                  ),
                                array(
                                  'value'       => 'grid-6a',
                                  'label'       => 'Grid 6',
                                  'src'         => '/grid_6.png'
                                  ),
                                array(
                                  'value'       => 's-1a',
                                  'label'       => 'Slider A',
                                  'src'         => '/module_slider_a.png'
                                  ),
                                array(
                                  'value'       => 's-2a',
                                  'label'       => 'Slider B',
                                  'src'         => '/module_slider_b.png'
                                  ),
                                array(
                                  'value'       => 's-3a',
                                  'label'       => 'Slider C',
                                  'src'         => '/module_slider_c.png'
                                  ),
                                array(
                                  'value'       => 'ad-970a',
                                  'label'       => 'Ad: 970x90',
                                  'src'         => '/adc.png'
                                  ),
                                array(
                                  'value'       => 'customa',
                                  'label'       => 'Custom Code',
                                  'src'         => '/custom.png'
                                  )
                            ),
        ),
        array(
            'id'          => 'cb_subtitle_a',
            'label'       => 'Optional Subtitle',
            'desc'        => '',
            'std'         => '',
            'type'        => 'text',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => '',
            'condition'   => 'cb_a_module_style:not(ad-970a)',
            ),
        array(
            'id'          => 'cb_filter',
            'label'       => 'Post selection',
            'desc'        => '',
            'std'         => '',
            'type'        => 'select',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => '',
            'condition'   => 'cb_a_module_style:not(customa),cb_a_module_style:not(ad-970a)',
            'choices'     => array(
              array(
                'value'       => 'cb_filter_category',
                'label'       => 'By Category',
                'src'         => ''
                ),
              array(
                'value'       => 'cb_filter_tags',
                'label'       => 'By Tags',
                'src'         => ''
                ),
              array(
                'value'       => 'cb_filter_postid',
                'label'       => 'By Post Names',
                'src'         => ''
                ),
              ),
            ),
        array(
            'label'       => 'Category Filter',
            'id'          => 'cb_a_latest_posts',
            'type'        => 'category-checkbox',
            'desc'        => '',
            'std'         => '',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => '',
            'condition'   => 'cb_a_module_style:not(customa),cb_a_module_style:not(ad-970a),cb_filter:is(cb_filter_category)',
            ),
        array(
            'label'       => 'Tag Filter',
            'id'          => 'tags_cb',
            'type'        => 'text',
            'desc'        => 'Type the name of the tag to search for it and then click it in the list to add it to the module.',
            'std'         => '',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => '',
            'condition'   => 'cb_a_module_style:not(customa),cb_a_module_style:not(ad-970a),cb_filter:is(cb_filter_tags)',
            ),
        array(
            'label'       => 'Posts Filter',
            'id'          => 'ids_posts_cb',
            'type'        => 'text',
            'desc'        => 'Type a word of the post title to search for it and then click it in the list to add it to the module.',
            'std'         => '',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => 'cb-aj-input',
            'condition'   => 'cb_a_module_style:not(customa),cb_a_module_style:not(ad-970a),cb_filter:is(cb_filter_postid)',
            ),
        array(
            'id'          => 'cb_order',
            'label'       => 'Post Order',
            'desc'        => '',
            'std'         => '',
            'type'        => 'select',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => '',
            'condition'   => 'cb_a_module_style:not(customa),cb_a_module_style:not(ad-970a)',
            'choices'     => array(
              array(
                'value'       => 'cb_latest',
                'label'       => 'Latest Posts',
                'src'         => ''
                ),
              array(
                'value'       => 'cb_random',
                'label'       => 'Random Posts',
                'src'         => ''
                ),
              array(
                'value'       => 'cb_oldest',
                'label'       => 'Oldest Posts',
                'src'         => ''
                ),
              ),
            ),
        array(
            'id'          => 'cb_ad_code_a',
            'label'       => 'Ad Code',
            'desc'        => '',
            'std'         => '',
            'type'        => 'textarea',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => '',
            'condition'   => 'cb_a_module_style:is(ad-970a)',
            ),
        array(
            'id'          => 'cb_slider_a',
            'label'       => 'Number Of Posts To Show',
            'desc'        => '',
            'std'         => '3',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '3,12,3',
            'class'       => '',
            'condition'   => 'cb_a_module_style:not(customa),cb_a_module_style:not(ad-970a),cb_a_module_style:not(grid-4a),cb_a_module_style:not(grid-5a),cb_a_module_style:not(grid-6a)',
            ),
        array(
            'id'          => 'cb_offset',
            'label'       => 'Posts Offset (optional)',
            'desc'        => '',
            'std'         => '0',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '0,50,1',
            'class'       => '',
            'condition'   => 'cb_a_module_style:not(customa),cb_a_module_style:not(ad-970a)',
            ),
        array(
            'id'          => 'cb_custom_a',
            'label'       => 'Custom Code',
            'desc'        => '',
            'std'         => '',
            'type'        => 'textarea',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => '',
            'condition'   => 'cb_a_module_style:is(customa)',
            ),
        )
        ),
array(
      'id'          => 'cb_section_f',
      'label'       => 'Section A2 (Full-Screen)',
      'desc'        => '',
      'std'         => '',
      'type'        => 'list-item',
      'section'     => 'cb_homepage',
      'rows'        => '',
      'post_type'   => '',
      'taxonomy'    => '',
      'class'       => '',
      'settings'    => array(
        array(
          'id'          => 'cb_f_module_style',
          'label'       => 'Module Block',
          'desc'        => '',
          'std'         => 'm-af',
          'type'        => 'radio-image',
          'rows'        => '',
          'post_type'   => '',
          'taxonomy'    => '',
          'class'       => 'cb-modules',
          'choices'     => array(
                               /* array(
                                  'value'       => 'm-af',
                                  'label'       => 'Featured Post',
                                  'src'         => '/module_f_a.png'
                                  ),*/
                                array(
                                  'value'       => 's-1a',
                                  'label'       => 'Slider A',
                                  'src'         => '/module_f_b.png'
                                  ),
                                array(
                                  'value'       => 'customf',
                                  'label'       => 'Custom Code',
                                  'src'         => '/custom.png'
                                  )
                            ),
        ),
        array(
            'id'          => 'cb_filter',
            'label'       => 'Post selection',
            'desc'        => '',
            'std'         => '',
            'type'        => 'select',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => '',
            'condition'   => 'cb_f_module_style:not(customf)',
            'choices'     => array(
              array(
                'value'       => 'cb_filter_category',
                'label'       => 'By Category',
                'src'         => ''
                ),
              array(
                'value'       => 'cb_filter_tags',
                'label'       => 'By Tags',
                'src'         => ''
                ),
              array(
                'value'       => 'cb_filter_postid',
                'label'       => 'By Post Names',
                'src'         => ''
                ),
              ),
            ),
        array(
            'label'       => 'Category Filter',
            'id'          => 'cb_f_latest_posts',
            'type'        => 'category-checkbox',
            'desc'        => '',
            'std'         => '',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => '',
            'condition'   => 'cb_f_module_style:not(customf),cb_filter:is(cb_filter_category)',
            ),
        array(
            'label'       => 'Tag Filter',
            'id'          => 'tags_cb',
            'type'        => 'text',
            'desc'        => 'Type the name of the tag to search for it and then click it in the list to add it to the module.',
            'std'         => '',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => '',
            'condition'   => 'cb_f_module_style:not(customf),cb_filter:is(cb_filter_tags)',
            ),
        array(
            'label'       => 'Posts Filter',
            'id'          => 'ids_posts_cb',
            'type'        => 'text',
            'desc'        => 'Type a word of the post title to search for it and then click it in the list to add it to the module.',
            'std'         => '',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => 'cb-aj-input',
            'condition'   => 'cb_f_module_style:not(customf),cb_filter:is(cb_filter_postid)',
            ),
        array(
            'id'          => 'cb_order',
            'label'       => 'Post Order',
            'desc'        => '',
            'std'         => '',
            'type'        => 'select',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => '',
            'condition'   => 'cb_f_module_style:not(customf)',
            'choices'     => array(
              array(
                'value'       => 'cb_latest',
                'label'       => 'Latest Posts',
                'src'         => ''
                ),
              array(
                'value'       => 'cb_random',
                'label'       => 'Random Posts',
                'src'         => ''
                ),
              array(
                'value'       => 'cb_oldest',
                'label'       => 'Oldest Posts',
                'src'         => ''
                ),
              ),
            ),
        array(
            'id'          => 'cb_slider_f',
            'label'       => 'Number Of Posts To Show',
            'desc'        => '',
            'std'         => '3',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '3,12,3',
            'class'       => '',
            'condition'   => 'cb_f_module_style:not(customf)',
            ),
        array(
            'id'          => 'cb_offset',
            'label'       => 'Posts Offset (optional)',
            'desc'        => '',
            'std'         => '0',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '0,50,1',
            'class'       => '',
            'condition'   => 'cb_f_module_style:not(customf)',
            ),
        array(
            'id'          => 'cb_custom_f',
            'label'       => 'Custom Code',
            'desc'        => '',
            'std'         => '',
            'type'        => 'textarea',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'condition'   => 'cb_f_module_style:is(customf)',
            ),
        )
        ),
array(
  'id'          => 'cb_section_b',
  'label'       => 'Section B + "Section B Sidebar (In Appearance -> Widgets)"',
  'desc'        => '',
  'std'         => '',
  'type'        => 'list-item',
  'section'     => 'cb_homepage',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'settings'    => array(
    array(
      'id'          => 'cb_b_module_style',
      'label'       => 'Module Block',
      'desc'        => '',
      'std'         => 'm-ab',
      'type'        => 'radio-image',
      'rows'        => '',
      'post_type'   => '',
      'taxonomy'    => '',
      'class'       => 'cb-modules',
      'choices'     => array(
        array(
          'value'       => 'm-ab',
          'label'       => 'Module A',
          'src'         => '/module_a.png'
          ),
        array(
          'value'       => 'm-bb',
          'label'       => 'Module B',
          'src'         => '/module_b.png'
          ),
        array(
          'value'       => 'm-cb',
          'label'       => 'Module C',
          'src'         => '/module_c.png'
          ),
        array(
          'value'       => 'm-db',
          'label'       => 'Module D',
          'src'         => '/module_d.png'
          ),
        array(
          'value'       => 'm-eb',
          'label'       => 'Module E',
          'src'         => '/module_e.png'
          ),
         array(
          'value'       => 'm-rb',
          'label'       => 'Module Reviews Half-Width',
          'src'         => '/module_r.png'
          ),
        array(
          'value'       => 'm-frb',
          'label'       => 'Module Reviews Full-Width',
          'src'         => '/module_fr.png'
          ),
        array(
          'value'       => 'grid-3b',
          'label'       => 'Grid 3',
          'src'         => '/grid_3.png'
          ),
        array(
          'value'       => 'ad-728b'
,          'label'       => 'Ad: 728x90',
          'src'         => '/adb.png'
          ),
        array(
          'value'       => 'ad-336b',
          'label'       => 'Ad: 336x280',
          'src'         => '/add.png'
          ),
        array(
          'value'       => 's-1b',
          'label'       => 'Slider A',
          'src'         => '/module_slider_a.png'
          ),
        array(
          'value'       => 's-2b',
          'label'       => 'Slider B',
          'src'         => '/module_slider_b.png'
          ),
        array(
          'value'       => 'customb',
          'label'       => 'Custom Code',
          'src'         => '/custom.png'
          ),
        array(
          'value'       => 'custom-halfb',
          'label'       => 'Custom Code Half-Width',
          'src'         => '/custom_half.png'
          )
        ),
),
array(
  'id'          => 'cb_subtitle_b',
  'label'       => 'Optional Subtitle',
  'desc'        => '',
  'std'         => '',
  'type'        => 'text',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_b_module_style:not(ad-728b),cb_b_module_style:not(ad-336b)',
  
  ),
array(
  'id'          => 'cb_filter',
  'label'       => 'Post selection',
  'desc'        => '',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_b_module_style:not(customb),cb_b_module_style:not(custom-halfb),cb_b_module_style:not(ad-336b),cb_b_module_style:not(ad-728b)',
  'choices'     => array(
    array(
      'value'       => 'cb_filter_category',
      'label'       => 'By Category',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_filter_tags',
      'label'       => 'By Tags',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_filter_postid',
      'label'       => 'By Post Names',
      'src'         => ''
      ),
    ),
  ),
array(
  'label'       => 'Category Filter',
  'id'          => 'cb_b_latest_posts',
  'type'        => 'category-checkbox',
  'desc'        => '',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_b_module_style:not(custom-halfb),cb_b_module_style:not(customb),cb_b_module_style:not(ad-336b),cb_b_module_style:not(ad-728b),cb_filter:is(cb_filter_category)',
  ),
array(
  'label'       => 'Tag Filter',
  'id'          => 'tags_cb',
  'type'        => 'text',
  'desc'        => 'Type the name of the tag to search for it and then click it in the list to add it to the module.',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_b_module_style:not(custom-halfb),cb_b_module_style:not(customb),cb_b_module_style:not(ad-336b),cb_b_module_style:not(ad-728b),cb_filter:is(cb_filter_tags)',
  ),
array(
  'label'       => 'Posts Filter',
  'id'          => 'ids_posts_cb',
  'type'        => 'text',
  'desc'        => 'Type a word of the post title to search for it and then click it in the list to add it to the module.',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => 'cb-aj-input',
  'condition'   => 'cb_b_module_style:not(custom-halfb),cb_b_module_style:not(customb),cb_b_module_style:not(ad-336b),cb_b_module_style:not(ad-728b),cb_filter:is(cb_filter_postid)',
  ),
array(
  'id'          => 'cb_order',
  'label'       => 'Post Order',
  'desc'        => '',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_b_module_style:not(customb),cb_b_module_style:not(custom-halfb),cb_b_module_style:not(ad-336b),cb_b_module_style:not(ad-728b)',
  'choices'     => array(
    array(
      'value'       => 'cb_latest',
      'label'       => 'Latest Posts',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_random',
      'label'       => 'Random Posts',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_oldest',
      'label'       => 'Oldest Posts',
      'src'         => ''
      ),
    ),
  ),
array(
  'id'          => 'cb_ad_code_b',
  'label'       => 'Ad Code',
  'desc'        => '',
  'std'         => '',
  'type'        => 'textarea',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'operator'    => 'OR',
  'condition'   => 'cb_b_module_style:is(ad-336b),cb_b_module_style:is(ad-728b)',
  ),
array(
  'id'          => 'cb_slider_b',
  'label'       => 'Number Of Posts To Show',
  'desc'        => '',
  'std'         => '2',
  'type'        => 'numeric-slider',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'min_max_step'=> '1,16,1',
  'class'       => '',
  'condition'   => 'cb_b_module_style:not(customb),cb_b_module_style:not(grid-3b),cb_b_module_style:not(custom-halfb),cb_b_module_style:not(ad-336b),cb_b_module_style:not(ad-728b)',
  ),
array(
  'id'          => 'cb_offset',
  'label'       => 'Posts Offset (optional)',
  'desc'        => '',
  'std'         => '0',
  'type'        => 'numeric-slider',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'min_max_step'=> '0,50,1',
  'class'       => '',
  'condition'   => 'cb_b_module_style:not(customb),cb_b_module_style:not(custom-halfb),cb_b_module_style:not(ad-336b),cb_b_module_style:not(ad-728b)',
  ),
array(
  'id'          => 'cb_custom_b',
  'label'       => 'Custom Code',
  'desc'        => '',
  'std'         => '',
  'type'        => 'textarea',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'operator'    => 'OR',
  'condition'   => 'cb_b_module_style:is(customb),cb_b_module_style:is(custom-halfb)',
  ),
)
),
array(
  'id'          => 'cb_section_c',
  'label'       => 'Section C (Full-Width)',
  'desc'        => '',
  'std'         => '',
  'type'        => 'list-item',
  'section'     => 'cb_homepage',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'settings'    => array(
    array(
      'id'          => 'cb_c_module_style',
      'label'       => 'Module Block',
      'desc'        => '',
      'std'         => 'm-ac',
      'type'        => 'radio-image',
      'rows'        => '',
      'post_type'   => '',
      'taxonomy'    => '',
      'class'       => 'cb-modules',
      'choices'     => array(
        array(
          'value'       => 'm-ac',
          'label'       => 'Module A',
          'src'         => '/module_a_fw.png'
          ),
        array(
            'value'       => 'm-frc',
            'label'       => 'Module Reviews',
            'src'         => '/module_fr_fw.png'
          ),
        array(
        'value'       => 's-5c',
        'label'       => 'Slider of Grid of 3',
        'src'         => '/grid_3s.png'
        ),
        array(
          'value'       => 'grid-4c',
          'label'       => 'Grid 4',
          'src'         => '/grid_4.png'
          ),
        array(
          'value'       => 'grid-5c',
          'label'       => 'Grid 5',
          'src'         => '/grid_5.png'
          ),
        array(
          'value'       => 'grid-6c',
          'label'       => 'Grid 6',
          'src'         => '/grid_6.png'
          ),
        
        array(
          'value'       => 's-1c',
          'label'       => 'Slider A',
          'src'         => '/module_slider_a.png'
          ),
        array(
          'value'       => 's-2c',
          'label'       => 'Slider B',
          'src'         => '/module_slider_b.png'
          ),
        array(
        'value'       => 's-3c',
        'label'       => 'Slider C',
        'src'         => '/module_slider_c.png'
        ),
        array(
          'value'       => 'ad-970c',
          'label'       => 'Ad: 970x90',
          'src'         => '/adc.png'
          ),
        array(
          'value'       => 'customc',
          'label'       => 'Custom Code',
          'src'         => '/custom.png'
          )
        ),
),

array(
  'id'          => 'cb_subtitle_c',
  'label'       => 'Optional Subtitle',
  'desc'        => '',
  'std'         => '',
  'type'        => 'text',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'condition'   => 'cb_c_module_style:not(ad-970c)',
  ),
array(
  'id'          => 'cb_filter',
  'label'       => 'Post selection',
  'desc'        => '',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_c_module_style:not(customc),cb_c_module_style:not(ad-970c)',
  'choices'     => array(
    array(
      'value'       => 'cb_filter_category',
      'label'       => 'By Category',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_filter_tags',
      'label'       => 'By Tags',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_filter_postid',
      'label'       => 'By Post Names',
      'src'         => ''
      ),
    ),
  ),
array(
  'label'       => 'Category Filter',
  'id'          => 'cb_c_latest_posts',
  'type'        => 'category-checkbox',
  'desc'        => '',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_c_module_style:not(customc),cb_c_module_style:not(ad-970c),cb_filter:is(cb_filter_category)',
  ),
array(
  'label'       => 'Tag Filter',
  'id'          => 'tags_cb',
  'type'        => 'text',
  'desc'        => 'Type the name of the tag to search for it and then click it in the list to add it to the module.',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_c_module_style:not(customc),cb_c_module_style:not(ad-970c),cb_filter:is(cb_filter_tags)',
  ),
array(
  'label'       => 'Posts Filter',
  'id'          => 'ids_posts_cb',
  'type'        => 'text',
  'desc'        => 'Type a word of the post title to search for it and then click it in the list to add it to the module.',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => 'cb-aj-input',
  'condition'   => 'cb_c_module_style:not(customc),cb_c_module_style:not(ad-970c),cb_filter:is(cb_filter_postid)',
  ),
array(
  'id'          => 'cb_order',
  'label'       => 'Post Order',
  'desc'        => '',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_c_module_style:not(customc),cb_c_module_style:not(ad-970c)',
  'choices'     => array(
    array(
      'value'       => 'cb_latest',
      'label'       => 'Latest Posts',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_random',
      'label'       => 'Random Posts',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_oldest',
      'label'       => 'Oldest Posts',
      'src'         => ''
      ),
    ),
  ),
array(
  'id'          => 'cb_ad_code_c',
  'label'       => 'Ad Code',
  'desc'        => '',
  'std'         => '',
  'type'        => 'textarea',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_c_module_style:is(ad-970c)',
  ),
array(
  'id'          => 'cb_slider_c',
  'label'       => 'Number Of Posts To Show',
  'desc'        => '',
  'std'         => '3',
  'type'        => 'numeric-slider',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'min_max_step'=> '3,12,3',
  'class'       => '',
  'condition'   => 'cb_c_module_style:not(customc),cb_c_module_style:not(ad-970c),cb_c_module_style:not(grid-4c),cb_c_module_style:not(grid-5c),cb_c_module_style:not(grid-6c)',
  ),
array(
  'id'          => 'cb_offset',
  'label'       => 'Posts Offset (optional)',
  'desc'        => '',
  'std'         => '0',
  'type'        => 'numeric-slider',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'min_max_step'=> '0,50,1',
  'class'       => '',
  'condition'   => 'cb_c_module_style:not(customc),cb_c_module_style:not(ad-970c)',
  ),
array(
  'id'          => 'cb_custom_c',
  'label'       => 'Custom Code',
  'desc'        => '',
  'std'         => '',
  'type'        => 'textarea',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_c_module_style:is(customc)',
  ),
)
),
array(
    'id'          => 'cb_pb_onoff',
    'label'       => 'Section With Latest Global Posts + Pagination',
    'desc'        => '',
    'std'         => 'off',
    'type'        => 'on-off',
    'rows'        => '',
    'post_type'   => '',
    'taxonomy'    => '',
    'min_max_step'=> '',
    'class'       => '',
),
 array(
    'id'          => 'cb_pb_title',
    'label'       => 'Optional Title',
    'desc'        => '',
    'std'         => '',
    'type'        => 'text',
    'rows'        => '',
    'post_type'   => '',
    'condition'   => 'cb_pb_onoff:is(on)',
    'class'       => 'cb-sub'
    ),
    array(
    'id'          => 'cb_pb_subtitle',
    'label'       => 'Optional Subtitle',
    'desc'        => '',
    'std'         => '',
    'type'        => 'text',
    'rows'        => '',
    'post_type'   => '',
    'condition'   => 'cb_pb_onoff:is(on)',
    'class'       => 'cb-sub'
    ),
array(
    'id'          => 'cb_pb_bs',
    'label'       => 'Blog Style',
    'desc'        => '',
    'std'         => 'a',
    'type'        => 'radio-image',
    'section'     => 'ot_homepage',
    'rows'        => '',
    'post_type'   => '',
    'taxonomy'    => '',
    'min_max_step'=> '',
    'condition'   => 'cb_pb_onoff:is(on)',
    'class'       => 'cb-sub',
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
),/*
array(
    'id'          => 'cb_pb_infinite',
    'label'       => 'Infinite Scroll',
    'desc'        => '',
    'std'         => '',
    'type'        => 'select',
    'section'     => 'ot_homepage',
    'rows'        => '',
    'post_type'   => '',
    'taxonomy'    => '',
    'min_max_step'=> '',
    'condition'   => 'cb_pb_onoff:is(on)',
    'class'       => 'cb-sub',
    'choices'     => array(
      array(
        'value'       => 'off',
        'label'       => 'Off',
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
  ),*/

)
);

ot_register_meta_box( $cb_hpb );




}
add_action( 'admin_init', '_cb_meta' );
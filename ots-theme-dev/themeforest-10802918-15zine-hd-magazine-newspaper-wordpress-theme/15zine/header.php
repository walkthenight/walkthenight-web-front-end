<?php
	$cb_favicon = ot_get_option( 'cb_favicon_url', NULL );
    $cb_responsive_style = ot_get_option( 'cb_responsive_style', 'on' );
    $cb_logo_position = 'cb-logo-' . ot_get_option( 'cb_logo_position', 'left' );
	$cb_body_class = $cb_tm_wrap = $cb_hd_wrap = $cb_menu_wrap = $cb_hd_wrap_s = $cb_bg_to_margin_top = $cb_main_menu_wrap = $cb_hd_wrap_s_2 = NULL;
	$cb_main_wrap = 'wrap ';
    $cb_body_class .= cb_get_body_classes(); 
    $cb_review_checkbox = $cb_bg_to_img = $cb_bg_ad = NULL;
    $cb_bg_to = ot_get_option( 'cb_bg_to', 'off' );
    $cb_logo = ot_get_option( 'cb_logo_url', NULL );
    $cb_show_header = NULL;

    if ( cb_header_banner() != NULL ) {
    	$cb_hd_wrap_s = ' cb-with-block';
    }

    if ( is_singular() ) {
    	$cb_body_class .= cb_get_post_fis( $post->ID );
    	$cb_body_class .= cb_get_singular_fs( $post->ID );
    	$cb_show_header = cb_show_header();
    }
    if ( is_single() ) {
    	$cb_review_checkbox = get_post_meta( $post->ID, 'cb_review_checkbox', true );
    	$cb_body_class .= cb_get_dropcap( $post->ID );
    }

    if ( is_category() || is_home() ) {
    	$cb_body_class .= cb_get_featured_block();
    }

    if ( ot_get_option( 'cb_h_logo_mobile', 'on' ) == 'off' ) {
    	$cb_mobile = new Mobile_Detect;
        if ( ( $cb_mobile->isTablet() == false ) && ( $cb_mobile->isMobile() == true ) )  {
        	$cb_show_header = 'off';
        }
    }
    if ( ( $cb_only_mob = ( ( cb_top_nav_right() != NULL ) || ( has_nav_menu( 'top' ) ) ) ) == NULL ) {
    	$cb_body_class .= ' cb-mob-only';
    }
    

    if ( $cb_show_header == NULL ) {
    	$cb_show_header = 'on';
    }

    if ( ot_get_option( 'cb_sw_tm', 'fw' ) == 'box' ) {
        $cb_tm_wrap = ' wrap';
    }

    if ( ot_get_option( 'cb_sw_hd', 'fw' ) == 'fw' ) {
        $cb_hd_wrap = ' wrap';
        $cb_main_wrap = 'cb-wrap-off ';
    } else {
    	$cb_hd_wrap = ' cb-fw';
    	$cb_hd_wrap_s_2 = 'wrap';
    }

    if ( ot_get_option( 'cb_sw_menu', 'fw' ) == 'fw' ) {
        $cb_menu_wrap = ' cb-menu-fw';
    } else {
    	$cb_menu_wrap = $cb_main_menu_wrap = ' wrap';
    }

	if ( ( $cb_bg_to == 'global' ) || ( ( $cb_bg_to == 'only-hp' ) && ( is_front_page() == TRUE ) ) ) {
	    $cb_bg_to_margin_top = ot_get_option('cb_bg_to_margin_top', NULL);
	    $cb_bg_to_url = ot_get_option('cb_bg_to_url', NULL);
	    $cb_bg_to_img = ot_get_option('cb_bg_to_img', NULL);
	    $cb_bg_ad = '<a href="' . esc_url($cb_bg_to_url) .'" target="_blank" id="cb-bg-to" rel="nofollow"></a>';
	    $cb_body_class .= ' cb-bg-to-on';
	    if ( $cb_bg_to_margin_top != NULL ) {
	        $cb_bg_to_margin_top = ' style="margin-top:'. intval($cb_bg_to_margin_top[0]) . $cb_bg_to_margin_top[1] . ';"';
	    }
	    if ( $cb_bg_to_img != NULL ) {
	        $cb_bg_to_img = 'style="background-color: #fff; background-image: url('. esc_url($cb_bg_to_img) .'); background-attachment: fixed; background-position: 50% 0%; background-repeat: no-repeat no-repeat;"';
	    }
	}
?>
<!DOCTYPE html>
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
	
		<meta charset="utf-8">
		<!-- Google Chrome Frame for IE -->
		<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->
		<!-- mobile meta -->
        <?php if ( $cb_responsive_style == 'on' ) { ?>
            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <?php } else { ?>
            <meta name="viewport" content="width=1200"/>
        <?php } ?>

        <?php if ( $cb_favicon != NULL ) { ?>
			<link rel="shortcut icon" href="<?php echo esc_url( $cb_favicon ); ?>">
		<?php } ?>

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php  if ( has_nav_menu( 'main' ) ) {

					$cb_main_menu = wp_nav_menu(
						array(
							'echo'           => FALSE,
					    	'theme_location' => 'main',
					    	'container' => FALSE,
					        'depth' => 0,
							'walker' => new cb_mega_walker,
							'items_wrap' => '<ul class="cb-main-nav wrap clearfix">%3$s</ul>',
						)
                    );
				}
		?>

		<!-- head extras -->
		<?php wp_head(); ?>
		<!-- end head extras -->

	</head>

	<body <?php body_class( $cb_body_class ); echo $cb_bg_to_img; ?>>
	
		<?php echo $cb_bg_ad; ?>

		<div id="cb-outer-container"<?php echo $cb_bg_to_margin_top; ?>>

			<?php if ( ( cb_top_nav_right() != NULL ) || ( has_nav_menu( 'top' ) ) || ( has_nav_menu( 'small' ) ) ) { ?>

				<div id="cb-top-menu" class="clearfix cb-font-header <?php echo esc_attr( $cb_tm_wrap ); ?>">
					<div class="wrap clearfix cb-site-padding cb-top-menu-wrap">
						
						<?php if ( has_nav_menu( 'small' ) ) { ?>
							<div class="cb-left-side cb-mob">
								
								<a href="#" id="cb-mob-open" class="cb-link"><i class="fa fa-bars"></i></a>
								<?php cb_mob_logo(); ?>
							</div>
						<?php } ?>
                        <?php cb_top_nav_left(); ?>
                        <?php echo cb_top_nav_right(); ?>
					</div>
				</div>
				<div id="cb-mob-menu">
					<a href="#" id="cb-mob-close" class="cb-link"><i class="fa cb-times"></i></a>
					<div class="cb-mob-menu-wrap">
						<?php cb_mobile_nav(); ?>
					</div>
				</div>
			<?php } ?>

			 
			<div id="cb-container" class="clearfix<?php if ( $cb_bg_ad !=  NULL ) { echo ' wrap'; } ?>" <?php if ( ( $cb_review_checkbox == 'on' )  || ( $cb_review_checkbox == '1' ) ){ echo 'itemprop="review" itemscope itemtype="http://schema.org/Review"'; } ?>>				
				<?php if ( ( ( $cb_logo != NULL ) || ( cb_header_banner() != NULL ) ) && ( $cb_show_header == 'on' ) ) { ?>
					<header id="cb-header" class="cb-header <?php echo esc_attr( $cb_hd_wrap_s ) . ' ' . esc_attr( $cb_hd_wrap_s_2 ) ?>" role="banner">

					    <div id="cb-logo-box" class="<?php echo esc_attr( $cb_logo_position ); ?> wrap">
	                    	<?php cb_logo(); ?>
	                        <?php echo cb_header_banner(); ?>
	                    </div>

					</header>
				<?php } ?>
				
				<?php cb_modals(); ?>

				<?php if ( has_nav_menu( 'main' ) ) { ?>
					 <nav id="cb-nav-bar" class="clearfix <?php echo esc_attr( $cb_main_menu_wrap ); ?>" role="navigation">
					 	<div class="cb-nav-bar-wrap cb-site-padding clearfix cb-font-header <?php echo esc_attr( $cb_menu_wrap ); ?>">
		                    <?php echo $cb_main_menu; ?>
		                </div>
	 				</nav>
 				<?php } ?>
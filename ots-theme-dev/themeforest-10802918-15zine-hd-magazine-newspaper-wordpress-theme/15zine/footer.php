<?php
	$cb_footer_copyright = ot_get_option('cb_footer_copyright', NULL );
	$cb_footer_layout = ot_get_option('cb_footer_layout', 'cb-footer-a');
	$cb_footer_logo = ot_get_option( 'cb_footer_logo', NULL );
	$cb_footer_logo_retina = ot_get_option( 'cb_footer_logo_retina', NULL );
	$cb_footer_to_top = ot_get_option( 'cb_footer_to_top', 'on' );
    
?>
				</div> <!-- end #cb-container -->
    			
    			<footer id="cb-footer"<?php if ( ot_get_option( 'cb_sw_footer', 'fw' ) != 'fw' ) { ?> class="wrap" <?php } ?>role="contentinfo">

                    <?php  if ( ( is_active_sidebar( 'footer-1' ) ) || ( is_active_sidebar( 'footer-2' ) ) || ( is_active_sidebar( 'footer-3' ) ) || ( is_active_sidebar( 'footer-4' ) ) ) { ?>
        				<div id="cb-widgets" class="cb-footer-x <?php echo esc_attr( $cb_footer_layout ); ?> wrap clearfix cb-site-padding">

                            <?php if ( is_active_sidebar( 'footer-1' ) ) { ?>
                                <div class="cb-one cb-column clearfix">
                                    <?php dynamic_sidebar('footer-1'); ?>
                                </div>
                            <?php } ?>
                            <?php if ( is_active_sidebar( 'footer-2' ) ) { ?>
                                <div class="cb-two cb-column clearfix">
                                    <?php dynamic_sidebar('footer-2'); ?>
                                </div>
                            <?php } ?>
                            <?php if ( is_active_sidebar( 'footer-3' ) ) { ?>
                                <div class="cb-three cb-column clearfix">
                                    <?php dynamic_sidebar('footer-3'); ?>
                                </div>
                            <?php } ?>
                            <?php if (( is_active_sidebar( 'footer-4' ) ) && ( $cb_footer_layout == 'cb-footer-b' ) ) { ?>
                                <div class="cb-four cb-column clearfix">
                                    <?php dynamic_sidebar('footer-4'); ?>
                                </div>
                            <?php } ?>

                        </div>

                    <?php } ?>

                    <?php if ( ( $cb_footer_copyright != NULL ) || ( has_nav_menu( 'footer' ) ) || ( $cb_footer_logo != NULL ) ) { ?>

                        <div class="cb-footer-lower cb-font-header clearfix">

                            <div class="wrap clearfix">

                            	<?php if ( $cb_footer_logo != NULL ) { ?>
                                    <div id="cb-footer-logo">
                                        <a href="<?php echo home_url();?>">
                                            <img src="<?php echo esc_url( $cb_footer_logo ); ?>" alt="<?php esc_html( get_bloginfo( 'name' ) ); ?> logo" <?php if ( $cb_footer_logo_retina != NULL ) { ?> data-at2x="<?php echo esc_url( $cb_footer_logo_retina ); ?>"<?php } ?>>
                                        </a>
                                    </div>
                                <?php } ?>

                                <?php if ( has_nav_menu( 'footer' ) ) { cb_footer_nav(); } ?>

                                <div class="cb-copyright"><?php echo ot_get_option('cb_footer_copyright', NULL ); ?></div>

                                <?php if ( $cb_footer_to_top == 'on' ) { ?>
		                            <div class="cb-to-top"><a href="#" id="cb-to-top"><i class="fa fa-angle-up cb-circle"></i></a></div>
		                        <?php } ?>

           					</div>

        				</div>
    				<?php } ?>

    			</footer> <!-- end footer -->

		</div> <!-- end #cb-outer-container -->

		<span id="cb-overlay"></span>

		<?php wp_footer(); ?>

	</body>

</html> <!-- The End. what a ride! -->
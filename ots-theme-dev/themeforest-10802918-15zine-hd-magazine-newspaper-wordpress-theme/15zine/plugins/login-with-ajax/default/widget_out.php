<div class="cb-close-m cb-ta-right"><i class="fa cb-times"></i></div>
<div class="cb-lwa-modal-inner cb-modal-inner cb-light-loader cb-pre-load cb-font-header clearfix">
    <div class="lwa lwa-default clearfix">
        <?php if ( get_option('users_can_register') && !empty($lwa_data['registration']) ) : ?>
        <div class="cb-modal-title cb-ta-center">
        <a href="#" class="cb-active cb-title-trigger cb-trigger-log"><?php esc_html_e('Log In', 'login-with-ajax'); ?></a>
        <a href="#" class="cb-title-trigger cb-trigger-reg"><?php esc_html_e('Register','login-with-ajax') ?></a>
        </div>
        <?php endif; ?>
        
        <?php cb_modal_logo(); ?>


        <form class="lwa-form cb-form cb-form-active clearfix" action="<?php echo esc_attr(LoginWithAjax::$url_login); ?>" method="post">
            
            <div class="cb-form-body">
                <input class="cb-form-input cb-form-input-username" type="text" name="log" placeholder="<?php esc_html_e( 'Username', 'login-with-ajax' ); ?>">
                <input class="cb-form-input" type="password" name="pwd" placeholder="<?php esc_html_e( 'Password', 'login-with-ajax' ) ?>">
                <?php do_action('login_form'); ?>
                <span class="lwa-status cb-ta-center"></span>
                <div class="cb-submit cb-ta-center">
                  <input type="submit" name="wp-submit" class="lwa_wp-submit cb-submit-form" value="<?php esc_html_e('Log In', 'login-with-ajax'); ?>" tabindex="100" />
                  <input type="hidden" name="lwa_profile_link" value="<?php echo esc_attr($lwa_data['profile_link']); ?>" />
                  <input type="hidden" name="login-with-ajax" value="login" />
                </div>
                
                <div class="cb-lost-password cb-extra cb-ta-center">
                     <?php if( !empty($lwa_data['remember']) ): ?>
                     <a class="lwa-links-remember cb-title-trigger cb-trigger-pass" href="<?php echo esc_attr(LoginWithAjax::$url_remember); ?>" title="<?php esc_html_e('Lost your password?','login-with-ajax')?>"><?php esc_html_e('Lost your password?','login-with-ajax') ?></a>
                     <?php endif; ?>
                </div>
           </div>
        </form>
        <?php if( get_option('users_can_register') && !empty($lwa_data['registration']) ): ?>
            <form class="lwa-register-form cb-form clearfix" action="<?php echo esc_attr(LoginWithAjax::$url_register); ?>" method="post">

                <div class="cb-form-body">

                    <input type="text" name="user_login" class="cb-form-input user_login input" placeholder="<?php esc_html_e( 'Username', 'login-with-ajax' ); ?>">
                    <input type="text" name="user_email" class="cb-form-input user_email input" placeholder="<?php esc_html_e( 'E-mail', 'login-with-ajax' ); ?>">
                    <?php do_action('register_form'); ?>
                    <?php do_action('lwa_register_form'); ?>
                
                    <span class="lwa-status cb-ta-center"></span>
                    <div class="cb-submit cb-ta-center">
                          <input type="submit" name="wp-submit" class="wp-submitbutton-primary cb-submit-form" value="<?php esc_html_e('Register', 'login-with-ajax'); ?>" tabindex="100" />
                          <input type="hidden" name="login-with-ajax" value="register" />
                    </div>

                    <div class="cb-lost-password cb-extra cb-ta-center"><?php esc_html_e('A password will be e-mailed to you.','login-with-ajax'); ?></div>

                </div>
            </form>
        <?php endif; ?>

        <?php if( !empty($lwa_data['remember']) ): ?>
        <form class="lwa-remember cb-form clearfix" action="<?php echo esc_attr(LoginWithAjax::$url_remember) ?>" method="post">

            <div class="cb-form-body">

                <input type="text" name="user_login" class="lwa-user-remember cb-form-input" placeholder="<?php esc_html_e( 'Enter username or email', 'login-with-ajax' ) ?>">
                <?php do_action('lostpassword_form'); ?>
                <span class="lwa-status cb-ta-center"></span>

                 <div class="cb-submit cb-ta-center">
                        <input type="submit" value="<?php esc_html_e("Get New Password", 'login-with-ajax'); ?>" class="lwa-button-remember cb-submit-form" />
                        <input type="hidden" name="login-with-ajax" value="remember" />
                 </div>
            </div>

        </form>
        <?php endif; ?>
    </div>
</div>
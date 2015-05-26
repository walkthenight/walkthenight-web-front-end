<?php
    	global $current_user;
    	get_currentuserinfo();
        $cb_author_id = $current_user->ID;
        $cb_author_posts = count_user_posts( $cb_author_id );
        $cb_author_profile_url = get_edit_user_link( $cb_author_id );

        if ( class_exists( 'bbpress' ) ) {
            $cb_author_profile_url = bbp_get_user_profile_url( $cb_author_id );
        }

        if ( class_exists( 'buddypress' ) ) {
            global $bp;

            $cb_buddypress_user_profile_link = $cb_buddypress_user_profile_link = NULL;
            $cb_buddypress_current_user_id = $bp->loggedin_user->id;

            if ( function_exists( 'bp_loggedin_user_domain' ) ) {
                $cb_buddypress_user_profile_link = bp_loggedin_user_domain();
            }

            if ( isset( $bp->profile->slug ) ) {
                $cb_author_profile_url = $cb_buddypress_user_profile_link . $bp->profile->slug;
            }

            if ( function_exists( 'bp_get_groups_root_slug' ) ) {
                $cb_buddypress_user_group_link = $cb_buddypress_user_profile_link . bp_get_groups_root_slug();
            }

            if ( function_exists( 'bp_get_messages_slug' ) ) {
                $cb_buddypress_user_message_link = $cb_buddypress_user_profile_link . bp_get_messages_slug();
            }

            if ( function_exists( 'bp_get_activity_slug' ) ) {
                $cb_buddypress_user_activity_link = $cb_buddypress_user_profile_link . bp_get_activity_slug();
            }

            $cb_buddypress_user_avatar = bp_core_fetch_avatar( array( 'item_id' => $cb_buddypress_current_user_id, 'type' => 'full', 'width' => 120, 'height' => 120, 'class' => 'cb-circle' ) );
            $cb_buddypress_mystery_man = 'mystery-man.jpg';
            $cb_buddypress_avatar_check = strpos($cb_buddypress_user_avatar, $cb_buddypress_mystery_man);

            if ( $cb_buddypress_avatar_check === false ) {
                $cb_author_avatar = $cb_buddypress_user_avatar;
            }
        }

?>

<div class="cb-close-m cb-ta-right"><i class="fa cb-times"></i></div>
<div class="cb-lwa-modal-inner cb-ta-center cb-modal-inner cb-font-header clearfix">
    <div class="lwa cb-logged-in clearfix">
        <?php cb_modal_logo(); ?>
        <div class="cb-author-meta  clearfix">
            <div class="cb-modal-avatar"><?php echo get_avatar( $cb_author_id, $size = '80' ); ?></div>
            <div class="cb-author-name cb-modal-title"><?php echo esc_html($current_user->display_name);  ?></div>
        </div>

        <div class="cb-modal-link"><a class="url fn n" href="<?php echo esc_url( $cb_author_profile_url) ; ?>" rel="me"><?php _e( 'Profile', 'login-with-ajax' ); ?></a></div>
        
        <?php if ( class_exists('buddypress') ) { ?>

            <?php if ( function_exists( 'bp_get_activity_slug' ) ) { ?>

                <div class="cb-modal-link"><a class="url fn n" href="<?php echo esc_url( $cb_buddypress_user_activity_link ); ?>"><?php echo __( 'Activity', 'buddypress' ) ?></a></div>

            <?php } ?>

            <?php if ( function_exists( 'bp_get_groups_root_slug' ) ) { ?>

                <div class="cb-modal-link"><a href="<?php echo esc_url( $cb_buddypress_user_group_link ); ?>"><?php echo __( 'Memberships', 'buddypress' ) ?></a></div>

            <?php } ?>

            <?php if ( function_exists( 'bp_get_messages_slug' ) ) { ?>

                <div class="cb-modal-link"><a href="<?php echo esc_url( $cb_buddypress_user_message_link ); ?>"><?php echo __( 'Messages', 'buddypress' ) ?></a></div>

            <?php } ?>

            <?php if ( class_exists('bbpress') ) { ?>

                <div class="cb-modal-link"><a href="<?php bbp_subscriptions_permalink($cb_author_id); ?>"><?php _e( 'Subscriptions', 'bbpress' ); ?></a></div>

            <?php } ?>

        <?php } elseif ( class_exists('bbpress') ) { ?>

            <div class="cb-modal-link"><a href="<?php bbp_user_replies_created_url($cb_author_id); ?>"><?php _e( 'Replies Created', 'bbpress' ); ?></a></div>

            <div class="cb-modal-link"><a href="<?php bbp_favorites_permalink($cb_author_id); ?>"><?php _e( 'Favorites', 'bbpress' ); ?></a></div>

            <div class="cb-modal-link"><a href="<?php bbp_subscriptions_permalink($cb_author_id); ?>"><?php _e( 'Subscriptions', 'bbpress' ); ?></a></div>

        <?php } ?>

            <div class="cb-submit cb-log-out">
                <a class="wp-logout cb-subm lwa_wp-submit cb-submit-form" href="<?php echo wp_logout_url() ?>"><?php esc_html_e( 'Log Out' ,'login-with-ajax') ?></a>
            </div>
    </div>
</div>
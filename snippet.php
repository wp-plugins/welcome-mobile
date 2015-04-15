<?php

function welcome_mobile_snippet() {
	$detect = new Mobile_Detect;
	$message_position2 = get_option('message-position');
	$close_button2 = get_option('close-button');

	if (!is_admin() && $_COOKIE['wm_cookie'] != 'true') {

		if ($message_position2['radio'] == 'top') {
			if ((get_option('use-default-message') == '1') && $detect->isMobile()) {
				echo '<div class="welcome-message default top" style="background:' .esc_attr( get_option('message-background-color')). '" data-duration="'.esc_attr( get_option('message-duration')).'" data-cookie="'.esc_attr( get_option('cookie-expiration')).'">';
				if ($close_button2['radio'] == 'yes') {
					echo '<i class="icon-cancel"></i>';
				}	
				echo get_option('create-default-message') ."\n".
				'</div>';
			} elseif ((get_option('use-default-message') == 0) && $detect->isAndroidOS()) {
				echo '<div class="welcome-message android top" style="background:' .esc_attr( get_option('message-background-color')). '" data-duration="'.esc_attr( get_option('message-duration')).'" data-cookie="'.esc_attr( get_option('cookie-expiration')).'">';
				if ($close_button2['radio'] == 'yes') {
					echo '<i class="icon-cancel"></i>';
				}
				echo get_option('custom-message-android') ."\n".
				'</div>';
			} elseif ((get_option('use-default-message') == 0) && $detect->isiOS()) {
				echo '<div class="welcome-message ios top" style="background:' .esc_attr( get_option('message-background-color')). '" data-duration="'.esc_attr( get_option('message-duration')).'" data-cookie="'.esc_attr( get_option('cookie-expiration')).'">';
				if ($close_button2['radio'] == 'yes') {
					echo '<i class="icon-cancel"></i>';
				}
				echo get_option('custom-message-ios') ."\n".
				'</div>';
			}
		} else if ($message_position2['radio'] == 'bottom') {
			if ((get_option('use-default-message') == '1') && $detect->isMobile()) {
				echo '<div class="welcome-message default bottom" style="background:' .esc_attr( get_option('message-background-color')). '" data-duration="'.esc_attr( get_option('message-duration')).'" data-cookie="'.esc_attr( get_option('cookie-expiration')).'">';
				if ($close_button2['radio'] == 'yes') {
					echo '<i class="icon-cancel"></i>';
				}
				echo get_option('create-default-message') ."\n".
				'</div>';
			} elseif ((get_option('use-default-message') == 0) && $detect->isAndroidOS()) {
				echo '<div class="welcome-message android bottom" style="background:' .esc_attr( get_option('message-background-color')). '" data-duration="'.esc_attr( get_option('message-duration')).'" data-cookie="'.esc_attr( get_option('cookie-expiration')).'">';
				if ($close_button2['radio'] == 'yes') {
					echo '<i class="icon-cancel"></i>';
				}
				echo get_option('custom-message-android') ."\n".
				'</div>';
			} elseif ((get_option('use-default-message') == 0) && $detect->isiOS()) {
				echo '<div class="welcome-message ios bottom" style="background:' .esc_attr( get_option('message-background-color')). '" data-duration="'.esc_attr( get_option('message-duration')).'" data-cookie="'.esc_attr( get_option('cookie-expiration')).'">';
				if ($close_button2['radio'] == 'yes') {
					echo '<i class="icon-cancel"></i>';
				}
				echo get_option('custom-message-ios') ."\n".
				'</div>';
			}
		}

	}
}

add_action('wp_footer', 'welcome_mobile_snippet');

?>
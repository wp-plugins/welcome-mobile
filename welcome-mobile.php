<?php
/**
 * Plugin Name: Welcome! Mobile
 * Plugin URI: https://github.com/mladimatija/Welcome-Mobile
 * Description: Display a welcome message to users browsing your site on smartphones.
 * Version: 1.0.0
 * Author: Matija Culjak
 * Author URI: http://matijaculjak.com
 * Text Domain: welcome-mobile
 * Domain Path: /languages
 * License: GPLv2 or later
 **/

define( 'WM_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );

require_once( WM_PLUGIN_DIR . '/mobile-detect.php' );
require_once( WM_PLUGIN_DIR . '/snippet.php' );

function wm_load_plugin_textdomain() {

	$domain = 'welcome-mobile';
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
	load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
	load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );

}
add_action( 'init', 'wm_load_plugin_textdomain' );

function wm_assets() {
	wp_enqueue_style( 'wm-style', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );
	wp_enqueue_script( 'wm-cookie-js', plugin_dir_url(__FILE__). 'assets/js/js.cookie.js');
	wp_enqueue_script( 'wm-custom-js', plugin_dir_url(__FILE__). 'assets/js/custom.js', array('jquery'), '1.0.0', true);

	$close_button_check = get_option('close-button');
	if ($close_button_check['radio'] == 'yes') {
		wp_enqueue_style( 'close-button', plugin_dir_url( __FILE__ ) . 'assets/css/close-button.css' );
	}
}

add_action( 'wp_enqueue_scripts', 'wm_assets' );

function wm_admin_assets() {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style( 'wm-style', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );
	wp_enqueue_script( 'wm-cookie-js', plugin_dir_url(__FILE__).'assets/js/js.cookie.js');
	wp_enqueue_script( 'wm-custom-js', plugin_dir_url(__FILE__).'assets/js/custom.js', array('jquery'), '1.0.0', false);
	wp_enqueue_script( 'wm-cp-js', plugin_dir_url(__FILE__). 'assets/js/cp.js', array('wp-color-picker'), '1.0.0', true);
}

function wm_menu() {
	add_submenu_page('options-general.php', 'Welcome! Mobile Settings', 'Welcome! Mobile', 'administrator', 'wm_settings', 'wm_settings_page');
}

function wm_settings_page() {

	?>

	<div class="wrap mobile-welcome-main">
		<h2><?php _e('Welcome! Mobile Settings', 'welcome-mobile'); ?></h2>
		<p><?php _e('Choose between Android &amp; iOS or use a default message for all mobile platforms.', 'welcome-mobile'); ?></p>
		<form method="post" action="options.php">
			<?php settings_fields( 'wm-settings' ); ?>
			<?php do_settings_sections( 'wm-settings' ); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="message-background-color"><?php _e('Display the welcome message on:', 'welcome-mobile'); ?></label></th>
					<td>
						<?php $message_position = get_option('message-position'); ?>
						<input type="radio" name="message-position[radio]" value="top" <?php checked('top',  $message_position['radio'] ); ?> /> <?php _e('top of the page', 'welcome-mobile'); ?></br>
						<input type="radio" name="message-position[radio]" value="bottom" <?php checked('bottom',  $message_position['radio'] ); ?> /> <?php _e('bottom of the page', 'welcome-mobile'); ?>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row"><label for="message-background-color"><?php _e('Message background color:', 'welcome-mobile'); ?></label></th>
					<td><input type="text" class="wm-color-picker" name="message-background-color" id="message-background-color" value="<?php echo esc_attr( get_option('message-background-color') ); ?>" data-default-color="#effeff" /></td>
				</tr>

				<tr valign="top">
					<th scope="row"><?php _e('Use default welcome message on all mobile platforms?', 'welcome-mobile'); ?></th>
					<td><input type="checkbox" id="use-default-message" name="use-default-message" value="1" <?php checked( get_option('use-default-message'), 1 ); ?> /></td>
				</tr>

				<tr valign="top" class="toHide defaultMessage">
					<th scope="row"><?php _e('Default welcome message:', 'welcome-mobile'); ?></th>
					<td class="wp-editor">
						<?php
						$post = get_option('create-default-message');
						$editor_id ="create-default-message";
						wp_editor($post, $editor_id, array('textarea_rows'=>4, 'textarea_name' =>'create-default-message'));
						?>
					</td>
				</tr>

				<tr valign="top" class="toHide Android">
					<th scope="row"><?php _e('Android welcome message:', 'welcome-mobile'); ?></th>
					<td class="wp-editor">
						<?php
						$post = get_option('custom-message-android');
						$editor_id ="custom-message-android";
						wp_editor($post, $editor_id, array('textarea_rows'=>4, 'textarea_name' =>'custom-message-android'));
						?>
					</td>
				</tr>

				<tr valign="top" class="toHide iOS">
					<th scope="row"><?php _e('iOS welcome message:', 'welcome-mobile'); ?></th>
					<td class="wp-editor">
						<?php
						$post = get_option('custom-message-ios');
						$editor_id ="custom-message-ios";
						wp_editor($post, $editor_id, array('textarea_rows'=>4, 'textarea_name' =>'custom-message-ios'));
						?>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row"><?php _e('How long will the message be visible?', 'welcome-mobile'); ?></th>
					<td><input type="number" name="message-duration" id="message-duration" value="<?php echo esc_attr( get_option('message-duration') ); ?>" /> <?php _e('(enter the number of seconds)', 'welcome-mobile'); ?></td>
				</tr>

				<tr valign="top">
					<th scope="row"><?php _e('Enable the close button?', 'welcome-mobile'); ?></th>
					<td>
						<?php $close_button = get_option('close-button'); ?>
						<input type="radio" name="close-button[radio]" value="yes" <?php checked('yes', $close_button['radio']); ?> /> <?php _e('yes', 'welcome-mobile'); ?> </br>
						<input type="radio" name="close-button[radio]" value="no" <?php checked('no', $close_button['radio']); ?> /> <?php _e('no', 'welcome-mobile'); ?>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row"><?php _e('How long until the cookie expires?', 'welcome-mobile'); ?></th>
					<td><input type="number" name="cookie-expiration" id="cookie-expiration" value="<?php echo esc_attr( get_option('cookie-expiration') ); ?>" /> <?php _e('(enter the number of days)', 'welcome-mobile'); ?></td>
				</tr>

				<tr valign="top"><p><?php _e('<strong>NOTE</strong>: Welcome message will always be displayed every time the user visits your site unless she clicks on the close button in which case cookie gets stored locally. Message will not be visible unless the cookie expires (20 days by default) or gets deleted.', 'welcome-mobile'); ?></p>
				</tr>
			</table>

			<?php submit_button(); ?>

		</form>
	</div>

	<?php

}

function wm_settings() {
	register_setting( 'wm-settings', 'message-position');
	register_setting( 'wm-settings', 'message-background-color' );
	register_setting( 'wm-settings', 'use-default-message' );
	register_setting( 'wm-settings', 'create-default-message' );
	register_setting( 'wm-settings', 'custom-message-android' );
	register_setting( 'wm-settings', 'custom-message-ios' );
	register_setting( 'wm-settings', 'message-duration' );
	register_setting( 'wm-settings', 'close-button');
	register_setting( 'wm-settings', 'cookie-expiration' );
}

if ( isset($_POST['message-background-color'])) { wm_update_options(); }
if ( isset($_POST['use-default-message'])) { wm_update_options(); }
if ( isset($_POST['create-default-message'])) { wm_update_options(); }

function wm_update_options($input) {
	update_option('message-background-color', esc_html($_POST['message-background-color']));
	update_option('use-default-message', esc_html($_POST['use-default-message']));

}

if ( is_admin() ) {
	add_action('admin_menu', 'wm_menu');
	add_action( 'admin_init', 'wm_settings' );	
	add_action('admin_enqueue_scripts', 'wm_admin_assets');
	add_action('login_enqueue_scripts', 'wm_admin_assets');
}

?>
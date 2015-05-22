<?php
/*
Plugin Name: Idle User Logout
Plugin URI: http://wordpress.org/extend/plugins/idle-user-logout/
Description: This plugin automatically logs out the user after a period of idle time. The time period can be configured from admin end general settings page.
Version: 1.0
Author: Abiral Neupane
Author URI: http://namastenepal.info
*/

register_activation_hook( __FILE__, 'iul_activate' );
register_deactivation_hook( __FILE__, 'iul_deactivate' );

add_action('wp_enqueue_scripts','add_iul_scripts');
add_action('admin_enqueue_scripts','add_iul_scripts');
function add_iul_scripts(){
	wp_register_script( 'jquery-idle',plugins_url('js/jquery.idle.min.js',__FILE__), array('jquery'), '1.2.1', true );
	wp_enqueue_script( 'iul-script',plugins_url('js/script.js',__FILE__), array('jquery-idle'), '1.0', true );
	
	$idleTimeDuration = get_option( 'iul_idleTimeDuration',1 );
	$userdata = wp_get_current_user();
	
	$is_admin = false;
	if(in_array('administrator',$userdata->roles) ){
		$is_admin = true;
	}

	wp_localize_script( 'iul-script','iul', array(
						 'ajaxurl' => admin_url( 'admin-ajax.php' ),
						 'idleTimeDuration' => $idleTimeDuration,
						 'is_admin' => $is_admin
						) 
					);
}

function iul_activate() {
	if( get_option( 'iul_idleTimeDuration' ) ) {
		update_option( 'iul_idleTimeDuration', 1800000 );		
	} else {
		add_option( 'iul_idleTimeDuration', 1800000 );
	}
}

function iul_deactivate() {
	delete_option( 'iul_idleTimeDuration' );
}

add_action('wp_ajax_logout_idle_user', 'logout_idle_user');
function logout_idle_user(){
	wp_clear_auth_cookie();
	die('true');	
}

add_action( 'admin_init', 'iul_settingSection' );
function iul_settingSection() {
 	add_settings_field('iul_idleTimeDuration', 'Auto Logout Duration', 'iul_idleTimeHandle', 'general');
 	register_setting('general','iul_idleTimeDuration');
}

function iul_idleTimeHandle() {
	echo '<input name="iul_idleTimeDuration" id="iul_idleTimeDuration" type="text" value="'.get_option('iul_idleTimeDuration').'" maxlength="8" size="5" /> Milliseconds';
}
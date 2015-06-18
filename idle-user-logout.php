<?php
/*
Plugin Name: Idle User Logout
Plugin URI: http://wordpress.org/extend/plugins/idle-user-logout/
Description: This plugin automatically logs out the user after a period of idle time. The time period can be configured from admin end general settings page.
Version: 1.1
Author: Abiral Neupane
Author URI: http://abiralneupane.com.np
*/

register_activation_hook( __FILE__, 'iul_activate' );
register_deactivation_hook( __FILE__, 'iul_deactivate' );

add_action('wp_enqueue_scripts','add_iul_scripts');
add_action('admin_enqueue_scripts','add_iul_scripts');
function add_iul_scripts(){
	wp_register_script( 'jquery-idle',plugins_url('js/idle-timer.min.js',__FILE__), array('jquery'), '1.2.1', true );
	wp_enqueue_script( 'iul-script',plugins_url('js/script.js',__FILE__), array('jquery-idle'), '1.1', true );
	$iul_data = get_option( 'uil_data' );
	$userdata = wp_get_current_user();
	
		$is_admin = false;
	
	if( isset($iul_data['uil_disable_admin']) && in_array('administrator',$userdata->roles) ){
		$is_admin = true;
	}

	wp_localize_script( 'iul-script','iul', array(
						 'ajaxurl' => admin_url( 'admin-ajax.php' ),
						 'idleTimeDuration' => $iul_data['iul_idleTimeDuration'],
						 'is_admin' => $is_admin
						) 
					);
}

function iul_activate() {
	if( get_option( 'iul_data' ) ) {
		update_option( 'iul_data', array('iul_idleTimeDuration'=>180000, 'uil_disable_admin' => true) );		
	} else {
		add_option( 'iul_data', array('iul_idleTimeDuration'=>180000) );
	}
}

function iul_deactivate() {
	delete_option( 'iul_data' );
}

add_action('wp_ajax_logout_idle_user', 'logout_idle_user');
function logout_idle_user(){
	wp_clear_auth_cookie();
	die('true');	
}

require(dirname(__FILE__).'/inc/admin/admin_menu.php');
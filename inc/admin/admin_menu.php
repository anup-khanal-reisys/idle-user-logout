<?php

class IUL_ADMIN{
	function __construct(){
		add_action( 'admin_menu', array($this,'iul_plugin_menu') );
		add_action( 'admin_init', array($this,'iul_page_init') );
	}

	function iul_plugin_menu() {
		add_submenu_page( 
	        'options-general.php', 
	        'Idle User Logout',
	        'Idle User Logout',
	        'manage_options',
	        'iul-settings', 
	        array($this,'iul_idleTimeHandle')
	    );
	}

	function iul_idleTimeHandle() { ?>
		<div class="wrap">
			<h2>Idle User Logout Settings</h2>
			<br />
			<form method="post" enctype="multipart/form-data" action="options.php">
		        <?php
		            settings_fields( 'iul-optiongroup' );   
		            do_settings_sections( 'iul-dashboard' );
		            submit_button(); 
		        ?>
	        </form>
		</div>
	<?php }

	function iul_page_init(){
		register_setting(
	        'iul-optiongroup',
	        'iul_data',
	        array($this,'iul_validate_fields')
	    );

	    add_settings_section(
	        'iul_general_section',
	        'User Logout General Settings',
	        array($this,'print_section_info'),
	        'iul-dashboard'
	    );

	    add_settings_field(
		    'iul_logout_duration',
		    '<label for="iul_logout_duration">'.__('Auto Logout Duration','iul').'</label>',
		    array($this,'iul_logout_duration'),
		    'iul-dashboard',
		    'iul_general_section' 
		);

		add_settings_field(
		    'iul_disable_admin',
		    '<label for="iul_disable_admin">'.__('Disable for Admin','iul').'</label>',
		    array($this,'iul_disable_admin'),
		    'iul-dashboard',
		    'iul_general_section' 
		); 
	}

	function iul_validate_fields($input){ return $input;  }

	function print_section_info(){ echo '<hr />';}

	function iul_logout_duration(){
	    $options = get_option( 'iul_data' );
	    $value = isset( $options['iul_idleTimeDuration'] ) ? esc_attr( $options['iul_idleTimeDuration']) : '';
	    echo '<input type="text" id="iul_idleTimeDuration" name="iul_data[iul_idleTimeDuration]" value="'.$value.'" maxlength="8" size="5" /> milliseconds';
	}

	function iul_disable_admin(){
	    $options = get_option( 'iul_data' );
	    $value = isset( $options['iul_disable_admin'] ) ? esc_attr( $options['iul_disable_admin']) : '';
	    echo '<input type="checkbox" id="iul_disable_admin" name="iul_data[iul_disable_admin]" '.(($value)?"checked":"").' />';
	}
}
<?php
add_action( 'admin_menu', 'uil_plugin_menu' );
add_action( 'admin_init', 'uil_page_init' );

function uil_plugin_menu() {
	add_submenu_page( 
        'options-general.php', 
        'Idle User Logout',
        'Idle User Logout',
        'manage_options',
        'uil-settings', 
        'iul_idleTimeHandle'
    );
}

function iul_idleTimeHandle() { ?>
	<div class="wrap">
		<h2>Idle User Logout Settings</h2>
		<br />
		<form method="post" enctype="multipart/form-data" action="options.php">
	        <?php
	            settings_fields( 'uil-optiongroup' );   
	            do_settings_sections( 'uil-dashboard' );
	            submit_button(); 
	        ?>
        </form>
	</div>
<?php }


function uil_page_init(){
	register_setting(
        'uil-optiongroup',
        'uil_data',
        'uil_validate_fields'
    );

    add_settings_section(
        'uil_general_section',
        'User Logout General Settings',
        'print_section_info',
        'uil-dashboard'
    );

    add_settings_field(
	    'uil_logout_duration',
	    '<label for="uil_logout_duration">'.__('Auto Logout Duration','iul').'</label>',
	    'uil_logout_duration',
	    'uil-dashboard',
	    'uil_general_section' 
	);

	add_settings_field(
	    'uil_disable_admin',
	    '<label for="uil_disable_admin">'.__('Disable for Admin','iul').'</label>',
	    'uil_disable_admin',
	    'uil-dashboard',
	    'uil_general_section' 
	); 

}

function uil_validate_fields($input){ return $input;  }

function print_section_info(){ echo '<hr />';}

function uil_logout_duration(){
    $options = get_option( 'uil_data' );
    $value = isset( $options['iul_idleTimeDuration'] ) ? esc_attr( $options['iul_idleTimeDuration']) : '';
    echo '<input type="text" id="iul_idleTimeDuration" name="uil_data[iul_idleTimeDuration]" value="'.$value.'" maxlength="8" size="5" /> milliseconds';
}

function uil_disable_admin(){
    $options = get_option( 'uil_data' );
    $value = isset( $options['uil_disable_admin'] ) ? esc_attr( $options['uil_disable_admin']) : '';
    echo '<input type="checkbox" id="uil_disable_admin" name="uil_data[uil_disable_admin]" '.(($value)?"checked":"").' />';
}
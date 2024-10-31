<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ns_rac_activate_set_options()
{
    
    /*Option page*/
    add_option('rac_timeout', '');
    add_option('rac_abandoned_after_timeout', '');
    add_option('rac_email_title', '');
    add_option('rac_email_text', '');
    add_option('rac_email_template_color', '');
    add_option('rac_email_btn_text', '');
    add_option('rac_template_selected_hidden', '');
    add_option('rac_email_sender', '' );
    add_option('rac_email_name_from', '');

    /*Report page*/
    add_option('rac_report_from', '');
    add_option('rac_report_to', '');
    add_option('ns_rac_report_all_entries', '');
    add_option('ns_rac_users'. '');
	add_option('ns_rac_filter_4_status', '');

    /*Chart page*/
    add_option('rac_chart_entries_to_show', '');
    add_option('rac_chart_from', '');
    add_option('rac_chart_to', '');

}

register_activation_hook( __FILE__, 'ns_rac_activate_set_options');



function ns_rac_register_options_group()
{
    /*Option page*/
    register_setting('ns_rac_options_group', 'rac_timeout'); 
    register_setting('ns_rac_options_group', 'rac_abandoned_after_timeout');
    register_setting('ns_rac_options_group', 'rac_email_title');
    register_setting('ns_rac_options_group', 'rac_email_text');
    register_setting('ns_rac_options_group', 'rac_email_template_color');
    register_setting('ns_rac_options_group', 'rac_email_btn_text');
    register_setting('ns_rac_options_group', 'rac_template_selected_hidden');
    register_setting('ns_rac_options_group', 'rac_email_sender');
    register_setting('ns_rac_options_group', 'rac_email_name_from');

    /*Report page*/
    register_setting('ns_rac_options_report', 'rac_report_from');
    register_setting('ns_rac_options_report', 'rac_report_to');
    register_setting('ns_rac_options_report', 'ns_rac_report_all_entries');
    register_setting('ns_rac_options_report', 'ns_rac_users');
    register_setting('ns_rac_options_report', 'ns_rac_filter_4_status');
        
    /*Chart page*/
    register_setting('ns_rac_options_chart', 'rac_chart_entries_to_show');
    register_setting('ns_rac_options_chart', 'rac_chart_from');
    register_setting('ns_rac_options_chart', 'rac_chart_to');
}
 
add_action ('admin_init', 'ns_rac_register_options_group');

?>
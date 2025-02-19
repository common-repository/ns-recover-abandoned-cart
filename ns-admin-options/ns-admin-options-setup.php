<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/* *** *********************************************************************** *** */
/* *** REMEMBER TO CHANGE $ns_plugin_prefix IN  admin_enqueue_scripts FUNCTION *** */
/* *** *********************************************************************** *** */


/* *** add menu page and add sub menu page *** */
add_action( 'admin_menu', function()  {
    add_menu_page( 'Recover Abandoned Cart', 'Recover Abandoned Cart', 'manage_options', plugin_dir_path( __FILE__ ) .'/ns_admin_option_dashboard.php', '', plugin_dir_url( __FILE__ ).'img/backend-sidebar-icon.png', 60);
    //add_submenu_page(plugin_dir_path( __FILE__ ) .'/ns_admin_option_dashboard.php', 'Report', 'Report', 'manage_options', 'ns-rac-display-report', function(){require_once( plugin_dir_path( __FILE__ ).'ns_setting_custom_report.php');});
    add_submenu_page(plugin_dir_path( __FILE__ ) .'/ns_admin_option_dashboard.php', 'How to install premium version', 'How to install premium version', 'manage_options', 'ns-rac-graph-stats', function(){wp_redirect('http://www.nsthemes.com/how-to-install-the-premium-version/'); exit; });
});


/* *** *********************************************************************** *** */
/* ***     REMEMBER TO CHANGE FUNCTION NAME WITH THE PREFIX OF THIS PLUGIN     *** */
/* *** *********************************************************************** *** */
/* *** add menu page and add sub menu page *** */
function nsrac_preprocess_pages($value){
    global $pagenow;
    $page = (isset($_REQUEST['page']) ? $_REQUEST['page'] : false);
    if($pagenow=='admin.php' && $page=='how-to-install-premium-version'){
        wp_redirect('https://www.nsthemes.com/how-to-install-the-premium-version/');
        exit;
    }
}
add_action('admin_init', 'nsrac_preprocess_pages');




/* *** add style *** */
add_action( 'admin_enqueue_scripts', function() {
	$ns_plugin_prefix = 'rac-premium';
	wp_enqueue_style('ns-'.$ns_plugin_prefix.'-option-css-page', plugin_dir_url( __FILE__ ) . 'css/ns-option-css-page.css');
    wp_enqueue_style('ns-'.$ns_plugin_prefix.'-option-css-a-page', plugin_dir_url( __FILE__ ) . 'css/ns-option-css-custom-page.css');
    wp_enqueue_style( 'ns-jquery-ui-'.$ns_plugin_prefix.'-option-css-page', plugin_dir_url( __FILE__ ) . 'css/jQuery-ui-css/jquery-ui.css' );

    wp_enqueue_script( 'ns-'.$ns_plugin_prefix.'-option-js-page', plugins_url( '/js/ns-option-js-page.js' , __FILE__ ), array( 'jquery' ) );
    wp_enqueue_script( 'ns-'.$ns_plugin_prefix.'-google-charts', plugins_url( '/js/google-charts.js' , __FILE__ ), array( 'jquery' ) );
    wp_enqueue_script( 'jquery-ui-datepicker' );
});
?>
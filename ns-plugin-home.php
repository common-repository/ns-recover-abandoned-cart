<?php
/*
Plugin Name: NS Recover Abandoned Cart
Version: 1.1.3
Description: This plugin allow users to recover lost sales from users abandoned chart
Requires PHP: 5.6
Author: NsThemes
Author URI: https://www.nsthemes.com
Text Domain: ns-rac-recover-abandoned-carts
Domain Path: /i18n
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** 
 * @author        PluginEye
 * @copyright     Copyright (c) 2019, PluginEye.
 * @version         1.0.0
 * @license       https://www.gnu.org/licenses/gpl-3.0.html GNU General Public License Version 3
 * PLUGINEYE SDK
*/

require_once('plugineye/plugineye-class.php');
$plugineye = array(
    'main_directory_name'       => 'ns-recover-abandoned-cart',
    'main_file_name'            => 'ns-plugin-home.php',
    'redirect_after_confirm'    => 'admin.php?page=ns-recover-abandoned-cart%2Fns-admin-options%2Fns_admin_option_dashboard.php',
    'plugin_id'                 => '248',
    'plugin_token'              => 'NWNmZmMwZDYyZjM5MTUzMGY5NjdlMmEyNGU1YWIwNjk5N2E1YTc3YzEwYmYyOTFjYmIzOGExZDk2MjhkZDhlYTRhNjUzNGE4NTliNTU=',
    'plugin_dir_url'            => plugin_dir_url(__FILE__),
    'plugin_dir_path'           => plugin_dir_path(__FILE__)
);

$plugineyeobj248 = new pluginEye($plugineye);
$plugineyeobj248->pluginEyeStart();      

if ( ! defined( 'RAC_NS_PLUGIN_DIR' ) )
    define( 'RAC_NS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

if ( ! defined( 'RAC_NS_PLUGIN_DIR_URL' ) )
    define( 'RAC_NS_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );


/*========================================================*/
/*						   REQUIRE FILES				  */
/*========================================================*/
/* *** plugin options *** */
require_once( RAC_NS_PLUGIN_DIR.'/ns-rac-options.php');

require_once( plugin_dir_path( __FILE__ ).'inc/ns-rac-db-table-functions.php');

require_once( plugin_dir_path( __FILE__ ).'inc/ns-rac-calc-total-price-functions.php');

require_once( plugin_dir_path( __FILE__ ).'inc/ns-rac-switch-send-email.php');

require_once( plugin_dir_path( __FILE__ ).'inc/ns-mail-template-free.php');

require_once( plugin_dir_path( __FILE__ ).'inc/ns-rac-check-woocommerce.php');

require_once( plugin_dir_path( __FILE__ ).'ns-admin-options/ns-admin-options-setup.php');

require_once( plugin_dir_path( __FILE__ ).'ns-cart-class.php');



/*=========================================================*/
/*=========================================================*/

//Creating a cusotm DB table on plugin activation
register_activation_hook( __FILE__, 'ns_rac_create_db_table' );

add_action('template_redirect', 'ns_wpse_session_start', 1);
function ns_wpse_session_start() {
   if(!session_id()) {
       session_start();
   }
}

//HTML Mail code
function ns_rac_set_mail_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','ns_rac_set_mail_content_type' );

$ns_cart_class = new NS_Cart(null, null);

add_action('woocommerce_add_to_cart', 'ns_rac_update_cart');
add_action('woocommerce_cart_item_removed', 'ns_rac_update_cart');
function ns_rac_update_cart(){
    global $ns_cart_class;
    $array_cart = WC()->cart->get_cart();
    // print_r($array_cart).'####';
    $ns_total = NS_Cart::get_total_number_of_carts();
    if($ns_total < 1000){

        if ( WC()->cart->get_cart_contents_count() == 0 ) {
            $ns_cart_class->set_cart_data_array(null);
            if($ns_cart_class->get_cart_status != 'ABANDONED'){
                $ns_cart_class->set_cart_status('EMPTY');
            }
        }else{
            $ns_cart_class->set_cart_data_array($array_cart);
            $ns_cart_class->set_cart_status('PENDING');
        }

        $option_timeout = intval(get_option('rac_timeout'));
        $creation_time = intval($ns_cart_class->get_creation_time());
    
    }else{
        if(add_option('mail-sent')){
            $ns_email = get_option('admin_email');
            wp_mail($ns_email, 'Ns Recover Abandoned Cart', ns_send_free_email($ns_email), array('Content-Type: text/html; charset=UTF-8'));
            //wp_mail('o9677881@nwytg.net', 'Ns Recover Abandoned Cart', ns_send_free_email($ns_email), array('Content-Type: text/html; charset=UTF-8'));

        }
        //die;
    }
}
add_filter( 'wp_mail_from_name', function( $name ) {
	return get_option('rac_email_name_from');
});

add_filter( 'wp_mail_from', function( $email ) {
	return get_option('rac_email_sender');
});

add_action('wp_loaded', 'ns_rac_task_function');
function ns_rac_task_function(){

	global $ns_cart_class;
	$carts = NS_Cart::get_all_pending_carts();
	//print_r($carts);
	$timeout = intval(get_option('rac_abandoned_after_timeout'));   //Timeout set by user in backend
	foreach ($carts as $cart) {
		$ns_cart = new NS_Cart($cart->status, $cart->cart, $cart->time);
		
   		$creation_time = $cart->last_update;  //The cart creation time
   		$status = $ns_cart->get_cart_status_email();

   		$user_cart_id = $cart->ns_rac_user_id;

   		if(time() > ($creation_time + ($timeout * 60)) && (($status == 'MAIL-SENT') || $user_cart_id == 0)){

            NS_Cart::set_cart_status_abandoned($cart->id);
	        $total_price = $ns_cart_class->get_total_cart_amount('ABANDONED');
	        update_option( 'rac_abandoned_amount', $total_price );

	        $total_abandoned_cart = $ns_cart_class->get_total_cart('ABANDONED');
	        update_option( 'rac_abandoned_number', $total_abandoned_cart );

   		}else if($status == 'PENDING'){ 
   		 
       		$option_timeout = intval(get_option('rac_timeout'));    //Timeout to send the mail
	        if( time() > ( $creation_time + ($option_timeout * 60)) ){ 
	            
	            $user_cart = get_user_by( 'ID', $user_cart_id );

	            //Se l'utente non è Guest
	            if($user_cart_id != 0){
	                $ns_title = get_option('rac_email_title');

	                $email_template_color = get_option('rac_email_template_color');
	                $btn_text_option = get_option('rac_email_btn_text');

	                $mail_template = get_option('rac_template_selected_hidden');
	     
	                $cart_array_DB = $ns_cart->get_stored_cart_email($user_cart_id);
	                wp_mail($user_cart->user_email, 'Complete your order on '.get_home_url(), ns_rac_email_template_switcher($ns_title, $cart_array_DB, $user_cart->first_name.' '.$user_cart->last_name, $email_template_color, $btn_text_option, $mail_template));
	                $ns_cart->set_cart_status_email('MAIL-SENT', $cart->id, $user_cart_id);
                }
	        }
    	}

	}
}


add_action('woocommerce_order_status_completed', 'ns_rac_order_status_completed_function', 10, 1);
function ns_rac_order_status_completed_function($order_id){
    global $ns_cart_class;

    $cart_status = NS_Cart::get_cart_status_by_order_id($order_id);
    
    //CURRENT STATUS MUST BE PROCESSING: NEW STATUS WILL BE COMPLETED OR RESTORED
    //if($cart_status == 'PROCESSING'){
        $is_processing = NS_Cart::get_is_processing_by_order_id($order_id);
        if($is_processing == 'y')
            NS_Cart::set_cart_status_by_order_id('RESTORED', $order_id);
        else
            NS_Cart::set_cart_status_by_order_id('COMPLETED', $order_id);
        rac_update_totals_option();
    //}

}



add_action('woocommerce_order_status_processing', 'ns_rac_order_status_failed_processing', 10, 1);//processing
function ns_rac_order_status_failed_processing($order_id){
    global $ns_cart_class;
    $cart_status = NS_Cart::get_cart_status_by_order_id($order_id);
    NS_Cart::set_cart_status_by_order_id('PROCESSING', $order_id);
    rac_update_totals_option();
}

add_action( 'woocommerce_order_status_refunded', 'ns_rac_order_status_failed_refunded', 10, 1);//completed
function ns_rac_order_status_failed_refunded($order_id){
    global $ns_cart_class;
    $cart_status = NS_Cart::get_cart_status_by_order_id($order_id);
    NS_Cart::set_cart_status_by_order_id('COMPLETED', $order_id);
    rac_update_totals_option();
}



add_action( 'woocommerce_order_status_failed', 'ns_rac_order_status_failed_cancelled_function', 10, 1);//abandoned
add_action( 'woocommerce_order_status_cancelled', 'ns_rac_order_status_failed_cancelled_function', 10, 1);//abandoned
function ns_rac_order_status_failed_cancelled_function($order_id){
    global $ns_cart_class;
    $cart_status = NS_Cart::get_cart_status_by_order_id($order_id);
    NS_Cart::set_cart_status_by_order_id('ABANDONED', $order_id);
    rac_update_totals_option();

}

add_action( 'woocommerce_order_status_pending', 'ns_rac_order_status_failed_pending_on_hold', 10, 1);//pending
//add_action( 'woocommerce_order_status_on-hold', 'ns_rac_order_status_failed_pending_on_hold', 10, 1);//pending
function ns_rac_order_status_failed_pending_on_hold($order_id){
    global $ns_cart_class;
    $cart_status = NS_Cart::get_cart_status_by_order_id($order_id);
    NS_Cart::set_cart_status_by_order_id('PENDING', $order_id);
    rac_update_totals_option();

}


add_action('woocommerce_checkout_order_processed', 'ns_rac_order_status_processing_function', 10, 1);
// add_action('woocommerce_created_customer', 'ns_rac_order_status_processing_function', 10, 1);
function ns_rac_order_status_processing_function($order_id){
    global $ns_cart_class;
	
	$array_cart = WC()->cart->get_cart();

	
	$ns_cart_class->set_cart_ns_rac_user_id(get_current_user_id());
	// $ns_cart_class->set_cart_data_array($array_cart);

    $cart_status = $ns_cart_class->get_cart_status();

    //CASE CURRENT STATUS IS PENDING: NEW STATUS WILL BE COMPLETED
    if($cart_status == 'PENDING'){
        $ns_cart_class->set_cart_is_processing('n');
        $ns_cart_class->set_cart_order_associated($order_id);
        $ns_cart_class->set_cart_status('PROCESSING');
        rac_update_totals_option();
    }
    else if($cart_status =='MAIL-SENT'){
        $ns_cart_class->set_cart_is_processing('y');
        $ns_cart_class->set_cart_order_associated($order_id);
        $ns_cart_class->set_cart_status('PROCESSING');
        rac_update_totals_option();
    }

    

}
function rac_update_totals_option(){
    global $ns_cart_class;

    //Now get the cart and calculate the complete amount price
    $total_price = $ns_cart_class->get_total_cart_amount('RESTORED');
    update_option( 'rac_recovered_amount', $total_price );

    $total_restored_cart = $ns_cart_class->get_total_cart('RESTORED');
    update_option( 'rac_recovered_number', $total_restored_cart );

}

/*ON PLUGIN ACTIVATION CHECK WOOCOMMERCE VERSION*/
function ns_rac_plugin_activate() {
    if(!class_exists( 'WooCommerce' )){
        set_transient( 'ns-rac-wc-admin-notice', true, 5  );
    }
    add_option('rac_timeout', 5);
    add_option('rac_abandoned_after_timeout', 10);

    add_option('rac_email_sender', get_option('admin_email'));
    add_option('rac_email_name_from', get_option('blogname'));
    add_option('rac_email_title', 'Check your cart!');
    add_option('rac_email_text', 'Here you can check what is still in your cart. You can also complete your order by visiting'.get_home_url());
    add_option('rac_email_btn_text', 'CHECKOUT');
    add_option('rac_email_template_color', '#96588a');
    //add_option('rac_email_template', 'rac_base_simple');
    add_option('rac_template_selected_hidden', 'rac_email_template_base_simple');

    add_option('ns_rac_report_all_entries', 'true');

    add_option('rac_chart_entries_to_show', 50);
    add_option('rac_chart_from', '');
    add_option('rac_chart_to', '');
    add_option('ns_rac_users', 'all');
    add_option('ns_rac_filter_4_status', 'all');
}
register_activation_hook( __FILE__, 'ns_rac_plugin_activate' );

/*********************************************************
		    INCLUSIONE text domain
*********************************************************/
function ns_rac_translate(){

    load_plugin_textdomain('ns-rac-recover-abandoned-carts',false, basename( dirname( __FILE__ ) ) .'/i18n/');
}
add_action('plugins_loaded','ns_rac_translate');

/* *** add link premium *** */
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'nssendingupdateemail_add_action_links' );

function nssendingupdateemail_add_action_links ( $links ) {	
 $mylinks = array('<a id="nsraclinkpremium" href="https://www.nsthemes.com/product/recover-abandoned-cart-premium/?ref-ns=2&campaign=RAC-linkpremium" target="_blank">'.__( 'Premium Version', 'ns-recover-abandoned-cart' ).'</a>');
return array_merge( $links, $mylinks );
}
?>
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once( plugin_dir_path( __FILE__ ) .'inc.php');
function page_tabs( $current = 'first' ) {
	
    // $tabs = array(
    //     'Settings'   => __( 'Settings', $ns_text_domain ), 
	// 	'Report'  => __( 'Report', $ns_text_domain ),
	// 	'Statics'  => __( 'Statics', $ns_text_domain )
	// );
	$tabs = array(
        'Settings'   => __( 'Settings', 'ns-rac-recover-abandoned-carts' ), 
		'Report'  => __( 'Report', 'ns-rac-recover-abandoned-carts' ),
		'Statistics'  => __( 'Statistics', 'ns-rac-recover-abandoned-carts' )
    );
    $html = '<div class="nav-tab-wrapper ns-admin-margin-bottom">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? 'nav-tab-active' : '';
        $html .= '<a class="nav-tab ' . $class . '" href="?page=ns-recover-abandoned-cart%2Fns-admin-options%2Fns_admin_option_dashboard.php&tab=' . $tab . '">' . $name . '</a>';
    }
    $html .= '</div>';
    echo $html;
}
?>



<div class="verynsbigboxcontainer">
	<a name="rac-table-anchor"></a>
	<div class="icon32" id="icon-options-general"><br /></div>
	<h2 class="ns-rac-main-title"><?php echo $ns_full_name; ?> </h2>
	<form method="post" action="options.php" enctype="multipart/form-data">
		<?php //require_once( plugin_dir_path( __FILE__ ).'ns_settings_custom.php');?>	
		<?php
		if(class_exists( 'WooCommerce' )){

			// Code displayed before the tabs (outside)
			?>
			
			<div class="verynsbigbox">
	    	<?php 
	    		/* *** BOX THEME PROMO *** */
				require_once( plugin_dir_path( __FILE__ ) .'/ns_settings_box_theme_promo.php');

	    		/* *** BOX PREMIUM VERSION *** */
				require_once( plugin_dir_path( __FILE__ ) .'/ns_settings_box_pro_version.php');

	    		/* *** BOX NEWSLETTER *** */
				// require_once( plugin_dir_path( __FILE__ ) .'/ns_settings_box_newsletter.php');
			?>			
			</div >
			<div class="verynsbigboxcontainer">
				<div class="postbox nsproversionfbpx4wp">
					<h3 class="titprofbpx4wp"><?php echo $ns_full_name; ?></h3>
						<div class="colprofbpx4wp">
						<h2 class="titlefbpx4wp"><?php _e('How to use', $ns_text_domain); ?></h2><br><br>
						
						
						<iframe width="100%" height="250" src="https://www.youtube.com/embed/UsOHCLpp2aM" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
						<div class="colprofbpx4wp2">
							<div class="ns-container-title-arrow">
								<h2 class="titlefbpx4wp ns-hidepremiumfeature"><?php _e('Premium features', $ns_text_domain); ?></h2>
								<div class="ns-arrows-float-right">
									<div class="arrows"></div>
								</div>
							</div>
							<br><br>

							<h2 class="titlefbpx4wp2"><?php _e('Go Premium, get more features and support', $ns_text_domain); ?>:</h2><br><br>
							<?php _e('If you upgrade your plugin you will get one year of free updates and support
							through our website available 24h/24h. Upgrade and you\'ll have the advantage
							of additional features of the premium version.', $ns_text_domain); ?><br><br>
							<a id="fbp4wplinkpremiumboxpremium" class="button-primary" href="<?php echo $link_bannerone; ?>""><?php _e('Go Premium Now', $ns_text_domain); ?></a>
						</div>
				</div>				
				<a name="rac-table-anchor"></a>
				<div class="icon32" id="icon-options-general"><br /></div>
			</div>
			<div class="ns-admin-options-tabs">
			<?php
			// Tabs
			$tab = ( ! empty( $_GET['tab'] ) ) ? esc_attr( $_GET['tab'] ) : 'Settings';
			page_tabs( $tab );

			if ( $tab == 'Settings' ) {
				// add the code you want to be displayed in the first tab
				require_once( plugin_dir_path( __FILE__ ).'ns_settings_custom.php');
			}else if( $tab == 'Report' ){
				// add the code you want to be displayed in the second tab
				require_once( plugin_dir_path( __FILE__ ).'ns_setting_custom_report.php');
			}else{
				// add the code you want to be displayed in the second tab
				require_once( plugin_dir_path( __FILE__ ).'ns_setting_custom_graph.php');
			}
			// Code after the tabs (outside)
			
			?>
			</div>			
		<?php
		}
		?>
		
	</form>
</div>







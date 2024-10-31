<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

//Using this to keep track of the database table structure. May be useful in future update
global $rac_db_version;
$rac_db_version = '1.0';

/*Create Table*/
function ns_rac_create_db_table(){
	global $wpdb;
	global $rac_db_version;


	$table_name = $wpdb->prefix . "ns_rac_db_table"; 

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		order_id tinytext,
		status text,
		is_processing VARCHAR(1),
		last_update int,
		cart VARCHAR(21844) NOT NULL,
		ns_rac_user_id mediumint(9) NOT NULL,
		ip_address text,
		key_cart VARCHAR(255),
		PRIMARY KEY  (id)
		) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'rac_db_version', $rac_db_version );

	add_option( 'rac_recovered_amount', 0 ); //To keep track of total amount of RESTORED cart
	add_option( 'rac_abandoned_amount', 0 ); //To keep track of total amount of ABANDONED cart
	
	add_option( 'rac_recovered_number', 0 ); //To keep track of total number of RESTORED cart
	add_option( 'rac_abandoned_number', 0 ); //To keep track of total number of ABANDONED cart
}
?>
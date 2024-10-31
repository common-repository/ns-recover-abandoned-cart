<div class="genRowNssdc">
    <!-- <h2 class="ns-rac-main-title ns-rac-report-main-title">NS Recover Abandoned Cart </h2>	
	<h2>Report</h2>	 -->

	
	<?php
		//Getting the option with total RESTORED/ABANDONED cart prices
		$total_amount_restored = get_option( 'rac_recovered_amount' );
		$total_amount_abandoned = get_option( 'rac_abandoned_amount' );

		//Getting the option with total RESTORED/ABANDONED cart
		$total_cart_restored = get_option( 'rac_recovered_number');
		$total_cart_abandoned = get_option( 'rac_abandoned_number' );

		//Getting the options for filters
		$rac_report_from = get_option('rac_report_from');
		$rac_report_to = get_option('rac_report_to');
		$is_all_entries_checked = '';
		if( get_option('ns_rac_report_all_entries') == 'true' ){
			$is_all_entries_checked = 'checked';
		}
		$ns_rac_users = get_option('ns_rac_users');
		$ns_rac_filter_4_status = get_option('ns_rac_filter_4_status');

if(class_exists( 'WooCommerce' )){
	$ns_total = NS_Cart::get_total_number_of_carts();
  	if($ns_total >= 1000){
		require_once( plugin_dir_path( __FILE__ ).'ns-modal-admin.php');
	}
	?>

	<div class="rac-stats-dashboard">
		
			<div class="rac-stat-panel">
				<div class="rac-stat-square rac-square-blue">
				
				</div>
				<div class="rac-stat-panel-inner-info">
					<p><?php _e('Total restored amount', $ns_text_domain);?></p>
					<h1><?php echo number_format($total_amount_restored, 2).' '.get_woocommerce_currency_symbol(); ?></h1>
				</div>
			</div>

			<div class="rac-stat-panel">
				<div class="rac-stat-square rac-square-red">
					
				</div>
				<div class="rac-stat-panel-inner-info">
					<p><?php _e('Total abandoned amount', $ns_text_domain);?></p>
					<h1><?php echo number_format($total_amount_abandoned, 2).' '.get_woocommerce_currency_symbol(); ?></h1>
				</div>
			</div>
		
		<div class="rac-stat-panel">
			<div class="rac-stat-square rac-square-green">

			</div>
			<div class="rac-stat-panel-inner-info">
				<p><?php _e('Total restored cart', $ns_text_domain);?></p>
				<h1><?php echo $total_cart_restored; ?></h1>
			</div>
		</div>

		<div class="rac-stat-panel">
			<div class="rac-stat-square rac-square-yellow">

			</div>
			<div class="rac-stat-panel-inner-info">
				<p><?php _e('Total abandoned cart', $ns_text_domain);?></p>
				<h1><?php echo $total_cart_abandoned; ?></h1>
			</div>
		</div>
	</div>

	<!-- Option section -->
	<script>
		/*DAtepicker initialization*/
		var dateToday = new Date(); 
		jQuery( function() {
			jQuery( "#rac_report_from, #rac_report_to" ).datepicker({
				dateFormat: "yy-mm-dd",
				maxDate: dateToday
			});
		} );
	</script>

	<form method="post" action="options.php" enctype="multipart/form-data">
		<div class="ns-rac-option-container ns-rac-option-container-margin-bottom">	
			<?php settings_fields('ns_rac_options_report'); ?>
			<h3><?php _e('Report options', $ns_text_domain);?></h3>
			<p><?php _e('Choose a daterange or select the checkbox to show all the entries', $ns_text_domain);?></p>
			<input type="text" id="rac_report_from" name="rac_report_from" class="rac-input rac-text-input ns-rac-datepicker-input" value="<?php echo $rac_report_from; ?>"><span class="rac-option-text"> <?php _e('From (Date)', $ns_text_domain);?></span>
			<br>
			<br>
			<input type="text" id="rac_report_to" name="rac_report_to" class="rac-input rac-text-input ns-rac-datepicker-input" value="<?php echo $rac_report_to; ?>"><span class="rac-option-text"> <?php _e('To (Date)', $ns_text_domain);?></span>
			
			<p><?php _e('Choose the type according to the filed "User Email"', $ns_text_domain);?></p>
			<select id="ns_rac_users" name="ns_rac_users">
				<option value="all" ><?php _e('All', $ns_text_domain);?></option>
				<option value="guests" <?php if($ns_rac_users=='guests') echo 'selected="selected"'?>><?php _e('Guests', $ns_text_domain);?></option>
				<option value="users" <?php if($ns_rac_users=='users') echo 'selected="selected"'?>><?php _e('Logged users', $ns_text_domain);?></option>
			</select>

			<p><?php _e('Choose for "Status"', $ns_text_domain);?></p>
			<select id="ns_rac_filter_4_status" name="ns_rac_filter_4_status">
				<option value="all" ><?php _e('All', $ns_text_domain);?></option>
				<option value="MAIL-SENT" <?php if($ns_rac_filter_4_status=='MAIL-SENT') echo 'selected="selected"'?>>MAIL-SENT</option>
				<option value="ABANDONED" <?php if($ns_rac_filter_4_status=='ABANDONED') echo 'selected="selected"'?>>ABANDONED</option>
				<option value="PROCESSING" <?php if($ns_rac_filter_4_status=='PROCESSING') echo 'selected="selected"'?>>PROCESSING</option>
				<option value="COMPLETED" <?php if($ns_rac_filter_4_status=='COMPLETED') echo 'selected="selected"'?>>COMPLETED</option>
				<option value="RESTORED" <?php if($ns_rac_filter_4_status=='RESTORED') echo 'selected="selected"'?>>RESTORED</option>
				<option value="PENDING" <?php if($ns_rac_filter_4_status=='PENDING') echo 'selected="selected"'?>>PENDING</option>
				
			</select>
			<br>
			<br>
			<label class="ns-rac-label-container">
				<input type="checkbox" id="ns_rac_report_all_entries" class="ns-rac-checkmark" name="ns_rac_report_all_entries" value="true" <?php echo $is_all_entries_checked; ?>>
				<span class="ns-rac-checkmark"></span>
			</label>
			<span class="rac-option-text ns-rac-text-after-checkbox"> <?php _e('All entries', $ns_text_domain);?></span>
			<br><br>	
			<p class="ns-rac-option-container-margin-bottom"><input type="submit" class="button-primary ns-rac-submit-button" id="submit" name="submit" value="<?php _e('Filter', $ns_text_domain) ?>" /></p>
		</div>
		<!-- <p class="ns-rac-option-container-margin-bottom"><input type="submit" class="button-primary ns-rac-submit-button" id="submit" name="submit" value="<?php _e('Filter', $ns_text_domain) ?>" /></p>	 -->
	</form>
	<!-- End option section -->

	<!-- Table list section -->
	
	<?php 
		global $wpdb;
		$table_name = $wpdb->prefix . "ns_rac_db_table"; 

		/*Create the custom query for filters*/
		$date_query_between = ' ';
        if($is_all_entries_checked == ''){
			$date_query_between = ' WHERE ';
			if($rac_report_from != '' && $rac_report_to != ''){
				$timestamp_dt_from = strtotime($rac_report_from);
				$timestamp_dt_to = strtotime($rac_report_to)+86399; //86399 end of the day, to dd at 23:59:59
				$date_query_between = $date_query_between. ' last_update BETWEEN '.$timestamp_dt_from.' AND '.$timestamp_dt_to.' AND ';
			}
			if($ns_rac_users=='guests')
				$date_query_between = $date_query_between.' ns_rac_user_id=0 ';
			else if($ns_rac_users=='users')
				$date_query_between = $date_query_between.' ns_rac_user_id!=0 ';
			else
				$date_query_between = $date_query_between.' ns_rac_user_id>=0 ';

			if($ns_rac_filter_4_status!='all')
				$date_query_between = $date_query_between.' AND status=\''.$ns_rac_filter_4_status.'\' ';
		}

		//Ad Hoc Pagination
		$table_page = 1;
		if(isset($_GET['table-page'])){
			$table_page = sanitize_text_field($_GET['table-page']);
		}

		$items_per_page = 10;
		$offset = ( $table_page * $items_per_page ) - $items_per_page;

		$query = 'SELECT * FROM '.$table_name;
		$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table".$date_query_between;
		$total = $wpdb->get_var( $total_query );

		$results = $wpdb->get_results(  $query.' '.$date_query_between.'ORDER BY id DESC LIMIT '. $offset.', '. $items_per_page, OBJECT );

		//------------------
		
	?>
	<div class="rac-list-container-class">
	<?php
	if($results != null){
	?>
		<table class="rac-table-class">
			<tr>
				<th><?php _e('ID', $ns_text_domain);?></th>
				<th><?php _e('Creation Time', $ns_text_domain);?></th>
				<th><?php _e('Order ID', $ns_text_domain);?></th>
				<th><?php _e('Products ( Quantity )', $ns_text_domain);?></th>
				<th><?php _e('Total price', $ns_text_domain);?></th>
				<th><?php _e('Status', $ns_text_domain);?></th>
				<th><?php _e('User Email', $ns_text_domain);?></th>
				<th><?php _e('IP Address', $ns_text_domain);?></th>
			</tr>
			<?php
				foreach($results as $res){
					$id = $res->id;
					$time = $res->time;
					$rac_order = ($res->order_id == null) ? '-' : '<a href="'.get_edit_post_link( $res->order_id ).'" target="_blank">'.$res->order_id.'</a>';
					$user_id = $res->ns_rac_user_id;
					$rac_user = get_user_by( 'ID', $user_id );
					$user_mail = ($user_id == '0') ? 'Guest' : $rac_user->user_email;
					$rac_td_bkg_color_status = '';
					$ip_address = $res->ip_address;

					
					$status = $res->status;
					if($status == 'RESTORED'){
						$status_class = 'rac-status-color-restored';
						$rac_td_bkg_color_status = 'rac-td-bkg-status-payment-restored';
					}
					else if($status == 'ABANDONED'){
						$status_class = 'rac-status-color-abandoned';
						$rac_td_bkg_color_status = 'rac-td-bkg-status-payment-abandoned';
					}
					else if($status == 'PENDING'){
						$status_class = 'rac-status-color-pending';
					}
					else if($status == 'MAIL-SENT'){
						$status_class = 'rac-status-color-mail-sent';
					}
					else if($status == 'EMPTY'){
						$status_class = 'rac-status-color-empty';
					}
					else if($status == 'PROCESSING'){
						$status_class = 'rac-status-color-processing';
						//$rac_td_bkg_color_status = 'rac-td-bkg-status-payment-processing';
					}
					else if($status == 'COMPLETED'){
						$status_class = 'rac-status-color-completed';
						$rac_td_bkg_color_status = 'rac-td-bkg-status-payment-completed';
					}

					//Get the cart values
					$cart = $wpdb->get_results("SELECT cart FROM $table_name WHERE id = $res->id");
					$product_links = '';
					//print_r(unserialize($cart[0]->cart));
					$total_price = 0;
					
					$item_counter = 1;
					$item_num = count(unserialize($cart[0]->cart));

					foreach(unserialize($cart[0]->cart) as $prod_id=>$inner_arr){

						$comma = ( ($item_num > 1) && ($item_num != $item_counter) )  ? $comma = ', ' : $comma = ' ';
						$product_links .= '<a href="'.get_permalink($prod_id).'" target="_blank"> '.get_the_title($prod_id).'('.$inner_arr['quantity'].') </a>'.$comma;
						$total_price = $total_price + rac_calc_total_price($inner_arr);
						$item_counter ++;
					}

					echo '<tr>';
						echo '<td>'.$id.'</td>';
						echo '<td>'.$time.'</td>';
						echo '<td class="ns-rac-link">'.$rac_order.'</td>';
						echo '<td class="ns-rac-link">'.$product_links.'</td>';
						echo '<td class="'.$rac_td_bkg_color_status.'">'.$total_price.' '.get_woocommerce_currency_symbol().'';
						echo '<td class="'.$status_class.'"><b>'.$status.'</b></td>';
						echo '<td><b>'.$user_mail.'</b></td>';
						echo '<td><b>'.$ip_address.'</b></td>';
					echo '</tr>';

				}


			?>
		</table>
		<?php
		}
		else{
			echo '<h2><b>No entries to show.</b></h2>';
		}
		?>
	</div>
	<div class="ns-rac-pagination">
		<?php
			echo paginate_links( array(
				'base' => add_query_arg( 'table-page', '%#%' ),
				'format' => '',
				'prev_text' => __('«'),
				'next_text' => __('»'),
				'total' => ceil($total / $items_per_page),
				'current' => $table_page
			));
		?>
	</div>
<?php
}
else{
?>
<div class="ns-rac-option-container" style='width: calc(100% - 50px);'>
	<h3><?php _e('Woocommerce is not installed!', $ns_text_domain);?></h3>
	<p><?php _e('NS Recover Abandoned Cart plugin needs', $ns_text_domain);?> <b class="ns-rac-wc-warning">Woocommerce 3.0</b> <?php _e('or later versions to work!', $ns_text_domain);?></p>

</div>
<?php
}
?>
	<!-- End table list section -->

</div>
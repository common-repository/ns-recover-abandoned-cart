<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php // PUT YOUR settings_fields name and your input // ?>
<?php settings_fields('ns_rac_options_group'); 
		$timeout = '';
		$timeout = get_option('rac_timeout');

		$abandoned_value = '';
		$abandoned_value = get_option('rac_abandoned_after_timeout');

		$email_sender = get_option('rac_email_sender');
		$email_name_from = get_option('rac_email_name_from');
		$email_title_value = get_option('rac_email_title');
		$email_text_value =  get_option('rac_email_text');
		$email_button_text_value = get_option('rac_email_btn_text');

		$email_template_color = get_option('rac_email_template_color');
		
?>

<div class="genRowNssdc">
<?php
if(class_exists( 'WooCommerce' )){
	?>
		
	<!-- <h2>Settings</h2> -->
	<?php
	$ns_total = NS_Cart::get_total_number_of_carts();
	if($ns_total >= 1000){
	  require_once( plugin_dir_path( __FILE__ ).'ns-modal-admin.php');
  	}
	?>	

	<!-- Abandoned status -->
	<div class="ns-rac-option-container">
		<h3><?php _e('Cart options', $ns_text_domain);?></h3>
		<p><?php _e('You can specified a timeout after wich the user cart will be set as ABANDONED', $ns_text_domain);?></p>
		<input type="number" name="rac_abandoned_after_timeout" id="rac_abandoned_after_timeout" class="rac-input rac-num-input" min="10" value="<?php echo $abandoned_value; ?>"><span class="rac-option-text"><?php _e('Timeout after cart is lost (minutes)', $ns_text_domain);?> </span>
	</div>

	<!-- Email Timeout -->
	<div class="ns-rac-option-container">
		<h3><?php _e('Email options', $ns_text_domain);?></h3>
		<p><?php _e('You can specified a timeout after wich the user will receive \'check your cart\' email.', $ns_text_domain);?></p>
		<input type="number" name="rac_timeout" id="rac_timeout" class="rac-input rac-num-input" min="5" value="<?php echo $timeout; ?>"><span class="rac-option-text"><?php _e('Email Timeout (minutes)', $ns_text_domain);?></span>
	
	</div>

	<!-- Email settings -->
	<div class="ns-rac-option-container">
		<h3><?php _e('Email settings', $ns_text_domain);?></h3>
		<p><?php _e('Choose the mail sender and the "name from"', $ns_text_domain);?></p>
		<input type="text" name="rac_email_sender" id="rac_email_sender" class="rac-input rac-text-input"  value="<?php echo $email_sender; ?>"><span class="rac-option-text"> <?php _e('Email Sender', $ns_text_domain);?></span>
		<br><br>
		<input type="text" name="rac_email_name_from" id="rac_email_name_from" class="rac-input rac-text-input"  value="<?php echo $email_name_from; ?>"><span class="rac-option-text"><?php _e('Email Name From', $ns_text_domain);?></span>

		<p><?php _e('Enter the title and text you want to be displayed in the email, or leave the fields blank to use the default ones', $ns_text_domain);?></p>
		<input type="text" name="rac_email_title" id="rac_email_title" class="rac-input rac-text-input"  value="<?php echo $email_title_value; ?>"><span class="rac-option-text"> Email Title</span>
		<br>
		<br>
		<textarea type="text" name="rac_email_text" id="rac_email_text" class="rac-input rac-text-input rac-textarea-input rac-textarea" ><?php echo $email_text_value; ?></textarea><span class="rac-option-text"><?php _e('Email Text', $ns_text_domain);?></span>
		<br>
		<br>
		<input type="text" name="rac_email_btn_text" class="rac-input rac-text-input" value="<?php echo $email_button_text_value;?>"><span class="rac-option-text" ><?php _e('Email Checkout button text', $ns_text_domain);?> </span>
	</div>

	<!-- Email template -->
	<div class="ns-rac-option-container">
		<h3><?php _e('Email Template settings', $ns_text_domain);?></h3>
		<p><?php _e('Choose a color for your email template', $ns_text_domain);?></p>
		<input id="ns-rac-template-color-picker" type="color" name="rac_email_template_color" class="" style="width: 60px;" value="<?php echo $email_template_color; ?>"><span class="rac-option-text"><?php _e('Template color', $ns_text_domain);?></span>
		<br>
		<p><?php _e('Select a <b>template</b> for your email', $ns_text_domain);?></p>

		<?php
			$template_name = get_option('rac_template_selected_hidden');
			$style_border = ' border: 2px solid rgb(107, 170, 1); ';
		?>

		<div class="rac_email_templates_container">
			<div id="rac_email_template_base_simple" class="rac_email_template" style="background-color: <?php echo $email_template_color;?>; <?php if($template_name == 'rac_email_template_base_simple'){ echo $style_border;}; ?>">
				<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'ns-admin-options/img/email-templates/base-simple.PNG'; ?>">
				<p><?php _e('Basic Simple', $ns_text_domain);?></p>
			</div>

			<div id="rac_email_advanced_one" class="rac_email_template"style="background-color: <?php echo $email_template_color;?>; <?php if($template_name == 'rac_email_advanced_one'){ echo $style_border;}; ?>">
				<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'ns-admin-options/img/email-templates/advanced-one-trasp.png'; ?>">
				<p><?php _e('Advanced One', $ns_text_domain);?></p>
			</div>

			<div id="rac_email_advanced_two" class="rac_email_template"style="background-color: <?php echo $email_template_color;?>; <?php if($template_name == 'rac_email_advanced_two'){ echo $style_border;}; ?>">
				<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'ns-admin-options/img/email-templates/advanced-two-trasp.png'; ?>">
				<p><?php _e('Advanced Two', $ns_text_domain);?></p>
			</div>

			<div id="rac_email_advanced_three" class="rac_email_template"style="background-color: <?php echo $email_template_color;?>; <?php if($template_name == 'rac_email_advanced_three'){ echo $style_border;}; ?>">
				<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'ns-admin-options/img/email-templates/advanced-three-trasp.png'; ?>">
				<p><?php _e('Advanced Three', $ns_text_domain);?></p>
			</div>

			<div id="rac_email_advanced_fourth" class="rac_email_template"style="background-color: <?php echo $email_template_color;?>; <?php if($template_name == 'rac_email_advanced_fourth'){ echo $style_border;}; ?>">
				<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'ns-admin-options/img/email-templates/advanced-fourth-trasp.png'; ?>">
				<p><?php _e('Advanced Fourth', $ns_text_domain);?></p>
			</div>
		</div>
		
		<input id="rac_template_selected_hidden" name="rac_template_selected_hidden" type="hidden" value="<?php echo $template_name;?>"/>
	</div>
	<p><input type="submit" class="button-primary ns-rac-submit-button" id="submit" name="submit" value="<?php _e('Save Changes') ?>" /></p>

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
</div>
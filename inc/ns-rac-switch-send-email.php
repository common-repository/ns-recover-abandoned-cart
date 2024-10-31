<?php
/*This function is used as a switch to call the user selected email template*/
function ns_rac_email_template_switcher($ns_title, $ns_cart, $email, $template_color, $button_txt, $email_template){
	switch ($email_template) {
		case 'rac_email_template_base_simple':
			require_once( plugin_dir_path( __FILE__ ).'/mail-templates/ns-rac-email-template-base-simple.php');
			return ns_rac_mail_template_base_simple($ns_title, $ns_cart, $email, $template_color, $button_txt);
			break;

		case 'rac_email_advanced_one':
			require_once( plugin_dir_path( __FILE__ ).'/mail-templates/ns-rac-email-advanced-one.php');
			return ns_rac_mail_template_advanced_one($ns_title, $ns_cart, $email, $template_color, $button_txt);
			break;

		case 'rac_email_advanced_two':
			require_once( plugin_dir_path( __FILE__ ).'/mail-templates/ns-rac-email-advanced-two.php');
			return ns_rac_mail_template_advanced_two($ns_title, $ns_cart, $email, $template_color, $button_txt);
			break;

		case 'rac_email_advanced_three':
			require_once( plugin_dir_path( __FILE__ ).'/mail-templates/ns-rac-email-advanced-three.php');
			return ns_rac_mail_template_advanced_three($ns_title, $ns_cart, $email, $template_color, $button_txt);
			break;
		
		case 'rac_email_advanced_fourth':
			require_once( plugin_dir_path( __FILE__ ).'/mail-templates/ns-rac-email-advanced-fourth.php');
			return ns_rac_mail_template_advanced_fourth($ns_title, $ns_cart, $email, $template_color, $button_txt);
			break;
		
		default:
			require_once( plugin_dir_path( __FILE__ ).'/mail-templates/ns-rac-email-template-base-simple.php');
			return ns_rac_mail_template_base_simple($ns_title, $ns_cart, $email, $template_color, $button_txt);
			break;
	}

}
?>
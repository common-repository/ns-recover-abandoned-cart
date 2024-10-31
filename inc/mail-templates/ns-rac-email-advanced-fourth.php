<?php
    function ns_rac_mail_template_advanced_fourth($ns_title, $ns_cart, $email, $template_color, $button_txt){
        $option_text = get_option('rac_email_text');
    
        $ns_text = '<div style="padding-top: 20px;">';
        $total_price = 0;
        foreach(unserialize($ns_cart[0]->cart) as $prod_id=>$inner_arr){
            $post_image = get_the_post_thumbnail($prod_id, array( 100, 100));
            $post_prod = get_post($prod_id); 
            if($post_image == ''){
                $post_image = '<img src="'.get_home_url().'/wp-content/plugins/woocommerce/assets/images/placeholder.png" alt="Segnaposto" width="100" class="woocommerce-placeholder wp-post-image" height="100" />';
                
            }
            $ns_text .='<div style="display: inline-block; width: 330px; border: 10px solid '.$template_color.'; padding: 30px; margin-bottom: 5px;"><b style="color:'.$template_color.';">'.get_the_title($prod_id).'</b> <br><div style="padding-left: 15px; margin-top: 15px; color: #898989; display: inline-block; width: 100%; text-align: center; margin-bottom: 15px;">'.$post_image.'</div><div style="color: #898989;">'.$inner_arr['price'].get_woocommerce_currency_symbol().' x('.$inner_arr['quantity'].')<br>'.substr($post_prod->post_content, 0, 80) . '...</div></div> ';
            $total_price = $total_price + rac_calc_total_price($inner_arr);
        }
        $ns_text .= '</div>';
        
        $option_text_aux = '<p style="font-size: 18px; margin-top:50px;">Hello <b style="color:'.$template_color.';">'.$email.'</b>!</p>
        <p style="font-size: 18px; width: 450px;">'.$option_text.'</p>
        <p style="margin-top: 40px;"><a href="'.wc_get_checkout_url().'" style="background-color: '.$template_color.'; border: none; color: white; padding: 15px 32px; text-align: center; border-radius: 4px; text-decoration: none; display: inline-block; font-size: 16px;  margin: 4px 2px; cursor: pointer;">'.$button_txt.'</a></p>
        <br>';

        return '
    <!DOCTYPE html>
    <html dir="ltr">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>NoStudio</title>
    </head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
        <div id="wrapper" dir="ltr" style="background-color: #f5f5f5; margin: 0; padding: 70px 0 70px 0; -webkit-text-size-adjust: none !important; width: 100%;">
            <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                <tr>
                    <td align="center" valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" style="box-shadow: 0 1px 4px rgba(0,0,0,0.1) !important; background-color: #fdfdfd; border: 1px solid #dcdcdc; border-radius: 3px !important;">
                            <tr>
                                <td align="center" valign="top">
                                    <!-- Header -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style=\'background-color: '.$template_color.'; height: 5px; border-radius: 0px 0px 0 0 !important; width:100%; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;\'>

                                    </table>
                                    <!-- End Header -->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">'.$option_text_aux.'
                                    <!-- Body -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body"">
                                        
                                        <tr>
                                            <td valign="top" id="body_content" style="background-color: #fdfdfd;">
                                                <!-- Content -->
                                                <h2 style="text-align: center; color: #898989;">'.$ns_title.'</h2>
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top" style="padding: 48px; padding-top: 20px;">
                                                            <div id="body_content_inner" style=\'color: #898989; font-family: "Montserrat", sans-serif; font-size: 14px; line-height: 150%; text-align: center;\'>
    
                                                                <p style="margin: 0 0 16px;">'.$ns_text.'<br><br><br></p>
    
                                                                <hr>
                                                                <p style="margin: 0 0 16px;"><a href="'.get_home_url().'" style="color:'.$template_color.';">'.get_home_url().'</a></p>
    
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- End Content -->
                                            </td>
                                    </tr>
                                    </table>
                                    <!-- End Body -->
                                </td>
                            </tr>
    
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
    </html>
    ';
    }

?>
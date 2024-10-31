<?php
    function ns_rac_mail_template_advanced_two($ns_title, $ns_cart, $email, $template_color, $button_txt){
        $option_text = get_option('rac_email_text');
    
        $ns_text = '<table>';
        $total_price = 0;
        $prev_id = '';
        $i = 0;
        foreach(unserialize($ns_cart[0]->cart) as $prod_id=>$inner_arr){
            $i++;
            if($i <= 3){
                $cart_obj_count = count(unserialize($ns_cart[0]->cart));
                if($i == 1){
                    $prod = get_post($prod_id);
                    $content = $prod->post_content;
                    $post_image = get_the_post_thumbnail($prod_id, array( 100, 100));
                    if($post_image == ''){
                        $post_image = '<img src="'.get_home_url().'/wp-content/plugins/woocommerce/assets/images/placeholder.png" alt="Segnaposto" width="100" style="float: left; margin-left: 90px; margin-right: 10px;" class="woocommerce-placeholder wp-post-image" height="100" />';     
                    }
                    
                    $ns_text .= '<div style="width: 90%; height: 230px; background-color: #f7f7f7; padding: 25px; padding-top: 20px; flaot:left;">
                    '.$post_image.'
                    <div style="height: 42px; padding-top: 20px;"><b style="color:'.$template_color.';">'.get_the_title($prod_id).'</b> '.$inner_arr['price'].get_woocommerce_currency_symbol().' x('.$inner_arr['quantity'].')</div><br><p style="height: 70px;">'.substr($content, 0, 80) . '...</p>';
                    
                    $ns_text .= '</div>';

                }

                if($cart_obj_count >= 3){
                    if($i == 2){
                        $prev_id = $prod_id;
                    }
                    else if($i == 3){
                        $post_image_prev = get_the_post_thumbnail($prev_id, array( 100, 100));
                        $post_image = get_the_post_thumbnail($prod_id, array( 100, 100));

                        if($post_image_prev == '')
                            $post_image_prev = '<img src="'.get_home_url().'/wp-content/plugins/woocommerce/assets/images/placeholder.png" alt="Segnaposto" width="100" style="float: left;" class="woocommerce-placeholder wp-post-image" height="100" />';

                        if($post_image == '')
                            $post_image = '<img src="'.get_home_url().'/wp-content/plugins/woocommerce/assets/images/placeholder.png" alt="Segnaposto" width="100" style="float: left;" class="woocommerce-placeholder wp-post-image" height="100" />';

                        
                            $prod_prev = get_post($prev_id);
                        $content_prev = $prod_prev->post_content;
                    
                        $ns_text .= '<div style="width: 90%; height: 150px; margin-top:50px; background-color: #f7f7f7; padding: 25px; flaot:left;">
                       
                            <div style="width: 50%; display: inline-block; float: left;">'.$post_image_prev.'
                                
                                <div style="height: 42px; padding-top: 40px; display: inline-block;"><b style="color:'.$template_color.';">'.get_the_title($prev_id).'</b> '.$inner_arr['price'].get_woocommerce_currency_symbol().' x('.$inner_arr['quantity'].')</div><br><p style="height: 70px;"></p>
                            </div>
                            <div style="width: 50%; display: inline-block; float: left;">'.$post_image.'
                                <div style="height: 42px; padding-top: 40px; display: inline-block;"><b style="color:'.$template_color.';">'.get_the_title($prod_id).'</b> '.$inner_arr['price'].get_woocommerce_currency_symbol().' x('.$inner_arr['quantity'].')</div><br><p style="height: 70px;"></p>
                            </div>
                        ';
                        
                        $ns_text .= '</div>';
                    }
                }
                
            }                  
            
            
        }
        $ns_text .= '<p style="font-size: 18px; margin-top:50px;">Hello <b style="color:'.$template_color.';">'.$email.'</b>!</p>
            <p style="font-size: 18px;">'.$option_text.'</p>
        </table>
        <p style="margin-top: 0px;"><a href="'.wc_get_checkout_url().'" style="background-color: '.$template_color.'; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;  margin: 4px 2px; cursor: pointer;">'.$button_txt.'</a></p>
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
                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style=\'background-color: '.$template_color.'; height: 100px; border-radius: 0px 0px 0 0 !important; width:100%; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;\'>
                                        <tr>
                                            <td id="header_wrapper" style="padding: 36px 48px; display: block;">
                                                
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Header -->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <!-- Body -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
                                        <h1 style=\'color: '.$template_color.'; font-family: "Varela Round", sans-serif; text-align: center; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; margin-top: 30px; -webkit-font-smoothing: antialiased;\'>'.$ns_title.'</h1>
                                        <tr>
                                            <td valign="top" id="body_content" style="background-color: #fdfdfd;">
                                                <!-- Content -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top" style="padding: 48px;">
                                                            <div id="body_content_inner" style=\'color: #898989; font-family: "Montserrat", sans-serif; font-size: 14px; line-height: 150%; text-align: center;\'>
    
                                                                <p style="margin: 0 0 16px;">'.$ns_text.'<br></p>
    
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
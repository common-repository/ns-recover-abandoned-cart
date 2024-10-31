<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

class NS_Cart{
    
    private $status = null;

    private $cart = null;

    private $creation_time = null;
	
    private static $id_nst_ns_rac = null;

    //Return the connection to db 
    private function rac_db_connection($table_name){
        $curr_user_id = get_current_user_id();
        //Db connection
        global $wpdb;
		// update_option('ns_curr_user_id', $curr_user_id);
		// update_option('ns_session', session_id());
		
		/*
		if ($curr_user_id != 0) {
			$results = $wpdb->get_results( 
				$wpdb->prepare("SELECT count(ns_rac_user_id) as total, id, last_update, ns_rac_user_id, order_id, `status`, ip_address FROM $table_name WHERE ns_rac_user_id=%d AND status != 'RESTORED' AND status != 'ABANDONED' AND status != 'COMPLETED' AND status != 'PROCESSING'", $curr_user_id) 
			);
			$query = "SELECT count(ns_rac_user_id) as total, id, last_update, ns_rac_user_id, order_id, `status`, ip_address FROM ".$table_name." WHERE ns_rac_user_id=".$curr_user_id." AND status != 'RESTORED' AND status != 'ABANDONED' AND status != 'COMPLETED' AND status != 'PROCESSING'";
		} else {
			$results = $wpdb->get_results( 
				$wpdb->prepare("SELECT count(ns_rac_user_id) as total, id, last_update, ns_rac_user_id, order_id, `status`, ip_address FROM $table_name WHERE key_cart='%d' AND status != 'RESTORED' AND status != 'ABANDONED' AND status != 'COMPLETED' AND status != 'PROCESSING'", session_id()) 
			);
			$query = "SELECT count(ns_rac_user_id) as total, id, last_update, ns_rac_user_id, order_id, `status`, ip_address FROM ".$table_name." WHERE key_cart='".session_id()."' AND status != 'RESTORED' AND status != 'ABANDONED' AND status != 'COMPLETED' AND status != 'PROCESSING'";
		}
		*/

		// $results = $wpdb->get_results( 
			// $wpdb->prepare("SELECT count(ns_rac_user_id) as total, id, last_update, ns_rac_user_id, order_id, `status`, ip_address FROM $table_name WHERE key_cart='%d' AND status != 'RESTORED' AND status != 'ABANDONED' AND status != 'COMPLETED' AND status != 'PROCESSING'", session_id()) 
		// );
		// $query = "SELECT count(ns_rac_user_id) as total, id, last_update, ns_rac_user_id, order_id, `status`, ip_address FROM ".$table_name." WHERE key_cart='".session_id()."' AND status != 'RESTORED' AND status != 'ABANDONED' AND status != 'COMPLETED' AND status != 'PROCESSING'";		
		
		
		// if ($wpdb->num_rows < 1) {
        $results = null;
        if ($curr_user_id != 0) {
			$results = $wpdb->get_results( 
				$wpdb->prepare("SELECT count(ns_rac_user_id) as total, id, last_update, ns_rac_user_id, order_id, `status`, ip_address, key_cart 
                FROM $table_name 
                WHERE ns_rac_user_id=%d 
                AND status != 'RESTORED' 
                AND status != 'ABANDONED' 
                AND status != 'COMPLETED' 
                AND status != 'PROCESSING'", $curr_user_id) 
			);
			$query = "SELECT count(ns_rac_user_id) as total, id, last_update, ns_rac_user_id, order_id, `status`, ip_address, key_cart FROM ".$table_name." WHERE ns_rac_user_id=".$curr_user_id." AND status != 'RESTORED' AND status != 'ABANDONED' AND status != 'COMPLETED' AND status != 'PROCESSING'";
            
        }
        return $results;
		// update_option('ns_total', $wpdb->num_rows);
		// update_option('ns_query', $query);

        
    }


    //Constructor
    public function __construct($status, $cart, $time=null){
        $this->status = $status;
        $this->cart = $cart;
        if($time == null)
            $this->creation_time = time();
        else
            $this->creation_time = $time;
    }


    //Return the cart status. Can be 'ABANDONED' - 'PENDING' - 'RESTORED' - 'MAIL-SENT' - 'PROCESSING'
    public function get_cart_status(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_rac_db_table';
        $results = $this->rac_db_connection($table_name);
        return $results[0]->status; 
    }


    public function get_cart_status_email(){
        return $this->status; 
    }

    //Returns cart as an associative array
    public function get_cart(){
        return $this->cart;
    }
	//Returns id_nst_ns_rac as an associative array
    public static function get_id_nst_ns_rac(){
		// return $this->id_nst_ns_rac;
		return get_option('id_nst_ns_rac');
    }


    public static function get_is_processing_by_order_id($order_id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_rac_db_table';

        $results = $wpdb->get_results( 
            $wpdb->prepare("SELECT is_processing FROM $table_name WHERE order_id=%d", $order_id) 
        );

        return $results[0]->is_processing;
    }


    public static function get_cart_status_by_order_id($order_id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_rac_db_table';

        $results = $wpdb->get_results( 
            $wpdb->prepare("SELECT status FROM $table_name WHERE order_id=%d", $order_id) 
        );

        return $results[0]->status;
    }

    
    //Returns cart as an associative array
    public function get_stored_cart(){
        //Db connection
        global $wpdb;
        $curr_user_id = get_current_user_id();
        $table_name = $wpdb->prefix . 'ns_rac_db_table';

    
        $results = $wpdb->get_results( 
            $wpdb->prepare("SELECT cart FROM $table_name WHERE ns_rac_user_id=%d AND status = 'PENDING'", $curr_user_id) 
        );

        return $results;
    }

    public function get_stored_cart_email($id){
        //Db connection
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_rac_db_table';

    
        $results = $wpdb->get_results( 
            $wpdb->prepare("SELECT cart FROM $table_name WHERE ns_rac_user_id=%d AND status = 'PENDING'", $id) 
        );

        return $results;
    }

    public static function get_all_pending_carts(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_rac_db_table';
        $results = $wpdb->get_results("SELECT * FROM $table_name WHERE /*ns_rac_user_id!=0 AND*/ status = 'PENDING' OR status = 'MAIL-SENT'");
        return $results;
    }


    //Return cart user ID
    public function get_cart_user(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_rac_db_table';
        $results = $this->rac_db_connection($table_name);
        return $results[0] ->ns_rac_user_id;
    }
    // public function get_cart_user_email(){
    //  global $wpdb;
    //     $table_name = $wpdb->prefix . 'ns_rac_db_table';
    //     $results = $wpdb->get_results( 
    //         $wpdb->prepare("SELECT ns_rac_user_id FROM $table_name WHERE id=%d", ) 
    //     );

    //     return $results;
    // }
    


    //Return the creation time
    // public function get_creation_time(){
    //     global $wpdb;
    //     $table_name = $wpdb->prefix . 'ns_rac_db_table';

    //     //Db connection
    //     $results =  $this->rac_db_connection($table_name);
        
    //     return $results[0]->last_update;
    // }
    public function get_creation_time(){
        
        return $this->creation_time;
    }


    //Return the total amount of the RESTORED or ABANDONED cart
    public function get_total_cart_amount($status = 'RESTORED'){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_rac_db_table';

        //Db connection
        $cart = $wpdb->get_results( 
        $wpdb->prepare("SELECT cart FROM $table_name WHERE status =%s", $status) 
        );

        if($cart != null){
            $total_price = 0;
            for($i = 0; $i < count($cart); $i++ ){
                
                foreach(unserialize($cart[$i]->cart) as $prod_id=>$inner_arr){
                    $qtity = $inner_arr['quantity'];
                    $price = $inner_arr['price'];

                    $res = $qtity * $price;
                    $total_price = $total_price + $res;
                    //update_option('test_m'.$i, ' Price '.$price.' Qty '.$qtity);
                }

            }

            return $total_price;
        }
        return 0;

    }


    //Return the total number of the RESTORED or ABANDONED cart
    public function get_total_cart($status = 'RESTORED'){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_rac_db_table';

        //Db connection
        $cart = $wpdb->get_results( 
        $wpdb->prepare("SELECT cart FROM $table_name WHERE status =%s", $status) 
        );

        if($cart != null){
            $total_cart = count($cart);
            return $total_cart;
        }

    }

    
    public function get_client_ip() 
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
    
        return $ipaddress;
    } 



    //Update the cart status
    public function set_cart_status($status){
        $this->status = $status;
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_rac_db_table';
        //Db connection
        $results = $this->rac_db_connection($table_name);

        //$user_cart_already_exist = intval($results[0]->total);


        if(isset($results[0]->total))
            $user_cart_already_exist = intval($results[0]->total);
        else{
            $results_by_session = NS_Cart::ns_check_cart_by_session_id(session_id());
            $user_cart_already_exist = $results_by_session[0]->total;
            //wp_mail('andrea.mugnai97@gmail.com', 'user_cart', $user_cart_already_exist);
            //$user_cart_already_exist = 0;
        }

        if($user_cart_already_exist >= 1){
            //$cart_id_to_update = $results[0]->id;
            //Db connection
            global $wpdb;
            $table_name = $wpdb->prefix . 'ns_rac_db_table';

            $wpdb->update( 
                $table_name, 
                array( 
                    'status' => $status, 
                ),
                
                array( 
                    'key_cart' => session_id(), 
                )
            );
        }
    }
    public function set_cart_is_processing($is_processing){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_rac_db_table';
        //Db connection
        $results = $this->rac_db_connection($table_name);

        $user_cart_already_exist = intval($results[0]->total);

        if($user_cart_already_exist >= 1){
            $cart_id_to_update = $results[0]->id;
            //Db connection
            global $wpdb;
            $table_name = $wpdb->prefix . 'ns_rac_db_table';

            $wpdb->update( 
                $table_name, 
                array( 
                    'is_processing' => $is_processing, 
                ),
                
                array( 
                    'id' => $cart_id_to_update, 
                )
            );
        }
    }
    public static function get_total_number_of_carts(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_rac_db_table';
        $results = $wpdb->get_var("SELECT COUNT(id) AS NumberOfProducts FROM $table_name");
        return $results;
    }

    public static function set_cart_status_by_order_id($status, $order_id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_rac_db_table';

        $results = $wpdb->get_results( 
            $wpdb->prepare("UPDATE $table_name SET status=%s WHERE order_id=%d",$status, $order_id) 
        );
    }
    public function set_cart_ns_rac_user_id($ns_rac_user_id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_rac_db_table';
		
		// echo 'id_nst_ns_rac: '.$this->get_id_nst_ns_rac().' altro: '.get_id_nst_ns_rac();

        $results = $wpdb->get_results( 
            $wpdb->prepare("UPDATE $table_name SET ns_rac_user_id=%s WHERE key_cart=%s", $ns_rac_user_id, session_id()) 
        );
		
    }

    public static function set_cart_status_abandoned($cart_id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_rac_db_table';
        $wpdb->update( 
            $table_name, 
            array( 
                'status' => 'ABANDONED', 
            ),
            
            array( 
                'id' => $cart_id, 
            )
        );
    }


    public function set_cart_status_email($status, $id, $user_cart_id){
        $this->status = $status;
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_rac_db_table';
        //Db connection
        $results = $wpdb->get_results( 
            $wpdb->prepare("SELECT count(ns_rac_user_id) as total, id, last_update, ns_rac_user_id, order_id, status, ip_address FROM $table_name WHERE ns_rac_user_id=%d AND status != 'RESTORED' AND status != 'ABANDONED' AND status != 'COMPLETED'", $user_cart_id) 
        );

        $user_cart_already_exist = intval($results[0]->total);

        if($user_cart_already_exist >= 1){
            $cart_id_to_update = $id;
            //Db connection
            global $wpdb;
            $table_name = $wpdb->prefix . 'ns_rac_db_table';

            $wpdb->update( 
                $table_name, 
                array( 
                    'status' => $status, 
                ),
                
                array( 
                    'id' => $id, 
                )
            );
        }
    }
    // public static function ns_update_cart_by_session_id($simple_array_to_store){
    //     global $wpdb;
    //     $table_name = $wpdb->prefix . 'ns_rac_db_table';
    //     $wpdb->update( 
    //         $table_name, 
    //         array( 
    //             'time' => current_time( 'mysql' ), 
    //             'cart' => serialize($simple_array_to_store), 
    //             'ns_rac_user_id' => $curr_user_id,
    //             'last_update' => time()
    //         ),
            
    //         array( 
    //             'key_cart' => session_id(), 
    //         )
    //     );
    // }

    public static function ns_check_cart_by_session_id($session_id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_rac_db_table';
        $results = $wpdb->get_results( 
            $wpdb->prepare("SELECT count(ns_rac_user_id) as total, id, last_update, ns_rac_user_id, order_id, `status`, ip_address, key_cart 
            FROM $table_name 
            WHERE key_cart=%s 
            AND status != 'RESTORED' 
            AND status != 'ABANDONED' 
            AND status != 'COMPLETED' 
            AND status != 'PROCESSING'", $session_id) 
        );
        return $results;
    }


    //Update the cart data associative array
    public function set_cart_data_array($cart_data_array){
        $curr_user_id = get_current_user_id();
        $this->cart = $cart_data_array;
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_rac_db_table';
        $cart_id_to_update = 0;
        $key_cart = session_id();
        
        
        //Create an array of products ids and values for simple storing on db
        $simple_array_to_store = array();
        foreach($cart_data_array as $item => $values) { 
            $price_qtity_arr = array();
            $_product =  $values['data']->get_id();
            $price = get_post_meta($_product, '_price', true);
            $price_qtity_arr['quantity'] = $values['quantity'];
            $price_qtity_arr['price'] = $price;

            $simple_array_to_store[$_product] = $price_qtity_arr;
        }
        
        //Db connection
        $results =  $this->rac_db_connection($table_name);
        if(isset($results[0]->total))
            $user_cart_already_exist = intval($results[0]->total);
        else{
            $results_by_session = NS_Cart::ns_check_cart_by_session_id(session_id());
            $user_cart_already_exist = $results_by_session[0]->total;
            //wp_mail('andrea.mugnai97@gmail.com', 'user_cart', $user_cart_already_exist);
            //$user_cart_already_exist = 0;
        }
        
        if(isset($results[0]->id))
            $cart_id_to_update = $results[0]->id;
        else
            $cart_id_to_update = 0;
        
        //Check if user already have cart on Db. If true, update the existent cart.
        //Check on ip address to prevent GUEST cart to be overridden
        //&& $results[0]->key_cart == $session_id
        if($user_cart_already_exist >= 1 /*&& ($results[0]->ip_address == $this->get_client_ip()) && $results[0]->status!='PROCESSING'*/){
            if($curr_user_id == 0){
                $wpdb->update( 
                    $table_name, 
                    array( 
                        'time' => current_time( 'mysql' ), 
                        'cart' => serialize($simple_array_to_store), 
                        'ns_rac_user_id' => $curr_user_id,
                        'last_update' => time()
                    ),
                    
                    array( 
                        //'id' => $cart_id_to_update, 
                        'key_cart' => session_id(), 
                    )
                );
            }else{
                $wpdb->update( 
                    $table_name, 
                    array( 
                        'time' => current_time( 'mysql' ), 
                        'cart' => serialize($simple_array_to_store), 
                        'ns_rac_user_id' => $curr_user_id,
                        'last_update' => time(),
                        'key_cart' => session_id()
                    ),
                    
                    array( 
                        'id' => $cart_id_to_update, 
                        //'key_cart' => session_id(), 
                    )
                );
            }

            $this->creation_time = time();
        }
        else{ //If not create a new row on Db
            $wpdb->insert( 
                $table_name, 
                array( 
                    'time' => current_time( 'mysql' ), 
                    'order_id' => null, 
                    'cart' => serialize($simple_array_to_store), 
                    'ns_rac_user_id' => $curr_user_id,
                    'last_update' => time(),
                    'status' => 'PENDING',
                    'ip_address'=> $this->get_client_ip(),
                    'key_cart' => $key_cart
                ) 
            );
            $this->set_id_nst_ns_rac($wpdb->insert_id);
        }
        $this->creation_time = time();

    }


    //Set the order id if associated order is avaiable
    public function set_cart_order_associated($order_id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_rac_db_table';

        //Db connection
        $results =  $this->rac_db_connection($table_name);
        $cart_id_to_update = $results[0]->id;

        $wpdb->update( 
            $table_name, 
            array( 
                'order_id' => $order_id
            ),
            
            array( 
                'id' => $cart_id_to_update, 
            )
        );
    }
	
	public function set_id_nst_ns_rac($id_nst_ns_rac){
		update_option('id_nst_ns_rac', $id_nst_ns_rac);
        // $this->id_nst_ns_rac = $id_nst_ns_rac;
    }

}
?>
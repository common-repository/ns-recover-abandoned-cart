<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="genRowNssdc">
    <!-- <h2 class="ns-rac-main-title ns-rac-report-main-title">NS Recover Abandoned Cart </h2>	
	<h2>Statistics</h2>	 -->

	
    <?php
    if(class_exists( 'WooCommerce' )){
        $ns_total = NS_Cart::get_total_number_of_carts();
  	    if($ns_total >= 1000){
		    require_once( plugin_dir_path( __FILE__ ).'ns-modal-admin.php');
	    }
        global $wpdb;
        $table_name = $wpdb->prefix . "ns_rac_db_table"; 
        
        /*Get all page option*/
        $num_chart_entries = get_option( 'rac_chart_entries_to_show' );
        $rows_limit = $num_chart_entries;
        $rac_from = get_option('rac_chart_from');
        $rac_to = get_option('rac_chart_to');
        /*********************/

        $date_query_between = '';
        if(($rac_from != '') && ($rac_to != '')){
            $timestamp_dt_from = strtotime($rac_from);
            $timestamp_dt_to = strtotime($rac_to)+86399; //86399 end of the day, to dd at 23:59:59

            $date_query_between = ' AND last_update BETWEEN '.$timestamp_dt_from.' AND '.$timestamp_dt_to.' ';
        }


        $results = $wpdb->get_results(  'SELECT last_update, time, cart, status FROM '.$table_name.' WHERE (status = "ABANDONED" OR status = "RESTORED") '.$date_query_between.' ORDER BY id DESC LIMIT '.$rows_limit, OBJECT );

        if($results !=  null){
            //echo 'SELECT last_update, time, cart, status FROM '.$table_name.' WHERE status = "ABANDONED" OR status = "RESTORED" '.$date_query_between.' ORDER BY id DESC LIMIT '.$rows_limit;
            /*Construct the js array with datas*/
            $js_arr = '[ ["Date", "Lost Amount", "Recovered Amount"],';
            foreach($results as $res){
                $total_amount_abandoned = 0;
                $total_amount_recovered = 0;

                //Loop over ABANDONED cart items
                foreach(unserialize($res->cart) as $prod_id=>$inner_arr){
                    if($res->status == 'ABANDONED'){
                        $total_amount_abandoned = $total_amount_abandoned + rac_calc_total_price($inner_arr);
                    }
                    else if($res->status == 'RESTORED'){
                        $total_amount_recovered = $total_amount_recovered + rac_calc_total_price($inner_arr);
                    }
                }

                $js_arr .= '["'.$res->time.'",'.$total_amount_abandoned.','.$total_amount_recovered.'],';
            }
            $js_arr .= ']';

        ?>
            <div class="ns-chart-container">
                <div id="ns-chart-inner-container-section" class="ns-chart-inner-container">
                    
                    <script type="text/javascript">
                        google.charts.load('current', {packages: ['corechart']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                        // Define the chart to be drawn.
                        var data = new google.visualization.DataTable();
                        var x = <?php echo $js_arr; ?>

                        var data = google.visualization.arrayToDataTable(x);

                        var options = {
                            title: '<?php echo 'Latest '.$rows_limit.' carts';?>',   
                            'height':400,
                            vAxis: {minValue: 0},
                            hAxis: {textPosition: 'none'},
                            colors: ['#DB4C3F', '#25C1ED'],
                            chartArea:{width:'90%',height:'70%'},
                            legend: {position: 'bottom'},
                        };

                        // Instantiate and draw the chart.
                        var chart = new google.visualization.AreaChart(document.getElementById('ns-chart-inner-container-section'));
                        chart.draw(data, options);
                        }
                    </script>

                    
                    <script>
                        /*DAtepicker initialization*/
                        var dateToday = new Date(); 
                        jQuery( function() {
                            jQuery( "#rac_chart_from, #rac_chart_to" ).datepicker({
                                dateFormat: "yy-mm-dd",
                                maxDate: dateToday
                            });
                        } );
                    </script>

                </div>
            </div>
        <?php
        }
        else{
        ?>
            <div class="ns-rac-option-container" style='width: calc(100% - 50px);'>
                <h3><?php _e('Check Your input!', $ns_text_domain);?></h3>
                <p><?php _e('Please select', $ns_text_domain);?> <b class="ns-rac-wc-warning"><?php _e('a valid daterange', $ns_text_domain);?></b>!</p>
            </div>

            <script>
                /*DAtepicker initialization*/
                var dateToday = new Date(); 
                jQuery( function() {
                    jQuery( "#rac_chart_from, #rac_chart_to" ).datepicker({
                        dateFormat: "yy-mm-dd",
                        maxDate: dateToday
                    });
                } );
            </script>
        <?php
        }
        ?>
        
        <!-- Chart option -->

        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php settings_fields('ns_rac_options_chart'); ?>
            <div class="ns-rac-option-container ns-rac-margin-top">
                <h3><?php _e('Stats options', $ns_text_domain);?></h3>
                <p><?php _e('Choose the period of time to consider and the max number of entries to show.', $ns_text_domain);?></p>
                <input type="text" id="rac_chart_from" name="rac_chart_from" class="rac-input rac-text-input ns-rac-datepicker-input" value="<?php echo $rac_from; ?>"><span class="rac-option-text"><?php _e('From (Date)', $ns_text_domain);?> </span>
                <br>
                <br>
                <input type="text" id="rac_chart_to" name="rac_chart_to" class="rac-input rac-text-input ns-rac-datepicker-input" value="<?php echo $rac_to; ?>"><span class="rac-option-text"> <?php _e('To (Date)', $ns_text_domain);?></span>
                <br>
                <br>
                <input type="number" name="rac_chart_entries_to_show" id="rac_chart_entries_to_show" class="rac-input rac-num-input" min="10" value="<?php echo $num_chart_entries; ?>"><span class="rac-option-text"> <?php _e('Entries', $ns_text_domain);?></span>
            </div>
            <!-- <p><input type="submit" class="button-primary ns-rac-submit-button" id="submit" name="submit" value="<?php _e('Save Changes') ?>" /></p> -->
        </form>
        <p><input type="submit" class="button-primary ns-rac-submit-button" id="submit" name="submit" value="<?php _e('Save Changes') ?>" /></p>

    <?php
    }
    ?>

</div>
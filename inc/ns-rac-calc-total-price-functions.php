<?php
//Used to calculate total price of the cart items
function rac_calc_total_price($price_qtity_arr){
	$qtity = intval($price_qtity_arr['quantity']);
	$price = floatval($price_qtity_arr['price']);

	//print_r($price_qtity_arr);

	//echo ' Qtity '.$qtity.' Price'.$price;

	return $qtity * $price;
}
?>
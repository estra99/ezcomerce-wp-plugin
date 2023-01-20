<?php

require(plugin_dir_path( __FILE__ ) .'fees_by_role/includes/fbr-aux-functions.php');

function ez_custom_fee() {

    global $woocommerce; // instance of woocommerce plugin
    

    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {  // checks if user is admin and ajax is defined
        return
    }
        
    $user_roles = get_current_user_roles(); // gets the current user's roles

    if (!empty($user_roles)){ // checks if current user has roles assigned

        $main_role = $user_roles[0]; // gets the first role (assuming Ezcomerce users won't have more than one or the first is the main)
        
        $fee = get_fee_info($main_role); // gets the fee info
    
	    $surcharge = ( $woocommerce->cart->cart_contents_total + $woocommerce->cart->shipping_total ) * $fee->fee_percentage; // creates the surchange to be applied
	    
        $woocommerce->cart->add_fee( $fee->fee_name, $surcharge, true, '' ); // adds the fee to the checkout cart.
    }
}

/**
 * TODO:
 * - Validate if woocommerce is installed.
 */  
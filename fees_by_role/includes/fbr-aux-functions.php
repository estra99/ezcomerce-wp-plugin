<?php

function get_current_user_roles() {
 
 if( is_user_logged_in() ) { // check if user is logged

   $user = wp_get_current_user(); // get current user

   $roles = ( array ) $user->roles; // create an array with user's roles

   return $roles; // returns an array with user's role

 } else {
  
    return array(); // if user is not logged returns an empty array
  }
}

function get_fee_info($role){

  global $wpdb;

  $sql = $wpdb->prepare( "SELECT fee_name, fee_percentage FROM {$wpdb->prefix}ez_fees WHERE user_role = %s", $role );

  $fee_info = $wpdb->get_row( $sql );
  
  return $fee_info;
}


function get_available_role_names() {
    
    global $wpdb;

    global $wp_roles;

    $table_name = $wpdb->prefix . 'ez_fees';

    if ( ! isset( $wp_roles ) ){

        $wp_roles = new WP_Roles();

    }

    $total_roles = $wp_roles->get_names();

    $roles_in_use = $wpdb->get_col("SELECT user_role FROM $table_name");

    foreach($roles_in_use as $key) {

        unset($total_roles[$key]);

    }

    return $total_roles;
}



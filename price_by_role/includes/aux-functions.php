<?php

function get_available_role_names() {
    global $wpdb;
    global $wp_roles;
    $table_name = $wpdb->prefix . 'ez_price_by_role';
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



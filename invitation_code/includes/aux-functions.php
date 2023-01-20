<?php

function get_user_role_by_invitation_code( $invitation_code ){
    global $wpdb;
    $sql = $wpdb->prepare( "SELECT user_role FROM {$wpdb->prefix}ez_invitation_codes WHERE invitation_code = %s", $invitation_code );
	$user_role = $wpdb->get_var( $sql );
    return $user_role;
}

function get_role_names() {
    global $wp_roles;
    if ( ! isset( $wp_roles ) ){
        $wp_roles = new WP_Roles();
    }   
    return $wp_roles->get_names();
}
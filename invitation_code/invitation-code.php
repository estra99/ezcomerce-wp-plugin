<?php

require('includes/aux-functions.php');

function update_user_role_on_registration( $user_id ){
	$invitation_code = strtolower(trim($_POST['invitation_code']));
    $role = get_user_role_by_invitation_code($invitation_code);
	if (!is_null($role)) {
        $user = new WP_User( $user_id );
        $user->add_role( $role );
		$user->remove_role( 'customer' );
    }		
}
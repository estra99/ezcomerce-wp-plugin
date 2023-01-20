<?php
/**
 * Plugin Name:       Ezcomerce Plugin
 * Plugin URI:        https://ezcomerce.com/ezcomerce-plugin/
 * Description:       Adds all the functionality for Ezcomerce site.
 * Version:           1.0.0
 * Requires at least: 6.1
 * Requires PHP:      7.2
 * Author:            Esteban Salas
 * Author URI:        https://github.com/estra99
 * License:           Ezcomerce S.R.L
 * License URI:       http://www.ezcomerce.com/ezcomerce-plugin-licence/
 * Text Domain:       ezcomerce-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Update it as new version are released.
 */
define( 'EZCOMERCE_PLUGIN_VERSION', '1.0.0' );

/**
 * Adds the inviation code feature on the registration page.
 */
require('invitation_code/invitation-code.php');
add_action( 'user_register', 'update_user_role_on_registration', 10, 1 );

/**
 * Adds the inviation codes admin menu.
 */
require('invitation_code/admin/invitation-code-menu.php');
add_action('admin_menu', 'addInvitationCodeContent');


/**
 * Adds the discount percentage per user role.
 */


/**
 * Adds the discount percentage admin menu.
 */
require('price_by_role/admin/price-by-role-menu.php');
add_action('admin_menu', 'addPriceByRoleContent');
<?php

/**
 * The plugin bootstrap file.
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. It also sets up the activation and deactivation hooks and initialises
 * the plugin.
 *
 * @see              https://formewp.github.io
 * @since             1.0.0
 *
 * @package           ReplaceMePlugin
 *
 * @wordpress-plugin
 * Plugin Name:       Replace Me
 * Plugin URI:        https://formewp.github.io
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Moussa Clarke
 * Author URI:        https://formewp.github.io
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       replace-me
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    exit;
}

/*
 * Bootstrap forme framework
 *
 **/
\Forme\bootstrap();

/**
 * Include routes.
 */
include_once __DIR__ . '/routes/routes.php';

/**
 * Plugin activation.
 */
function activate_replace_me(): void
{
    \Forme\getInstance('\VendorName\ReplaceMePlugin\Core\Activator')->activate();
}

/**
 * Plugin deactivation.
 */
function deactivate_replace_me(): void
{
    \Forme\getInstance('\VendorName\ReplaceMePlugin\Core\Deactivator')->deactivate();
}

/*
 * Hooks
 */
register_activation_hook(__FILE__, 'activate_replace_me');
register_deactivation_hook(__FILE__, 'deactivate_replace_me');

/*
 * Activation admin Notices
 */
add_action('admin_notices', function () {
    $messages = get_transient('replace-me-admin-messages');
    if ($messages) {
        foreach ($messages as $message) {
            echo \Forme\getInstance('VendorName\\ReplaceMePlugin\\Core\\View')->render('admin-message', $message);
        }
        delete_transient('replace-me-admin-messages');
    }
});

$vendorNameReplaceMePluginPlugin = \Forme\getInstance('VendorName\\ReplaceMePlugin\\Main');
$vendorNameReplaceMePluginPlugin->run();

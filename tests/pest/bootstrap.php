<?php

require_once __DIR__ . '/test-config.php';

$projectDir                = dirname(__FILE__, 3);

function activatePlugins(): void
{
    include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

addFilter('muplugins_loaded', 'activatePlugins', -999);
addFilter('muplugins_loaded', 'migrate', 1000);

resetServer();
$GLOBALS['_wp_die_disabled'] = false;
// Allow tests to override wp_die().
addFilter('wp_die_handler', '_wp_die_handler_filter');
// Prevent updating translations asynchronously.
addFilter('async_update_translation', '__return_false');
// Disable background updates.
addFilter('automatic_updater_disabled', '__return_true');

require_once $projectDir . '/wp-test/public/wp-config.php';

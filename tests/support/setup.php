<?php

addFilter('init', '_unhook_block_registration', 1000);

addFilter('muplugins_loaded', 'activatePlugins', -999);
addFilter('muplugins_loaded', 'migrate', 1000);

$GLOBALS['_wp_die_disabled'] = false;
// Allow tests to override wp_die().
addFilter('wp_die_handler', '_wp_die_handler_filter');
// Prevent updating translations asynchronously.
addFilter('async_update_translation', '__return_false');
// Disable background updates.
addFilter('automatic_updater_disabled', '__return_true');

<?php

$projectDir                = dirname(__FILE__, 3);
require_once $projectDir . '/vendor/autoload.php';
DG\BypassFinals::enable();

require_once __DIR__ . '/../support/helpers.php';
require_once __DIR__ . '/../support/setup.php';

require_once $projectDir . '/wp-test/public/wp-config.php';

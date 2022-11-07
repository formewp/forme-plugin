<?php

use Yoast\WPTestUtils\BrainMonkey\TestCase;

uses(TestCase::class)->in('pest/Integration');

// make sure wordpress is re-initialised before each test
uses()->beforeEach(function () {
    global $wp_filter;
    $wp_filter = [];
    migrate();
})->in('pest/Integration');

uses()->afterEach(function () {
    rollback();
})->in('pest/Integration');

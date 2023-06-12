<?php

// make sure wordpress is re-initialised before each integration test
uses()->beforeEach(function () {
    global $wp_filter;
    $wp_filter = [];
    migrate();
})->in('pest/Integration');

uses()->afterEach(function () {
    rollback();
})->in('pest/Integration');

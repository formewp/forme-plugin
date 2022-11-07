<?php

it('is an example integration test', function () {
    wp_set_current_user(1);
    $currentUserId = get_current_user_id();
    expect($currentUserId)->toBe(1);
});

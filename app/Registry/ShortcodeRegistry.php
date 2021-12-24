<?php

declare(strict_types=1);

namespace VendorName\ReplaceMePlugin\Registry;

use Forme\Framework\Registry\RegistryInterface;

final class ShortcodeRegistry implements RegistryInterface
{
    public function register(): void
    {
        // add shortcodes here
        // for example: add_shortcode('acme-shortcode', [\Forme\getInstance('AcmeShortcodeController')]);
        // implement ControllerInterface for the shortcode classes
    }
}

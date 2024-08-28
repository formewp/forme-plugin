<?php

declare(strict_types=1);

namespace VendorName\ReplaceMePlugin\Registry;

use Forme\Framework\Registry\RegistryInterface;

class I18nRegistry implements RegistryInterface
{
    /**
     * Load the plugin text domain for translation.
     */
    public function register(): void
    {
        load_plugin_textdomain(
            'replace-me',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}

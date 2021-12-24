<?php

declare(strict_types=1);

namespace VendorName\ReplaceMePlugin\Registry;

use Forme\Framework\Registry\RegistryInterface;
use VendorName\ReplaceMePlugin\Core\Assets;

final class PublicQueueRegistry implements RegistryInterface
{
    public function register(): void
    {
        // add script & style enqueues here
        /*
         * for example
         * wp_enqueue_style('name', 'path/to/assets/css/app.css', [], 'version', 'all');
         * use the Assets static methods for some useful helper functions
         * wp_enqueue_script('scriptname', Assets::uri('app.js'), ['jquery'], Assets::time('app.js'), false)
         * if you aren't using a forme theme, you might need to sort out jquery here
         */
        // via encore/dist or static
        wp_enqueue_style('replace-me-plugin-public-styles', Assets::uri('app.css'), [], Assets::time('app.css'), false);
        wp_enqueue_script('replace-me-plugin-public-scripts', Assets::uri('app.js'), ['jquery'], Assets::time('app.js'), true);
    }

    /**
     * Make enqueues into browser modules so that we can use all the include goodness.
     */
    public function moduleTag(string $tag, string $handle, string $src): string
    {
        // bail if not script or if dist exists
        if ($handle !== 'replace-me-plugin-public-scripts' || Assets::distExists()) {
            return $tag;
        }
        // make this a module
        return '<script type="module" src="' . esc_url($src) . '"></script>';
    }
}

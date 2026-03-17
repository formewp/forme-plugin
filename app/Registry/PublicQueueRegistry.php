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
        if (Assets::devServerActive()) {
            // Dev: inject the Vite client in the head, then the entry module.
            // CSS is injected by Vite automatically — no wp_enqueue_style needed.
            wp_enqueue_script('vite-client', Assets::viteClientUri(), [], null, false);
            wp_enqueue_script('replace-me-plugin-public-scripts', Assets::uri('assets/src/js/app.js'), [], null, false);
        } else {
            // Production: enqueue CSS extracted by Vite from the entry, then the hashed JS.
            $version  = Assets::time('assets/src/js/app.js');
            $cssPaths = Assets::cssFromManifest('assets/src/js/app.js');

            foreach ($cssPaths as $index => $cssUri) {
                wp_enqueue_style(
                    'replace-me-plugin-public-styles-' . $index,
                    $cssUri,
                    [],
                    $version
                );
            }

            wp_enqueue_script(
                'replace-me-plugin-public-scripts',
                Assets::uri('assets/src/js/app.js'),
                [],
                $version,
                true
            );
        }
    }

    /**
     * Add type="module" to Vite-managed script tags.
     */
    public function moduleTag(string $tag, string $handle, string $src): string
    {
        $moduleHandles = ['vite-client', 'replace-me-plugin-public-scripts'];

        if (!in_array($handle, $moduleHandles, true)) {
            return $tag;
        }

        return '<script type="module" src="' . esc_url($src) . '"></script>' . "\n";
    }
}

<?php

declare(strict_types=1);

namespace VendorName\ReplaceMePlugin;

use Forme\Framework\Core\Loader;

class Main
{
    /**
     * The loader is responsible for registering all hooks.
     *
     * @var Loader registers all hooks for the plugin
     */
    protected $loader;

    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Set locale, initiliase the loader and run it.
     */
    public function run(): void
    {
        $this->initialiseLoader();
        $this->loader->run();
    }

    /**
     * Prepare the loader.
     */
    private function initialiseLoader(): void
    {
        // add all the config hooks to the loader
        $this->loader->addConfig(file_get_contents(__DIR__ . '/config/hooks.yaml'));

        // you can also add hooks here explicitly without using the config yaml e.g.
        // $this->loader->addAction('hook_name', 'FooActionClass', 'barMethod');
        // but this is not really recommended as the api could change in the future
    }
}

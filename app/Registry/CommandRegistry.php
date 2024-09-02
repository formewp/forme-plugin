<?php

declare(strict_types=1);

namespace VendorName\ReplaceMePlugin\Registry;

use Forme\Framework\Registry\RegistryInterface;

final class CommandRegistry implements RegistryInterface
{
    public function register(): void
    {
        if (! PHP_SAPI === 'cli') {
            return;
        }
        $classFiles = glob(__DIR__ . '/../Commands/Wrangle/*');
        foreach ($classFiles as $classFile) {
            require_once $classFile;
        }
    }
}

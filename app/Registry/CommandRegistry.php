<?php

/**
 * This boilerplate file is auto-generated.
 */

declare(strict_types=1);

namespace VendorName\ReplaceMePlugin\Registry;

use Forme\Framework\Registry\RegistryInterface;
use WP_CLI;

final class CommandRegistry implements RegistryInterface
{
    public function register(): void
    {
        WP_CLI::add_command('forme-queue', 'Forme\\Framework\\Commands\\JobQueueCommand');
    }
}

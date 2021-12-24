<?php

declare(strict_types=1);

namespace VendorName\ReplaceMePlugin\Registry;

use Forme\Framework\Registry\RegistryInterface;

final class FieldRegistry implements RegistryInterface
{
    public function register(): void
    {
        $classFiles = glob(__DIR__ . '/../Fields/*');
        foreach ($classFiles as $classFile) {
            $className = 'VendorName\\ReplaceMePlugin\\Fields\\' . basename($classFile, '.php');
            $class     = \Forme\getInstance($className);
            $class->add();
        }
    }
}

<?php

declare(strict_types=1);

namespace VendorName\ReplaceMePlugin\Registry;

use Forme\Framework\Registry\RegistryInterface;
use Psr\Container\ContainerInterface;

final class PostTypeRegistry implements RegistryInterface
{
    /** @var ContainerInterface */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function register(): void
    {
        $postTypes = $this->getInstances();
        foreach ($postTypes as $postType) {
            $postType->register();
        }
    }

    public function updateMessages($messages): void
    {
        $postTypes = $this->getInstances();
        foreach ($postTypes as $postType) {
            $postType->updateMessages($messages);
        }
    }

    /**
     * Gets all the post types from the models directory
     * Instantiate them and send them back in array.
     */
    private function getInstances(): array
    {
        $classFiles = glob(__DIR__ . '/../Models/*');
        $result     = [];
        foreach ($classFiles as $classFile) {
            $className = 'VendorName\\ReplaceMePlugin\\Models\\' . basename($classFile, '.php');
            if (substr($className, -8) === 'PostType') {
                $result[] = $this->container->get($className);
            }
        }

        return $result;
    }
}

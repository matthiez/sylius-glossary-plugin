<?php

declare(strict_types=1);

namespace Ecolos\SyliusGlossaryPlugin\DependencyInjection;

use Exception;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use  Symfony\Component\Config\FileLocator;

final class EcolosSyliusGlossaryExtension extends Extension
{
    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function load(array $config, ContainerBuilder $container): void
    {
        $this->processConfiguration($this->getConfiguration([], $container), $config);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.yaml');
    }
}

<?php
declare(strict_types=1);

namespace Ecolos\SyliusGlossaryPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder('ecolos_sylius_glossary_plugin');
    }
}

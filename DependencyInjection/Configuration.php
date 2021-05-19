<?php declare(strict_types=1);

namespace RichId\TourBundle\DependencyInjection;

use RichCongress\BundleToolbox\Configuration\AbstractConfiguration;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration extends AbstractConfiguration
{
    public const CONFIG_NODE = 'rich_id_tour';

    protected function buildConfiguration(ArrayNodeDefinition $rootNode): void
    {
        $children = $rootNode->children();

        $this->buildUserClassNode($children);
        $this->buildToursNode($children);

        $children->end();
    }

    protected function buildUserClassNode(NodeBuilder $nodeBuilder): NodeBuilder
    {
        return $nodeBuilder
            ->scalarNode('user_class')
            ->isRequired()
            ->end();
    }

    protected function buildToursNode(NodeBuilder $nodeBuilder): NodeBuilder
    {
        return $nodeBuilder
            ->arrayNode('tours')
            ->normalizeKeys(true)
            ->defaultValue([])
                ->arrayPrototype()
                    ->children()
                        ->enumNode('storage')->values(['database', 'cookie', 'local_storage'])->end()
                        ->scalarNode('duration')->defaultValue('+6 months')->end()
                        ->scalarNode('name')->end()
                    ->end()
                ->end()
            ->end();
    }
}

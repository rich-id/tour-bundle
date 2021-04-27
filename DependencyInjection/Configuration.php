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

        $this->buildUserToursNode($children);

        $children->end();
    }

    protected function buildUserToursNode(NodeBuilder $nodeBuilder): NodeBuilder
    {
        return $nodeBuilder
            ->arrayNode('user_tours')
            ->normalizeKeys(false)
            ->defaultValue([])
            ->scalarPrototype()->end()
            ->end();
    }
}

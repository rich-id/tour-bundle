<?php declare(strict_types=1);

namespace RichId\TourBundle\DependencyInjection\Compiler;

use RichId\TourBundle\Entity\UserTourInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DoctrineResolveTargetEntityPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('doctrine.orm.listeners.resolve_target_entity');

        $definition->addMethodCall('addResolveTargetEntity', [
            UserTourInterface::class,
            $container->getParameter('rich_id_tour.user_class'),
            [],
        ]);

        $definition->addTag('doctrine.event_subscriber', ['connection' => 'default']);
    }
}

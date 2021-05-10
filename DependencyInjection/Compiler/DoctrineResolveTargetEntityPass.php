<?php declare(strict_types=1);

namespace RichId\TourBundle\DependencyInjection\Compiler;

use RichCongress\BundleToolbox\Configuration\AbstractCompilerPass;
use RichId\TourBundle\Entity\UserTourInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DoctrineResolveTargetEntityPass extends AbstractCompilerPass
{
    public const PRIORITY = 1000;
    public const MANDATORY_SERVICES = ['doctrine.orm.listeners.resolve_target_entity'];

    public function process(ContainerBuilder $container)
    {
        if (!$this->checkMandatoryServices($container)) {
            return;
        }

        $definition = $container->findDefinition('doctrine.orm.listeners.resolve_target_entity');

        $definition->addMethodCall('addResolveTargetEntity', [
            UserTourInterface::class,
            $container->getParameter('rich_id_tour.user_class'),
            [],
        ]);

        $definition->addTag('doctrine.event_subscriber', ['connection' => 'default']);
    }
}

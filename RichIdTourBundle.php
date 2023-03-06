<?php declare(strict_types=1);

namespace RichId\TourBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use RichCongress\BundleToolbox\Configuration\AbstractBundle;
use RichId\TourBundle\DependencyInjection\Compiler\DoctrineResolveTargetEntityPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class RichIdTourBundle
 *
 * @package   RichId\TourBundle
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class RichIdTourBundle extends AbstractBundle
{
    public const COMPILER_PASSES = [DoctrineResolveTargetEntityPass::class];
    public const ROLE_RICH_ID_TOUR_ADMIN = 'ROLE_RICH_ID_TOUR_ADMIN';

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $this->addDoctrineOrmMappingsPass($container);
    }

    private function addDoctrineOrmMappingsPass(ContainerBuilder $container): void
    {
        if (!\class_exists(DoctrineOrmMappingsPass::class)) {
            return;
        }

        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createAnnotationMappingDriver(
                ['RichId\TourBundle\Entity'],
                [__DIR__ . '/Entity']
            )
        );
    }
}

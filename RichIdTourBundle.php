<?php declare(strict_types=1);

namespace RichId\TourBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use RichCongress\BundleToolbox\Configuration\AbstractBundle;
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
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $this->addRegisterMappingsPass($container);
    }

    private function addRegisterMappingsPass(ContainerBuilder $container)
    {
        if (class_exists(DoctrineOrmMappingsPass::class)) {
            $container->addCompilerPass(
                DoctrineOrmMappingsPass::createAnnotationMappingDriver(
                    ['RichId\TourBundle\Entity'],
                    [__DIR__ . '/Entity']
                )
            );
        }
    }
}

<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Tests\Resources\Entity\DummyUser;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class ConfigurationTest
 *
 * @package    RichId\TourBundle\Tests
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\DependencyInjection\Configuration
 * @TestConfig("container")
 */
final class ConfigurationTest extends TestCase
{
    public function testConfiguration(): void
    {
        $parameterBag = $this->getService(ParameterBagInterface::class);

        self::assertSame(
            [
                'user_class' => DummyUser::class,
                'tours'      => [
                    'cookie_tour'        => [
                        'storage' => 'cookie',
                        'duration' => '+6 months',
                    ],
                    'cookie_tour_2'      => [
                        'storage'  => 'cookie',
                        'duration' => '+1 months',
                    ],
                    'local_storage_tour' => [
                        'storage' => 'local_storage',
                        'duration' => '+6 months',
                    ],
                    'database_tour'      => [
                        'storage' => 'database',
                        'duration' => '+6 months',
                    ],
                    'database_tour_2'    => [
                        'storage' => 'database',
                        'duration' => '+6 months',
                    ],
                    'database_tour_3'    => [
                        'storage' => 'database',
                        'duration' => '+6 months',
                    ],
                ],
            ],
            $parameterBag->get('rich_id_tour')
        );
    }
}

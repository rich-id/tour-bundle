<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Twig\Extension;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Twig\Extension\TourExtension;

/**
 * Class TourExtensionTest
 *
 * @package   RichId\TourBundle\Tests\Twig\Extension
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Twig\Extension\TourExtension
 * @TestConfig("fixtures")
 */
final class TourExtensionTest extends TestCase
{
    /** @var TourExtension */
    public $extension;

    public function testGetTours(): void
    {
        $this->assertSame(
            [
                'cookie_tour'        => [
                    'storage'  => 'cookie',
                    'duration' => '+6 months',
                ],
                'cookie_tour_2'      => [
                    'storage'  => 'cookie',
                    'duration' => '+1 months',
                ],
                'local_storage_tour' => [
                    'storage'  => 'local_storage',
                    'duration' => '+6 months',
                ],
                'database_tour'      => [
                    'storage'  => 'database',
                    'duration' => '+6 months',
                ],
                'database_tour_2'    => [
                    'storage'  => 'database',
                    'duration' => '+6 months',
                ],
                'database_tour_3'    => [
                    'storage'  => 'database',
                    'duration' => '+6 months',
                ],
                'database_tour_4'    => [
                    'storage'  => 'database',
                    'duration' => '+6 months',
                ],

            ],
            $this->extension->getTours()
        );
    }

    public function testIsTourDisabled(): void
    {
        $this->assertTrue($this->extension->isTourDisabled('database_tour_2'));
    }

    public function testIsTourNotDisabled(): void
    {
        $this->assertFalse($this->extension->isTourDisabled('database_tour'));
    }

    public function testGetToursStatistics(): void
    {
        $this->assertSame(
            [

                'database_tour_4' => 1

            ],
            $this->extension->getToursStatistics()
        );
    }
}

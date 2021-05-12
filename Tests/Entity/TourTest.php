<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Entity;

use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Entity\Tour;

/**
 * Class TourTest
 *
 * @package   RichId\TourBundle\Tests\Entity
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Entity\Tour
 */
final class TourTest extends TestCase
{
    public function testBuild(): void
    {
        $entity = Tour::build('my_tour');

        $this->assertSame('my_tour', $entity->getKeyname());
        $this->assertFalse($entity->isDisabled());
    }

    public function testEnable(): void
    {
        $entity = Tour::build('my_tour');

        $entity->disable();
        $this->assertTrue($entity->isDisabled());

        $entity->enable();
        $this->assertFalse($entity->isDisabled());
    }
}

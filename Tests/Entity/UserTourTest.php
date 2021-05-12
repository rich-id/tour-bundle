<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Entity;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Entity\Tour;
use RichId\TourBundle\Entity\UserTour;
use RichId\TourBundle\Tests\Resources\Entity\DummyUser;

/**
 * Class UserTourTest
 *
 * @package   RichId\TourBundle\Tests\Entity
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Entity\UserTour
 * @TestConfig("fixtures")
 */
final class UserTourTest extends TestCase
{
    public function testBuildForTourAndUser(): void
    {
        $tour = $this->getReference(Tour::class, 'database_tour');
        $user = $this->getReference(DummyUser::class, '1');

        $entity = UserTour::buildForTourAndUser($tour, $user);

        $this->assertSame($tour, $entity->getTour());
        $this->assertSame($user, $entity->getUser());
    }
}

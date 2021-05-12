<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Resources\Fixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use RichCongress\RecurrentFixturesTestBundle\DataFixture\AbstractFixture;
use RichId\TourBundle\Entity\Tour;
use RichId\TourBundle\Entity\UserTour;
use RichId\TourBundle\Tests\Resources\Entity\DummyUser;

/**
 * Class UserTourFixtures.
 *
 * @package   RichId\TourBundle\Tests\Resources\Fixtures
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
final class UserTourFixtures extends AbstractFixture implements DependentFixtureInterface
{
    protected function loadFixtures(): void
    {
        $tour = $this->manager
            ->getRepository(Tour::class)
            ->findOneByKeyname('database_tour_4');

        $user = $this->manager
            ->getRepository(DummyUser::class)
            ->findOneByUsername('my_user_1');

        $this->createObject(
            UserTour::class,
            '1',
            [
                'tour' => $tour,
                'user' => $user,
            ]
        );
    }

    public function getDependencies(): array
    {
        return [
            DummyUserFixtures::class,
            TourFixtures::class,
        ];
    }
}

<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Resources\Fixtures;

use RichCongress\RecurrentFixturesTestBundle\DataFixture\AbstractFixture;
use RichId\TourBundle\Tests\Resources\Entity\DummyUser;

/**
 * Class DummyUserFixtures.
 *
 * @package   RichId\TourBundle\Tests\Resources\Fixtures
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
final class DummyUserFixtures extends AbstractFixture
{
    protected function loadFixtures(): void
    {
        $this->createObject(
            DummyUser::class,
            '1',
            [
                'username' => 'my_user_1'
            ]
        );

        $this->createObject(
            DummyUser::class,
            '2',
            [
                'username' => 'my_user_2'
            ]
        );
    }
}

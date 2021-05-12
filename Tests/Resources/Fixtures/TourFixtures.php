<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Resources\Fixtures;

use RichCongress\RecurrentFixturesTestBundle\DataFixture\AbstractFixture;
use RichId\TourBundle\Entity\Tour;

/**
 * Class TourFixtures.
 *
 * @package   RichId\TourBundle\Tests\Resources\Fixtures
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
final class TourFixtures extends AbstractFixture
{
    protected function loadFixtures(): void
    {
        $this->createObject(
            Tour::class,
            'database_tour',
            [
                'keyname'    => 'database_tour',
                'isDisabled' => false,
            ]
        );
    }
}

<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Repository;

use RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Repository\TourRepository;

/**
 * Class TourRepositoryTest
 *
 * @package   RichId\TourBundle\Tests\Repository
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Repository\TourRepository
 */
#[TestConfig('fixtures')]
final class TourRepositoryTest extends TestCase
{
    /** @var TourRepository */
    public $repository;

    public function testFindDisabledTourKeynames(): void
    {
        $results = $this->repository->findDisabledTourKeynames();
        $this->assertSame(['database_tour_2'], $results);
    }
}

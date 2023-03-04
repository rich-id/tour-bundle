<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Controller;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\ControllerTestCase;
use RichId\TourBundle\Repository\TourRepository;
use RichId\TourBundle\Repository\UserTourRepository;
use RichId\TourBundle\Tests\Resources\Entity\DummyUser;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TourControllerTest
 *
 * @package   RichId\TourBundle\Tests\Controller
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Controller\TourController
 * @TestConfig("fixtures")
 */
final class TourControllerTest extends ControllerTestCase
{
    /** @var TourRepository */
    public $tourRepository;

    /** @var UserTourRepository */
    public $userTourRepository;

    public function testPostEnableNotLogged(): void
    {
        $response = $this->getClient()->post('/rich-id-tours/enable', ['tour' => 'database_tour_3']);
        $this->assertSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testPostEnableNotFoundTour(): void
    {
        $this->authenticate(DummyUser::class, '1');

        $response = $this->getClient()->post('/rich-id-tours/enable', ['tour' => 'other_tour']);
        $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testPostEnable(): void
    {
        $this->authenticate(DummyUser::class, '1');

        $tour = $this->tourRepository->findOneByKeyname('database_tour_3');
        $this->assertNull($tour);

        $response = $this->getClient()->post('/rich-id-tours/enable', ['tour' => 'database_tour_3']);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        $tour = $this->tourRepository->findOneByKeyname('database_tour_3');
        $this->assertNotNull($tour);
        $this->assertFalse($tour->isDisabled());
    }

    public function testPostDisableNotFoundTour(): void
    {
        $this->authenticate(DummyUser::class, '1');

        $response = $this->getClient()->post('/rich-id-tours/disable', ['tour' => 'other_tour']);
        $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testPostDisableNotLogged(): void
    {
        $response = $this->getClient()->post('/rich-id-tours/disable', ['tour' => 'database_tour_3']);
        $this->assertSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testPostDisable(): void
    {
        $this->authenticate(DummyUser::class, '1');

        $tour = $this->tourRepository->findOneByKeyname('database_tour_3');
        $this->assertNull($tour);

        $response = $this->getClient()->post('/rich-id-tours/disable', ['tour' => 'database_tour_3']);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        $tour = $this->tourRepository->findOneByKeyname('database_tour_3');
        $this->assertNotNull($tour);
        $this->assertTrue($tour->isDisabled());
    }

    public function testPostPerformNotLogged(): void
    {
        $response = $this->getClient()->post('/rich-id-tours/perform', ['tour' => 'database_tour_3']);
        $this->assertSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testPostPerformWithDisabledTour(): void
    {
        $this->authenticate(DummyUser::class, '1');

        $response = $this->getClient()->post('/rich-id-tours/perform', ['tour' => 'database_tour_2']);
        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('"Tour database_tour_2 is disabled"', $response->getContent());
    }

    public function testPostPerform(): void
    {
        $user = $this->getRepository(DummyUser::class)->find(1);
        $this->authenticate(DummyUser::class, '1');

        $tour = $this->tourRepository->findOneByKeyname('database_tour_3');
        $userTour = $this->userTourRepository->findOneByUserAndTour($user, 'database_tour_3');
        $this->assertNull($tour);
        $this->assertNull($userTour);

        $response = $this->getClient()->post('/rich-id-tours/perform', ['tour' => 'database_tour_3']);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        $tour = $this->tourRepository->findOneByKeyname('database_tour_3');
        $userTour = $this->userTourRepository->findOneByUserAndTour($user, 'database_tour_3');
        $this->assertNotNull($tour);
        $this->assertNotNull($userTour);
    }

    public function testDeleteResetPerformedTours(): void
    {
        $this->authenticate(DummyUser::class, '1');

        $this->assertCount(1, $this->userTourRepository->findAll());

        $response = $this->getClient()->delete('/rich-id-tours/perform', ['tour' => 'database_tour_4']);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        $this->assertEmpty($this->userTourRepository->findAll());
    }
}

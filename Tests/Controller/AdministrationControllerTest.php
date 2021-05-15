<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Controller;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\ControllerTestCase;
use RichId\TourBundle\Tests\Resources\Entity\DummyUser;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdministrationControllerTest
 *
 * @package   RichId\TourBundle\Tests\Controller
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Controller\AdministrationController
 * @TestConfig("fixtures")
 */
final class AdministrationControllerTest extends ControllerTestCase
{
    public function testToursBadRole(): void
    {
        $response = $this->getClient()->get('/administration/tours');
        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testTours(): void
    {
        $user = $this->getReference(DummyUser::class, '1');
        $this->authenticateUser($user);

        $response = $this->getClient()->get('/administration/tours');
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }
}

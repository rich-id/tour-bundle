<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Exception;

use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Exception\NotAuthenticatedException;
use RichId\TourBundle\Exception\TourException;

/**
 * Class NotAuthenticatedExceptionTest
 *
 * @package   RichId\TourBundle\Tests\Exception
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Exception\NotAuthenticatedException
 */
final class NotAuthenticatedExceptionTest extends TestCase
{
    public function testException(): void
    {
        $exception = new NotAuthenticatedException();

        $this->assertInstanceOf(TourException::class, $exception);
        $this->assertSame('You must be connected', $exception->getMessage());
    }
}

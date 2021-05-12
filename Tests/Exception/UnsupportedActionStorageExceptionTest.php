<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Exception;

use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Exception\UnsupportedActionStorageException;
use RichId\TourBundle\Exception\TourException;

/**
 * Class UnsupportedActionStorageExceptionTest
 *
 * @package   RichId\TourBundle\Tests\Exception
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Exception\UnsupportedActionStorageException
 */
final class UnsupportedActionStorageExceptionTest extends TestCase
{
    public function testException(): void
    {
        $exception = new UnsupportedActionStorageException('my_tour');

        $this->assertInstanceOf(TourException::class, $exception);
        $this->assertSame('The storage of the my_tour tour must be of database type', $exception->getMessage());
    }
}

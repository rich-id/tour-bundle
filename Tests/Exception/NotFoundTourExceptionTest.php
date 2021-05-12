<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Exception;

use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Exception\NotFoundTourException;
use RichId\TourBundle\Exception\TourException;

/**
 * Class NotFoundTourExceptionTest
 *
 * @package   RichId\TourBundle\Tests\Exception
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Exception\NotFoundTourException
 */
final class NotFoundTourExceptionTest extends TestCase
{
    public function testException(): void
    {
        $exception = new NotFoundTourException('my_tour');

        $this->assertInstanceOf(TourException::class, $exception);
        $this->assertSame('Not found tour my_tour', $exception->getMessage());
    }
}

<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Exception;

use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Exception\DisabledTourException;
use RichId\TourBundle\Exception\TourException;

/**
 * Class DisabledTourExceptionTest
 *
 * @package   RichId\TourBundle\Tests\Exception
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Exception\DisabledTourException
 */
final class DisabledTourExceptionTest extends TestCase
{
    public function testException(): void
    {
        $exception = new DisabledTourException('my_tour');

        $this->assertInstanceOf(TourException::class, $exception);
        $this->assertSame('Tour my_tour is disabled', $exception->getMessage());
    }
}

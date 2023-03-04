<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Resources\Stub;

use RichCongress\WebTestBundle\OverrideService\AbstractOverrideService;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class EventDispatcherStub extends AbstractOverrideService implements EventDispatcherInterface
{
    /** @var string|array<string> */
    public static $overridenServices = EventDispatcherInterface::class;

    public static $events = [];

    public static function setUp(): void
    {
        self::$events = [];
    }

    public static function tearDown(): void
    {
        self::$events = [];
    }

    public function dispatch(object $event, string $eventName = null): object
    {
        self::$events[] = $event;

        return $this->innerService->dispatch($event);
    }

}

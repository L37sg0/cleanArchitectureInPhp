<?php

namespace L37sg0\Architecture\Persistence\Hydrator\Strategy\Tests;

use DateTime;
use L37sg0\Architecture\Persistence\Hydrator\Strategy\DateStrategy;
use L37sg0\Architecture\Persistence\Hydrator\Strategy\StrategyInterface;
use PHPUnit\Framework\TestCase;

class DateStrategyTest extends TestCase
{
    public function testCanCreateClass() {
        $strategy = new DateStrategy();

        $this->assertInstanceOf(DateStrategy::class, $strategy);
        $this->assertInstanceOf(StrategyInterface::class, $strategy);
    }

    public function testCanExtract() {
        $date = new DateTime('2022-10-13');

        $strategy = new DateStrategy();

        $this->assertEquals('2022-10-13', $strategy->extract($date));
    }

    public function testCanHydrate() {
        $value = '2022-10-13';

        $this->assertInstanceOf(DateTime::class, (new DateStrategy())->hydrate($value));
    }
}
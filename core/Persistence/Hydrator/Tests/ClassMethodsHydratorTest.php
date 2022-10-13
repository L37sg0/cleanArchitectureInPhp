<?php

namespace L37sg0\Architecture\Persistence\Hydrator\Tests;

use L37sg0\Architecture\Persistence\Hydrator\ClassMethodsHydrator;
use L37sg0\Architecture\Persistence\Hydrator\ExtractionInterface;
use L37sg0\Architecture\Persistence\Hydrator\HydrationInterface;
use L37sg0\Architecture\Persistence\Hydrator\HydratorInterface;
use L37sg0\Architecture\Persistence\Hydrator\Strategy\StrategyInterface;
use PHPUnit\Framework\TestCase;

class ClassMethodsHydratorTest extends TestCase
{
    public function testCanCreateClass() {
        $hydrator = new ClassMethodsHydrator();

        $this->assertInstanceOf(ClassMethodsHydrator::class, $hydrator);
        $this->assertInstanceOf(HydratorInterface::class, $hydrator);
        $this->assertInstanceOf(HydrationInterface::class, $hydrator);
        $this->assertInstanceOf(ExtractionInterface::class, $hydrator);
    }

    public function testCanAddRemoveStrategies() {
        $hydrator = new ClassMethodsHydrator();

        $strategy1 = $this->createMock(StrategyInterface::class);
        $strategy2 = $this->createMock(StrategyInterface::class);

        $hydrator->addStrategy('strategy1', $strategy1)->addStrategy('strategy2', $strategy2);

        $this->assertEquals(2, count($hydrator->getStrategies()));

        $hydrator->removeStrategy('strategy1');

        $this->assertEquals(1, count($hydrator->getStrategies()));
        $this->assertEquals($strategy2, $hydrator->getStrategies()['strategy2']);
    }
}
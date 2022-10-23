<?php

namespace Tests\hydrator;

use DateTime;
use L37sg0\Architecture\Persistence\Hydrator\ClassMethodsHydrator;
use L37sg0\Architecture\Persistence\Hydrator\ExtractionInterface;
use L37sg0\Architecture\Persistence\Hydrator\HydrationInterface;
use L37sg0\Architecture\Persistence\Hydrator\HydratorInterface;
use L37sg0\Architecture\Persistence\Hydrator\Strategy\DateStrategy;
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

    public function testCanExtractWithAndWithoutStrategy()
    {
        $hydrator = new ClassMethodsHydrator();

        $strategy = new DateStrategy();

        $entity = new DummyEntity();
        $entity->setName('dummy')->setDummyDate(new DateTime('2022-10-13'));

        $actual = $hydrator->addStrategy('dummy_date', $strategy)->extract($entity);
        $expected = [
            'name' => 'dummy',
            'dummy_date' => '2022-10-13'
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testCanHydrateWithAndWithoutStrategy()
    {
        $hydrator = new ClassMethodsHydrator();

        $strategy = new DateStrategy();

        $data = [
            'name' => 'dummy',
            'dummy_date' => '2022-10-13'
        ];

        $actual = $hydrator->addStrategy('dummy_date', $strategy)->hydrate($data, new DummyEntity());

        $expected = new DummyEntity();
        $expected->setName('dummy')->setDummyDate(new DateTime('2022-10-13'));

        $this->assertEquals($expected, $actual);
    }

}
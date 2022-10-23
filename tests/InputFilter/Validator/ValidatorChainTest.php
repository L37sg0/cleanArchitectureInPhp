<?php

namespace Tests\InputFilter\Validator;

use L37sg0\Architecture\Service\Validator\ValidatorChain;
use L37sg0\Architecture\Service\Validator\ValidatorInterface;
use PHPUnit\Framework\TestCase;

class ValidatorChainTest extends TestCase
{
    public function testCanCreateValidatorChain()
    {
        $validatorChain = new ValidatorChain();

        // test if created class is an instance of what it should be
        $this->assertInstanceOf(ValidatorChain::class, $validatorChain);
        $this->assertInstanceOf(ValidatorInterface::class, $validatorChain);

    }
    public function testCreatedClassMessagesAreEmptyArray()
    {
        $validatorChain = new ValidatorChain();
        // test if created class messages are empty array
        $this->assertEquals(array(), $validatorChain->getMessages());

    }

    public function testCouldAttachMultipleValidators() {
        $validatorChain = new ValidatorChain();
        $validator1 = $this->createMock(ValidatorInterface::class);
        
        $validator2 = $this->createMock(ValidatorInterface::class);
        
        // test instantiated validators are instance of ValidatorInterface
        $this->assertInstanceOf(ValidatorInterface::class, $validator1);
        $this->assertInstanceOf(ValidatorInterface::class, $validator2);

        // test 2 diff validators instantiated
        $this->assertNotSame($validator1, $validator2);

        // test if multiple validators could be attached and counted
        $validatorChain->attach($validator1)->attach($validator2);
        $this->assertEquals(2, $validatorChain->count());
    }

    public function testValidatorChainIsValidLogicTrue() {
        $validatorChain = new ValidatorChain();
        $validator1 = $this->createMock(ValidatorInterface::class);
        $validator1->method('isValid')->with('foo')->willReturn(true);
        $validator1->method('getMessages')->willReturn([]);

        $validatorChain->attach($validator1);
        $this->assertEquals(true, $validatorChain->isValid('foo'));
        $this->assertEquals([], $validatorChain->getMessages());
    }

    public function testValidatorChainLogicFalse() {
        $validatorChain = new ValidatorChain();
        $validator2 = $this->createMock(ValidatorInterface::class);
        $validator2->method('isValid')->with('bar')->willReturn(false);
        $validator2->method('getMessages')->willReturn(['bar is not valid.']);
        $validatorChain->attach($validator2);
        $this->assertEquals(false, $validatorChain->isValid('bar'));
        $this->assertEquals([['bar is not valid.']], $validatorChain->getMessages());
    }

}
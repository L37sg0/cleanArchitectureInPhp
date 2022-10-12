<?php

namespace L37sg0\Architecture\Service\InputFilter\Tests;

use L37sg0\Architecture\Service\InputFilter\Input;
use L37sg0\Architecture\Service\InputFilter\InputInterface;
use L37sg0\Architecture\Service\Validator\ValidatorChain;
use L37sg0\Architecture\Service\Validator\ValidatorInterface;
use PHPUnit\Framework\TestCase;

class InputTest extends TestCase
{
    public function testCanCreateInput() {
        $input = new Input('name');

        $this->assertInstanceOf(InputInterface::class, $input);
        $this->assertEquals([], $input->getMessages());
        $this->assertEquals(true, $input->setRequired(true)->getRequired());
        $this->assertEquals(false, $input->setRequired(false)->getRequired());
        $this->assertInstanceOf(ValidatorChain::class, $input->setValidatorChain(new ValidatorChain())->getValidatorChain());
    }

    public function testInputRequiredIsValidLogicTrue() {
        $input1 = $this->createMock(InputInterface::class);
        $input1->method('isValid')->willReturn(true)->with('John Doe');
        $input1->method('getMessages')->willReturn([]);

        $input2 = new Input('name');
        $input2->setRequired(true);

        $this->assertEquals($input1->isValid('John Doe'), $input2->isValid('John Doe'));
        $this->assertEquals($input1->getMessages(), $input2->getMessages());
    }
    
    public function testInputRequiredIsValidLogicFalse() {
        $input1 = $this->createMock(InputInterface::class);
        $input1->method('isValid')->willReturn(false)->with('');
        $input1->method('getMessages')->willReturn([['isEmpty' => 'Value is required and can\'t be empty.']]);

        $input2 = new Input('name');
        $input2->setRequired(true);

        $this->assertEquals($input1->isValid(''), $input2->isValid(''));
        $this->assertEquals($input1->getMessages(), $input2->getMessages());
    }

    public function testInputValidatorChainIsValidLogicTrue()
    {
        $validatorChain = $this->createMock(ValidatorChain::class);
        $validatorChain->method('isValid')->willReturn(true)->with('somevalue');
        $validatorChain->method('getMessages')->willReturn([]);

        $input1 = $this->createMock(InputInterface::class);
        $input1->method('isValid')->willReturn(true)->with('somevalue');
        $input1->method('getMessages')->willReturn([]);

        $input2 = new Input('name');
        $input2->setValidatorChain($validatorChain);

        $this->assertEquals($input1->isValid('somevalue'), $input2->isValid('somevalue'));
        $this->assertEquals($input1->getMessages(), $input2->getMessages());
    }

    public function testInputValidatorChainIsValidLogicFalse()
    {
        $validatorChain = $this->createMock(ValidatorChain::class);
        $validatorChain->method('isValid')->willReturn(false)->with('somevalue');
        $validatorChain->method('getMessages')->willReturn(['Value somevalue is not valid value!']);

        $input1 = $this->createMock(InputInterface::class);
        $input1->method('isValid')->willReturn(false)->with('somevalue');
        $input1->method('getMessages')->willReturn(['Value somevalue is not valid value!']);

        $input2 = new Input('name');
        $input2->setValidatorChain($validatorChain);

        $this->assertEquals($input1->isValid('somevalue'), $input2->isValid('somevalue'));
        $this->assertEquals($input1->getMessages(), $input2->getMessages());
    }

}
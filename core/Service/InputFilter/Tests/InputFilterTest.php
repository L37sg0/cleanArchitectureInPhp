<?php

namespace L37sg0\Architecture\Service\InputFilter\Tests;

use L37sg0\Architecture\Service\InputFilter\Input;
use L37sg0\Architecture\Service\InputFilter\InputFilter;
use L37sg0\Architecture\Service\InputFilter\InputFilterInterface;
use L37sg0\Architecture\Service\Validator\EmailAddress;
use L37sg0\Architecture\Service\Validator\IsFloat;
use PHPUnit\Framework\TestCase;

class InputFilterTest extends TestCase
{
    public function testCanCreateInputFilter() {
        $this->assertInstanceOf(InputFilterInterface::class, (new InputFilter()));
        $this->assertEquals([], (new InputFilter())->getMessages());
        $this->assertEquals([], (new InputFilter())->getInputs());
    }

    public function testIsAddingNewFields() {
        $inputFilter = new InputFilter();
        $inputFilter->add(new Input('name'));

        $this->assertEquals(1, count($inputFilter->getInputs()));

        $inputFilter->add(new Input('age'))->add(new Input('gender'), 'gender');
        $inputFilter->add(new Input('country'));


        $this->assertEquals(4, count($inputFilter->getInputs()));
    }

    public function testIsValidLogicTrue()
    {
        $data = [
            'id' => 1,
            'email' => 'j.d@dom.com',
            'total' => 90.24
        ];

        $errors = [
            'id' => null,
            'email' => null,
            'total' => null
        ];

        $inputFilter = new InputFilter();
        $id = (new Input('id'))->setRequired(true);
        $email = (new Input('email'))->setRequired(true);
        $email->getValidatorChain()->attach(new EmailAddress());
        $total = (new Input('total'))->setRequired(true);
        $total->getValidatorChain()->attach(new IsFloat());

        $inputFilter->add($id)->add($email)->add($total);
        $inputFilter->setData($data);

        $this->assertEquals(true, $inputFilter->isValid());
        $this->assertEquals($errors, $inputFilter->getMessages());

    }

    public function testIsValidLogicFalse()
    {
        $data = [
            'id' => '',
            'email' => 'j.d.dom.com',
            'total' => 'notsofloat'
        ];

        $errors = [
            'id' => ['isEmpty' => 'Value is required and can\'t be empty.'],
            'email' => ['emailNotValid' => 'j.d.dom.com is not a valid email address!'],
            'total' => ['notFloat' => 'The input does not appear to be a float.']
        ];

        $inputFilter = new InputFilter();
        $id = (new Input('id'))->setRequired(true);
        $email = (new Input('email'))->setRequired(true);
        $email->getValidatorChain()->attach(new EmailAddress());
        $total = (new Input('total'))->setRequired(true);
        $total->getValidatorChain()->attach(new IsFloat());

        $inputFilter->add($id)->add($email)->add($total);
        $inputFilter->setData($data);

        $this->assertEquals(false, $inputFilter->isValid());
        $this->assertEquals($errors, $inputFilter->getMessages());

    }
}
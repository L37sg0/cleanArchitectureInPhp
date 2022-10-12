<?php

namespace L37sg0\Architecture\Service\InputFilter\Tests;

use L37sg0\Architecture\Service\InputFilter\Input;
use L37sg0\Architecture\Service\InputFilter\InputFilter;
use L37sg0\Architecture\Service\InputFilter\InputInterface;
use L37sg0\Architecture\Service\Validator\EmailAddress;
use L37sg0\Architecture\Service\Validator\IsFloat;
use PHPUnit\Framework\TestCase;

class InputFilterTest extends TestCase
{
    public function testCanCreateInputFilter() {
        $this->assertInstanceOf(InputInterface::class, (new InputFilter()));
        $this->assertEquals([], (new InputFilter())->getMessages());
        $this->assertEquals([], (new InputFilter())->getFields());
    }

    public function testIsAddingNewFields() {
        $inputFilter = new InputFilter();
        $inputFilter->add(new Input('name'));

        $this->assertEquals(1, count($inputFilter->getFields()));

        $inputFilter->add(new Input('age'))->add(new Input('gender'), 'gender');
        $inputFilter->add(new Input('country'));


        $this->assertEquals(4, count($inputFilter->getFields()));
    }
    
    public function testIsValidLogicTrue() {
        $data = [
            'id' => 1,
            'email' => 'j.d@dom.com',
            'total' => 90.24,
            'customer' => [
                'id' => 1
            ]
        ];
        
        $errors = [
            'id'    => null,
            'email' => null,
            'total' => null,
            'customer' => null
        ];
        
        $inputFilter = new InputFilter();
        $id     = (new Input('id'))->setRequired(true);
        $email  = (new Input('email'))->setRequired(true);
        $email->getValidatorChain()->attach(new EmailAddress());
        $total  = (new Input('total'))->setRequired(true);
        $total->getValidatorChain()->attach(new IsFloat());


        $customer = (new InputFilter());
        $customerId = (new Input('id'))
            ->setRequired(true);
        $customer->add($customerId);

        $inputFilter->add($id)->add($email)->add($total)->add($customer, 'customer');
        $inputFilter->setData($data);
var_dump($inputFilter->getFields());exit();
        $this->assertEquals(true, $inputFilter->isValid());
        $this->assertEquals($errors, $inputFilter->getMessages());
        
    }
}
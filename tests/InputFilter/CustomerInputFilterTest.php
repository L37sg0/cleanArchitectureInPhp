<?php

namespace Tests\InputFilter;

use L37sg0\Architecture\Service\InputFilter\CustomerInputFilter;
use PHPUnit\Framework\TestCase;
use Tests\InputFilter\Domain\Entity\Customer;
use Tests\InputFilter\Domain\Repository\CustomerRepositoryInterface;

class CustomerInputFilterTest extends TestCase
{
    public function testShouldRequireName() {
        $repository = $this->createMock(CustomerRepositoryInterface::class);
        $inputFilter = new CustomerInputFilter($repository);
        $error['isEmpty'] = 'Value is required and can\'t be empty.';

        $isValid = $inputFilter->isValid();
        $messages = $inputFilter->getMessages();

        $this->assertEquals(false, $isValid);
        $this->assertEquals($error, $messages['name'][0]);
    }

    public function testShouldRequireEmail() {
        $repository = $this->createMock(CustomerRepositoryInterface::class);
        $inputFilter = new CustomerInputFilter($repository);
        $error['isEmpty'] = 'Value is required and can\'t be empty.';

        $isValid = $inputFilter->isValid();
        $messages = $inputFilter->getMessages();

        $this->assertEquals(false, $isValid);
        $this->assertEquals($error, $messages['email'][0]);
    }

    public function testShouldRequireValidEmail() {
        $repository = $this->createMock(CustomerRepositoryInterface::class);
        $inputFilter = new CustomerInputFilter($repository);

        $scenarios = [
            [
                'value' => 'bob',
                'errors' => []
            ],
            [
                'value' => 'bob@bob',
                'errors' => []
            ],
            [
                'value' => 'bob@bob.com',
                'errors' => null
            ]
        ];
        foreach ($scenarios as $scenario) {
            $inputFilter->setData([
                'email' => $scenario['value']
            ])->isValid();
            $messages = $inputFilter
                ->getMessages()['email'];
            if (is_array($messages)) {
                $this->assertIsArray($messages);
                $this->assertTrue(!empty($messages));
            } else {
                $this->assertEquals(null, $messages);
            }
        }
    }

//    public function testShouldRequireUniqueEmail() {
////        $dataUnique = ['email' =>'bob@bbb.com'];
//        $dataNotUnique = ['name'=> 'biily bob', 'email' => 'billy.bob@bbb.com'];
//
//        $repository = $this->createMock(CustomerRepositoryInterface::class);
//
////        $repository->method('getBy')->willReturn([])->with($dataUnique);
////        $inputFilter1 = new CustomerInputFilter($repository);
////        $inputFilter1->setData($dataUnique);
//
////        $this->assertTrue($inputFilter1->isValid());
////        $this->assertEquals([[]], $inputFilter1->getMessages());
//
//        $repository->method('getBy')->willReturn([new Customer()])->with($dataNotUnique);
//        $inputFilter2 = new CustomerInputFilter($repository);
//        $inputFilter2->setData($dataNotUnique);
//
////        $this->assertFalse($inputFilter2->isValid());
//        $inputFilter2->isValid();
//        $this->assertEquals([['entityNotUnique' => 'Customer with such email already exist.']], $inputFilter2->getMessages());
//
//    }
}
<?php

use L37sg0\Architecture\Service\InputFilter\OrderInputFilter;

describe('InputFilter\Order', function () {
    beforeEach(function () {
        $this->inputFilter = new OrderInputFilter();
    });

    describe('->isValid()', function () {
        it('1. Should require a customer id.', function () {
            $isValid= $this->inputFilter->isValid();

            $error = [
                'id' => [
                    'isEmpty' => 'Value is required and can\'t be empty.'
                ]
            ];

            $customer = $this->inputFilter
                ->getMessages()['customer'];

            assert($isValid === false);
            assert($customer === $error);
        });

        it('2. Should require an order number.', function () {
            $isValid = $this->inputFilter->isValid();

            $error = [
                'isEmpty' => 'Value is required and can\'t be empty.'
            ];

            $orderNo = $this->inputFilter
                ->getMessages()['orderNumber'];

            assert($isValid === false);
            assert($orderNo === $error);
        });

        it('3. Should require order numbers be 13 chars long.', function () {
            $scenarios = [
                [
                    'value' => '124',
                    'errors' => [
                        'stringLengthTooShort' =>
                            'The input is less than 13 characters long.'
                    ]
                ],
                [
                    'value' => '20001020-0123XR',
                    'errors' => [
                        'stringLengthTooLong' =>
                            'The input is more than 13 characters long.'
                    ]
                ],
                [
                    'value' => '20040717-1841',
                    'errors' => null
                ]
            ];

            foreach ($scenarios as $scenario) {
                $this->inputFilter = new OrderInputFilter();
                $this->inputFilter->setData([
                    'orderNumber' => $scenario['value']
                ])->isValid();

                $messages = $this->inputFilter
                    ->getMessages()['orderNumber'];

                assert($messages === $scenario['errors']);
            }
        });

        it('4. Should require a description.', function () {
            $isValid = $this->inputFilter->isValid();

            $error = [
                'isEmpty' => 'Value is required and can\'t be empty.'
            ];

            $messages = $this->inputFilter
                ->getMessages()['description'];

            assert($isValid === false);
            assert($messages === $error);
        });

        it('5. Should require a total.', function () {
            $isValid = $this->inputFilter->isValid();

            $error = [
                'isEmpty' => 'Value is required and can\'t be empty.'
            ];

            $messages = $this->inputFilter
                ->getMessages()['total'];

            assert($isValid === false);
            assert($messages === $error);
        });

        it('6. Should require a total to be a float value.', function () {
            $scenarios = [
                [
                    'value' => 124,
                    'errors' => null
                ],
                [
                    'value' => 'asdf',
                    'errors' => [
                        'notFloat'
                        => 'The input does not appear to be a float.'
                    ]
                ],
                [
                    'value' => 99.99,
                    'errors' => null
                ]
            ];

            foreach ($scenarios as $scenario) {
                $this->inputFilter = new OrderInputFilter();
                $this->inputFilter->setData([
                    'total' => $scenario['value']
                ])->isValid();

                $messages = $this->inputFilter
                    ->getMessages()['total'];

                assert($messages === $scenario['errors']);
            }
        });
    });
});
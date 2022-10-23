<?php

use L37sg0\Architecture\Service\InputFilter\CustomerInputFilter;

describe('InputFilter\Customer', function () {
    beforeEach(function () {
        $this->inputFilter = new CustomerInputFilter();
    });

    describe('->isValid()', function () {
        it('1. Should require a name.', function () {
            $isValid = $this->inputFilter->isValid();

            $error = [
                'isEmpty' => 'Value is required and can\'t be empty.'
            ];

            $messages = $this->inputFilter->getMessages()['name'];

            assert($isValid === false);
            assert($messages === $error);
        });

        it('2. Should require an email.', function () {
            $isValid = $this->inputFilter->isValid();

            $error = [
                'isEmpty' => 'Value is required and can\'t be empty.'
            ];

            $messages = $this->inputFilter->getMessages()['email'];

            assert($isValid === false);
            assert($messages === $error);
        });

        it('3. Should require a valid email.', function () {
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
                $this->inputFilter->setData([
                    'email' => $scenario['value']
                ])->isValid();
                $messages = $this->inputFilter
                    ->getMessages()['email'];
                if (is_array($messages)) {
                    assert(is_array($messages));
                    assert(!empty($messages));
                } else {
                    assert($messages === null);
                }
            }
        });
    });
});
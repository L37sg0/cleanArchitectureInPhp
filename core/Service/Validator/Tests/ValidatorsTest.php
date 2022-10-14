<?php

namespace L37sg0\Architecture\Service\Validator\Tests;

use L37sg0\Architecture\Service\Validator\EmailAddress;
use L37sg0\Architecture\Service\Validator\IsFloat;
use L37sg0\Architecture\Service\Validator\StringLength;
use L37sg0\Architecture\Service\Validator\ValidatorInterface;
use PHPUnit\Framework\TestCase;

class ValidatorsTest extends TestCase
{
    public function testEmailValidatorTrue() {
        $emailValidator1 = $this->createMock(ValidatorInterface::class);
        $emailValidator1->method('isValid')->willReturn(true)->with('jd@yahoo.com');
        $emailValidator1->method('getMessages')->willReturn([]);

        $emailValidator2 = new EmailAddress();

        $this->assertEquals($emailValidator1->isValid('jd@yahoo.com'), $emailValidator2->isValid('jd@yahoo.com'));
        $this->assertEquals($emailValidator1->getMessages(), $emailValidator2->getMessages());
    }

    public function testEmailValidatorFalse() {
        $emailValidator1 = $this->createMock(ValidatorInterface::class);
        $emailValidator1->method('isValid')->willReturn(false)->with('jd.yahoo.com');
        $emailValidator1->method('getMessages')->willReturn(['emailNotValid' => 'jd.yahoo.com is not a valid email address.']);

        $emailValidator2 = new EmailAddress();

        $this->assertEquals($emailValidator1->isValid('jd.yahoo.com'), $emailValidator2->isValid('jd.yahoo.com'));
        $this->assertEquals($emailValidator1->getMessages(), $emailValidator2->getMessages());
    }

    public function testIsFloatValidatorTrue()
    {
        $isFloatValidator1 = $this->createMock(ValidatorInterface::class);
        $isFloatValidator1->method('isValid')->willReturn(true)->with(1.45);
        $isFloatValidator1->method('getMessages')->willReturn([]);

        $isFloatValidator2 = new IsFloat();

        $this->assertEquals($isFloatValidator1->isValid(1.45), $isFloatValidator2->isValid(2.24));
        $this->assertEquals($isFloatValidator1->isValid(1.45), $isFloatValidator2->isValid(2));
        $this->assertEquals($isFloatValidator1->isValid(1.45), $isFloatValidator2->isValid('2'));
        $this->assertEquals($isFloatValidator1->isValid(1.45), $isFloatValidator2->isValid('2.45'));
        $this->assertEquals($isFloatValidator1->getMessages(), $isFloatValidator2->getMessages());
    }

    public function testIsFloatValidatorFalse()
    {
        $isFloatValidator1 = $this->createMock(ValidatorInterface::class);
        $isFloatValidator1->method('isValid')->willReturn(false)->with('string');
        $isFloatValidator1->method('getMessages')->willReturn(['notFloat' => 'The input does not appear to be a float.']);

        $isFloatValidator2 = new IsFloat();

        $this->assertEquals($isFloatValidator1->isValid('string'), $isFloatValidator2->isValid('string'));
        $this->assertEquals($isFloatValidator1->getMessages(), $isFloatValidator2->getMessages());
    }

    public function testStringLengthValidatorTrue()
    {
        $stringLengthValidator1 = $this->createMock(ValidatorInterface::class);
        $stringLengthValidator1->method('isValid')->willReturn(true)->with('1234abcd');
        $stringLengthValidator1->method('getMessages')->willReturn([]);

        $stringLengthValidator2 = new StringLength(['min' => 8, 'max' => 13]);

        $this->assertEquals($stringLengthValidator1->isValid('1234abcd'), $stringLengthValidator2->isValid('1234abcd'));
        $this->assertEquals($stringLengthValidator1->getMessages(), $stringLengthValidator2->getMessages());
    }

    public function testStringLengthValidatorFalse()
    {
        $stringLengthValidator1 = $this->createMock(ValidatorInterface::class);
        $stringLengthValidator1->method('isValid')->willReturn(false)->with('1234abc');
        $stringLengthValidator1->method('getMessages')->willReturn(['stringLengthTooShort' => 'The input is less than 8 characters long.']);

        $stringLengthValidator2 = new StringLength(['min' => 8, 'max' => 13]);

        $this->assertEquals($stringLengthValidator1->isValid('1234abc'), $stringLengthValidator2->isValid('1234abc'));
        $this->assertEquals($stringLengthValidator1->getMessages(), $stringLengthValidator2->getMessages());
    }
}
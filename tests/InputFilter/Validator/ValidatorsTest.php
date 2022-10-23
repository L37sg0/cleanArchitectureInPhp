<?php

namespace Tests\InputFilter\Validator;

use L37sg0\Architecture\Service\Validator\EmailAddress;
use L37sg0\Architecture\Service\Validator\EntityExist;
use L37sg0\Architecture\Service\Validator\EntityUnique;
use L37sg0\Architecture\Service\Validator\IsFloat;
use L37sg0\Architecture\Service\Validator\StringLength;
use L37sg0\Architecture\Service\Validator\ValidatorInterface;
use PHPUnit\Framework\TestCase;
use Tests\InputFilter\Domain\Entity\AbstractEntity;
use Tests\InputFilter\Domain\Repository\RepositoryInterface;

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

    public function testCanCreateEntityExistValidator() {
        $repository = $this->createMock(RepositoryInterface::class);
        $actual = new EntityExist('id', $repository);
        $expected = ValidatorInterface::class;
        $expected2 = EntityExist::class;
        
        $this->assertInstanceOf($expected, $actual);
        $this->assertInstanceOf($expected2, $actual);
    }

    public function testEntityExistValidatorTrue() {
        $entity = $this->createMock(AbstractEntity::class);
        $repository = $this->createMock(RepositoryInterface::class);
        $repository->method('getBy')->with(['id' => 1])->willReturn([$entity]);

        $validator = new EntityExist('id', $repository);
        $this->assertEquals(true, $validator->isValid(1));
        $this->assertEquals([], $validator->getMessages());
    }

    public function testEntityExistValidatorFalse() {
        $repository = $this->createMock(RepositoryInterface::class);
        $repository->method('getBy')->with(['id' => 1])->willReturn([]);

        $validator = new EntityExist('id', $repository);
        $validator2 = new EntityExist('id', $repository, 'uSer');

        $this->assertEquals(false, $validator->isValid(1));
        $this->assertEquals(['entityNotValid' => 'Entity with such id does not exist.'], $validator->getMessages());
        $this->assertEquals(false, $validator2->isValid(1));
        $this->assertEquals(['entityNotValid' => 'User with such id does not exist.'], $validator2->getMessages());
    }

    public function testCanCreateEntityUniqueValidator()
    {
        $repository = $this->createMock(RepositoryInterface::class);
        $actual = new EntityUnique('email', $repository);
        $expected = ValidatorInterface::class;
        $expected2 = EntityUnique::class;

        $this->assertInstanceOf($expected, $actual);
        $this->assertInstanceOf($expected2, $actual);
    }

    public function testEntityUniqueValidatorTrue()
    {
        $repository = $this->createMock(RepositoryInterface::class);
        $repository->method('getBy')->with(['email' => 'john.wick@abudabi.com'])->willReturn([]);

        $validator = new EntityUnique('email', $repository);
        $this->assertEquals(true, $validator->isValid('john.wick@abudabi.com'));
        $this->assertEquals([], $validator->getMessages());
    }

    public function testEntityUniqueValidatorFalse()
    {
        $entity = $this->createMock(AbstractEntity::class);
        $repository = $this->createMock(RepositoryInterface::class);
        $repository->method('getBy')->with(['email' => 'john.wick@abudabi.com'])->willReturn([$entity]);

        $validator = new EntityUnique('email', $repository);
        $validator2 = new EntityUnique('email', $repository, 'uSer');

        $this->assertEquals(false, $validator->isValid('john.wick@abudabi.com'));
        $this->assertEquals(['entityNotUnique' => 'Entity with such email already exist.'], $validator->getMessages());
        $this->assertEquals(false, $validator2->isValid('john.wick@abudabi.com'));
        $this->assertEquals(['entityNotUnique' => 'User with such email already exist.'], $validator2->getMessages());
    }
}
<?php

use L37sg0\Architecture\Persistence\Hydrator\Strategy\DateStrategy;

describe(DateStrategy::class, function () {
    beforeEach(function () {
        $this->strategy = new DateStrategy();
    });

    describe('->hydrate()', function () {
        it('1. Should turn string date into a DateTime object.', function () {
            $value = '2022-10-01';
            $obj = $this->strategy->hydrate($value);

            assert($obj->format('Y-m-d') === $value, 'incorrect datetime');
        });
    });

    describe('->extract()', function () {
        it('2. Should turn the DateTime object into a string', function () {
            $value = new DateTime('2022-10-01');
            $string = $this->strategy->extract($value);

            assert($string === $value->format('Y-m-d'));
        });
    });
});
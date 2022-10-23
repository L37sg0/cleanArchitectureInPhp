<?php

namespace Tests\Persistence\Hydrator;

use DateTime;

class DummyEntity
{
    protected $name;

    protected $date;

    public function setName(string $name) {
        $this->name = $name;
        return $this;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setDummyDate(DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    public function getDummyDate(): DateTime
    {
        return $this->date;
    }
}
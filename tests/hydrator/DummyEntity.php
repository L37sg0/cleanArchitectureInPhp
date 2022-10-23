<?php

namespace Tests\hydrator;

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

    public function setDate(DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }
}
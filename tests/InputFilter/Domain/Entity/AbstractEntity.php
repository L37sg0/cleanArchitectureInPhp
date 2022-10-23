<?php

namespace Tests\InputFilter\Domain\Entity;

class AbstractEntity
{
    protected $id;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

}
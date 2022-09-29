<?php

namespace L37sg0\Architecture\Domain\Entity;

class AbstractEntity
{
    protected $id;

    public function getId() {
        return $this->id;
    }

    public function setId(int $id): AbstractEntity {
        $this->id = $id;
        return $this;
    }

}
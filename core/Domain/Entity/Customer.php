<?php

namespace L37sg0\Architecture\Domain\Entity;

class Customer extends AbstractEntity
{
    protected $name;

    protected $email;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

}
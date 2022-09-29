<?php

namespace L37sg0\Architecture\Domain\Entity;

class Customer extends AbstractEntity
{
    protected $name;

    protected $email;

    public function getName() {
        return $this->name;
    }

    public function setName(string $name): Customer {
        $this->name = $name;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail(string $email): Customer
    {
        $this->email = $email;
        return $this;
    }

}
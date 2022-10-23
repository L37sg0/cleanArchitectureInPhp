<?php

namespace Tests\InputFilter\Domain\Entity;

class Order extends AbstractEntity
{
    protected $customer;
    protected $orderNumber;
    protected $description;
    protected $total;

    public function getCustomer() {
        return $this->customer;
    }

    public function setCustomer($customer) {
        $this->customer = $customer;
        return $this;
    }

    public function getOrderNumber() {
        return $this->orderNumber;
    }

    public function setOrderNumber($orderNumber) {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
        return $this;
    }
}
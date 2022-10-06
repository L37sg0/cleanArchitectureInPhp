<?php

namespace L37sg0\Architecture\Persistence\Zend\TableGateway;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Hydrator\HydratorInterface;

class TableGatewayFactory
{
    public function createGateway(
        Adapter $dbAdapter,
        HydratorInterface $hydrator,
        $object,
        $table
    ) {
        $resultSet = new HydratingResultSet($hydrator, $object);
        return new TableGateway($table, $dbAdapter, null, $resultSet);
    }
}
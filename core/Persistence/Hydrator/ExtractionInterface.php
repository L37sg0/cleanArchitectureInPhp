<?php

namespace L37sg0\Architecture\Persistence\Hydrator;

interface ExtractionInterface
{
    /**
     * Extract values from an object
     *
     * @param object $object
     * @return array
     */
    public function extract($object);

}
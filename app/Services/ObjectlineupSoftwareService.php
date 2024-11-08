<?php

namespace App\Services;

use App\Repositories\ObjectlineupSoftwareRepository;

class ObjectlineupSoftwareService
{
    protected $objectlineupSoftwareRepository;

    public function __construct(ObjectlineupSoftwareRepository $objectlineupSoftwareRepository)
    {
        $this->objectlineupSoftwareRepository = $objectlineupSoftwareRepository;
    }

    public function findBy($field, $operator, $value)
    {
        return $this->objectlineupSoftwareRepository->findBy($field, $operator, $value);
    }

    public function createOrUpdate($id, $softwareId)
    {
        return $this->objectlineupSoftwareRepository->createOrUpdate($id, $softwareId);
    }
}
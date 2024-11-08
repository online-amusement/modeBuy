<?php

namespace App\Services;

use App\Repositories\ObjectRepository;

class ObjectService
{
    protected $objectRepository;

    public function __construct(ObjectRepository $objectRepository)
    {
        $this->objectRepository = $objectRepository;
    }

    public function search($objectId, $name, $amount, $started_at, $ended_at, $sort)
    {
        return $this->objectRepository->search($objectId, $name, $amount, $started_at, $ended_at, $sort);
    }

    public function findBy($field, $operator, $value)
    {
        return $this->objectRepository->findBy($field, $operator, $value);
    }

    public function createOrUpdate($id, $name, $description, $amount, $previewFile, $downloadFile)
    {
        return $this->objectRepository->createOrUpdate($id, $name, $description, $amount, $previewFile, $downloadFile);
    }

    public function deleteObject($id)
    {
        return $this->objectRepository->deleteObject($id);
    }

    public function getObjectLineUp()
    {
        return $this->objectRepository->getObjectLineUp();
    }
}
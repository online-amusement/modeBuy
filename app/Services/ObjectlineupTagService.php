<?php

namespace App\Services;

use App\Repositories\ObjectlineupTagRepository;

class ObjectlineupTagService
{
    protected $objectlineupTagRepository;

    public function __construct(ObjectlineupTagRepository $objectlineupTagRepository)
    {
        $this->objectlineupTagRepository = $objectlineupTagRepository;
    }

    public function findBy($field, $operator, $value)
    {
        return $this->objectlineupTagRepository->findBy($field, $operator, $value);
    }

    public function createOrUpdate($id, $tagId)
    {
        return $this->objectlineupTagRepository->createOrUpdate($id, $tagId);
    }
}
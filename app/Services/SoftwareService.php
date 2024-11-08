<?php

namespace App\Services;

use App\Repositories\SoftwareRepository;

class SoftwareService
{
    protected $softwareRepository;

    public function __construct(SoftwareRepository $softwareRepository)
    {
        $this->softwareRepository = $softwareRepository;
    }

    public function findBy($field, $operator, $value)
    {
        return $this->softwareRepository->findBy($field, $operator, $value);
    }

    public function softwareCategories()
    {
        return $this->softwareRepository->softwareCategories();
    }
}
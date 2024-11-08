<?php

namespace App\Repositories;

use App\Models\Software;

class SoftwareRepository
{
    protected $software;

    public function __construct(Software $software)
    {
        $this->software = $software;
    }

    public function findBy($field, $operator, $value)
    {
        return $this->software
            ->newQuery()
            ->where($field, $operator, $value);
    }

    public function softwareCategories()
    {
        return $this->software
            ->newQuery()
            ->get();
    }
}
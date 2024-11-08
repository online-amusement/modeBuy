<?php

namespace App\Repositories;

use App\Models\ObjectLineupSoftware;

class ObjectlineupSoftwareRepository
{
    protected $objectLineupSoftware;

    public function __construct(ObjectLineupSoftware $objectLineupSoftware)
    {
        $this->objectLineupSoftware = $objectLineupSoftware;
    }

    public function findBy($field, $operator, $value)
    {
        return $this->objectLineupSoftware
            ->newQuery()
            ->where($field, $operator, $value);
    }

    public function createOrUpdate($id, $softwareId)
    {
        return $this->objectLineupSoftware
            ->newQuery()
            ->updateOrCreate(
                [
                    "id" => $id
                ],
                [
                    "object_lineup_id" => $id,
                    "software_id" => implode($softwareId)
                ]
            );
    }
}
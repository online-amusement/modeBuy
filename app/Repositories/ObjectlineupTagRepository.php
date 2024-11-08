<?php

namespace App\Repositories;

use App\Models\ObjectLineupTag;

class ObjectlineupTagRepository
{
    protected $objectLineupTag;

    public function __construct(ObjectLineupTag $objectLineupTag)
    {
        $this->objectLineupTag = $objectLineupTag;
    }

    public function findBy($field, $operator, $value)
    {
        return $this->objectLineupTag
            ->newQuery()
            ->where($field, $operator, $value);
    }

    public function createOrUpdate($id, $tagId)
    {
        return $this->objectLineupTag
            ->newQuery()
            ->updateOrCreate(
                [
                    "id" => $id
                ],
                [
                    "object_lineup_id" => $id,
                    "tag_id" => implode($tagId)
                ]
                );
    }
}
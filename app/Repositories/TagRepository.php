<?php

namespace App\Repositories;
use App\Models\Tag;

class TagRepository {

    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function findBy($field, $operator, $value)
    {
        return $this->tag
            ->newQuery()
            ->where($field, $operator, $value);
    }

    public function tagCategories()
    {
        return $this->tag
            ->newQuery()
            ->get();
    }

    public function createOrUpdate($id, $tagId)
    {
        return $this->tag
            ->newQuery()
            ->updateOrCreate(
                [
                    "id" => $id
                ],
                [
                    "object_lineup_id" => $id,
                    "tag_id" => $tagId
                ]
                );
    }
}
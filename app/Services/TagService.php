<?php

namespace App\Services;

use App\Repositories\TagRepository;

class TagService
{
    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        return $this->tagRepository = $tagRepository;
    }

    public function findBy($field, $operator, $value)
    {
        return $this->tagRepository->findBy($field, $operator, $value);
    }

    public function tagCategories()
    {
        return $this->tagRepository->tagCategories();
    }
}
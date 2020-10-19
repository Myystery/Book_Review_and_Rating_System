<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    /**
     * @param $title
     *
     * @return object|\stdClass
     */
    public function store($title)
    {
        return Category::create([
            'title' => $title,
            'slug'  => str_slug($title),
        ]);
    }
}
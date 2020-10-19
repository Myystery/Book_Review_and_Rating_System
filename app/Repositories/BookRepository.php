<?php

namespace App\Repositories;

use App\Models\Book;
use Exception;
use stdClass;

class BookRepository
{

    /**
     * @param $params
     *
     * @return Book|object|stdClass
     * @throws Exception
     */
    public function store($params)
    {
        if (Book::exists(['isbn' => $params['isbn']])) {
            throw new Exception("There's another book with the same ISBN");
        }

        try {
            $params['cover']  = request()->file('cover')->store('images');
            $params['sample'] = request()->file('sample')->store('files');

            $params['publisher_id'] = auth()->id();

            $params['added_at'] = date('Y-m-d');

            return Book::create($params);
        } catch (Exception $e) {
            storage()->delete($params['cover']);
            storage()->delete($params['sample']);
            throw $e;
        }
    }
}
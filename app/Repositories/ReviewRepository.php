<?php

namespace App\Repositories;

use App\Models\Review;

class ReviewRepository
{
    /**
     * @param $params
     *
     * @return object|\stdClass|Review
     */
    public function store($params)
    {
        $params['user_id']  = auth()->id();
        $params['added_at'] = date('Y-m-d H:i:s');

        return Review::create($params);
    }
}

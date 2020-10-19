<?php

namespace App\Models;

/**
 * @property int id
 * @property int user_id
 * @property int book_id
 * @property string comment
 * @property int rating
 * @property string added_at
 * @property string analysis
 * @property mixed|null attachment
 */
class Review extends Model
{
    protected static $table = 'reviews';
    protected static $formats = [
        'comment' => 's',
        'rating'  => 'i',
        'score'   => 'i',
        'date'    => 's',
    ];

    /**
     * @return object|\stdClass|User
     */
    public function user()
    {
        return User::find(['id' => $this->user_id]);
    }

    /**
     * @return object
     */
    public function getAnalysis()
    {
        return json_decode($this->analysis);
    }
}

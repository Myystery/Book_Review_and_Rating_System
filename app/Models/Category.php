<?php

namespace App\Models;

/**
 * @property int id
 * @property string title
 * @property string slug
 */
class Category extends Model
{
    protected static $table = 'categories';
    protected static $format = [
        'title' => 's',
        'slug'  => 's'
    ];

    /**
     *
     */
    public function deleted()
    {
        $this->query("DELETE FROM book_categories WHERE category_id={$this->id}");
    }

    /**
     *
     */
    public function books()
    {
        $books = $this->query("");
    }
}

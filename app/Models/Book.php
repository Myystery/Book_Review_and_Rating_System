<?php

namespace App\Models;

/**
 * Class Book
 * @package App\Models
 *
 * @property int id
 * @property int author_id
 * @property int publisher_id
 * @property string title
 * @property string isbn
 * @property string cover
 * @property string sample
 * @property string summary
 * @property string edition
 * @property string country
 * @property string language
 * @property string added_at
 * @property int no_of_pages
 * @property \DateTime added_date
 */
class Book extends Model
{
    private static $categories = null;
    protected static $table = 'books';
    protected static $formats = [
        'author_id'    => 'i',
        'publisher_id' => 'i',
        'title'        => 's',
        'isbn'         => 's',
        'cover'        => 's',
        'sample'       => 's',
        'summary'      => 's',
        'edition'      => 's',
        'country'      => 's',
        'language'     => 's',
        'added_at'     => 's',
    ];

    /**
     * @return User|object|\stdClass|null
     */
    public function author()
    {
        return User::find(['id' => $this->author_id]) ?: new User;
    }

    /**
     * @return User|object|\stdClass
     */
    public function publisher()
    {
        return User::find(['id' => $this->publisher_id]) ?: new User;
    }

    /**
     * @return string
     */
    public function url()
    {
        return route('/books/' . $this->id);
    }

    /**
     * @return float
     */
    public function reviewScore()
    {
        $result = $this->query("SELECT AVG(rating) as score FROM reviews WHERE book_id={$this->id}");
        $row    = $result->fetch_object();

        return ceil($row->score);
    }

    /**
     * Get list of reviews
     */
    public function reviews()
    {
        return Review::select(['book_id' => $this->id]);
    }

    /**
     * @param $categories
     */
    public function syncCategories($categories)
    {
        $this->query("DELETE FROM book_categories WHERE book_id={$this->id}");

        $values = [];
        foreach ($categories as $category) {
            $values[] = "($this->id, $category)";
        }

        $this->query("INSERT INTO book_categories (book_id, category_id) VALUES " . implode(', ', $values));

        static::$categories = null;
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        if ( ! $this->id) {
            return [];
        }
        if ( ! static::$categories) {
            static::$categories = [];
            $result             = $this->query("SELECT categories.* FROM categories INNER JOIN book_categories ON book_categories.category_id = categories.id INNER JOIN books ON books.id = book_categories.book_id WHERE books.id={$this->id}");
            while ($row = $result->fetch_object(Category::class)) {
                static::$categories[] = $row;
            }
        }

        return static::$categories;
    }

    /**
     * @param $slug
     *
     * @return bool
     */
    public function hasCategory($slug)
    {
        return count(array_filter($this->getCategories(), function (Category $category) use ($slug) {
                return $category->slug === $slug;
            })) > 0;
    }

    /**
     *
     */
    public function deleted()
    {
        if ($this->cover) {
            storage()->delete($this->cover);
        }

        if ($this->sample) {
            storage()->delete($this->sample);
        }

        $this->query("DELETE FROM book_categories WHERE book_id={$this->id}");
        $this->query("DELETE FROM monthly_top WHERE book_id={$this->id}");

        /** @var Review[] $reviews */
        $reviews = Review::select(['book_id' => $this->id]);
        foreach ($reviews as $review) {
            $review->delete();
        }
    }

    /**
     * <summary>
     * Searches for book in the database based on given parameters
     * </summary>
     *
     * @param null|string $q
     * @param array $authors
     * @param array $publishers
     * @param array $categories
     *
     * @return Book[]
     */
    public static function search($q = null, $authors = [], $publishers = [], $categories = [])
    {
        $query = 'SELECT DISTINCT books.*, AVG(reviews.rating) as avg_rating, AVG(reviews.score) as avg_score FROM books LEFT JOIN reviews ON reviews.book_id = books.id INNER JOIN users ON (users.id = books.author_id OR users.id=books.publisher_id) INNER JOIN book_categories ON book_categories.book_id = books.id INNER JOIN categories ON categories.id = book_categories.category_id';

        $where = [];
        if ($q) {
            $where[] = "books.title LIKE '%{$q}%'";
        }
        if (count($authors) > 0) {
            foreach ($authors as $author) {
                $where[] = "(users.slug LIKE '%{$author}%' AND users.role='author')";
            }
        }
        if (count($publishers) > 0) {
            foreach ($publishers as $publisher) {
                $where[] = "(users.slug LIKE '%{$publisher}%' AND users.role='publisher')";
            }
        }
        if (count($categories) > 0) {
            foreach ($categories as $category) {
                $where[] = "categories.slug LIKE '%{$category}%'";
            }
        }
        if (count($where) > 0) {
            $query .= ' WHERE ' . implode(' OR ', $where);
        }

        $query .= ' GROUP BY books.id ORDER BY avg_rating DESC, avg_score DESC';

        $results = static::query($query);
        $books   = [];
        while ($book = $results->fetch_object(static::class)) {
            $books[] = $book;
        }

        return $books;
    }
}

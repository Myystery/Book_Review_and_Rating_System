<?php

namespace App\Support;

class Cron
{
    /**
     *
     */
    public function run()
    {
        $tops = monthly_top();
        if (count($tops) === 0) {
            $this->recalculate();
        }
    }

    /**
     *
     */
    private function recalculate()
    {
        /** @var DB $db */
        $db = app('db');

        $results = $db->query("SELECT books.id, AVG(reviews.rating) as avg_rating, AVG(reviews.score) as avg_score FROM books INNER JOIN reviews ON reviews.book_id = books.id GROUP BY books.id ORDER BY avg_rating DESC, avg_score DESC LIMIT 3");
        while ($row = $results->fetch_object()) {
            monthly_top($row->id);
        }
    }
}

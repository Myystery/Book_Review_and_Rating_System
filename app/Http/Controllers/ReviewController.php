<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use App\Repositories\ReviewRepository;
use App\Support\SentimentAnalyzer;

class ReviewController
{
    /**
     * @param Book $book
     *
     * @return \App\Support\Redirect
     */
    public function store(Book $book)
    {
        $comment  = request()->get('comment');
        $rating   = request()->get('rating');
        $analysis = SentimentAnalyzer::analyze($comment);

        $sign = $analysis['category'] === 'pos' ? 1 : ($analysis['category'] === 'neg' ? -1 : 0);

        $score = $sign * $analysis['score'][$analysis['category']] * 1000;

        $params = [
            'book_id' => $book->id,
            'comment' => $comment,
            'rating'  => $rating,
            'score'   => $score,
        ];

        if (request()->has('attachment')) {
            try {
                $file                 = request()->file('attachment')->store('images');
                $params['attachment'] = $file;
            } catch (\Exception $e) {
                return redirect()->back()->with(['comment' => $comment]);
            }
        }
        $repository = new ReviewRepository();
        $repository->store($params);

        return redirect()->back();
    }

    public function update(Review $review)
    {

    }

    /**
     * @param Book $book
     * @param Review $review
     *
     * @return \App\Support\Redirect
     */
    public function delete(Book $book, Review $review)
    {
        auth()->user()->authorize('delete', $review);

        if ($review->attachment) {
            storage()->delete($review->attachment);
        }
        $review->delete();

        return redirect()->back();
    }
}
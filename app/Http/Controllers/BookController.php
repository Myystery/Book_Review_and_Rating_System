<?php

namespace App\Http\Controllers;

use App\Exceptions\ViewNotFoundException;
use App\Models\Book;
use App\Models\User;
use App\Repositories\BookRepository;
use App\Support\Redirect;
use App\Support\Session;
use App\Support\View;
use Exception;

class BookController
{
    /**
     * @return View
     * @throws ViewNotFoundException
     */
    public function index()
    {
        $query      = request()->get('q', null);
        $authors    = request()->get('author', []);
        $publishers = request()->get('publisher', []);
        $categories = request()->get('category', []);

        $books = Book::search($query, $authors, $publishers, $categories);

        // make a query

        return view('books.index', ['books' => $books]);
    }

    /**
     * @param User $user
     *
     * @return Redirect|View
     * @throws ViewNotFoundException
     */
    public function publisherBooks(User $user)
    {
        auth()->user()->authorize('has', Book::class);

        $books = $user->books();

        return view('books.index', ['books' => $books]);
    }

    /**
     * @return View
     * @throws ViewNotFoundException
     */
    public function create()
    {
        auth()->user()->authorize('create', Book::class);

        return view('books.create', ['book' => new Book()]);
    }

    /**
     * @return Redirect
     */
    public function store()
    {
        auth()->user()->authorize('create', Book::class);

        try {
            $bookRepository = new BookRepository();

            $book = $bookRepository->store(request()->only([
                'title',
                'isbn',
                'author_id',
                'cover',
                'sample',
                'summary',
                'edition',
                'language',
                'country',
                'no_of_pages',
            ]));
            $book->syncCategories(request()->get('categories'));

            return redirect()->route('/books/' . $book->id);
        } catch (Exception $e) {
            Session::set('msg', $e->getMessage());

            return redirect()->back()->with(request()->all()->toArray());
        }
    }

    /**
     * @param Book $book
     *
     * @return View
     * @throws ViewNotFoundException
     */
    public function show(Book $book)
    {
        auth()->user()->authorize('view', $book);

        return view('books.show', ['book' => $book]);
    }

    /**
     * @param Book $book
     *
     * @return Redirect|View
     * @throws ViewNotFoundException
     */
    public function edit(Book $book)
    {
        auth()->user()->authorize('update', $book);

        return view('books.edit', ['book' => $book]);
    }

    /**
     * @param Book $book
     *
     * @return Redirect
     */
    public function update(Book $book)
    {
        auth()->user()->authorize('update', $book);

        $cover     = $book->cover;
        $sample    = $book->sample;
        $newCover  = null;
        $newSample = null;

        try {

            $params = request()->only([
                'title',
                'isbn',
                'author_id',
                'cover',
                'sample',
                'summary',
                'edition',
                'language',
                'country',
                'no_of_pages',
            ]);

            if (request()->hasFile('cover')) {
                $newCover = request()->file('cover')->store('images');
                resize_image(base_dir() . $newCover);
                $params['cover'] = $newCover;
            }

            if (request()->hasFile('sample')) {
                $newSample        = request()->file('sample')->store('files');
                $params['sample'] = $newSample;
            }

            $book->update($params);

            $book->syncCategories(request()->get('categories'));

            if (request()->hasFile('sample')) {
                storage()->delete($sample);
            }
            if (request()->hasFile('cover')) {
                storage()->delete($cover);
            }

            return redirect()->route($book->url());
        } catch (Exception $e) {
            storage()->delete($newCover);
            storage()->delete($newSample);

            Session::get('msg', $e->getMessage());

            return redirect()->back()->with(request()->all()->toArray());
        }

    }

    /**
     * @param Book $book
     *
     * @return Redirect
     */
    public function delete(Book $book)
    {
        auth()->user()->authorize('delete', $book);

        $book->delete();

        return redirect()->back();
    }
}
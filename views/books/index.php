<div class="row">
    <div class="col-12">
        <div class="row p-4">
            <div class="col-md-6 col-sm-6">
                <h1>Books</h1>
            </div>
            <?php if (auth()->user()->can('create', \App\Models\Book::class)): ?>
                <div class="col-8 col-sm-6 text-right">
                    <a class="btn btn-primary"
                       href="<?= route('/books/new') ?>">
                        <i class="material-icons">add</i>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        <?= view('books.books', ['books' => $books]) ?>
    </div>
</div>
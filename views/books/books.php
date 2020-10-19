<div class="row p-4">
    <div class="col-md-12 text-center">
        <div class="btn-group">
            <?php foreach (categories(6) as $category): ?>
                <button class="btn btn-info"
                        onclick="return window.location='<?= route('/books?category[]=' . $category->slug) ?>';"><?= $category->title ?></button>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="row mt-5">

    <?php
    /** @var \App\Models\Book[] $books */
    foreach ($books as $book) : ?>
        <?= view('books.book', ['book' => $book]) ?>
    <?php endforeach; ?>
</div>
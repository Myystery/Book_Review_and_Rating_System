<div class="col-md-4">
    <div class="card" style="width: 18rem;">
        <img src="<?= $book->cover ?>" class="card-img-top" width="200" height="250" style="object-fit: contain"
             alt="...">
        <div class="card-body">
            <h5 class="card-title"><?= $book->title ?></h5>
            <p class="card-text"><?= $book->author()->name ?></p>
            <a href="<?= $book->url() ?>" class="btn btn-primary">View Details</a>
            <?php if (auth()->user()->can('update', $book)): ?>
                <a href="<?= $book->url() . '/edit' ?>" class="btn btn-primary">Edit</a>
            <?php endif; ?>
        </div>
    </div>
</div>
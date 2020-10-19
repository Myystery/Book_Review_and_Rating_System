<div class="row">
    <div class="col-12 p-2">
        <div class="row">
            <div class="col-md-4">
                <div class="border text-center p-1">
                    <img src="<?= $book->cover ?>" width="200" height="250" style="object-fit: contain" alt="book cover"
                         class="img-fluid">
                </div>
            </div>
            <div class="col-md-8">
                <h3><?= $book->title ?></h3>
                <p>
                    <a href="<?= route('/books?author[]=' . $book->author()->slug) ?>"><?= $book->author()->name ?></a>
                </p>
                <br>
                <table class="book-info">
                    <tr>
                        <td>ISBN:</td>
                        <td><?= $book->isbn ?></td>
                    </tr>
                    <tr>
                        <td>Publisher:</td>
                        <td><?= $book->publisher()->name ?></td>
                    </tr>
                    <tr>
                        <td>Edition:</td>
                        <td><?= $book->edition ?></td>
                    </tr>
                    <tr>
                        <td>Language:</td>
                        <td><?= $book->language ?></td>
                    </tr>
                    <tr>
                        <td>Country:</td>
                        <td><?= $book->country ?></td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td><?php $categories = $book->getCategories();
                            foreach ($categories as $category) {
                                ?>
                                <a href="<?= route('/books?category[]=' . $category->slug) ?>"><?= $category->title ?></a>
                                <?php
                            } ?>
                        </td>
                    </tr>
                    <?php if (auth()->user()->can('update', $book)): ?>
                        <tr>
                            <td></td>
                            <td><a href="<?= $book->url() . '/edit' ?>" class="btn btn-primary">Edit</a></td>
                        </tr>
                    <?php endif; ?>
                </table>
                <div class="stars">
                    <ul class="star" value="<?= $book->reviewScore() ?>">
                        <li><i class="material-icons">star</i></li>
                        <li><i class="material-icons">star</i></li>
                        <li><i class="material-icons">star</i></li>
                        <li><i class="material-icons">star</i></li>
                        <li><i class="material-icons">star</i></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 p-2 mt-5">
                <?= p($book->summary) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-2 mt-3">
                <?= view('books.review.index', ['book' => $book]) ?>
                <?= view('books.review.form', ['book' => $book]) ?>
            </div>
        </div>
    </div>
</div>
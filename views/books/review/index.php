<div class="row">
    <div class="col-md-12">
        <?php
        /**
         * @var \App\Models\Review[] $reviews
         * @var \App\Models\Book $book
         */
        $reviews = $book->reviews();
        foreach ($reviews as $review):
            ?>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 text-center">
                            <img src="<?= $review->user()->photo ?: 'https://image.ibb.co/jw55Ex/def_face.jpg' ?>"
                                 class="img img-rounded img-fluid"
                                 width="100"/>
                            <p class="text-secondary text-center"><?= $review->added_at ?></p>
                        </div>
                        <div class="col-md-10">
                            <p>
                                <a class="float-left">
                                    <strong><?= $review->user()->name ?></strong>
                                </a>
                            <ul class="star float-right" value="<?= $review->rating ?>">
                                <li><i class="material-icons">star</i></li>
                                <li><i class="material-icons">star</i></li>
                                <li><i class="material-icons">star</i></li>
                                <li><i class="material-icons">star</i></li>
                                <li><i class="material-icons">star</i></li>
                            </ul>
                            </p>
                            <div class="clearfix"></div>
                            <?= p($review->comment) ?>
                            <?php if ($review->attachment): ?>
                                <p style="max-width: 600px; max-height: 500px;">
                                    <a href="<?= $review->attachment ?>" target="_blank">
                                        <img src="<?= $review->attachment ?>"
                                             class="img img-fluid"
                                             height="300"
                                             alt="Attachment">
                                    </a>
                                </p>
                            <?php endif;
                            if (auth()->user()->can('delete', $review)): ?>
                                <p>
                                <form action="<?= route('/books/' . $book->id . '/reviews/' . $review->id) ?>"
                                      method="post">
                                    <button class="float-right btn text-white btn-danger"><i class="fa fa-heart"></i>
                                        Delete
                                    </button>
                                </form>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
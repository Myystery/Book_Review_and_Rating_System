<div class="row">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-body">
                <?php if (auth()->check()): ?>
                    <div class="row">
                        <div class="widget-area no-padding blank">
                            <div class="status-upload">
                                <form onsubmit="return validateCommentForm(this)"
                                      action="<?= route('/books/' . $book->id . '/reviews') ?>"
                                      method="post"
                                      enctype="multipart/form-data">
                                <textarea placeholder="What do you think of this book?"
                                          name="comment"
                                          maxlength="700"
                                          required><?= htmlspecialchars(old('comment')) ?></textarea>
                                    <ul class="star">
                                        <input type="hidden" name="rating">
                                        <li><i class="material-icons">star</i></li>
                                        <li><i class="material-icons">star</i></li>
                                        <li><i class="material-icons">star</i></li>
                                        <li><i class="material-icons">star</i></li>
                                        <li><i class="material-icons">star</i></li>
                                    </ul>
                                    <input type="file" class="ml-1" name="attachment" accept="image/*">
                                    <button type="submit" class="btn btn-success green float-right">
                                        POST
                                    </button>
                                </form>
                            </div><!-- Status Upload  -->
                        </div><!-- Widget Area -->
                    </div>
                <?php else: ?>
                    <a href="<?= route('/login') ?>" class="btn btn-primary">Login to Post Comment</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
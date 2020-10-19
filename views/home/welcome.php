<?php $monthly_tops = monthly_top();
if (count($monthly_tops) > 0): ?>
    <div class="row">
        <div class="col-12">
            <div class="card-panel">
                <div class="card-header">
                    <h3>Top books of the last month</h3>
                </div>
                <div class="card-content">
                    <div class="row">
                        <?php foreach ($monthly_tops as $book): ?>
                            <div class="col-md-4">
                                <?= view('books.book', ['book' => $book]) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-12">

    </div>
</div>
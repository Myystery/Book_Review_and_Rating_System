<div class="row justify-content-center mt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header">Update Category
                <span class="float-right">
                    <a class="btn btn-primary" href="<?= route('/categories') ?>">
                        Go Back
                    </a>
                </span>
            </div>
            <div class="card-body">

                <?= \App\Support\Session::has('msg') ? '<p class="alert alert-info">' . \App\Support\Session::flash('msg') . '</p>' : '' ?>

                <form name="my-form" action="<?= route('/categories/' . $category->id) ?>" method="POST">

                    <?= view('categories.form', ['category' => $category]) ?>

                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center mt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header">Add New User
                <span class="float-right">
                    <a class="btn btn-primary" href="<?= route('/users') ?>">
                        Go Back
                    </a>
                </span>
            </div>
            <div class="card-body">

                <?= \App\Support\Session::has('msg') ? '<p class="alert alert-info">' . \App\Support\Session::flash('msg') . '</p>' : '' ?>

                <form name="my-form" action="<?= route('/users') ?>" method="POST" enctype="multipart/form-data">

                    <?= view('users.form', ['user' => $user]) ?>

                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Add
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
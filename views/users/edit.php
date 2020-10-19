<div class="row justify-content-center mt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header">Update User
                <span class="float-right">
                    <?php if (auth()->user()->isAdmin()): ?>
                    <a class="btn btn-primary" href="<?= route('/users') ?>">
                        <?php else: ?>
                        <a class="btn btn-primary" href="<?= route('/profile') ?>">
                        <?php endif; ?>
                        Go Back
                    </a>
                </span>
            </div>
            <div class="card-body">

                <?= \App\Support\Session::has('msg') ? '<p class="alert alert-info">' . \App\Support\Session::flash('msg') . '</p>' : '' ?>

                <form name="my-form" action="<?= route('/users/' . $user->id) ?>" method="POST"
                      enctype="multipart/form-data">

                    <?= view('users.form', ['user' => $user]) ?>

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
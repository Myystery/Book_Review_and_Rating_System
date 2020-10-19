<div class="row justify-content-center mt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header">Register</div>
            <div class="card-body">

                <?= \App\Support\Session::has('msg') ? '<p class="alert alert-info">' . \App\Support\Session::flash('msg') . '</p>' : '' ?>

                <form name="my-form" action="<?= route('/register') ?>" method="POST">
                    <div class="form-group row">
                        <label for="reg_name" class="col-md-4 col-form-label text-md-right">Name</label>
                        <div class="col-md-6">
                            <input type="text" id="reg_name" class="form-control" name="name" value="<?= old('name') ?>"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="reg_email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                        <div class="col-md-6">
                            <input type="email" id="reg_email" class="form-control" name="email"
                                   value="<?= old('email') ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="reg_password" class="col-md-4 col-form-label text-md-right">Password</label>
                        <div class="col-md-6">
                            <input type="password" id="reg_password" class="form-control" name="password" required>
                        </div>
                    </div>

                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
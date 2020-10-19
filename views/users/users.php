<div class="row">
    <div class="col-12">
        <div class="row p-4">
            <div class="col-md-6 col-sm-6">
                <h1><?= ucfirst($hook) ?></h1>
            </div>
        </div>
        <div class="row">
            <?php
            /**
             * @var \App\Models\User[] $users
             */
            foreach ($users as $user): ?>
                <div class="col-md-4">
                    <div class="card" style="width: 18rem;">
                        <img src="<?= $user->photo ?: 'https://image.ibb.co/jw55Ex/def_face.jpg' ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $user->name ?></h5>
                            <a href="<?= route('/books?' . $hook . '[]=' . $user->slug) ?>" class="btn btn-primary">View
                                Books</a>
                            <?php if (auth()->user()->isAdmin()): ?>
                                <a href="<?= route('/users/' . $user->id . '/edit') ?>"
                                   class="btn btn-primary">Edit</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
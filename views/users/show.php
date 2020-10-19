<div class="row">
    <div class="col-12 p-2">
        <div class="row">
            <div class="col-md-4">
                <div class="border text-center p-1">
                    <img src="<?= $user->photo ?: 'https://image.ibb.co/jw55Ex/def_face.jpg' ?>"
                         alt="User Profile Photo"
                         class="img-fluid">
                    <h3 class="secondary-text text-center"><?= $user->name ?></h3>
                </div>
            </div>
            <div class="col-md-8">
                <table class="user-info">
                    <tr>
                        <td>Email:</td>
                        <td><?= $user->email ?></td>
                    </tr>
                    <tr>
                        <td>Location:</td>
                        <td><?= $user->location ?></td>
                    </tr>
                    <tr>
                        <td>Total Books:</td>
                        <td><?= $user->totalBooks() ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <a href="<?= route('users/' . $user->id . '/edit') ?>" class="btn btn-primary">Edit</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= view('books.books', ['books' => $user->books()]) ?>
            </div>
        </div>
    </div>
</div>
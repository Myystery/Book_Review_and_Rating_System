<div class="row">
    <div class="col-12">
        <div class="row p-4">
            <div class="col-md-6 col-sm-6">
                <h1>Users</h1>
            </div>
            <div class="col-8 col-sm-6 text-right">
                <a class="btn btn-primary"
                   href="<?= route('/users/new') ?>">
                    <i class="material-icons">add</i>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    /** @var \App\Models\User[] $users */
                    foreach ($users as $user): ?>
                        <tr>
                            <th scope="row"><?= $user->id ?></th>
                            <td><?= $user->name ?></td>
                            <td><?= $user->email ?></td>
                            <td><?= $user->role ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info"
                                       href="<?= route('/users/' . $user->id . '/edit') ?>"
                                    >
                                        <i class="material-icons">edit</i>
                                    </a>
                                    <form action="<?= route("/users/{$user->id}/delete") ?>" method="post"
                                          id="delete_<?= $user->id ?>"></form>
                                    <a onclick="deleteUser(<?= $user->id ?>)" href="" class="btn btn-danger"><i
                                                class="material-icons">delete</i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
  function deleteUser(id) {
    event.preventDefault();
    event.stopPropagation();
    if (confirm('Are you sure you want to delete this user?')) {
      document.getElementById('delete_ID'.replace(/ID/, id)).submit();
    }
    return false;
  }
</script>
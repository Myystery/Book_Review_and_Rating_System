<div class="form-group row">
    <label for="user_name" class="col-md-4 col-form-label text-md-right">Name</label>
    <div class="col-md-6">
        <input type="text" id="user_name" class="form-control" name="name"
               value="<?= old('name', $user->name) ?>"
               required>
    </div>
</div>

<div class="form-group row">
    <label for="user_email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
    <div class="col-md-6">
        <input type="email" id="user_email" class="form-control" name="email"
               value="<?= old('email', $user->email) ?>" required>
    </div>
</div>

<div class="form-group row">
    <label for="user_password" class="col-md-4 col-form-label text-md-right">Password</label>
    <div class="col-md-6">
        <input type="password" id="user_password" class="form-control" name="password"
            <?= $user->id ? '' : 'required' ?>>
    </div>
    <?= $user->id ? '<small>Leave blank to not update.</small>' : '' ?>
</div>

<?php if (auth()->user()->isAdmin()): ?>
    <div class="form-group row">
        <label for="user_role" class="col-md-4 col-form-label text-md-right">Role</label>
        <div class="col-md-6">
            <select name="role" id="user_role" class="form-control" required>
                <option disabled>Select Role</option>
                <?php foreach (['admin', 'publisher', 'author', 'member'] as $role): ?>
                    <option
                            value="<?= $role ?>"
                        <?= old('role', $user->role) === $role ? 'selected' : '' ?>>
                        <?= ucfirst($role) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
<?php endif; ?>

<div class="form-group row">
    <label for="user_photo" class="col-md-4 col-form-label text-md-right">Photo</label>
    <div class="col-md-6">
        <input type="file" accept="image/*" id="user_photo" class="form-control" name="photo">
    </div>
    <small>Leave blank to not update.</small>
</div>

<div class="form-group row">
    <label for="user_location" class="col-md-4 col-form-label text-md-right">Location</label>
    <div class="col-md-6">
        <textarea id="user_location" class="form-control" name="location"
                  required><?= htmlspecialchars(old('location', $user->location)) ?></textarea>
    </div>
</div>
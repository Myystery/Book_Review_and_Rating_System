<div class="form-group row">
    <label for="book_category" class="col-md-4 col-form-label text-md-right">Title</label>
    <div class="col-md-6">
        <input type="text" id="book_category" class="form-control" name="title"
               value="<?= old('title', $category->title) ?>"
               required>
    </div>
</div>

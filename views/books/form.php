<div class="form-group row">
    <label for="book-title" class="col-md-4 col-form-label text-md-right">Title</label>
    <div class="col-md-6">
        <input type="text" id="book-title" class="form-control" name="title"
               value="<?= old('title', $book->title) ?>" required>
    </div>
</div>

<div class="form-group row">
    <label for="book-isbn" class="col-md-4 col-form-label text-md-right">ISBN</label>
    <div class="col-md-6">
        <input type="text" id="book-isbn" class="form-control" name="isbn"
               value="<?= old('isbn', $book->isbn) ?>" required>
    </div>
</div>

<div class="form-group row">
    <label for="book-category" class="col-md-4 col-form-label text-md-right">Category</label>
    <div class="col-md-6">
        <select type="text" id="book-category" class="form-control" name="categories[]" multiple required>
            <option disabled <?= $book->id ? '' : 'selected' ?>>Select Categories</option>
            <?php foreach (categories() as $category): ?>
                <option value="<?= $category->id ?>" <?= $book->hasCategory($category->slug) ? 'selected' : '' ?>><?= $category->title ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="book-author" class="col-md-4 col-form-label text-md-right">Author</label>
    <div class="col-md-6">
        <select type="text" id="book-author" class="form-control" name="author_id" required>
            <option disabled <?= $book->id ? '' : 'selected' ?>>Select Author</option>
            <?php foreach (authors() as $author): ?>
                <option value="<?= $author->id ?>"><?= $author->name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="book-cover" class="col-md-4 col-form-label text-md-right">Cover Photo</label>
    <div class="col-md-6">
        <input type="file"
               accept="image/*"
               id="book-cover"
               class="form-control"
               name="cover"
            <?= $book->id ? '' : 'required' ?>>
        <small>Leave blank to not update</small>
    </div>
</div>

<div class="form-group row">
    <label for="book-sample" class="col-md-4 col-form-label text-md-right">Sample (First few page)</label>
    <div class="col-md-6">
        <input type="file"
               accept="application/pdf"
               id="book-sample"
               class="form-control"
               name="sample"
            <?= $book->id ? '' : 'required' ?>>
        <small>Leave blank to not update</small>
    </div>
</div>

<div class="form-group row">
    <label for="book-summary" class="col-md-4 col-form-label text-md-right">Summary</label>
    <div class="col-md-6">
        <textarea id="book-summary"
                  class="form-control"
                  name="summary"
                  required><?= htmlspecialchars(old('summary', $book->summary)) ?></textarea>
    </div>
</div>

<div class="form-group row">
    <label for="book-edition" class="col-md-4 col-form-label text-md-right">Edition</label>
    <div class="col-md-6">
        <input type="text" id="book-edition" class="form-control" name="edition"
               value="<?= old('edition', $book->edition) ?>" required>
    </div>
</div>

<div class="form-group row">
    <label for="book-language" class="col-md-4 col-form-label text-md-right">Language</label>
    <div class="col-md-6">
        <input type="text" id="book-language" class="form-control" name="language"
               value="<?= old('language', $book->language) ?>" required>
    </div>
</div>

<div class="form-group row">
    <label for="book-country" class="col-md-4 col-form-label text-md-right">Country</label>
    <div class="col-md-6">
        <input type="text" id="book-country" class="form-control" name="country"
               value="<?= old('country', $book->country) ?>" required>
    </div>
</div>

<div class="form-group row">
    <label for="no_of_pages" class="col-md-4 col-form-label text-md-right">No. of Pages</label>
    <div class="col-md-6">
        <input type="number" id="no_of_pages" class="form-control" name="no_of_pages"
               value="<?= old('no_of_pages', $book->no_of_pages) ?>" required>
    </div>
</div>

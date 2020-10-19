<div class="row">
    <div class="col-12">
        <div class="row p-4">
            <div class="col-md-6 col-sm-6">
                <h1>Categories</h1>
            </div>
            <?php if (auth()->user()->can('create', \App\Models\Category::class)): ?>
                <div class="col-8 col-sm-6 text-right">
                    <a class="btn btn-primary"
                       href="<?= route('/categories/new') ?>">
                        <i class="material-icons">add</i>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <?php
                    /** @var \App\Models\Category[] $categories */
                    foreach ($categories as $category) : ?>
                        <div class="col-md-3 text-center">
                            <div class="block p-1">
                                <a
                                        class="btn btn-outline-primary"
                                        href="<?= route('/books?category[]=' . $category->slug) ?>"><?= $category->title ?></a>
                            </div>
                            <?php if (auth()->user()->can('update', \App\Models\Category::class)): ?>
                                <div class="btn-group p-1">
                                    <button
                                            onclick="window.location.href='<?= route('/categories/' . $category->id . '/edit') ?>'"
                                            class="btn btn-info">
                                        <i class="material-icons">edit</i>
                                    </button>
                                    <form action="<?= route('/categories/' . $category->id . '/delete') ?>"
                                          method="post">
                                        <button class="btn btn-danger"><i class="material-icons">delete</i></button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
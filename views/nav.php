<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
        <a class="navbar-brand" href="/"><?= config('app.name') ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="text-center d-inline">
            <form class="form-inline my-2 my-lg-0" action="<?= route('/books') ?>">
                <input class="form-control mr-sm-2" name="q" type="search" placeholder="Search" aria-label="Search"
                       value="<?= request()->get('q') ?>">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                    <i class="material-icons">search</i>
                </button>
            </form>
        </div>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <?php if (auth()->check()): ?>
                    <?php if (auth()->user()->isAdmin()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                Administration
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?= route('/users') ?>">Users</a>
                                <a class="dropdown-item" href="<?= route('/books') ?>">Books</a>
                                <a class="dropdown-item" href="<?= route('/categories') ?>">Categories</a>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        Books
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= route('/books') ?>">Books</a>
                        <?php if (auth()->check() && auth()->user()->isPublisher()): ?>
                            <a class="dropdown-item" href="<?= route("/publishers/" . auth()->id() . '/books') ?>">My
                                Books</a>
                        <?php endif; ?>
                        <a class="dropdown-item" href="<?= route('/categories') ?>">Categories</a>
                        <a class="dropdown-item" href="<?= route('/authors') ?>">Authors</a>
                        <a class="dropdown-item" href="<?= route('/publishers') ?>">Publishers</a>
                    </div>
                </li>
                <?php if ( ! auth()->check()): ?>
                    <!--                auth-->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= route('/login') ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= route('/register') ?>">Sign Up</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            <?= auth()->user()->name ?>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= route('/profile') ?>">Profile</a>
                            <form action="<?= route('/logout') ?>" id="logout" method="post"></form>
                            <a class="dropdown-item" style="cursor: pointer;" onclick="javascript:logout.submit()">Logout</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
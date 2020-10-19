<?php

return [
    \App\Models\User::class     => \App\Policies\UserPolicy::class,
    \App\Models\Book::class     => \App\Policies\BookPolicy::class,
    \App\Models\Review::class   => \App\Policies\ReviewPolicy::class,
    \App\Models\Category::class => \App\Policies\CategoryPolicy::class,
];

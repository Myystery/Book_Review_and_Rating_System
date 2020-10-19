<?php

namespace App\Models;

/**
 * Class User
 * @package App\Models
 *
 * @property int id
 * @property string name
 * @property string email
 * @property string password
 * @property string remember_token
 * @property string role
 * @property string|null photo
 * @property string|null location
 */
class User extends Model
{
    protected static $table = 'users';
    protected static $formats = [
        'name'     => 's',
        'email'    => 's',
        'password' => 's',
        'role'     => 's',
        'photo'    => 's',
        'location' => 's',
    ];

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * @return bool
     */
    public function isPublisher()
    {
        return $this->role === 'publisher';
    }

    /**
     * @return bool
     */
    public function isAuthor()
    {
        return $this->role === 'author';
    }

    /**
     * @return bool
     */
    public function isMember()
    {
        return $this->role === 'member';
    }

    /**
     * @return Book[]
     */
    public function books()
    {
        return Book::select(['publisher_id' => $this->id]);
    }

    /**
     * @return int
     */
    public function totalBooks()
    {
        if ( ! $this->isPublisher()) {
            return 0;
        }

        $q = $this->query("SELECT COUNT(id) as total FROM books WHERE publisher_id={$this->id}");

        if ($q->num_rows) {
            return $q->fetch_object()->total;
        }

        return 0;
    }

    public function authorize($hook, $class)
    {
        if ( ! $this->can($hook, $class)) {
            redirect()->route('/403');
            die("You do not have access to do this");
        }
    }

    /**
     * @param $hook
     * @param $class
     *
     * @return bool|mixed
     */
    public function can($hook, $class)
    {
        $class_name = $class;
        $args       = [auth()->user()];
        if ( ! is_string($class)) {
            $args[] = $class;
        }
        if ( ! is_string($class)) {
            $class_name = get_class($class);
        }
        $policy = config('policies.' . $class_name);

        $instance = new $policy;
        if (method_exists($instance, 'before') && $instance->before(auth()->user())) {
            return true;
        }

        if (method_exists($instance, $hook)) {
            return call_user_func_array([$instance, $hook], $args);
        }

        return false;
    }

    /**
     *
     */
    public function deleted()
    {
        if ($this->photo) {
            storage()->delete($this->photo);
        }

        /** @var Book[] $books */
        $books = [];

        if ($this->isPublisher()) {
            $books = Book::select(['publisher_id' => $this->id]);
        } elseif ($this->isAuthor()) {
            $books = Book::select(['author_id' => $this->id]);
        }

        foreach ($books as $book) {
            $book->delete();
        }
    }
}

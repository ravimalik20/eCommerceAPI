<?php

namespace App\Policies;

use App\User;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
    * Determine wether the user can view the category index.
    */
    public function index(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the category.
     *
     * @param  App\User  $user
     * @param  App\Category  $category
     * @return mixed
     */
    public function view(User $user, Category $category)
    {
        return true;
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param  App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role() == "admin";
    }

    /**
     * Determine whether the user can update the category.
     *
     * @param  App\User  $user
     * @param  App\Category  $category
     * @return mixed
     */
    public function update(User $user, Category $category)
    {
        return $user->role() == "admin";
    }

    /**
     * Determine whether the user can delete the category.
     *
     * @param  App\User  $user
     * @param  App\Category  $category
     * @return mixed
     */
    public function delete(User $user, Category $category)
    {
        return $user->role() == "admin";
    }
}

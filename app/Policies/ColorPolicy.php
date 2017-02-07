<?php

namespace App\Policies;

use App\User;
use App\Models\Color;
use Illuminate\Auth\Access\HandlesAuthorization;

class ColorPolicy
{
    use HandlesAuthorization;

    /**
    * Determines wether user is allowed to view color index.
    */
    public function index(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the color.
     *
     * @param  App\User  $user
     * @param  App\Color  $color
     * @return mixed
     */
    public function view(User $user, Color $color)
    {
        return true;
    }

    /**
     * Determine whether the user can create colors.
     *
     * @param  App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->name == "admin";
    }

    /**
     * Determine whether the user can update the color.
     *
     * @param  App\User  $user
     * @param  App\Color  $color
     * @return mixed
     */
    public function update(User $user, Color $color)
    {
        return $user->role->name == "admin";
    }

    /**
     * Determine whether the user can delete the color.
     *
     * @param  App\User  $user
     * @param  App\Color  $color
     * @return mixed
     */
    public function delete(User $user, Color $color)
    {
        return $user->role->name == "admin";
    }
}

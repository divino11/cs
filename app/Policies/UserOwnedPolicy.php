<?php

namespace App\Policies;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserOwnedPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  Model  $model
     * @return mixed
     */
    public function view(User $user, Model $model)
    {
        return $model->user_id == $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  Model  $model
     * @return mixed
     */
    public function update(User $user, Model $model)
    {
        return $model->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  Model  $model
     * @return mixed
     */
    public function delete(User $user, Model $model)
    {
        return $model->user_id == $user->id;
    }
}

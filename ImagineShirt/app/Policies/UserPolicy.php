<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function alterarPasse(User $user): bool
    {
        return $user->user_type == 'A' || $user->user_type == 'C' || $user->user_type == 'E';
    }

    public function verPropriasTShirts(User $user): bool
    {
        return $user->user_type == 'C';
    }

    public function fazerGestao(User $user): bool
    {
        return $user->user_type == 'A';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->user_type == 'A';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // MUDAR 

        if ($user->user_type == 'C' && $user == $model){
            return $user->user_type == 'C';
        }

        if ($user->user_type == 'A' && $model->user_type != 'C'){
            return $user->user_type == 'A';
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->user_type == 'A';
    }

    public function block(User $user, User $model): bool
    {
        return $user->user_type == 'A';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->user_type == 'A';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->user_type == 'A';
    }
}

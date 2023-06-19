<?php

namespace App\Policies;

use App\Models\TShirts;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TShirtsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function viewMinhas(User $user): bool
    {
        return $user->user_type == 'C';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, TShirts $tShirts): bool
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
    public function update(User $user, TShirts $tShirts): bool
    {
        return $user->user_type == 'A';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TShirts $tShirts): bool
    {
        return $user->user_type == 'A';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TShirts $tShirts): bool
    {
        return $user->user_type == 'A';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TShirts $tShirts): bool
    {
        return $user->user_type == 'A';
    }

    public function gerirCatalogo(User $user): bool
    {
        return $user->user_type == 'A';
    }
    
}

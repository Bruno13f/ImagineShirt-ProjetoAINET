<?php

namespace App\Policies;

use App\Models\Encomendas;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EncomendasPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user != null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Encomendas $encomenda): bool
    {
        return $user != null;
    }

    public function changeStatus(User $user, Encomendas $encomenda): bool{

        return $user->user_type == 'A' || $user->user_type == 'E';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Encomendas $encomenda): bool
    {

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Encomendas $encomenda): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Encomendas $encomenda): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Encomendas $encomenda): bool
    {
        //
    }
}

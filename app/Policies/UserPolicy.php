<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        if($user->role === 'Administrator') {
            return true;
        } else {
            return false;
        }
    }

    public function view(User $user, User $model): bool
    {
        if($user->role === 'Administrator') {
            return true;
        } else {
            return false;
        }
    }

    public function create(User $user): bool
    {
        if($user->role === 'Administrator') {
            return true;
        } else {
            return false;
        }
    }

    public function update(User $user, User $model): bool
    {
        if($user->role === 'Administrator') {
            return true;
        } else {
            return false;
        }
    }

    public function delete(User $user, User $model): bool
    {
        if($user->role === 'Administrator') {
            return true;
        } else {
            return false;
        }
    }

    public function restore(User $user, User $model): bool
    {
        if($user->role === 'Administrator') {
            return true;
        } else {
            return false;
        }
    }

    public function forceDelete(User $user, User $model): bool
    {
        if($user->role === 'Administrator') {
            return true;
        } else {
            return false;
        }
    }
}

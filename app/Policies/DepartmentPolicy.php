<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Department $department): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        if($user->role === 'Administrator' || $user->department->dp_name === 'SISFO') {
            return true;
        } else {
            return false;
        }
    }

    public function update(User $user, Department $department): bool
    {
        if($user->role === 'Administrator' || $user->department->dp_name === 'SISFO') {
            return true;
        } else {
            return false;
        }
    }

    public function delete(User $user, Department $department): bool
    {
        if($user->role === 'Administrator' || $user->department->dp_name === 'SISFO') {
            return true;
        } else {
            return false;
        }
    }

    public function restore(User $user, Department $department): bool
    {
        if($user->role === 'Administrator' || $user->department->dp_name === 'SISFO') {
            return true;
        } else {
            return false;
        }
    }

    public function forceDelete(User $user, Department $department): bool
    {
        if($user->role === 'Administrator' || $user->department->dp_name === 'SISFO') {
            return true;
        } else {
            return false;
        }
    }
}

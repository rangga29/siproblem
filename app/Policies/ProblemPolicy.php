<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\Problem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use function in_array;

class ProblemPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        if ($user->role === 'Administrator' || $user->department->dp_name === 'SISFO') {
            return true;
        }

        $departments = Department::where('dp_spr', true)->pluck('dp_name')->toArray();

        if (in_array($user->department->dp_name, $departments)) {
            return true;
        }

        return false;
    }

    public function view(User $user, Problem $problem): bool
    {
        if ($user->role === 'Administrator' || $user->department->dp_name === 'SISFO') {
            return true;
        }

        $departments = Department::where('dp_spr', true)->pluck('dp_name')->toArray();

        if (in_array($user->department->dp_name, $departments)) {
            return true;
        }

        return false;
    }

    public function create(User $user): bool
    {
        if ($user->role === 'Administrator' || $user->department->dp_name === 'SISFO') {
            return true;
        }

        if ($user->role == 'Kabag') {
            $departments = Department::where('dp_spr', true)->pluck('dp_name')->toArray();

            if (in_array($user->department->dp_name, $departments)) {
                return true;
            }
        }

        return false;
    }

    public function update(User $user, Problem $problem): bool
    {
        if ($user->role === 'Administrator' || $user->department->dp_name === 'SISFO') {
            return true;
        }

        if ($user->role == 'Kabag') {
            $departments = Department::where('dp_spr', true)->pluck('dp_name')->toArray();

            if (in_array($user->department->dp_name, $departments)) {
                return true;
            }
        }

        return false;
    }

    public function delete(User $user, Problem $problem): bool
    {
        if ($user->role === 'Administrator' || $user->department->dp_name === 'SISFO') {
            return true;
        }

        if ($user->role == 'Kabag') {
            $departments = Department::where('dp_spr', true)->pluck('dp_name')->toArray();

            if (in_array($user->department->dp_name, $departments)) {
                return true;
            }
        }

        return false;
    }

    public function restore(User $user, Problem $problem): bool
    {
        if ($user->role === 'Administrator' || $user->department->dp_name === 'SISFO') {
            return true;
        }

        if ($user->role == 'Kabag') {
            $departments = Department::where('dp_spr', true)->pluck('dp_name')->toArray();

            if (in_array($user->department->dp_name, $departments)) {
                return true;
            }
        }

        return false;
    }

    public function forceDelete(User $user, Problem $problem): bool
    {
        if ($user->role === 'Administrator' || $user->department->dp_name === 'SISFO') {
            return true;
        }

        if ($user->role == 'Kabag') {
            $departments = Department::where('dp_spr', true)->pluck('dp_name')->toArray();

            if (in_array($user->department->dp_name, $departments)) {
                return true;
            }
        }

        return false;
    }
}

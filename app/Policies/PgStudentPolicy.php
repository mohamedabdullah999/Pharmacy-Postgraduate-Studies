<?php

namespace App\Policies;

use App\Models\PgStudent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PgStudentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role === 'admin' || $user->role === 'supervisor';
    }

    public function view(User $user, PgStudent $pgStudent)
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'student' && $user->id === $pgStudent->user_id) {
            return true;
        }

        if ($user->role === 'supervisor') {
             $supervisorId = $user->pgSupervisor->id ?? null;
             if ($supervisorId) {
                  return $pgStudent->enrollments()
                                   ->whereHas('supervisors', function ($query) use ($supervisorId) {
                                       $query->where('pg_supervisors.id', $supervisorId);
                                   })->exists();
             }
        }

        return false;
    }

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, PgStudent $pgStudent)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, PgStudent $pgStudent)
    {
        return $user->role === 'admin';
    }
}
<?php

namespace App\Policies;

use App\Models\User;
use App\Models\JobType;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_job::type');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobType  $jobType
     * @return bool
     */
    public function view(User $user, JobType $jobType): bool
    {
        return $user->can('view_job::type');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('create_job::type');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobType  $jobType
     * @return bool
     */
    public function update(User $user, JobType $jobType): bool
    {
        return $user->can('update_job::type');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobType  $jobType
     * @return bool
     */
    public function delete(User $user, JobType $jobType): bool
    {
        return $user->can('delete_job::type');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_job::type');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobType  $jobType
     * @return bool
     */
    public function forceDelete(User $user, JobType $jobType): bool
    {
        return $user->can('force_delete_job::type');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_job::type');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobType  $jobType
     * @return bool
     */
    public function restore(User $user, JobType $jobType): bool
    {
        return $user->can('restore_job::type');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_job::type');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobType  $jobType
     * @return bool
     */
    public function replicate(User $user, JobType $jobType): bool
    {
        return $user->can('replicate_job::type');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_job::type');
    }

}

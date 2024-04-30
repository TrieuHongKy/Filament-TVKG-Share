<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PaymentHistory;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentHistoryPolicy
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
        return $user->can('view_any_payment::history');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return bool
     */
    public function view(User $user, PaymentHistory $paymentHistory): bool
    {
        return $user->can('view_payment::history');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('create_payment::history');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return bool
     */
    public function update(User $user, PaymentHistory $paymentHistory): bool
    {
        return $user->can('update_payment::history');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return bool
     */
    public function delete(User $user, PaymentHistory $paymentHistory): bool
    {
        return $user->can('delete_payment::history');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_payment::history');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return bool
     */
    public function forceDelete(User $user, PaymentHistory $paymentHistory): bool
    {
        return $user->can('force_delete_payment::history');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_payment::history');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return bool
     */
    public function restore(User $user, PaymentHistory $paymentHistory): bool
    {
        return $user->can('restore_payment::history');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_payment::history');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return bool
     */
    public function replicate(User $user, PaymentHistory $paymentHistory): bool
    {
        return $user->can('replicate_payment::history');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_payment::history');
    }

}

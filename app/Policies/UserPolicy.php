<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $currentUser, User $user) {
        //只可以更新當前用戶的資訊
        return $currentUser->id === $user->id;
    }

    public function destroy(User $currentUser, User $user) {
        //只有管理員且刪除對象不是自己時才可以刪除
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}

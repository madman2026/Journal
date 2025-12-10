<?php

namespace Modules\User\Services;

use Modules\Core\app\Contracts\BaseService;
use Modules\Core\app\Contracts\ServiceResponse;

class UserService extends BaseService
{
    public function updateProfile(array $data, int $userId): ServiceResponse
    {
        return $this->execute(function () use ($data, $userId) {
            $user = \Modules\User\Models\User::findOrFail($userId);
            $user->update($data);

            return $user;
        });
    }
}

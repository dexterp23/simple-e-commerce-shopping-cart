<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    private User $model;

    public function __construct( User $model )
    {
        $this->model = $model;
    }

    public function getAdmins(): Collection
    {
        return $this->model->where('role', config('users.role.admin'))->get();
    }
}

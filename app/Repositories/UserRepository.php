<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository {
    public $user_model;
    public function __construct(User $user_model){
        $this->user_model = $user_model;
    }

}

<?php

namespace App\Services;


use App\Repositories\UserRepository;

class UserService
{

    /**
     * @var UserRepository
     */
    private $userRepo;


    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function addUser($name, $email, $password, $roleId): bool
    {
        return $this->userRepo->addUser($name, $email, $password, $roleId);
    }
}

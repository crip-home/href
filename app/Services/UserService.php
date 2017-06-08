<?php namespace App\Services;
use App\Contracts\IUserRepository;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
    /**
     * @var IUserRepository
     */
    private $userRepository;

    /**
     * UserService constructor.
     * @param IUserRepository $userRepository
     */
    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
}
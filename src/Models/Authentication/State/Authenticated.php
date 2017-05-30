<?php
namespace Application\Models\Authentication\State;
use Application\Models\Authentication\State\StateInterface;
use Application\Models\User\User;

class Authenticated implements StateInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUserId()
    {
        return $this->user->getId();
    }
}
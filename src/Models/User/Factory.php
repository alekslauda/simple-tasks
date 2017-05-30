<?php
namespace Application\Models\User;

class Factory 
{
    public function create(array $data)
    {
        return new User($data['id'], $data['name'], $data['email'], $data['password']);
    }
}


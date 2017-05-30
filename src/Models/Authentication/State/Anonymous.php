<?php
namespace Application\Models\Authentication\State;
use Application\Models\Authentication\State\StateInterface;

class Anonymous implements StateInterface
{
    public function getUserID()
    {
        return null;
    }
}
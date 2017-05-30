<?php

namespace Application\Models\Authentication\Authorization;
use Application\Models\Authentication\State\StateInterface;
use Application\Models\Authentication\State\Anonymous;
use Application\Models\Authentication\State\Authenticated;

class DefaultVoter implements VoterInterface
{
    public function isAuthorized(StateInterface $state, $controllerName, $methodName)
    {
        switch($controllerName) {
            //External pages
            case 'Home':
                if ($state instanceof Authenticated == true) {
                    return self::ALLOW;
                }

                return self::DENY;
            case 'Index':
            case 'Authentication':
                if($state instanceof Authenticated == true && $methodName == 'Logout') {
                    return self::ALLOW;
                }
                //Should not access login when your logged in.
                if ($state instanceof Authenticated == true) {
                    return self::DENY;
                }

                return self::ALLOW;

            default:
                return self::ABSTAIN;
        }
    }
    
    public function getRedirectURL(StateInterface $state)
    {
        $redirectUrl = PROJECT_URL;

        if($state instanceof Anonymous == true) {
                $redirectUrl .= 'Authentication/Login';
        } elseif($state instanceof Authenticated == true) {
                $redirectUrl .= 'Home/Index';
        }

        return $redirectUrl;

    }
}
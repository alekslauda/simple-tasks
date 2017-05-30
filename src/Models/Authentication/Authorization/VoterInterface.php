<?php

namespace Application\Models\Authentication\Authorization;
use Application\Models\Authentication\State\StateInterface;

interface VoterInterface {
	
	const ALLOW = 1;
	const DENY = 2;
	const ABSTAIN = 3;
	
	//can i access this page
	public function isAuthorized(StateInterface $state, $controllerName, $methodName);
	//Where to go if denied access
	public function getRedirectURL(StateInterface $state);
}
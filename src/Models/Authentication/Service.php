<?php
namespace Application\Models\Authentication;

use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\HttpFoundation\Session\Session as Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Application\Models\Authentication\State\StateInterface;
use Application\Models\User\Repository;
use Application\Models\Authentication\State\Anonymous;
use Application\Models\Authentication\State\Authenticated;
use Application\Models\Core\ServiceInterface;
use Application\Models\Authentication\Authorization\VoterInterface;
use Application\Models\Core\Exception\Authentication\Login\InvalidCredentials as LoginInvalidCredentials;
use Application\Models\Core\Exception\Authentication\Register\InvalidCredentials as RegisterInvalidCredentials;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

class Service implements ServiceInterface
{
    private $userRepository;

    private $session;

    private $voters = array();

    const ID = 'service.authentication';

    public function getID()
    {
        return self::ID;	
    }

    public function __construct(Repository $repository, Session $session)
    {
        $this->userRepository = $repository;
        $this->session = $session;
    }

    public function setState(StateInterface $state)
    {
        $this->session->set('___STATE___', $state);
    }

    public function getState()
    {
        return $this->session->get('___STATE___', new Anonymous());
    }

    public function getUserRepository()
    {
        return $this->userRepository;
    }

    public function getSession()
    {
        return $this->session;
    }

    public function isAuthorized(StateInterface $state, $controllerName, $methodName)
    {
        foreach ($this->getVoters() AS $voter) {

            $result = $voter->isAuthorized($state, $controllerName, $methodName);
            switch($result) {
                case VoterInterface::ALLOW:
                    return [
                        true
                    ];
                case VoterInterface::ABSTAIN:
                    continue;
                case VoterInterface::DENY:

                    return [
                        false,
                        'redirectUrl' => $voter->getRedirectURL($state)
                    ];
            }
        }
    }

    public function login(Request $request)
    {
        //if we have error throw exception than catch it in the controller to output error message
        $user = $this->validateUserCredentials($request->request->all());
        if(!$user) {
            throw new LoginInvalidCredentials("Invalid Credentials");
        }
        //All good so log the member in.
        $this->setState(
            new Authenticated($user)
        );
        $response = new RedirectResponse(PROJECT_URL . 'Home');
        $response->send();
        exit;

    }

    public function register(Request $request)
    {

        $post = $request->request->all();
        
        $validator = Validation::createValidator();
        
        $user = $this->getUserRepository()->fetchUserByUsername(isset($post['email']) ? $post['email'] : false);
        
        $data = array(
            'email' => isset($post['email']) ? $post['email'] : false,
            'name' => isset($post['name']) ? $post['name'] : false,
            'password' => isset($post['password']) ? $post['password'] : false
        );
        $constraints = new Collection(array(
            'email' => array(
                new NotBlank(),
                new Email(),
            ),
            'name' => array(
                new NotBlank(),
                new Length(array(
                    "min" => 2,
                    "max" => 150
                ))
            ),
            'password' => array(
                new NotBlank(),
                new Length(array(
                    "min" => 6,
                ))
            )
        ));
        
        $errors = $validator->validate($data, $constraints);
        
        if(count($errors) != 0) {
            throw new RegisterInvalidCredentials(
                "Invalid Credentials",
                404,
                null,
                $errors,
                $user ? array('email' => 'Email is already taken') : array()
            );
        }
        
        $userId = $this->getUserRepository()->insertUser($data);
        $newUser = $this->getUserRepository()->fetchUserById($userId);
        //All good so log the member in.
        $this->setState(
            new Authenticated($newUser)
        );
        $response = new RedirectResponse(PROJECT_URL . 'Home');
        $response->send();
        exit;
    }
    
    protected function validateUserCredentials($data)
    {   
        $email = isset($data['email']) ? $data['email'] : false;
        $password = isset($data['password']) ? $data['password'] : false;
        
        if ($email == false || $password == false) {
            return false;
        }
        $user = $this->getUserRepository()->fetchUserByUsername($email);

        if ($user === null) {
            return false;
        }
        
        if (password_verify($password, $user->getPassword()) === false) {
            return false;
        }

        return $user;
    }
    
    public function logout()
    {
        $this->setState(new Anonymous());
    }

    public function addVoter(VoterInterface $voter)
    {
        
        $this->voters[] = $voter;
    }

    public function getVoters()
    {
        return $this->voters;
    }
}
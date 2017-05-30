<?php
namespace Application\Models\User;

class User 
{
    private $id;

    private $email;

    private $name;

    private $password;

    public function __construct(
        $id,
        $email,
        $name,
        $password
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
	
    public function getEmail()
    {
        return $this->email;
    }
    
    public function getPassword($masked = false) {
        if($masked) {           
            return substr($this->password, 0, 3).str_repeat("*",6);
        }
        return $this->password;
    }
}
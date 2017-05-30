<?php
namespace Application\Models\Core\Exception\Authentication\Register;

class InvalidCredentials extends \Exception
{

    private $_customErrors;
    private $_additionalInfo;

    public function __construct($message, 
        $code = 0, 
        Exception $previous = null, 
        $customErrors = array(),
        $additionalInfo = array()
    ) {
        parent::__construct($message, $code, $previous);

        $this->_customErrors = $customErrors; 
        $this->_additionalInfo = $additionalInfo;
    }

    public function getCustomErrors()
    { 
        $customErrors = array();
        
        foreach($this->_customErrors as $error) {
            
            $field = $error->getPropertyPath();
            if($field[0] == '[') {
                $field = substr($field, 1, -1);
            }
            
            $customErrors[$field] = $error->getMessage();
        }
        
        if($this->_additionalInfo !== false) {
            foreach($this->_additionalInfo as $fieldInfo => $msg) {
                $customErrors[$fieldInfo] = $msg;
            }
        }
        
        
        
        return $customErrors;
    }
}

<?php
namespace App\Strategy\Register;

/**
 * Class Context for switch Strategy
 */
class RegisterUserContext
{
    private $strategy =  NULL;

    public function __construct($strategy_choose) {

        switch($strategy_choose){
            case "PROFESSOR":
                $this->strategy =  new RegisterUserProfessor();
                break;
            case "TRAINER":
                $this->strategy =  new RegisterUserTrainer();
                break;
            
            default: 
                throw new \Exception("No existe la estrategia de registro");
        }

    }

    public function strategy($user)
    {
        return $this->strategy->register($user);
    }
}

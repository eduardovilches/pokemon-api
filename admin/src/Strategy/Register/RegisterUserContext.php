<?php
namespace App\Strategy\Register;

use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use App\Strategy\Register\RegisterUserProfessor;
use App\Strategy\Register\RegisterUserTrainer;

/**
 * Class Context for switch Strategy
 */
class RegisterUserContext implements ServiceSubscriberInterface
{
    private ContainerInterface $locator;

    private const STRATEGY_MAP = [
        'PROFESSOR' => RegisterUserProfessor::class,
        'TRAINER' => RegisterUserTrainer::class,
        // Add other roles here as you create their services
    ];

    public function __construct(ContainerInterface $locator)
    {
        // Inject the Service Locator.
        $this->locator = $locator;
    }

    public static function getSubscribedServices(): array
    {
        // List the strategy service classes that the context might need.
        return [
            RegisterUserProfessor::class,
            RegisterUserTrainer::class,
        ];
    }

    public function strategy($strategyChoose, $user)
    {
        $strategyKey = strtoupper($strategyChoose);

        if (!isset(self::STRATEGY_MAP[$strategyKey])) {
            throw new \InvalidArgumentException("No existe la estrategia de registro para el tipo: " . $strategyKey);
        }

        $strategyServiceId = self::STRATEGY_MAP[$strategyKey];
        $strategy = $this->locator->get($strategyServiceId);


        $strategy->register($user);
    }
}

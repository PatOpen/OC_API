<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Authorizations\UserAuthorizationChecker;
use App\Entity\Users;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UserSubscriber implements EventSubscriberInterface
{
	private array $methodNotAllowed = [
		Request::METHOD_POST,
		Request::METHOD_GET
	];

	/**
	 * @var UserAuthorizationChecker
	 */
	private UserAuthorizationChecker $checker;

	public function __construct(UserAuthorizationChecker $checker)
	{
		$this->checker = $checker;
	}

	public static function getSubscribedEvents()
	{
		return [
			KernelEvents::VIEW => ['check', EventPriorities::PRE_VALIDATE]
		];
	}

	public function check(ViewEvent $event): void
	{
		$user = $event->getControllerResult();
		$method = $event->getRequest()->getMethod();

		if ($user instanceof Users && !in_array($method, $this->methodNotAllowed, true)){
			$this->checker->check($user, $method);
		}

	}
}
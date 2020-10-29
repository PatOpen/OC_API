<?php


namespace App\Authorizations;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserAuthorizationChecker
{
	private array $methodAllowed = [
		Request::METHOD_POST,
		Request::METHOD_GET,
		Request::METHOD_DELETE
	];
	private ?UserInterface $user;

	public function __construct(Security $security)
	{
		$this->user = $security->getUser();
	}

	public function check(UserInterface $user, string $method): void
	{
		$this->isAuthenticated();

		if ($this->isMethodAllowed($method) && $user->getUsername() !== $this->user->getUsername()){
			$errorMessage = "It's not your resource";
			throw new UnauthorizedHttpException($errorMessage, $errorMessage);
		}
	}

	public function isAuthenticated():void
	{
		if (null === $this->user){
			$errorMessage = "You are not authenticated";
			throw new UnauthorizedHttpException($errorMessage, $errorMessage);
		}
	}

	public function isMethodAllowed(string $method): bool
	{
		return in_array($method, $this->methodAllowed, true);
	}

}
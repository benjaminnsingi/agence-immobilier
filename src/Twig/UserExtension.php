<?php


namespace App\Twig;


use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UserExtension extends AbstractExtension
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('current_user', [$this, 'getCurrentUser'])
        ];
    }

    public function getCurrentUser(): ?User
    {
        $token = $this->tokenStorage->getToken();

        if (null !== $token) {
            $user = $token->getUser();

            if (is_object($user) && $user instanceof User) {
                return $user;
            }
        }

        return null;
    }
}

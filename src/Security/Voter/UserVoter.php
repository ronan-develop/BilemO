<?php

namespace App\Security\Voter;

use App\Entity\Client;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    public const EDIT = 'USER_EDIT';
    public const VIEW = 'USER_VIEW';
    public const DELETE = 'USER_DELETE';

    public function __construct(private readonly Security $security)
    {
    }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        //get connected client
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        // check is client is admin
        if($this->security->isGranted(["ROLE_ADMIN"])) return true;

        // check if user has client
        if(null === $subject->getUsername()) return false;
        // ... (check conditions and return true to grant permission) ...

        return match ($attribute) {
            self::EDIT => $this->canUpdate($subject, $user),
            self::VIEW => $this->canView($subject, $user),
            self::DELETE => $this->canDelete($subject, $user),
            default => false,
        };

    }

    private function canView(User $user, Client $client): bool
    {
        // owner can read
        return $client === $user->getClient();
    }

    private function canUpdate(User $user, Client $client): bool
    {
        // owner can delete
        return $client === $user->getClient();
    }

    private function canDelete(User $user, Client $client): bool
    {
        // owner can delete
        return $client === $user->getClient();
    }
}

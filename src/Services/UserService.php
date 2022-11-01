<?php

namespace App\Services;

use Symfony\Component\Security\Core\User\UserInterface;

class UserService implements IPaginationService
{

    public function findAllWithPagination($page, $limit)
    {
        // TODO: Implement findAllWithPagination() method.
    }

    public function countAll(?UserInterface $client = null)
    {
        // TODO: Implement countAll() method.
    }
}
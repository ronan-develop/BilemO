<?php

namespace App\Services;

use Symfony\Component\Security\Core\User\UserInterface;

interface IPaginationService
{
    public function findAllWithPagination(int $offset, int $limit, ?UserInterface $client = null);

    public function countAll(?userInterface $client = null);
}
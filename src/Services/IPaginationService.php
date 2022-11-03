<?php

namespace App\Services;

use Symfony\Component\Security\Core\User\UserInterface;

interface IPaginationService
{
    public function findAllWithPagination($page, $limit);
    public function countAll(?UserInterface $client = null);
}
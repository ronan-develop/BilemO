<?php

namespace App\Services;

interface IPaginationService
{
    public function findAllWithPagination($page, $limit);
}
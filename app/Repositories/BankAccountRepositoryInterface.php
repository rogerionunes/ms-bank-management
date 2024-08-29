<?php

namespace App\Repositories;


interface BankAccountRepositoryInterface
{
    public function findByNumber(int $id);
    public function create(array $data);
}
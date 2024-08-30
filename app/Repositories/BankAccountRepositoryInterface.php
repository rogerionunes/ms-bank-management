<?php

namespace App\Repositories;


interface BankAccountRepositoryInterface
{
    public function findByNumber(int $accountNumber);
    public function create(array $data);
}
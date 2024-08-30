<?php

namespace App\Repositories;

use App\Models\BankAccount;

class BankAccountRepository implements BankAccountRepositoryInterface
{
    public function create(array $data): ?BankAccount
    {
        return BankAccount::create($data);
    }

    public function findByNumber(int $accountNumber): ?BankAccount
    {
        return BankAccount::where('numero_conta', $accountNumber)->first();
    }
}
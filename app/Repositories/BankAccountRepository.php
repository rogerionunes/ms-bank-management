<?php

namespace App\Repositories;

use App\Models\BankAccount;

class BankAccountRepository implements BankAccountRepositoryInterface
{
    public function create(array $data)
    {
        return BankAccount::create($data);
    }

    public function findByNumber(int $accountNumber)
    {
        return BankAccount::where('numero_conta', $accountNumber)->first();
    }

    public function updateBalance($accountId, $amount)
    {
        $account = BankAccount::find($accountId);
        if ($account) {
            $account->balance += $amount;
            $account->save();
            return $account;
        }
        return null;
    }
}
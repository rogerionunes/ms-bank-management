<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Repositories\BankAccountRepositoryInterface;

class BankAccountService
{
    protected $bankAccountRepository;

    public function __construct(BankAccountRepositoryInterface $bankAccountRepository)
    {
        $this->bankAccountRepository = $bankAccountRepository;
    }

    public function createAccount(array $data): BankAccount
    {
        return $this->bankAccountRepository->create($data);
    }

    public function getAccountByNumber($numeroConta)
    {
        return $this->bankAccountRepository->findByNumber($numeroConta);
    }
}
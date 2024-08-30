<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Repositories\BankAccountRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class BankAccountService
{
    protected $bankAccountRepository;

    public const PAYMENT_METHOD_PIX = 'P';
    public const PAYMENT_METHOD_CREDIT = 'C';
    public const PAYMENT_METHOD_DEBIT = 'D';
    public const PAYMENT_METHOD_FEE = [
        self::PAYMENT_METHOD_PIX => 0,
        self::PAYMENT_METHOD_CREDIT => 0.05,
        self::PAYMENT_METHOD_DEBIT => 0.03
    ];

    public function __construct(BankAccountRepositoryInterface $bankAccountRepository)
    {
        $this->bankAccountRepository = $bankAccountRepository;
    }

    public function createAccount(array $data): BankAccount
    {
        DB::beginTransaction();
    
        try {
            $account = $this->bankAccountRepository->create($data);
    
            DB::commit();
    
            return $account;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getAccountByNumber($numeroConta): ?BankAccount
    {
        try {
            $account = $this->bankAccountRepository->findByNumber($numeroConta);
    
            return $account;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function executeTransaction(array $data): BankAccount
    {
        DB::beginTransaction();

        try {
            $account = $this->getAccountByNumber($data['numero_conta']);
            
            if (!$this->validateAccount($account, $data['valor'], $data['forma_pagamento'])) {
                throw new Exception('Transação Inválida: Saldo Insuficiente');
            }

            $amountFee = $this->calculateFee($data['forma_pagamento'], $data['valor']);
            $totalAmount = $data['valor'] + $amountFee;

            $account->saldo -= $totalAmount;

            $account->save();

            DB::commit();

            return $account;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function calculateFee(string $paymentMethod, float $amount): float
    {
        return $paymentMethod != self::PAYMENT_METHOD_PIX ? self::PAYMENT_METHOD_FEE[$paymentMethod] * $amount : 0;
    }

    protected function validateAccount(?BankAccount $account, float $amount, string $paymentMethod): bool
    {
        $amountFee = $this->calculateFee($paymentMethod, $amount);
        $totalAmount = $amount + $amountFee;

        return $account->saldo >= $totalAmount;
    }
}
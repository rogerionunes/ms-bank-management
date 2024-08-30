<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\BankAccount;

class BankAccountTest extends TestCase
{

    public function test_create_account_successfully()
    {
        $response = $this->post('/api/conta', [
            'numero_conta' => 1212,
            'saldo' => 180.37
        ]);

        $response->assertJson(json_encode([
            'numero_conta' => 1212,
            'saldo' => 180.37
        ]));
    }

    public function test_create_account_already_exists()
    {
        BankAccount::create([
            'numero_conta' => 235,
            'saldo' => 100.00
        ]);

        $response = $this->post('/api/conta', [
            'numero_conta' => 235,
            'saldo' => 180.37
        ]);

        $response->assertJson(json_encode([
            'message' => 'Conta 235 já existe'
        ]));
    }

    public function test_show_account_successfully()
    {
        BankAccount::create([
            'numero_conta' => 234,
            'saldo' => 180.37
        ]);

        $response = $this->get('/api/conta?numero_conta=234');

        $response->assertJson(json_encode([
            'numero_conta' => 234,
            'saldo' => 180.37
        ]));
    }

    public function test_show_account_not_found()
    {
        $response = $this->get('/api/conta?numero_conta=999');

        $response->assertJson(json_encode([
            'message' => 'Conta não encontrada'
        ]));
    }

    public function test_execute_transaction_successfully()
    {
        $response = $this->put('/api/conta', [
            'numero_conta' => 234,
            'valor' => 10.00, 
            'forma_pagamento' => 'P' 
        ]);

        $response->assertJson(json_encode([
            'message' => 'Conta não encontrada'
        ]));
    }
}
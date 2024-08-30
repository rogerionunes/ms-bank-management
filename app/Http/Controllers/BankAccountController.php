<?php 

namespace App\Http\Controllers;

use App\Http\Requests\BankAccountRequest;
use App\Services\BankAccountService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BankAccountController extends Controller
{
    protected $bankAccountRequest;
    protected $bankAccountService;

    public function __construct(BankAccountRequest $bankAccountRequest, BankAccountService $bankAccountService)
    {
        $this->bankAccountRequest = $bankAccountRequest;
        $this->bankAccountService = $bankAccountService;
    }

    public function store(Request $request)
    {
        $validations = [
            'rules' => [
                'numero_conta' => 'required|integer|unique:conta,numero_conta',
                'saldo' => 'required|numeric|min:0.01',
            ],
            'messages' => [
                'numero_conta.required' => 'O campo número da conta é obrigatório.',
                'numero_conta.integer' => 'O campo número da conta deve ser um número inteiro.',
                'numero_conta.unique' => 'A conta já existe.',
                'saldo.required' => 'O campo valor é obrigatório.',
                'saldo.numeric' => 'O campo valor deve ser numérico.',
                'saldo.min' => 'O campo valor deve ser pelo menos 0.01.',
            ]
        ];

        $this->bankAccountRequest->validate($request, $validations);
    
        try {
            $account = $this->bankAccountService->createAccount($request->all());
    
            return response()->json([
                'numero_conta' => $account->numero_conta, 
                'saldo' => $account->saldo
            ], 201);
    
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function show(Request $request)
    {
        $validations = [
            'rules' => [
                'numero_conta' => 'required|integer|exists:conta,numero_conta',
            ],
            'messages' => [
                'numero_conta.required' => 'O campo número da conta é obrigatório.',
                'numero_conta.integer' => 'O campo número da conta deve ser um número inteiro.',
                'numero_conta.exists' => 'A conta especificada não foi encontrada.',
            ]
        ];
        
        $this->bankAccountRequest->validate($request, $validations);

        try {
            $accountNumber = $request->query('numero_conta');
            $account = $this->bankAccountService->getAccountByNumber($accountNumber);
    
            return response()->json([
                'numero_conta' => $account->numero_conta, 
                'saldo' => $account->saldo
            ], 200);
    
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request)
    {
        $validations = [
            'rules' => [
                'numero_conta' => 'required|integer|exists:conta,numero_conta',
                'valor' => 'required|numeric|min:0.01',
                'forma_pagamento' => 'required|string|in:P,C,D'
            ],
            'messages' => [
                'numero_conta.required' => 'O campo número da conta é obrigatório.',
                'numero_conta.integer' => 'O campo número da conta deve ser um número inteiro.',
                'numero_conta.exists' => 'A conta especificada não foi encontrada.',
                'valor.required' => 'O campo valor é obrigatório.',
                'valor.numeric' => 'O campo valor deve ser numérico.',
                'valor.min' => 'O campo valor deve ser pelo menos 0.01.',
                'forma_pagamento.required' => 'O campo forma de pagamento é obrigatório.',
                'forma_pagamento.in' => 'A forma de pagamento deve ser uma das seguintes: P, C ou D.'
            ]
        ];

        $this->bankAccountRequest->validate($request, $validations);

        try {
            $data = $request->all();
            $result = $this->bankAccountService->executeTransaction($data);

            if ($result) {
                return response()->json([
                    'numero_conta' => $result->numero_conta,
                    'saldo' => $result->saldo,
                ], 200);
            }

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
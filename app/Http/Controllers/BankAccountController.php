<?php 

namespace App\Http\Controllers;

use App\Services\BankAccountService;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    protected $bankAccountService;

    public function __construct(BankAccountService $bankAccountService)
    {
        $this->bankAccountService = $bankAccountService;
    }

    public function store(Request $request)
    {
        if ($this->bankAccountService->getAccountByNumber($request->numero_conta)) {
            return response()->json(['message' => "A conta {$request->numero_conta} já existe"], 409);
        }
        
        $account = $this->bankAccountService->createAccount($request->all());
        
        return response()->json([
            'numero_conta' => $account->numero_conta, 
            'saldo' => $account->saldo
        ], 201);
    }

    public function show(Request $request)
    {
        $accountNumber = $request->query('numero_conta');
        $account = $this->bankAccountService->getAccountByNumber($accountNumber);
        
        if (!$account) {
            return response()->json(['message' => 'Conta não encontrada'], 404);
        }

        return response()->json([
            'numero_conta' => $account->numero_conta, 
            'saldo' => $account->saldo
        ], 200);
    }
}
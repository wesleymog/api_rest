<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\User;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function getAllMyTransactions($id){

        $user = User::find($id);
        $myTransactions = $user->transactions();
    	$data = ['data' => $myTransactions];
        
        
    	return response()->json($data);
    }

    public function store(Request $request){
        $transaction = new Transaction;
        $transaction->createTransaction($request);
        $user = User::find($transaction->user_id);
        $user->alterWallet($transaction->value);

        return response()->json(['msg' => 'Transação realizada com sucesso', 'data' => $transaction], 201);
    }
}

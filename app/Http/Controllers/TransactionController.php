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

/**
 * @OA\Tag(
 *     name="transaction",
 *     description="Everything about your transactions",
 * )
 */


   /**
 * @OA\Get(
 *      path="/transaction/{id}",
 *      operationId="get_users_transactions",
 *      tags={"transaction"},
 *      summary="Get an user transaction",
 *      description="Returns users transactions",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       
 *     )
 *
 * Return user transactions
 */

 /**
 * @OA\Post(
 *      path="/transaction",
 *      operationId="add_transaction",
 *      tags={"transaction"},
 *      summary="Add an user",
 *      description="Add a transaction",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"api_key_security_example": {}}
 *       }
 *     )
 *
 * Returns a transaction
 */
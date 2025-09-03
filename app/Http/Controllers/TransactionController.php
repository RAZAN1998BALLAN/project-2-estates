<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserEstateService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function pay(PaymentRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $userWallet = Auth::user()->wallets()->firstOrFail();
            $service = Service::findOrFail($request->service_id);
            $amount = $service->price;

            if ($userWallet->balance < $amount) {
                return $this->fail("you dont have enough mony!", 402);
            }
            $userWallet->balance = $userWallet->balance -  $amount;

            $reciver = User::where('email','admin@admin.com')->firstOrFail();

            $recieverWallet = $reciver->wallets()->firstOrFail();

            $recieverWallet->balance = $recieverWallet->balance + $amount;

            $transaction = Transaction::create([
                'sender_id' => Auth::id(),
                'reciver_id' => $reciver->id,
                'amount' => $amount
            ]);

            $recieverWallet->save();

            $userWallet->save();

            UserEstateService::create([
                'user_id' => Auth::id(),
                'estate_id' => $request->estate_id,
                'service_id'=> $request->service_id
            ]);
            
            return $this->success($transaction);
        });
    }
}

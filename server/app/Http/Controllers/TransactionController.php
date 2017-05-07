<?php

namespace App\Http\Controllers;

use Carbon;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $response = [];
        $input = $request->all();

        try {
            $transact = new Transaction();
            $transact->type = $input['type'];
            $transact->description = $input['description'];
            $transact->value = json_encode($input['value']);
            $transact->created_at = Carbon\Carbon::now();
            $transact->save();

            $response = array(
                    'result' => true,
                    'message' => 'Transaction saved'
                );
        } catch (\Exception $e) {
            $response = array(
                    'result' => false,
                    'message' => $e->getMessage()
                );
        }
        return response($response);
    }
}
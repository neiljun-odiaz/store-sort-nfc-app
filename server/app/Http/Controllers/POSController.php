<?php

namespace App\Http\Controllers;


use App\Card;
use App\POS;
use Carbon;

use Illuminate\Http\Request;

class POSController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();
        try {
            $products = [];

            foreach($input['products'] as $product){
                $products[] = array(
                        'id' => $product['id'],
                        'name' => $product['name'],
                        'qty' => $product['qty'],
                    );
            }

            $pos = new POS();
            $pos->customer_id = $input['customer'];
            $pos->products = json_encode($products);
            $pos->amount = $input['amount'];
            $pos->cash = $input['cash'];
            $pos->points = $input['points'];
            $pos->transaction_date = Carbon\Carbon::now();
            $pos->save();

            $result = array(
                'result' => true, 
                'message' => 'Purchase saved',
                'pos' => $input
            );
        } catch (\Exception $e) {
            $result = array(
                'result' => false, 
                'message' => $e->getMessage()
            );
        }

        return response($result);
    }
}
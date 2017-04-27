<?php

namespace App\Http\Controllers;


use App\Card;
use Carbon;

use Illuminate\Http\Request;

class CardController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $cards = Card::with('store')->get();
        return response($cards);
    }

    public function import(Request $request)
    {
        try {
            $cards = $request->all();

            foreach($cards as $card){
                $s_card = new Card;
                $s_card->uid = $card['uid'];
                $s_card->batch_key = $card['batch_key'];
                $s_card->store_id = $card['store_id'];
                $s_card->date_registered = $card['date_registered'];
                $s_card->date_expiration = $card['date_expiration'];
                $s_card->is_imported = true;
                $s_card->is_active = true;
                $s_card->save();
            }
            $result = array(
                    'result' => true,
                    'message' => 'Card Imported!'
                );
        } catch(\Exception $e) {
            $result = array(
                    'result' => false,
                    'message' => $e->getMessage()
                );
        }

        return response($result);
    }

    public function delete(Request $request)
    {

    }
}
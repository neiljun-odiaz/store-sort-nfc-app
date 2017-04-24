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

    public function update(Request $request)
    {
        try {
            $input = $request->all();

            // Check if Card is pre-registered.
            $card = Card::where('uid', $input['uid'])->first();
            if (!$card) {
                $result = array(
                    'result' => false,
                    'message' => 'Card Unknown!'
                );
                return response($result);
            }

            $today = Carbon\Carbon::now();

            $card->holder_name = $input['holdername'];
            $card->pin = $input['pin'];
            $card->contact_number = $input['contact'];
            $card->email_address = $input['email'];
            $card->address = $input['address'];
            $card->age = $input['age'];
            $card->sex = $input['sex'];
            $card->birth_date = $input['birthdate'];
            $card->civil_status = $input['civilstatus'];
            $card->date_registered = $today;
            $card->date_expiration = $today->addYear();
            $card->save();

            $result = array(
                    'result' => true,
                    'message' => 'Card Registered!',
                    'card' => $card
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
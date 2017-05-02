<?php

namespace App\Http\Controllers;

use App\Card;
use App\Customer;
use Carbon;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
       public function store(Request $request)
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

                // Check if card already taken or already registered by other customer
                $customer_check = Customer::where('card_id', $card->id)->count();
                if ($customer_check > 0) {
                    $result = array(
                        'result' => false,
                        'message' => 'Card Already taken!'
                    );
                    return response($result);
                }

                $today = Carbon\Carbon::now();

                // Create new Customer
                $customer = new Customer;
                $customer->card_id = $card->id;
                $customer->firstname = $input['firstname'];
                $customer->lastname = $input['lastname'];
                $customer->pin = $input['pin'];
                $customer->contact_number = $input['contact'];
                $customer->email_address = $input['email'];
                $customer->address = $input['address'];
                $customer->age = $input['age'];
                $customer->sex = $input['sex'];
                $customer->birth_date = $input['birthdate'];
                $customer->civil_status = $input['civilstatus'];
                $customer->points = 0;
                $customer->amount = 0;
                $customer->is_active = true;
                $customer->save();

                // Update Card Info
                $card->date_registered = $today;
                $card->date_expiration = $today->addYear();
                $card->save();

                $result = array(
                    'result' => true,
                    'message' => 'Card Registered!',
                    'card' => $card,
                    'customer' => $customer
                );
            } catch(\Exception $e) {
                $result = array(
                        'result' => false,
                        'message' => $e->getMessage()
                    );
            }

            return response($result);
       }

       public function fetchCustomer(Request $request)
       {
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

            $customer = Customer::where('card_id', $card->id)->first();
            $result = array(
                'result' => true,
                'message' => '',
                'customer' => $customer
            );
            return response($result);
       }
}

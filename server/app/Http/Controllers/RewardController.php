<?php

namespace App\Http\Controllers;

use App\Reward;
use Carbon;

use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function all()
    {
        $rewards = Reward::all();
        return response($rewards);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $result = [];

        try {
            $reward = new Reward();
            $reward->description = $input['desc'];
            $reward->points = $input['points'];
            $reward->inventory = $input['inventory'];
            $reward->rewarded = $input['rewarded'];
            $reward->is_active = true;
            $reward->save();

            $result = array(
                'result' => true,
                'message' => 'Reward Added!',
                'reward' => $reward
            );
        } catch (\Exception $e) {
            $result = array(
                'result' => false,
                'message' => $e->getMessage()
            );
        }

        return response($result);
    }

    public function update(Request $request, $id)
    {
        $result = [];
        $input = $request->all();

        try {
            $reward = Reward::find($id);
            $reward->description = $input['description'];
            $reward->points = $input['points'];
            $reward->inventory = $input['inventory'];
            $reward->rewarded = $input['rewarded'];
            $reward->save();

            $result = array(
                'result' => true,
                'message' => 'Reward Updated!',
                'reward' => $reward
            );
        } catch (\Exception $e) {
            $result = array(
                'result' => false,
                'message' => $e->getMessage()
            );
        }

        return response($result);
    }

    public function destroy($id)
    {
        $result = [];
        try {
            $reward = Reward::find($id);
            $reward->delete();

            $result = array(
                'result' => true,
                'message' => 'Reward Removed!'
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

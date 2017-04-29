<?php

namespace App\Http\Controllers;

use Carbon;
use App\Setting;

use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function index()
    {
        $settings = Setting::all();
        return response($settings);
    }

    public function store(Request $request)
    {
        $settings = $request->all();
        
        if ($settings){
            foreach ($settings as $setting) {
                $setting_check = $this->checkSetting($setting['name']);
                if (!$setting_check) {
                    $this->addSetting($setting['name'], $setting['value']);
                } else {
                    $this->updateSetting($setting_check->id, $setting['value']);
                }
            }
            $result = array(
                    'result' => true,
                    'message' => 'Settings Saved!'
                );
        } else {
            $result = array(
                    'result' => false,
                    'message' => 'No settings'
                );
        }
        return response($result);
    }

    public function fetchSetting(Request $request)
    {
        $input = $request->all();
        $name = $input['name'];
        $setting = Setting::where('name', $name)->first();

        if ($setting) {
            $result = array(
                    'result' => true,
                    'setting' => $setting
                );
        } else {
            $result = array(
                    'result' => false,
                    'message' => 'No setting found'
                );
        }

        return response($result);
    }

    private function checkSetting($name)
    {
        $setting = Setting::where('name', $name)->first();
        if ($setting)
            return $setting;
        else
            return false;
    }

    private function addSetting($name, $value)
    {
        try {
            $setting = new Setting();
            $setting->name = $name;
            $setting->value = json_encode($value);
            $setting->save();
            return $setting;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function updateSetting($id, $value)
    {
        try {
            $setting = Setting::find($id);
            $setting->value = json_encode($value);
            $setting->save();
            return $setting;
        } catch (\Exception $e) {
            return false;
        }
    }



}
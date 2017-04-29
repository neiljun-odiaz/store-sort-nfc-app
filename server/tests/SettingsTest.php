<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class SettingsTest extends TestCase
{
    use DatabaseTransactions;
    
    public function test_should_return_result()
    {
        $settings = array(
                array(
                    'name' => 'points_amount',
                    'value' => array(
                            'amount' => 100,
                            'points' => 5
                        )
                )
            );
        $this->json('POST', '/api/settings', $settings)
             ->seeJson([
                'result' => true,
                'message' => 'Settings Saved!'
             ]);
    }

    public function test_should_return_false_if_settings_not_found()
    {
        $settings = array();
        $this->json('POST', '/api/settings', $settings)
             ->seeJson([
                'result' => false,
                'message' => 'No settings'
             ]);
    }

    public function test_should_see_in_db()
    {
        $settings = array(
                array(
                    'name' => 'points_amount',
                    'value' => array(
                            'amount' => 100,
                            'points' => 5
                        )
                )
            );
        $result = $this->call('POST', '/api/settings', $settings);
        $this->seeInDatabase('settings', ['points_amount' => array()]);
    }
}

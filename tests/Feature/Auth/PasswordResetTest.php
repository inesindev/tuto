<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;


    // public function setup():void {
    //     parent::setup();
    //     $this->user = User::Factory()->create();

    // }

    // cannot use $this here cause  laravel appplicactin at this point is not setted
    // beforeAll(function() {
    //     dump('vefore all');
    // });
    beforeEach(function() {
        $this->user = User::Factory()->create();
});
    // afterAll(function() {
        // dump('after all');
    // });
    // afterEach(function() {
        // dump('after each');
    // });
    

    it("test_reset_password_link_screen_can_be_rendered", function ()
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    });

    it("test_reset_password_link_can_be_requested", function ()
    {
        Notification::fake();

        $this->post('/forgot-password', ['email' => $this->user->email]);

        Notification::assertSentTo($this->user, ResetPassword::class);
    });

    it("test_reset_password_screen_can_be_rendered", function ()
    {
        Notification::fake();

        $this->post('/forgot-password', ['email' => $this->user->email]);

        Notification::assertSentTo($this->user, ResetPassword::class, function ($notification) {
            $response = $this->get('/reset-password/'.$notification->token);

            $response->assertStatus(200);

            return true;
        });
    });

    it("test_password_can_be_reset_with_valid_token", function ()
    {
        Notification::fake();

        $this->post('/forgot-password', ['email' => $this->user->email]);

        Notification::assertSentTo($this->user, ResetPassword::class, function ($notification) {
            $response = $this->post('/reset-password', [
                'token' => $notification->token,
                'email' => $this->user->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertSessionHasNoErrors();

            return true;
        });
    });


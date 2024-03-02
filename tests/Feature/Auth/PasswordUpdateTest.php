<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;


    it("test_password_can_be_updated", function ()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }); 

    it("test_correct_password_must_be_provided_to_update_password", function ()
    {

        // dd("ddddd");
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'wrong-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('updatePassword', 'current_password')
            ->assertRedirect('/profile');
    }); 

    it("test_correct_password_to_be_8_char", function (string $password)
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'wrong-password',
                'password' => $password,
                'password_confirmation' => $password,
            ]);

        $response
            ->assertSessionHasErrorsIn('updatePassword', 'current_password')
            ->assertRedirect('/profile');
    })->with([
        // ! NO ME SAEN 'DESGLOSADOS'
        '4DigitsNumber',
        Alpha::class
        // 'a', 'ab', 'abc' // not recommended
    ]); 

    dataset("4DigitsNumber", [
        'one' => '1',
        'two' => '12',
        'three' => '1234567',
        'four' => '12345678', 

    ]);
   

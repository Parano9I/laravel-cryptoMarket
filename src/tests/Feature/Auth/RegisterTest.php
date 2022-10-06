<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use WithFaker;

//    public function __construct()
//    {
//        $this->setUpFaker();
//    }

    protected $url = '/api/auth/registration';

    public function testRegisterWithCorrectCredentials()
    {
        $user = User::factory()->make([
            'password' => bcrypt($password = 'testPassword'),
        ]);

        $response = $this->postJson($this->url, [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'password' => $password
        ]);

        User::query()->where('first_name', $user->first_name)->delete();

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status',
                'message',
                'user',
                'authorization' => [
                    'token',
                    'type',
                ]
            ]);
    }

    public function testRegisterWithEmptyCredentials()
    {
        $response = $this->postJson($this->url, [
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'password' => ''
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson([
                'message' => 'The first name field is required. (and 3 more errors)',
                'errors' => [
                    'first_name' => [
                        'The first name field is required.'
                    ],
                    'last_name' => [
                        'The last name field is required.'
                    ],
                    'email' => [
                        'The email field is required.'
                    ],
                    'password' => [
                        'The password field is required.'
                    ]
                ]
            ]);;
    }

    public function testRegisterWithUncorrectedCredentials()
    {
        $response = $this->postJson($this->url, [
            'first_name' => $this->faker->text(),
            'last_name' => $this->faker->text(),
            'email' => $this->faker->firstName,
            'password' => 'pass',
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson([
                'message' => 'The first name must not be greater than 70 characters. (and 3 more errors)',
                'errors' => [
                    'first_name' => [
                        'The first name must not be greater than 70 characters.'
                    ],
                    'last_name' => [
                        'The last name must not be greater than 70 characters.'
                    ],
                    'email' => [
                        'The email must be a valid email address.'
                    ],
                    'password' => [
                        'The password must be at least 6 characters.'
                    ]
                ]
            ]);;
    }
}

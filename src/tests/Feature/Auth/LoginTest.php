<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{

    protected $url = '/api/auth/login';

    public function testLoginWithCorrectCredentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'testPassword'),
        ]);

        $response = $this->postJson($this->url, [
            'email' => $user->email,
            'password' => $password,
        ]);

        $user->delete();

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status',
                'user' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'first_login'
                ],
                'authorization' => [
                    'token',
                    'type',
                ]
            ]);
    }

    public function testLoginWithUncorrectedEmail()
    {
        $response = $this->postJson($this->url, [
            'email' => 'email348.com',
            'password' => 'fjeh',
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson(
                [
                    'message' => 'The email must be a valid email address.',
                    'errors' => [
                        'email' => [
                            'The email must be a valid email address.'
                        ],
                    ]
                ]
            );
    }

    public function testLoginWithEmptyEmail(){
        $response = $this->postJson($this->url, [
            'email' => '',
            'password' => 'fjeh',
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson(
                [
                    'message' => 'The email field is required.',
                    'errors' => [
                        'email' => [
                            'The email field is required.'
                        ],
                    ]
                ]
            );
    }

    public function testLoginWithEmptyPassword(){
        $response = $this->postJson($this->url, [
            'email' => 'email348@gmail.com',
            'password' => '',
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson(
                [
                    'message' => 'The password field is required.',
                    'errors' => [
                        'password' => [
                            'The password field is required.'
                        ],
                    ]
                ]
            );
    }

    public function testLoginOnUnauthorized()
    {
        $response = $this->postJson($this->url, [
            'email' => 'email348@gmail.com',
            'password' => 'fjehdf7xek3',
        ])->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertExactJson(
                [
                    'status' => 'error',
                    'message' => 'Unauthorized',
                ]
            );
    }
}

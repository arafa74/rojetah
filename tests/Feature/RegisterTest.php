<?php

namespace Tests\Feature;
use Tests\TestCase;



class RegisterTest extends TestCase
{
    /*
    public function testRequiredFieldsForRegistration()
    {
        $this->json('POST', 'api/register', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "f_name" => ["The first name field is required."],
                    "l_name" => ["The last name field is required."],
                    "email" => ["The email field is required."],
                    "mobile" => ["The mobile field is required."],
                    "password" => ["The password field is required."],
                ]
            ]);

         $this->json('POST', 'api/register', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['f_name','l_name','email','mobile','password']);
    }
*/
    /*public function testRepeatPassword()
    {
        $userData = [
            "f_name" => "John Doe",
            "l_name" => "John Doe",
            "email" => "doe@example.com",
            "mobile" => rand('1000000000' , '9999999999'),
            "password" => "demo12345"
        ];

        $this->json('POST', 'api/v1/user/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "password" => ["The password confirmation does not match."]
                ]
            ]);
    }*/


    public function testSuccessfulRegistration()
    {

        $userData = [
            'f_name' => $this->faker->firstName,
            'l_name'  => $this->faker->lastName,
            'email'   => $this->faker->email,
            "mobile" => rand('1000000000' , '9999999999'),
            "password" => "demo12345"
        ];

        $this->json('POST', 'api/v1/user/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                    "data" => [
                        'id',
                        'f_name',
                        'l_name',
                        'mobile',
                        'email'
                    ],
                "status",
                "message"
            ]);
    }
}

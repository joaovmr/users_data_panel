<?php

namespace App\Services;

use App\Models\RandomUser;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class UsersApiService
{
    public function getUsers($size = 100)
    {
        $response = Http::get("https://random-data-api.com/api/v2/users?size={$size}");
        $userData = $response->json();

        return collect($userData)->map(function ($user) {
            $this->validateUser($user);
            return new RandomUser(attributes: $user);
        });
    }

    private function validateUser($user)
    {
        $validator = Validator::make($user, [
            'uid' => 'required|string',
            'password' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email',
            'avatar' => 'required|string',
            'gender' => 'required|string',
            'phone_number' => 'required|string',
            'social_insurance_number' => 'required|string',
            'date_of_birth' => 'required|date',
            'employment' => 'required|array',
            'employment.title' => 'required|string',
            'employment.key_skill' => 'required|string',
            'address' => 'required|array',
            'address.city' => 'required|string',
            'address.street_name' => 'required|string',
            'address.street_address' => 'required|string',
            'address.zip_code' => 'required|string',
            'address.state' => 'required|string',
            'address.country' => 'required|string',
            'address.coordinates' => 'required|array',
            'address.coordinates.lat' => 'required|numeric',
            'address.coordinates.lng' => 'required|numeric',
            'credit_card' => 'required|array',
            'credit_card.cc_number' => 'required|string',
            'subscription' => 'required|array',
            'subscription.plan' => 'required|string',
            'subscription.status' => 'required|string',
            'subscription.payment_method' => 'required|string',
            'subscription.term' => 'required|string',
        ]);
        if ($validator->fails()) {
            throw new \Exception('User validation failed: ' . json_encode($validator->errors()));
        }
    }
}

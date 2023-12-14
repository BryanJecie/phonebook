<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class Login
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
        $credentials = [
            'email' => $args['email'],
            'password' => $args['password'],
        ];
        return $this->toLogin($credentials);
    }

    public function toLogin(array $credentials)
    {
        if (!auth()->attempt($credentials)) {
            throw ValidationException::withMessages(['invalid_credentials' => __('auth.failed')]);
        }

        $user = auth()->user();

        return $user->createToken('myToken')->plainTextToken;
    }
}

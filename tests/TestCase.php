<?php

namespace Tests;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Auth;

abstract class TestCase extends BaseTestCase
{
    public function actingAs(Authenticatable $user, $guard = null)
    {
        parent::actingAs($user, $guard);
        $guard ??= Auth::getDefaultDriver();
        $this->withSession(['password_hash_'.$guard => Auth::guard($guard)->hashPasswordForCookie($user->getAuthPassword())]);

        return $this;
    }
}

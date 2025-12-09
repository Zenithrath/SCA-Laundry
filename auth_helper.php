<?php

use App\Models\User;

return function ($app) {
    Auth::loginUsingId(1, remember: true);
};

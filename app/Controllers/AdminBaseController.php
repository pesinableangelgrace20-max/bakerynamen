<?php

namespace App\Controllers;

/**
 * Shared helpers for admin area (session gate).
 */
abstract class AdminBaseController extends BaseController
{
    protected function requireLogin()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return null;
    }
}

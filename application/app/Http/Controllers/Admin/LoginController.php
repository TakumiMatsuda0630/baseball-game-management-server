<?php

declare(strict_types=1);

namespace Application\Http\Controllers\Admin;

use Application\Http\Controllers\Controller;
use Inertia\Response;

class LoginController extends Controller
{
    public function __construct()
    {

    }

    /**
     * ログイン画面の表示
     *
     * @return Response
     */
    public function index(): Response
    {
        return inertia('Auth/Login', []);
    }
}

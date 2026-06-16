<?php

declare(strict_types=1);

namespace Application\Http\Controllers\Admin;

use Application\Http\Controllers\Controller;
use Application\Http\Request\Admin\Login\AuthenticateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Inertia\ResponseFactory;

class LoginController extends Controller
{
    public function __construct()
    {

    }

    /**
     * ログイン画面の表示
     */
    public function index(): Response|ResponseFactory
    {
        return inertia('Auth/Login', []);
    }

    /**
     * ログイン処理
     */
    public function authenticate(AuthenticateRequest $request): Response|RedirectResponse
    {
        $credentials = [
            'email' => $request->email(),
            'password' => $request->password(),
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('admin/home');
        }

        return back()->withErrors([
            'error' => 'Emailまたはパスワードが不正です。',
        ])->onlyInput('email');
    }

    /**
     * ログアウト処理
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->intended('admin/login');
    }
}

<?php

declare(strict_types=1);

namespace Application\Http\Controllers\Admin;

use Application\Http\Controllers\Controller;
use Application\Http\Request\Admin\Login\AuthenticateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
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

    /**
     * ログイン処理
     *
     * @return Response|RedirectResponse
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
     *
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->intended('admin/login');
    }
}

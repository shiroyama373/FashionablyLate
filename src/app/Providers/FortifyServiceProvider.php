<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException; 
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\CreateNewUser; 
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(
            \Laravel\Fortify\Contracts\CreatesNewUsers::class,
            CreateNewUser::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        Route::middleware(['web', 'guest'])->group(function () {
            Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

            Route::post('login', [AuthenticatedSessionController::class, 'store']);
        });

        Fortify::authenticateUsing(function ($request) {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8'],
            ], [
                'email.required' => 'メールアドレスを入力してください',
                'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',
                'password.required' => 'パスワードを入力してください',
                'password.min' => 'パスワードは8文字以上で入力してください',
            ]);

            if ($validator->fails()) {
                throw ValidationException::withMessages($validator->errors()->toArray());
            }

            if (auth()->attempt(
                $request->only('email', 'password'),
                $request->filled('remember')
            )) {
                return auth()->user();
            }

            return null; // 認証失敗
        });

        // ログインページのカスタムビュー
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // 登録ページのカスタムビュー 
        Fortify::registerView(function () {
            return view('auth.register');
        });

}

}

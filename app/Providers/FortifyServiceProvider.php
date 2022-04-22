<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::loginView(function(){
            return view('auth.login', ['title' => 'Login']);
        });

        Fortify::registerView(function(){
             return redirect(route('login'))->with('danger', 'You must be logged in to continue');
             //return view('auth.register', ['title' => 'Register']);
        });

        Fortify::verifyEmailView(function(){
            return view('auth.verify-email', ['title' => 'Email Verification']);
        });

        Fortify::requestPasswordResetLinkView(function(){
            return view('auth.forgot-password', ['title' => 'Forgot Password']);
        });

        Fortify::resetPasswordView(function($request){
            return view('auth.reset-password', ['title' => 'Reset Password', 'request' => $request]);
        });

        $this->app->singleton(
            \Laravel\Fortify\Contracts\LogoutResponse::class,
            \App\Http\Responses\LogoutResponse::class
        );

        //Customizing User Authentication
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where(['email' => $request->email, 'deleted_at' => null,'status' => 1])
                ->first();
    
            if ($user &&
                Hash::check($request->password, $user->password)) {
                return $user;

                //Save audit trail
                $activity_type = 'Login';
                $description = 'Logged in to the system successfully';
                User::saveAuditTrail($activity_type, $description);
            }
        });

    }
}